<?php
    include_once 'header.php'
?>

<h3>Login Form</h3>
<form action="includes/login-inc.php" method="post" id="login">
    <table width="550" border="0" cellpadding="5">
        <tr>
            <td width="200">E-mail Address</td>
            <td width="300"><label for="user_email"></label>
                <input type="email" name="user_email" id="user_email" size="40" required/>
            </td>
        </tr>

        <tr>
            <td width="200">Password</td>
            <td width="300"><label for="user_pwd"></label>
                <input type="password" name="user_pwd" id="user_pwd" size="40" required/>
            </td>
        </tr>

        <tr>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" value="Submit"></td>
        </tr>
    </table>
</form>

<?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p style='color:red;'>Please make sure all fields are filled.</p>";
        } else if ($_GET["error"] == "invalidemail") {
            echo "<p style='color:red;'>Please input a valid E-mail address.</p>";
        } else if ($_GET["error"] == "unregisteredemail") {
            echo "<p style='color:red;'>E-mail has not been registered. Please register before logging in.</p>";
        } else if ($_GET["error"] == "wrongpassword") {
            echo "<p style='color:red;'>Incorrect password. Please try again.</p>";
        }
    }
?>

<?php
    include_once 'footer.php'
?>