<?php

session_start();

//PHPMailer
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function matchCaptcha($session_captcha, $captcha) {
    session_start();
    $result;
    // check if the captcha entered correctly (case sensitive)
    if(strcmp($session_captcha, $captcha) != 0) {
        // unmatch captcha code
        $result = true;
    } else {
        // matching captcha code
        $result = false;
    }
    return $result;
}

function emptyInputRegister($user_name_e, $user_name_c, $user_gender, $user_date_birth, $user_place_birth, $user_address, $user_occupation, $user_hkid, $user_email, $user_pwd, $cfm_pwd, $captcha) {
    $result;
    if (empty($user_name_e) || empty($user_name_c) || empty($user_gender) || empty($user_date_birth) || empty($user_place_birth) || empty($user_address) || empty($user_occupation) || empty($user_hkid) || empty($user_email) || empty($user_pwd) || empty($cfm_pwd) || empty($captcha)) {
        // some of the fields are empty, return error is true
        $result = true;
    } else {
        // all fields were filled, no error
        $result = false;
    }
    return $result;
}

function invalidEmail($user_email) {
    $result;
    // make sure of php built-in filter validation function
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        // invalid email format, return error
        $result = true;
    } else {
        // correct email format, no error
        $result = false;
    }
    return $result;
}

function invalidCName($user_name_c) {
    $result;
    // use regular expression to check if Chinese Name is in correct format and length
    if (!preg_match("/\p{Han}{2,}+/u", $user_name_c)) {
        // unable to meet requirement, return error
        $result = true;
    } else {
        // requirement meet, no error
        $result = false;
    }
    return $result;
}

function invalidEName($user_name_e) {
    $result;
    // use regular expression to check if English Name is in correct format and length
    if (!preg_match("/^[A-Z][a-zA-Z]+(?: [A-Z][a-zA-Z]+)+$/", $user_name_e)) {
        // unable to meet requirement, return error
        $result = true;
    } else {
        // requirement meet, no error
        $result = false;
    }
    return $result;
}

function invalidHKID($user_hkid) {
    $result;
    // use regular expression to check if HKID is in correct format
    if (!preg_match("/^([A-Z]{1,2})([0-9]{6})\(([0-9A])\)$/", $user_hkid)) {
        // invalid HKID format, return error
        $result = true;
    } else {
        // correct HKID format, no error
        $result = false;
    }
    return $result;
}

function invalidPwd($user_pwd) {
    $result;
    // use regular expression to check if password is in correct format and length
    if (!preg_match("/(?=(.*[0-9]))(?=.*[\!@#$%^&*()\\[\]{}\-_+=~`|:;\"'<>,.\/?])(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/", $user_pwd)) {
        // unable to meet requirement, return error
        $result = true;
    } else {
        // requirement meet, no error
        $result = false;
    }
    return $result;
}

function spacePwd($user_pwd) {
    $result;
    // use regular expression to check if there is space inside the password
    if (!preg_match("/^\S*$/", $user_pwd)) {
        // unable to meet requirement, return error
        $result = true;
    } else {
        // requirement meet, no error
        $result = false;
    }
    return $result;
}

function matchPwd($user_pwd, $cfm_pwd) {
    $result;
    // check if password matches with the confirm password
    if ($user_pwd !== $cfm_pwd) {
        // unmatch password
        $result = true;
    } else {
        // match password
        $result = false;
    }
    return $result;
}

function existEmail($conn, $user_email) {
    // create a sql statement to search if the email is already exist in the database
    $sql = "SELECT * FROM users WHERE user_email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

}

function existHKID($conn, $user_hkid) {
    $result;

    $result = false;

    return $result;

    // BUG TO BE FIXED --- validate if HKID is exist in the database

/*     // create a sql statement to search if the email is already exist in the database
    $sql = "SELECT * FROM users ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    $dbSalt = $existHKID["user_salt"];
    $dbHashedHKID = $existHKID["user_hkid"];

    $inputHKIDHashed = hash("sha512", $dbSalt . $user_hkid);

    if (strcmp($dbHashedHKID, $inputHKIDHashed) == 0) {
        // Returns < 0 if string1 is less than string2; > 0 if string1 is greater than string2, and 0 if they are equal.
        // equal means the input HKID existed in database
        $result = true;
    } elseif (strcmp($dbHashedHKID, $inputHKIDHashed) !== 0) {
        // HKID has not been registered, no error
        $result = false;
    }
    return $result; */
}

function generateSalt($length)
{
    $rand_str = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    
    for($i = 0; $i < $length; $i++) 
    {
        $rand_str = $rand_str . $chars[rand(0, strlen($chars) - 1)];
    } 
    
    return $rand_str;
}

