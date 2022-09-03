<?php
    include_once 'header.php'
?>

<h3>Login Form</h3>
<form action="includes/login-inc.php" method="post" id="login">
    <table width="550" border="0" cellpadding="5">
        <tr>
            <td width="200">E-mail Address</td>
            <td width="300"><label for="user_email"></label>
                <input type="text" name="user_email" id="user_email" size="40" />
            </td>
        </tr>

        <tr>
            <td width="200">Password</td>
            <td width="300"><label for="user_pwd"></label>
                <input type="password" name="user_pwd" id="user_pwd" size="40" />
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
    include_once 'footer.php'
?>