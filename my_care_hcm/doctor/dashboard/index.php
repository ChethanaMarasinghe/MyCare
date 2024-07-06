<?php

require "../../dbConfig/dbConfig.php";

if (!isset($_SESSION["Doctor_name"])) {
    header("Location: /my_care_hcm/doctor/index.php?error=You are not logged in");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Doctor</title>
</head>

<body>
    <a href="logout.php">Logout</a>
    <div>
        <p>Hello, <?php echo $_SESSION["Doctor_name"]; ?></p>
        <p><?php echo $_SESSION["Doctor_email"]; ?></p>
    </div>
    <!-- Dashboard -->
    <div>
        <p>Manage Appointments</p>
        <ul>
            <li><a href="appointments/view.php">View Appointments</a></li>
        </ul>
    </div>
</body>

</html>