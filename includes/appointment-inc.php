<?php

    session_start();

// check if it is access in a proper way
if (isset($_POST['submit'])) {
    /* Get form data */
    $appt_date = $_POST["appt_date"];
    $appt_time = $_POST["appt_time"];
    $appt_location = $_POST["appt_location"];

    $appt_date_time = $appt_date." ".$appt_time;

    $user_id = $_SESSION["user_id"];
    $user_email = $_SESSION["user_email"];

    /* conect to database */
    require("../config.php");
    require("function-inc.php");

    if (emptyInputAppointment($appt_date, $appt_time, $appt_location) !== false) {
        header("location: ../appointment.php?error=emptyinput");
        exit();
    }

    if (emptySession($user_id, $user_email) !== false) {
        header("location: ../appointment.php?error=sessionerror");
        exit();
    }
    
    createAppointment($conn, $appt_location, $appt_date_time, $user_id);

} else {
    // redirect to appointment.php
    header("location: ../appointment.php");
    exit();
}