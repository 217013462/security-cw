<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Register</title>
</head>


<body>
    <h3>Register Form</h3>
    <p>Fill in the following form for apply or replace your HKID</p>
    <form action="registered.php" method="post" id="form1">
        <table width="850" border="0" cellpadding="5">
            <tr>
                <td width="200">English Name on ID Card</td>
                <td width="300"><label for="user_name_e"></label>
                    <input type="text" name="user_name_e" id="user_name_e" size="40" />
                </td>
                <td width="300" style="color:grey; font-size:small;">At least 2 English words start with capital letter</td>
            </tr>

            <tr>
                <td width="200">Chinese Name on ID Card</td>
                <td width="300"><label for="user_name_c"></label>
                    <input type="text" name="user_name_c" id="user_name_c" size="40" />
                </td>
                <td width="200" style="color:grey; font-size:small;">At least 2 Chinese characters</td>
            </tr>

            <tr>
                <td width="200">Gender</td>
                <td width="300">
                    <input type="radio" id="user_gender" name="user_gender" value="Male">
                    <label for="Male">Male</label>
                    <input type="radio" id="user_gender" name="user_gender" value="Female">
                    <label for="Female">Female</label>
                </td>
            </tr>

            <tr>
                <td width="200">Date of Birth</td>
                <td width="300"><label for="user_date_birth"></label>
                    <input type="date" id="user_date_birth" name="user_date_birth" max="<?php echo date("Y-m-d"); ?>">
                    <!-- restrict user from selecting date in the future -->
                </td>
            </tr>

            <tr>
                <td width="200">Place of Birth</td>
                <td width="300"><label for="user_place_birth"></label>
                    <input type="text" name="user_place_birth" id="user_place_birth" size="40" />
                </td>
            </tr>

            <tr>
                <td width="200">Address</td>
                <td width="300"><label for="user_address"></label>
                    <input type="text" name="user_address" id="user_address" size="40" />
                </td>
            </tr>

            <tr>
                <td width="200">Occupation</td>
                <td width="300"><label for="user_occupation"></label>
                    <input type="text" name="user_occupation" id="user_occupation" size="40" />
                </td>
            </tr>

            <tr>
                <td width="200">HK ID Card Number</td>
                <td width="300"><label for="user_hkid"></label>
                    <input type="text" name="user_hkid" id="user_hkid" size="40" placeholder="C668668(E)"/>
                </td>
            </tr>

            <tr>
                <td width="200">E-mail Address</td>
                <td width="300"><label for="user_email"></label>
                    <input type="text" name="user_email" id="user_email" size="40" placeholder="hkid@example.com"/>
                </td>
            </tr>

            <tr>
                <td width="200">Password</td>
                <td width="300"><label for="user_pwd"></label>
                    <input type="text" name="user_pwd" id="user_pwd" size="40" />
                </td>
                <td width="200" style="color:grey; font-size:small;">At least 8 characters with combination of letters, numbers, and symbols</td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td><input name="submit" type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>

</html>