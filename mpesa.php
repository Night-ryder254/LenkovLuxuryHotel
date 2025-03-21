<?php
// Mpesa API Credentials
define('CONSUMER_KEY', 'rG4sKTCYZVCcL32SROVSNK1OWxliu1n8BiG0xgXUtUdSg1Ap'); 
define('CONSUMER_SECRET', 'AnnjSAEOewu9Pc0DEutNrM0NAkk5BJrP5qYTkX0ZwVbCXdW1WCFbfxbf3GuvwJC6

');
define('SHORTCODE', '174379');
define('PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'); 
define('ENVIRONMENT', 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'); // Use 'sandbox' or 'production'

function getAccessToken() {
    $url = ENVIRONMENT === 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest' 
        ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    
    $credentials = base64_encode(CONSUMER_KEY . ':' . CONSUMER_SECRET);
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Basic $credentials"]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);
    
    return $response['access_token'] ?? null;
}

function initiateSTKPush($phone, $amount, $callbackUrl) {
    $accessToken = getAccessToken();
    if (!$accessToken) {
        return ['status' => 'Error', 'message' => 'Failed to get access token'];
    }
    
    $timestamp = date('YmdHis');
    $password = base64_encode(SHORTCODE . PASSKEY . $timestamp);
    
    $url = ENVIRONMENT === 'sandbox' 
        ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
        : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    
    $postData = [
        'BusinessShortCode' => SHORTCODE,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phone,
        'PartyB' => SHORTCODE,
        'PhoneNumber' => $phone,
        'CallBackURL' => $callbackUrl,
        'AccountReference' => 'HotelBooking',
        'TransactionDesc' => 'Room Booking Payment'
    ];
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Bearer $accessToken", "Content-Type: application/json"]);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);
    
    return $response;
}
?>
