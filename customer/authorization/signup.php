<?php 

session_start();
include "../../includes/db.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

$success = "";
$error = "";

$usernameValue = "";
$emailValue = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];

  $usernameValue = htmlspecialchars($username);
  $emailValue = htmlspecialchars($email);

  if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $error = "All fields are required!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format!";
  } elseif ($password !== $confirm_password) {
    $error = "Passwords do not match!";
  } elseif (strlen($password) < 8) {
    $error = "Password must be at least 8 characters long!";
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0) {
      $error = "Email is already registered!";
    } else {
      $checkUser = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
      $checkUser->bind_param("s", $username);
      $checkUser->execute();
      $checkUser->store_result();

      if($checkUser->num_rows > 0) {
        $error = "Username is already taken!";
      } else {
        $sql = "INSERT INTO users (username, email, password, role, created_at) 
        VALUES (?, ?, ?, 'customer', NOW())";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
          die("Prepare failed: ". $conn->error);
        }

        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
          // Auto-login after signup
          $_SESSION['user_id'] = $conn->insert_id;
          $_SESSION['username'] = $username;
          $_SESSION['email'] = $email;
          $_SESSION['role'] = "customer";

          $success = "Account created successfully! Redirecting...";
          echo "<script>
            setTimeout(function() {
              window.location.href = '../../dashboard.php';
            }, 2000);
          </script>";
        } else {
          $error = "Signup failed. Please try again." . $stmt->error;
        }
        $stmt->close();
      }
      $checkUser->close();
    }
    $check->close();
  }
}

$conn->close();

?>

<?php include "../../includes/boilerplate.php" ?>

<div class="auth-container">
  <h1>Create New Account</h1>

  <?php 
  if(!empty($success)) {
    echo "<p class='success'>" . $success . "</p>";
  }
  if(!empty($error)) {
    echo "<p class='error'>" . $error . "</p>";
  }
  ?>

  <form action="signup.php" method="POST">
    <div class="form-group">
      <label for="username" class="form-label">Username: </label>
      <input type="text" class="form-control" id="username" name="username" value="<?= $usernameValue ?>" required>
    </div>
    <div class="form-group">
      <label for="email" class="form-label">Email: </label>
      <input type="email" class="form-control" id="email" name="email" value="<?= $emailValue ?>" required>
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
      <button class="btn">Sign Up</button>
    </div>
  </form>
</div>

<?php include "../../includes/footer.php" ?>