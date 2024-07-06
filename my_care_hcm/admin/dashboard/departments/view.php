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
    <title>Document</title>
    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/common.css">
</head>

<body>
    <div>
        <h1>View Departments</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
            <?php
            $sql = "SELECT Department_id, Department_name FROM department";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                        <tr>
                            <td>$row[Department_id]</td>
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