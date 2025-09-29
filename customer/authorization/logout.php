<?php
session_start();
session_unset();
session_destroy();

session_start();
header("Location: /EspressoEase-v2/customer/authorization/login.php");
exit();
?>