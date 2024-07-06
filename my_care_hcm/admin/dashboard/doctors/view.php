<?php

require "../../../dbConfig/dbConfig.php";

if (!isset($_SESSION["Admin_name"])) {
    header("Location: /my_care_hcm/admin/index.php?error=You are not logged in");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Doctors</title>
    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/common.css">
</head>

<body>
    <div>
        <h1>View Doctors</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Fee ($)</th>
                <th>Department</th>
            </tr>
            <?php
            $sql = "SELECT doctor.Doctor_id, doctor.Doctor_name, doctor.Doctor_email, doctor.Doctor_fee, department.Department_name FROM doctor JOIN department ON doctor.Department_id = department.Department_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                        <tr>
                            <td>$row[Doctor_id]</td>
                            <td>$row[Doctor_name]</td>
                            <td>$row[Doctor_email]</td>
                            <td>$row[Doctor_fee]</td>
                            <td>$row[Department_name]</td>
                        </tr>
                    ";
                }
            } else {
                echo "
                    <tr>
                        <td colspan='2' class='empty-result'>No results found</td>
                    </tr>
                ";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div>
</body>

</html>