<?php
require 'db.php';

$sql = "SELECT room_types.room_type_id AS id, name, description, price_per_night 
        FROM room_types";
$result = $conn->query($sql);

$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

echo json_encode(['rooms' => $rooms]);
$conn->close();
?>
