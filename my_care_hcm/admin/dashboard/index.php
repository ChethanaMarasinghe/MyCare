<?php

require "../../dbConfig/dbConfig.php";

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
    <title>Document</title>
</head>

<body>
    <a href="logout.php">Logout</a>
    <div>
        <p>Hello, <?php echo $_SESSION["Admin_name"]; ?></p>
        <p><?php echo $_SESSION["Admin_email"]; ?></p>
    </div>
    <!-- Dashboard -->
    <div>
        <p>Manage Departments</p>
        <ul>
            <li><a href="departments/view.php">View Departments</a></li>
            <li><a href="departments/add.php">Add Department</a></li>
        </ul>
        <p>Manage Doctors</p>
        <ul>
            <li><a href="doctors/view.php">View Doctors</a></li>
            <!-- <li><a href="doctors/add.php">Add Doctors</a></li> -->
        </ul>
        <p>Manage Rooms</p>
        <ul>
            <li><a href="rooms/add.php">Add Room</a></li>
        </ul>
    </div>
</body>

</html>