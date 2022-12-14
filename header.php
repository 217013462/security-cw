<?php
    session_start();

    if (isset($_SESSION['LOGGED']) && (time() - $_SESSION['LOGGED'] > 900)) {
        // user was logged in for more than 15 minutes (900 seconds)
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        header("Location: login.php?error=expiredsession");
        exit();
    }
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Online Appointment Booking System of Hong Kong Identity Cards</title>
    <style>
    body {
        font-family: "Poppins";
        text-align: center;
    }

    form {
        display: inline-block;
    }

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #34495E;
        text-transform: uppercase;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover:not(.active) {
        background-color: #212F3C;
    }
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>

            <?php

                if (isset($_SESSION["user_email"])) {
                    echo "<li><a href='profile.php'>Profile</a></li>";
                    echo "<li><a href='appointment.php'>Appointment</a></li>";
                    echo "<li style='float:right'><a href='includes/logout-inc.php'>Logout</a></li>";
                } else {
                    echo "<li style='float:right'><a href='login.php'>Login</a></li>";
                    echo "<li style='float:right'><a href='register.php'>Register</a></li>";
                }
                
            ?>

        </ul>
    </nav>

    <script>
    //Refresh Captcha
    function refreshCaptcha() {
        var img = document.images['captcha_image'];
        img.src = img.src.substring(
            0, img.src.lastIndexOf("?")
        ) + "?rand=" + Math.random() * 1000;
    }
    </script>