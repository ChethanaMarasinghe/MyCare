<?php

require "../dbConfig/dbConfig.php";

// define variables and set to empty values
$email = $password = "";

function validate($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = validate($_POST["email"]);
  $password = validate($_POST["password"]);

  if (empty($email)) {
    header("Location: index.php?error=Email is required");
    exit();
  } elseif (empty($password)) {
    header("Location: index.php?error=Password is required");
    exit();
  } else {

    $sql = "SELECT Admin_name, Admin_email, Admin_password FROM admin WHERE Admin_email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row["Admin_password"])) {
          $_SESSION["Admin_name"] = $row["Admin_name"];
          $_SESSION["Admin_email"] = $row["Admin_email"];
          header("Location: dashboard/index.php");
          exit();
        } else {
          header("Location: index.php?error=Incorrect email or password");
          exit();
        }
      }
    } else {
      header("Location: index.php?error=Incorrect email or password");
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
  <title>Admin Login</title>
  <!-- Styles -->
  <link rel="stylesheet" href="../css/common.css">
</head>

<body>
  <form class="form admin-login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h1>Admin Login</h1>
    <label for="email">
      Email:
      <input type="email" name="email" id="email" required>
    </label>
    <label for="password">
      Password:
      <input type="password" name="password" id="password" required>
    </label>
    <label for="submit">
      <input type="submit" name="submit" id="submit" value="Login">
    </label>
  </form>
</body>

</html>