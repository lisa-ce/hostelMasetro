<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "hostel_menu_db";
$port = 3307; // change to 3306 if needed

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>