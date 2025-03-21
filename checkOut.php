<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingId = $_POST['booking_id'];

    $sql = "UPDATE bookings SET status = 'Checked Out' WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);

    if ($stmt->execute()) {
        echo "Check-out successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
