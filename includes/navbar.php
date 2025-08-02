<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EspressoEase</title>
    <link rel="stylesheet" href="/EspressoEase-v2/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

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

</html>