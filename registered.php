<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Successfully registered!</title>
</head>

<body>
<?php

/* conect to database */
require("connect_db.php");

/* Get form data */
$user_name_e = $_POST["user_name_e"];
$user_name_c = $_POST["user_name_c"];
$user_gender = $_POST["user_gender"];
$user_date_birth = $_POST["user_date_birth"];
$user_place_birth = $_POST["user_place_birth"];
$user_address = $_POST["user_address"];
$user_occupation = $_POST["user_occupation"];
$user_hkid = $_POST["user_hkid"];
$user_email = $_POST["user_email"];
$user_pwd = $_POST["user_pwd"];

/* execute sql */
$insert_sql = "INSERT INTO user (user_name_e, user_name_c, user_gender, user_date_birth, user_place_birth, user_address, user_occupation, user_hkid, user_email, user_pwd) VALUES ('$user_name_e', '$user_name_c', '$user_gender', '$user_date_birth', '$user_place_birth', '$user_address', '$user_occupation', '$user_hkid', '$user_email', '$user_pwd')";
mysqli_query($conn, $insert_sql);

?>
    <h3>Successfully registered!</h3>
    <p><a href="index.php">Go back to index page</a></p>
</body>

</html>