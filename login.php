<?php
    include_once 'header.php'
?>

<?php
if (isset($_SESSION["user_email"])) {
    // redirect user to index page as user already logged in
    header("Location: index.php");
    exit();
}
?>

<h3>Login Form</h3>
<form action="includes/login-inc.php" method="post" id="login">
    <table width="550" border="0" cellpadding="5">
        <tr>
            <td width="200" style="text-align: right">E-mail Address</td>
            <td width="300"><label for="user_email"></label>
                <input type="email" name="user_email" id="user_email" size="40" required/>
            </td>
        </tr>

        <tr>
            <td width="200" style="text-align: right">Password</td>
            <td width="300"><label for="user_pwd"></label>
                <input type="password" name="user_pwd" id="user_pwd" size="40" required/>
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right; vertical-align: bottom">Captcha Code</td>
            <td width="150"><label for="captcha"></label>
                <input type="text" name="captcha" id="captcha" size="10" required />
                <img src="includes/captcha.php?rand=<?php echo rand(); ?>" id="captcha_image">
            </td>
            <td><a href="javascript: refreshCaptcha();"><i class="fa-solid fa-arrows-rotate"></i></a>
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
        } else if ($_GET["error"] == "unmatchcaptcha") {
            echo "<p style='color:red;'>Captcha code incorrect.<br/>Please be reminded that it is case sensitive.</p>";
        } else if ($_GET["error"] == "invalidemail") {
            echo "<p style='color:red;'>Please input a valid E-mail address.</p>";
        } else if ($_GET["error"] == "unregisteredemail") {
            echo "<p style='color:red;'>E-mail has not been registered. Please register before logging in.</p>";
        } else if ($_GET["error"] == "wrongpassword") {
            echo "<p style='color:red;'>Incorrect password. Please try again.</p>";
        } else if ($_GET["error"] == "expiredsession") {
            echo "<p style='color:red;'>Login session expired.</br>You have been forced to logout for security reason.</br>Please login again if you wish make an appointment.</p>";
        } else if ($_GET["error"] == "invalidaccess") {
            echo "<p style='color:red;'>Invalid access!</br>Please login and authenticate before accessing restricted pages.</p>";
        }
    }
?>

<?php
    include_once 'footer.php'
?>