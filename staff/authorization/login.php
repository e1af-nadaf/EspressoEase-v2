<?php
session_start();
include "../../includes/db.php";

error_reporting(E_ALL);
ini_set("display_errors", 1);

$error = "";
$usernameValue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $usernameValue = htmlspecialchars($username);

    if (empty($username) || empty($password)) {
        $error = "Both fields are required!";
    } else {
        // Check if username exists and role is staff
        $sql = "SELECT user_id, username, password, role FROM users WHERE username = ? AND role = 'staff'";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];

                // Redirect to staff dashboard
                header("Location: ../dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "No staff account found with that username!";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<?php include "../../includes/boilerplate.php"; ?>

<div class="auth-container">
    <h1>Staff Login</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username" class="form-label">Username: </label>
            <input type="text" class="form-control" id="username" name="username" value="<?= $usernameValue ?>" required>
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

<?php include "../../includes/footer.php"; ?>
