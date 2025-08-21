<?php
session_start();
session_unset(); 
session_destroy();

session_start();
$_SESSION['message'] = "You have been logged out successfully.";

header("Location: /EspressoEase-v2/index.php");
exit();
