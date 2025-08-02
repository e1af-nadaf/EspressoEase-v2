<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
?>

<body>
    <header>
        <nav>
            <div class="nav-container">
                <div class="logo">EspressoEase</div>
                <ul class="nav-links">
                    <li><a href="/EspressoEase-v2/index.php">Home</a></li>
                    <li><a href="/EspressoEase-v2/">Menu</a></li>
                    <li><a href="/EspressoEase-v2/">About Us</a></li>
                    <?php if(isset($_SESSION["user"])): ?>
                        <li><a href="/EspressoEase-v2/">Cart</a></li>
                        <li><a href="/EspressoEase-v2/">My Orders</a></li>
                        <li><a href="/EspressoEase-v2/">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/EspressoEase-v2/">Login</a></li>
                        <li><a href="/EspressoEase-v2/">Signup</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
</body>