function createUser($conn, $user_name_e, $user_name_c, $user_gender, $user_date_birth, $user_place_birth, $user_address, $user_occupation, $user_hkid, $user_email, $user_pwd) {
    // create a sql statement to insert a new user
    $sql = "INSERT INTO users (user_name_e, user_name_c, user_gender, user_date_birth, user_place_birth, user_address, user_occupation, user_hkid, user_email, user_salt, user_pwd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    // hashing password with salt
    $salt = generateSalt(16);
    $hashedPwd = hash("sha512", $salt . $user_pwd);
    
    // get variables from config file
    require '../config.php';
    // encrpyting HKID
    $cipherHKID = openssl_encrypt($user_hkid, $cipher, $key, $options, $iv);
    $cipherIVHKID = $binary_iv . $cipherHKID;

    mysqli_stmt_bind_param($stmt, "sssssssssss", $user_name_e, $user_name_c, $user_gender, $user_date_birth, $user_place_birth, $user_address, $user_occupation, $cipherIVHKID, $user_email, $salt, $hashedPwd);
    mysqli_stmt_execute($stmt);

    header("location: ../register.php?error=none");
    exit();
}

function emptyInputLogin($user_email, $user_pwd) {
    $result;
    if (empty($user_email) || empty($user_pwd)) {
        // some of the fields are empty, return error is true
        $result = true;
    } else {
        // all fields were filled, no error
        $result = false;
    }
    return $result;
}

function loginUser($conn, $user_email, $user_pwd) {
    $existUser = existEmail($conn, $user_email);

    if ($existUser === false) {
        header("location: ../login.php?error=unregisteredemail");
        exit();
    }

    $dbSalt = $existUser["user_salt"];
    $dbHashedPwd = $existUser["user_pwd"];

    $loginPwdHashed = hash("sha512", $dbSalt . $user_pwd);

    if (strcmp($dbHashedPwd, $loginPwdHashed) !== 0) {
        // Returns < 0 if string1 is less than string2; > 0 if string1 is greater than string2, and 0 if they are equal.
        header("location: ../login.php?error=wrongpassword");
        exit();
    } elseif (strcmp($dbHashedPwd, $loginPwdHashed) == 0) {
        session_start();

        $_SESSION["user_id"] = $existUser["user_id"];
        $_SESSION["user_email"] = $existUser["user_email"];
        $_SESSION["user_name_e"] = $existUser["user_name_e"];

        // record user's login time for 15 minutes login session
        $_SESSION["LOGGED"] = time();

        header("location: ../index.php");
        exit();
    }
}

function emptyInputAppointment($appt_date, $appt_time, $appt_location) {
    $result;
    if (empty($appt_date) || empty($appt_time) || empty($appt_location)) {
        // some of the fields are empty, return error is true
        $result = true;
    } else {
        // all fields were filled, no error
        $result = false;
    }
    return $result;
}

function emptySession($user_id, $user_email) {
    $result;
    if (empty($user_id) || empty($user_email)) {
        // empty session, return error is true
        $result = true;
    } else {
        // user detail can be found in session, no error
        $result = false;
    }
    return $result;
}

function createAppointment($conn, $appt_location, $appt_date_time, $user_id) {
    // create a sql statement to insert a new appointment
    $sql = "INSERT INTO appointments (user_id, appt_location, appt_date_time) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../appointment.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iss", $user_id, $appt_location, $appt_date_time);
    mysqli_stmt_execute($stmt);

    // for confirmation message display on the appointment page
    $_SESSION["appt_date_time"] = $appt_date_time;
    $_SESSION["appt_location"] = $appt_location;

    /* sending a confirmation email to user to confirm the appointment by using PHPMailer */
    /* mailing function refer to https://github.com/PHPMailer/PHPMailer */

    //Import PHPMailer classes into the global namespace

    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Load Mailing Config
    require '../config.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $mailhost;                              //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $mailusername;                          //SMTP username
        $mail->Password   = $mailpassword;                          //SMTP password
        $mail->SMTPSecure = $mailSMTPSecure;                        //Enable implicit TLS encryption
        $mail->Port       = $mailport;                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($mailusername, 'Appointment Reminder');
        $mail->addAddress($_SESSION["user_email"], $_SESSION["user_name_e"]);        //Add a recipient
        #$mail->addAddress('ellen@example.com');                                     //Name is optional
        #$mail->addReplyTo('info@example.com', 'Information');
        #$mail->addCC('cc@example.com');
        #$mail->addBCC('bcc@example.com');

        //Attachments
        #$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Confirmation of your HKID appointment booking';
        $mail->Body    = '<h1 style="text-align:center">Confirmation of your HKID appointment booking</h1><h3>Dear '.$_SESSION["user_name_e"].',</h3><h3>You had made an appointment on <u>'.$appt_date_time.'</u> at <u>'.$appt_location.'</u>.</h3><h3>Please remember to bring along your original HKID card or other relevant documents.</h3>';
        #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header("location: ../appointment.php?error=none");
    exit();
}