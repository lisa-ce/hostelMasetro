<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "hostel_menu_db";
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>