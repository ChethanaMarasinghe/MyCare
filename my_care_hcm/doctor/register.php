<?php

require "../dbConfig/dbConfig.php";

// define variables and set to empty values
$name = $email = $password = $fee = $department_id = "";

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validate($_POST["doctor_name"]);
    $email = validate($_POST["doctor_email"]);
    $password = validate($_POST["doctor_password"]);
    $fee = validate($_POST["doctor_fee"]);
    $department_id = validate($_POST["department_id"]);

    if (empty($email)) {
        header("Location: index.php?error=Email is required");
        exit();
    } elseif (empty($password)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO doctor (Doctor_name, Doctor_email, Doctor_password, Doctor_fee, Department_id) VALUES ('$name', '$email', '$hashed_password', '$fee', '$department_id')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("Location: index.php?success=Doctor registered successfully");
            exit();
        } else {
            header("Location: register.php?error=Failed to register doctor");
            exit();
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/common.css">
</head>

<body>
    <h2>Doctor Registration Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="doctor_name">Name:
            <input type="text" id="doctor_name" name="doctor_name" required>
        </label>

        <label for="doctor_email">Email:
            <input type="email" id="doctor_email" name="doctor_email" required>
        </label>

        <label for="doctor_password">Password:
            <input type="password" id="doctor_password" name="doctor_password" required>
        </label>

        <label for="doctor_fee">Consultation Fee ($):
            <input type="number" id="doctor_fee" name="doctor_fee" min="0" step="any" required>
        </label>

        <label for="department_id">Department:</label><br>
        <select id="department_id" name="department_id" required>
            <option value="" selected disabled>Select a department</option>
            <?php
            $sql = "SELECT Department_id, Department_name FROM department";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["Department_id"] . "'>" . $row["Department_name"] . "</option>";
            }
            ?>
        </select>

        <input type="submit" value="Register">
    </form>
</body>

</html>