<?php
// Database configuration template
// Copy this file to db.php and fill in your actual credentials

$host = "localhost";
$username = "your_database_username";
$password = "your_database_password";
$dbname = "hotel_booking_system";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>