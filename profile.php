<?php
    include_once 'header.php'
?>

<?php

if (!isset($_SESSION["user_email"])) {
    // redirect user to login if user try to access without a valid access
    header("Location: login.php?error=invalidaccess");
    exit();
}

require "config.php";

$sql = "SELECT * FROM users WHERE user_email = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../profile.php?error=stmtfailed");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $_SESSION["user_email"]);
mysqli_stmt_execute($stmt);

$resultData = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($resultData)) {
    // retrieve user info from database
    // using htmlspecialchars to escape the risk for XSS attack
    $user_name_e = htmlspecialchars($row["user_name_e"]);
    $user_name_c = htmlspecialchars($row["user_name_c"]);
    $user_gender = htmlspecialchars($row["user_gender"]);
    $user_date_birth = date_format(date_create(substr(htmlspecialchars($row["user_date_birth"]), 0, 10)), "d M Y"); // for better display
    $user_place_birth = htmlspecialchars($row["user_place_birth"]);
    $user_address = htmlspecialchars($row["user_address"]);
    $user_occupation = htmlspecialchars($row["user_occupation"]);
    $user_hkid = htmlspecialchars($row["user_hkid"]);
    $user_email = htmlspecialchars($row["user_email"]);

    //decrpyt hkid and display only the first four character for security reason
    $db_iv = substr($user_hkid, 0, 32);
    $dbhexiv = hex2bin($db_iv);
    $db_hkid = substr($user_hkid, 32);
    $decrypted_user_hkid = openssl_decrypt($db_hkid, $cipher, $key, $options, $dbhexiv);
    $fourdig_hkid = substr($decrypted_user_hkid, 0, 4);
    $display_hkid = $fourdig_hkid."***(*)";

    echo "
    <h3>Profile</h3>
    <h4>Your Personal Information</h4>
    <table border='0' cellpadding='5' style='display: inline-block'>

    <tr>
    <td style='text-align: right'>English Name on ID Card</td>
    <td style='text-align: left'>$user_name_e</td>
    </tr>

    <tr>
    <td style='text-align: right'>Chinese Name on ID Card</td>
    <td style='text-align: left'>$user_name_c</td>
    </tr>

    <tr>
    <td style='text-align: right'>Gender</td>
    <td style='text-align: left'>$user_gender</td>
    </tr>

    <tr>
    <td style='text-align: right'>Date of Birth</td>
    <td style='text-align: left'>$user_date_birth</td>
    </tr>

    <tr>
    <td style='text-align: right'>Place of Birth</td>
    <td style='text-align: left'>$user_place_birth</td>
    </tr>

    <tr>
    <td style='text-align: right'>Address</td>
    <td style='text-align: left'>$user_address</td>
    </tr>

    <tr>
    <td style='text-align: right'>Occupation</td>
    <td style='text-align: left'>$user_occupation</td>
    </tr>

    <tr>
    <td style='text-align: right'>HK ID Card Number</td>
    <td style='text-align: left'>$display_hkid</td>
    </tr>

    <tr>
    <td style='text-align: right'>E-mail Address</td>
    <td style='text-align: left'>$user_email</td>
    </tr>

    </table>
    ";
}

mysqli_stmt_close($stmt);

?>

<?php
    include_once 'footer.php'
?>