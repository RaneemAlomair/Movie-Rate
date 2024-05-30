<?php

$host = "localhost";
$database = "movie_rate";
$user = "root";
$pass = "";

$error_msg = false;
$success_msg = false;

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
} else {
    $conn->query("SET NAMES 'utf8'");
    $conn->query("SET CHARACTER SET utf8");
}
?>