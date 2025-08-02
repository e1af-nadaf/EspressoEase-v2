<?php

$host = "localhost";
$user = "root";
$pass = "poiuytrewq_9960691390";
$db = "espressoease_v2";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

?>