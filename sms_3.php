<?php
// Check if the required arguments are provided
if ($argc < 3) {
    echo "Usage: php send_sms.php <phone_number> <message>\n";
    echo "Example: php send_sms.php 201149737837 \"Hello world\"\n";
    exit(1);
}

// Get arguments from command line
$receiver = $argv[1];
$smsText = $argv[2];

function sendSMS($receiver, $smsText)
{
    $accountId = '550182041';
    $password = 'Vodafone.1';
    $secretKey = 'CA7FAB8B6A4146FFB66513E912D1DEF4';
    $senderName = "Super jet";
    
    // Build the string to hash
    $stringToHash = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=$receiver&SMSText=$smsText";
    
    // Calculate the hash using HMAC-SHA256 with the raw hex string as key
    $secureHash = strtoupper(hash_hmac('sha256', $stringToHash, $secretKey));
    
    echo "Secure Hash: $secureHash\n";
    
    // Build XML for request
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<SubmitSMSRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:="http://www.edafa.com/web2sms/sms/model/" 
xsi:schemaLocation="http://www.edafa.com/web2sms/sms/model/SMSAPI.xsd "
xsi:type="SubmitSMSRequest">
    <AccountId>' . $accountId . '</AccountId>
    <Password>' . $password . '</Password>
    <SecureHash>' . $secureHash . '</SecureHash>
    <SMSList>
        <SenderName>' . $senderName . '</SenderName>
        <ReceiverMSISDN>' . $receiver . '</ReceiverMSISDN>
        <SMSText>' . $smsText . '</SMSText>
    </SMSList>
</SubmitSMSRequest>';
    
    // Execute the request using cURL
    $url = 'https://e3len.vodafone.com.eg/web2sms/sms/submit/';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/xml; charset=utf-8'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_POST, true);
    
    // Add additional options for SSL if needed
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch) . "\n";
    }
    
    curl_close($ch);
    echo "Response:\n$response\n";
}

echo "Sending SMS to: $receiver\n";
echo "Message: $smsText\n";
sendSMS($receiver, $smsText);