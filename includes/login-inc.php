<?php

session_start();

// check if it is access in a proper way
if (isset($_POST['submit'])) {

    /* Get form data */
    $user_email = $_POST["user_email"];
    $user_pwd = $_POST["user_pwd"];
    $captcha = $_POST["captcha"];
    $session_captcha = $_SESSION["captcha"];

    /* conect to database */
    require("../config.php");
    require("function-inc.php");

    if (matchCaptcha($session_captcha, $captcha) !== false) {
        header("location: ../login.php?error=unmatchcaptcha");
        exit();
    }

    if (emptyInputLogin($user_email, $user_pwd) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    if (invalidEmail($user_email) !== false) {
        header("location: ../login.php?error=invalidemail");
        exit();
    }

    loginUser($conn, $user_email, $user_pwd);

} else {
        // redirect to register.php
        header("location: ../login.php");
        exit();
}