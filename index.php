<?php
    include_once 'header.php'
?>

<h1 style="text-align: center;">
    <strong>
        Welcome to Online Appointment Booking System of Hong Kong Identity Cards!
    </strong>
</h1>


<?php
    if (isset($_SESSION["user_name_e"])) {
        $user_name_e = $_SESSION["user_name_e"];
        echo "</br>";
        echo "<h2>Welcome $user_name_e !</h2><h2>You can make new appointments to apply or replace your HKID <a href='appointment.php' style='color:#2980B9;'>here</a>!</h2>";
        echo "</br></br>";
        echo "<h3>For security reason, you will be automatically logout after you logged in for <u style='color:red'>15 minutes</u>.</br>";
        echo "Sorry for any inconvience caused.</h3>";
    } else {
        echo "<h2>Please login to the system for making new appointments.</h2>";
    }
?>

<?php
    include_once 'footer.php'
?>