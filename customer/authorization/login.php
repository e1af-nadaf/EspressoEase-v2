<?php
session_start();
include "../../includes/db.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

$error = "";
$emailValue = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $emailValue = htmlspecialchars($email);

    if(empty($email) || empty($password)) {
        $error = "Both fields are required!";
    } else {
        // check if email exists
        $sql = "SELECT user_id, username, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if(!$stmt){
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // verify password
            if(password_verify($password, $user["password"])) {
                // login success -> set session
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];

                header("Location: ../menu/menu.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "No account found with that email!";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<?php include "../../includes/boilerplate.php" ?>

<div class="auth-container">
  <h1>Login</h1>

  <?php if(!empty($error)) echo "<p class='error'>{$error}</p>"; ?>

  <form action="login.php" method="POST">
    <div class="form-group">
      <label for="email" class="form-label">Email: </label>
      <input type="email" class="form-control" id="email" name="email" value="<?= $emailValue ?>" required>
    </div>
    <div class="form-group">
      <label for="password" class="form-label">Password: </label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="btn-container">
      <button class="btn" type="submit">Login</button>
    </div>
  </form>
</div>

<?php include "../../includes/footer.php" ?>
