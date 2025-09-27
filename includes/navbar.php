<?php 
if(session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<body>
  <header>
    <nav>
      <div class="nav-container">
        <div class="logo">EspressoEase</div>
        <div class="hamburger">
          <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links">
          <li><a href="/EspressoEase-v2/index.php">Home</a></li>
          <li><a href="/EspressoEase-v2/customer/menu/menu.php">Menu</a></li>
          <li><a href="/EspressoEase-v2/about.php">About Us</a></li>

          <?php if(isset($_SESSION["user_id"])): ?>
            <li><a href="/EspressoEase-v2/cart.php">Cart</a></li>
            <li><a href="/EspressoEase-v2/orders.php">My Orders</a></li>
            <li><a href="/EspressoEase-v2/customer/authorization/logout.php">Logout</a></li>
          <?php else: ?>
            <li><a href="/EspressoEase-v2/customer/authorization/login.php">Login</a></li>
            <li><a href="/EspressoEase-v2/customer/authorization/signup.php">Signup</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>
</body>