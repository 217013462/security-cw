<?php

// check if it is access in a proper way
if (isset($_POST['submit'])) {

    /* Get form data */
    $user_email = $_POST["user_email"];
    $user_pwd = $_POST["user_pwd"];

    /* conect to database */
    require("../config.php");
    require("function-inc.php");

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