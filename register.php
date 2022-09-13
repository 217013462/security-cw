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

<h3>Register Form</h3>
<p>Fill in the following form for apply or replace your HKID</p>
<form action="includes/register-inc.php" method="post" id="register">
    <table width="900" border="0" cellpadding="5">
        <tr>
            <td width="250" style="text-align: right">English Name on ID Card</td>
            <td width="350"><label for="user_name_e"></label>
                <input type="text" name="user_name_e" id="user_name_e" size="45" required />
            </td>
            <td width="250" style="color:grey; font-size:small;">At least 2 English words start with capital letter</td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Chinese Name on ID Card</td>
            <td width="350"><label for="user_name_c"></label>
                <input type="text" name="user_name_c" id="user_name_c" size="45" required />
            </td>
            <td width="250" style="color:grey; font-size:small;">At least 2 Chinese characters</td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Gender</td>
            <td width="350">
                <input type="radio" id="user_gender" name="user_gender" value="Male" required>
                <label for="Male">Male</label>
                <input type="radio" id="user_gender" name="user_gender" value="Female" required>
                <label for="Female">Female</label>
                <input type="radio" id="user_gender" name="user_gender" value="Other" required>
                <label for="Other">Other</label>
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Date of Birth</td>
            <td width="350"><label for="user_date_birth"></label>
                <input type="date" id="user_date_birth" name="user_date_birth" max="<?php echo date("Y-m-d"); ?>"
                    required>
                <!-- restrict user from selecting date in the future -->
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Place of Birth</td>
            <td width="350"><label for="user_place_birth"></label>
                <input type="text" name="user_place_birth" id="user_place_birth" size="45" required />
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Address</td>
            <td width="350"><label for="user_address"></label>
                <input type="text" name="user_address" id="user_address" size="45" required />
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Occupation</td>
            <td width="350"><label for="user_occupation"></label>
                <input type="text" name="user_occupation" id="user_occupation" size="45" required />
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">HK ID Card Number</td>
            <td width="350"><label for="user_hkid"></label>
                <input type="password" name="user_hkid" id="user_hkid" size="45" placeholder="C668668(E)" required />
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">E-mail Address</td>
            <td width="350"><label for="user_email"></label>
                <input type="email" name="user_email" id="user_email" size="45" placeholder="hkid@example.com"
                    required />
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Password</td>
            <td width="350"><label for="user_pwd"></label>
                <input type="password" name="user_pwd" id="user_pwd" size="45" required />
            </td>
            <td width="250" style="color:grey; font-size:small;">8 or more characters with 1 lowercase, 1 uppercase, 1
                number, 1 special character (No space)</td>
        </tr>

        <tr>
            <td width="250" style="text-align: right">Confirm Password</td>
            <td width="350"><label for="cfm_pwd"></label>
                <input type="password" name="cfm_pwd" id="cfm_pwd" size="45" required />
            </td>
        </tr>

        <tr>
            <td width="250" style="text-align: right; vertical-align: bottom">Captcha Code</td>
            <td width="150"><label for="captcha"></label>
                <input type="text" name="captcha" id="captcha" size="15" required />
                <img src="includes/captcha.php?rand=<?php echo rand(); ?>" id="captcha_image">
            </td>
            <td><a href="javascript: refreshCaptcha();"><i class="fa-solid fa-arrows-rotate"></i></a>
            </td>
        </tr>

        <tr>
            <td></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td style="text-align:center"><input name="submit" type="submit" value="Submit"></td>
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
        } else if ($_GET["error"] == "invalidcname") {
            echo "<p style='color:red;'>Please input at least 2 Chinese characters.</p>";
        } else if ($_GET["error"] == "invalidename") {
            echo "<p style='color:red;'>Please input at least 2 English words start with capital letter.</p>";
        } else if ($_GET["error"] == "invalidhkid") {
            echo "<p style='color:red;'>Please input a valid HKID.<br/>A valid HKID starts with 1-2 capital letters, follow by 6 numbers, and end with a number or A inside a parentheses.</p>";
        } else if ($_GET["error"] == "invalidpassword") {
            echo "<p style='color:red;'>Please input a valid password.<br/>It should be combine with at least 1 uppercase letter, 1 lowercase letter, 1 number, 1 special character, with mpre than 8 characters.</p>";
        } else if ($_GET["error"] == "spacepassword") {
            echo "<p style='color:red;'>Please input a valid password.<br/>No space is allowed</p>";
        } else if ($_GET["error"] == "unmatchpassword") {
            echo "<p style='color:red;'>Password and confirm password are not the same.</p>";
        } else if ($_GET["error"] == "existedemail") {
            echo "<p style='color:red;'>The E-mail is already registered.<br/>Please login or use another e-mail.</p>";
        } else if ($_GET["error"] == "existedhkid") {
            echo "<p style='color:red;'>The HKID is already registered under another e-mail.<br/>Please check again or login with registered e-mail.</p>";
        } else if ($_GET["error"] == "stmtfailed") {
            echo "<p style='color:red;'>Something went wrong. Please try again.</p>";
        } else if ($_GET["error"] == "none") {
            echo "<p style='color:green;'>Successfully reigstered!</p>";
        }
    }
?>

<?php
    include_once 'footer.php'
?>