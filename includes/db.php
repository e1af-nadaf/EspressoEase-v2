<?php

$host = "localhost";
$user = "root";
$password = "poiuytrewq_9960691390";
$db = "espressoease_v2";

$conn = new mysqli($host, $user, $password, $db);

if($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

echo "Database connected successfully!";

?>