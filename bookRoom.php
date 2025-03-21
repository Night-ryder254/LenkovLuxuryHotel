<?php
require 'db.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerId = $_SESSION['customer_id'];
    $roomId = $_POST['room_id'];
    $checkIn = $_POST['check_in_date'];
    $checkOut = $_POST['check_out_date'];
    $totalPrice = $_POST['total_price'];

    $sql = "INSERT INTO bookings (customer_id, room_id, check_in_date, check_out_date, total_price) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissd", $customerId, $roomId, $checkIn, $checkOut, $totalPrice);

    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
