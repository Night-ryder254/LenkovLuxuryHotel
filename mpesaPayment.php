<?php
header("Content-Type: application/json");

// Capture input JSON
$input = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($input['phone'], $input['amount'], $input['room_id'], $input['check_in_date'], $input['check_out_date'])) {
    echo json_encode(["status" => "Error", "message" => "Missing required fields"]);
    exit();
}

// Mpesa API configuration
$consumerKey = "rG4sKTCYZVCcL32SROVSNK1OWxliu1n8BiG0xgXUtUdSg1Ap";
$consumerSecret = "AnnjSAEOewu9Pc0DEutNrM0NAkk5BJrP5qYTkX0ZwVbCXdW1WCFbfxbf3GuvwJC6";
$businessShortCode = "174379";
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$callbackUrl = "https://d096-105-160-67-63.ngrok-free.app/lenkovluxuryhotel/paymentCallback.php";

// Generate access token
$tokenUrl = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
$credentials = base64_encode("$consumerKey:$consumerSecret");

$curl = curl_init($tokenUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Basic $credentials"]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo json_encode(["status" => "Error", "message" => "cURL Error: " . curl_error($curl)]);
    curl_close($curl);
    exit();
}

curl_close($curl);
$tokenResponse = json_decode($response, true);

if (!isset($tokenResponse['access_token'])) {
    echo json_encode(["status" => "Error", "message" => "Failed to generate access token"]);
    exit();
}

$accessToken = $tokenResponse['access_token'];

// Initiate STK Push
$stkPushUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
$timestamp = date("YmdHis");
$password = base64_encode($businessShortCode . $passkey . $timestamp);

// Validate and sanitize amount
$amount = (int)$input['amount'];
if ($amount <= 0) {
    echo json_encode(["status" => "Error", "message" => "Invalid amount"]);
    exit();
}

// Validate phone number
$phone = preg_replace('/\D/', '', $input['phone']); // Remove non-numeric characters
if (strlen($phone) != 12 || substr($phone, 0, 3) != "254") { // Ensure phone starts with '254'
    echo json_encode(["status" => "Error", "message" => "Invalid phone number"]);
    exit();
}

$requestData = [
    "BusinessShortCode" => $businessShortCode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phone,
    "PartyB" => $businessShortCode,
    "PhoneNumber" => $phone,
    "CallBackURL" => $callbackUrl,
    "AccountReference" => "Booking_" . $input['room_id'],
    "TransactionDesc" => "Room booking payment"
];

$curl = curl_init($stkPushUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken",
    "Content-Type: application/json"
]);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo json_encode(["status" => "Error", "message" => "cURL Error: " . curl_error($curl)]);
    curl_close($curl);
    exit();
}

curl_close($curl);
$stkResponse = json_decode($response, true);

if (isset($stkResponse['ResponseCode']) && $stkResponse['ResponseCode'] == "0") {
    echo json_encode([
        "status" => "Success",
        "message" => "Payment initiated successfully",
        "mpesa_reference" => $stkResponse['CheckoutRequestID']
    ]);
} else {
    $message = isset($stkResponse['errorMessage']) ? $stkResponse['errorMessage'] : "Failed to initiate payment";
    echo json_encode(["status" => "Error", "message" => $message]);
}
?>
