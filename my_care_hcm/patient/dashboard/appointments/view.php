<?php

require "../../../dbConfig/dbConfig.php";

if (!isset($_SESSION["Patient_name"])) {
    header("Location: /my_care_hcm/patient/index.php?error=You are not logged in");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/common.css">
</head>

<body>
    <div>
        <h1>View Appointments</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Doctor Name</th>
                <th>Room Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            <?php
            $sql = "SELECT appointment.Appointment_id, patient.Patient_name, doctor.Doctor_name, room.Room_name, appointment.Date, appointment.Start_time, appointment.End_time FROM appointment JOIN patient ON appointment.Patient_id = patient.Patient_id JOIN doctor ON appointment.Doctor_id = doctor.Doctor_id JOIN room ON appointment.Room_id = room.Room_id WHERE patient.Patient_id = $_SESSION[Patient_id];";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                        <tr>
                            <td>$row[Appointment_id]</td>
                            <td>$row[Doctor_name]</td>
                            <td>$row[Room_name]</td>
                            <td>$row[Date]</td>
                            <td>$row[Start_time]</td>
                            <td>$row[End_time]</td>
                        </tr>
                    ";
                }
            } else {
                echo "
                    <tr>
                        <td colspan='6' class='empty-result'>No results found</td>
                    </tr>
                ";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div>
</body>

</html>