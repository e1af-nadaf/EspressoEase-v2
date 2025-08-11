<?php include "includes/boilerplate.php" ?>

<?php if (isset($_SESSION["user_id"])): ?>
    <p class="welcome-text">Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</p>
<?php endif; ?>


<?php include "includes/footer.php" ?>

