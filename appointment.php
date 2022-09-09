<?php
    include_once 'header.php'
?>

<?php
    if(!isset($_SESSION['user_name_e'])) {
        header("location: ../cw/login.php");
        exit();
    }
?>

<h3>Make an appointment</h3>
<form action="includes/appointment-inc.php" method="post" id="appt">
    <table width="350" border="0" cellpadding="5">
        <tr>
            <td width="100">Date</td>
            <td width="200"><label for="appt_date"></label>
                <input type="date" name="appt_date" id="appt_date" size="40" required />
            </td>
        </tr>

        <tr>
            <td width="100">Time</td>
            <td width="200"><label for="appt_time"></label>
                <input type="time" name="appt_time" id="appt_time" size="40" required />
            </td>
        </tr>

        <tr>
            <td width="100">Location</td>
            <td width="200"><label for="appt_location"></label>
                <select name="appt_location" id="appt_location" required>
                    <option value="" disabled selected>Select your preference location</option>
                    <optgroup label="Hong Kong Island">
                        <option value="Wan Chai">Wan Chai</option>
                    </optgroup>
                    <optgroup label="Kowloon">
                        <option value="Kwun Tong">Kwun Tong</option>
                        <option value="Mong Kok">Mong Kok</option>
                    </optgroup>
                    <optgroup label="New Territories">
                        <option value="Tsuen Wan">Tsuen Wan</option>
                        <option value="Sha Tin">Sha Tin</option>
                        <option value="Sheung Shui">Sheung Shui</option>
                        <option value="Tuen Mun">Tuen Mun</option>
                        <option value="Yuen Long">Yuen Long</option>
                        <option value="Tseung Kwan O">Tseung Kwan O</option>
                    </optgroup>
                </select>
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