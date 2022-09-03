<?php

function emptyInputRegister($user_name_e, $user_name_c, $user_gender, $user_date_birth, $user_place_birth, $user_address, $user_occupation, $user_hkid, $user_email, $user_pwd, $cfm_pwd) {
    $result;
    if (empty($user_name_e) || empty($user_name_c) || empty($user_gender) || empty($user_date_birth) || empty($user_place_birth) || empty($user_address) || empty($user_occupation) || empty($user_hkid) || empty($user_email) || empty($user_pwd) || empty($cfm_pwd)) {
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

    $existUser = existEmail($conn, $user_email);

    $dbSalt = $existUser["user_salt"];
    $dbHashedHKID = $existUser["user_hkid"];

    $inputHKIDHashed = hash("sha512", $dbSalt . $user_hkid);

    if (strcmp($dbHashedHKID, $inputHKIDHashed) == 0) {
        // Returns < 0 if string1 is less than string2; > 0 if string1 is greater than string2, and 0 if they are equal.
        // equal means the input HKID existed in database
        $result = true;
    } else {
        // HKID has not been registered, no error
        $result = false;
    }
    return $result;
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

    $salt = generateSalt(16);

    $hashedHKID = hash("sha512", $salt . $user_hkid);
    $hashedPwd = hash("sha512", $salt . $user_pwd);

    mysqli_stmt_bind_param($stmt, "sssssssssss", $user_name_e, $user_name_c, $user_gender, $user_date_birth, $user_place_birth, $user_address, $user_occupation, $hashedHKID, $user_email, $salt, $hashedPwd);
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
        header("location: ../index.php");
        exit();
    }
}