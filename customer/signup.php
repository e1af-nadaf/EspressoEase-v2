<?php 
session_start();
include "../includes/db.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

$success = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];

  if (empty($username) || empty($email) || empty($password)) {
    $error = "All fields are required!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format!";
  } elseif ($password !== $confirm_password) {
    $error = "Passwords do not match!";
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //check if emal already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0) {
      $error = "Email is already registered!";
    } else {
      $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sss", $username, $email, $hashed_password);
      if($stmt->execute()) {
        $success = "Signed up successfully! Redirecting...";
        echo "<script>
          setTimeout(function() {
          window.location.href = 'login.php';
          }, 2000);
        </script>";
      } else {
        $error = "Signup failed. Please try again.";
      }
      $stmt->close();
    }
    $check->close();
  }
}
$conn->close();
?>

  <?php include "../includes/boilerplate.php"; ?>

  <div class="signup-container">
    <h1>Create New Account</h1>

    <?php 
    if (!empty($success)) {
      echo "<p class='success'>" . htmlspecialchars($success) . "</p>";
    }
    if (!empty($error)) {
      echo "<p class='error'>" . htmlspecialchars($error) . "</p>";
    }
    ?>

    <form action="signup.php" method="POST">
      <div class="form-group">
        <label for="username" class="form-label">Username: </label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email" class="form-label">Email: </label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password" class="form-label">Password: </label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirm_password" class="form-label">Confirm Password: </label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>
      <div class="btn-container">
        <button class="btn" type="submit">Sign Up</button>
      </div>
    </form>

    
  </div>


