<?php

$receiver = $argv[1];
$smsText = $argv[2];

function sendSMS($receiver, $smsText)
{
    $accountId = '550182041';
    $password = 'Vodafone.1';
    $secretKey = 'CA7FAB8B6A4146FFB66513E912D1DEF4';
    $senderName = "Super jet";

    // بناء سلسلة الهاش
        $stringToHash = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=$receiver&SMSText=$smsText";
    
    // حساب الهاش باستخدام HMAC-SHA256 وتحويله إلى أحرف كبيرة
    // $secureHash = strtoupper(hash_hmac('sha256', $stringToHash, pack('H*', $secretKey)));
    // $finalString = $stringToHash . $secretKey;
    //  $secureHash = strtoupper(hash_hmac('sha256', $stringToHash, hex2bin($secretKey)));
        // $stringToHash .= hex2bin($secretKey);
        $secureHash1 = strtoupper(hash('sha256', $stringToHash . hex2bin($secretKey)));
    echo "Method 1: $secureHash1\n";
    
    // Method 2: Try HMAC-SHA256
    $secureHash2 = strtoupper(hash_hmac('sha256', $stringToHash, hex2bin($secretKey)));
    echo "Method 2: $secureHash2\n";
    
    // Method 3: Try regular SHA-256 of the combined string (without hex2bin)
    $secureHash3 = strtoupper(hash('sha256', $stringToHash . $secretKey));
    echo "Method 3: $secureHash3\n";

// Method 4: Try exact string format from documentation
    $stringToHash4 = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=$receiver&SMSText=$smsText";
    // Use SHA256 with the hex string directly as key
    $hash4 = hash_hmac('sha256', $stringToHash4, $secretKey);
    $secureHash4 = strtoupper($hash4);
    echo "Method 4: $secureHash4\n";
    
    // Method 5: Check for space/encoding issues
    $stringToHash5 = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=$receiver&SMSText=$smsText";
    $hash5 = strtoupper(hash('sha256', utf8_encode($stringToHash5 . $secretKey)));
    echo "Method 5: $secureHash5\n";
    
    // Method 6: Direct binary conversion without hex2bin 
    $binaryKey = '';
    for ($i = 0; $i < strlen($secretKey); $i += 2) {
        $binaryKey .= chr(hexdec(substr($secretKey, $i, 2)));
    }
    $hash6 = strtoupper(hash('sha256', $stringToHash4 . $binaryKey));
    echo "Method 6: $hash6\n";
    // Calculate SHA-256 hash and convert to uppercase
    $secureHash = strtoupper(hash('sha256', $stringToHash));
    echo "$secureHash\n";
    // بناء XML للطلب
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

    // تنفيذ الطلب باستخدام cURL
    $url = 'https://e3len.vodafone.com.eg/web2sms/sms/submit/';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/xml; charset=utf-8'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_POST, true);

    $response = curl_exec($ch);
    curl_close($ch);

    echo "Response:\n$response\n";
}

sendSMS($receiver, $smsText);