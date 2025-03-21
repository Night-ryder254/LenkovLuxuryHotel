<?php
require 'db.php'; // Include your database connection

// Log callback data for debugging
$callbackData = json_decode(file_get_contents('php://input'), true);
file_put_contents('mpesa_callback.log', print_r($callbackData, true), FILE_APPEND);

if (isset($callbackData['Body']['stkCallback']['ResultCode'])) {
    $resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
    $resultDesc = $callbackData['Body']['stkCallback']['ResultDesc'];
    $checkoutRequestId = $callbackData['Body']['stkCallback']['CheckoutRequestID'];
    $mpesaReceipt = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'] ?? null;
    
    // Update database based on payment result
    $status = ($resultCode == 0) ? 'Paid' : 'Failed';
    
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = ?, mpesa_reference = ? WHERE mpesa_reference = ?");
    $stmt->bind_param("sss", $status, $mpesaReceipt, $checkoutRequestId);
    $stmt->execute();
    $stmt->close();
}
?>

