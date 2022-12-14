<?php

session_start();

// check if it is access in a proper way
if (isset($_POST['submit'])) {
    /* Get form data */
    $user_name_e = $_POST["user_name_e"];
    $user_name_c = $_POST["user_name_c"];
    $user_gender = $_POST["user_gender"];
    $user_date_birth = $_POST["user_date_birth"];
    $user_place_birth = htmlspecialchars($_POST["user_place_birth"]);
    $user_address = htmlspecialchars($_POST["user_address"]);
    $user_occupation = htmlspecialchars($_POST["user_occupation"]);
    $user_hkid = $_POST["user_hkid"];
    $user_email = $_POST["user_email"];
    $user_pwd = $_POST["user_pwd"];
    $cfm_pwd = $_POST["cfm_pwd"];
    $captcha = $_POST["captcha"];
    $session_captcha = $_SESSION["captcha"];
    
    /* conect to database */
    require("../config.php");
    require("function-inc.php");
    
    if (matchCaptcha($session_captcha, $captcha) !== false) {
        header("location: ../register.php?error=unmatchcaptcha");
        exit();
    }
    
    if (emptyInputRegister($user_name_e, $user_name_c, $user_gender, $user_date_birth, $user_place_birth, $user_address, $user_occupation, $user_hkid, $user_email, $user_pwd, $cfm_pwd, $captcha) !== false) {
        header("location: ../register.php?error=emptyinput");
        exit();
    }
    
    if (invalidEmail($user_email) !== false) {
        header("location: ../register.php?error=invalidemail");
        exit();
    }
    
    if (invalidCName($user_name_c) !== false) {
        header("location: ../register.php?error=invalidcname");
        exit();
    }
    
    if (invalidEName($user_name_e) !== false) {
        header("location: ../register.php?error=invalidename");
        exit();
    }
    
    if (invalidHKID($user_hkid) !== false) {
        header("location: ../register.php?error=invalidhkid");
        exit();
    }
    
    if (invalidPwd($user_pwd) !== false) {
        header("location: ../register.php?error=invalidpassword");
        exit();
    }
    
    if (spacePwd($user_pwd) !== false) {
        header("location: ../register.php?error=spacepassword");
        exit();
    }
    
    if (matchPwd($user_pwd, $cfm_pwd) !== false) {
        header("location: ../register.php?error=unmatchpassword");
        exit();
    }
    
    if (existEmail($conn, $user_email) !== false) {
        header("location: ../register.php?error=existedemail");
        exit();
    }
    
    if (existHKID($conn, $user_hkid) !== false) {
        header("location: ../register.php?error=existedhkid");
        exit();
    }

    createUser($conn, $user_name_e, $user_name_c, $user_gender, $user_date_birth, $user_place_birth, $user_address, $user_occupation, $user_hkid, $user_email, $user_pwd);


} else {
    // redirect to register.php
    header("location: ../register.php");
    exit();
}