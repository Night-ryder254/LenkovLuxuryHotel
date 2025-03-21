<?php
require 'db.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    die("Unauthorized access.");
}

$customerId = $_SESSION['customer_id'];

$sql = "SELECT bookings.booking_id, room_number, check_in_date, check_out_date, total_price, status 
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.room_id 
        WHERE bookings.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

echo json_encode(['bookings' => $bookings]);
$stmt->close();
$conn->close();
?>
