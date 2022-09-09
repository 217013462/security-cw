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
<p>Appointments available for the next 30 days</p>
<form action="includes/appointment-inc.php" method="post" id="appt">
    <table width="350" border="0" cellpadding="5">
        <tr>
            <td width="100">Date</td>
            <td width="200"><label for="appt_date"></label>
                <input type="date" name="appt_date" id="appt_date" size="40"
                    min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>"
                    max="<?php echo date("Y-m-d", strtotime("+30 day")); ?>" required />
            </td>
        </tr>

        <tr>
            <td width="100">Time</td>
            <td width="200"><label for="appt_time"></label>
                <select name="appt_time" id="appt_time" required>
                    <option value="" disabled selected>Select your preference time</option>
                    <option value="08:00">08:00</option>
                    <option value="08:30">08:30</option>
                    <option value="09:00">09:00</option>
                    <option value="09:30">09:30</option>
                    <option value="10:00">10:00</option>
                    <option value="10:30">10:30</option>
                    <option value="11:00">11:00</option>
                    <option value="11:30">11:30</option>
                    <option value="12:00">12:00</option>
                    <option value="12:30">12:30</option>
                    <option value="13:00">13:00</option>
                    <option value="13:30">13:30</option>
                    <option value="14:00">14:00</option>
                    <option value="14:30">14:30</option>
                    <option value="15:00">15:00</option>
                    <option value="15:30">15:30</option>
                    <option value="16:00">16:00</option>
                    <option value="16:30">16:30</option>
                    <option value="17:00">17:00</option>
                    <option value="17:30">17:30</option>
                    <option value="18:00">18:00</option>
                    <option value="18:30">18:30</option>
                    <option value="19:00">19:00</option>
                    <option value="19:30">19:30</option>
                    <option value="20:00">20:00</option>
                    <option value="20:30">20:30</option>
                    <option value="21:00">21:00</option>
                    <option value="21:30">21:30</option>
                </select>
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