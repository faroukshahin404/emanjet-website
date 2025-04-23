<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($argc < 3) {
    echo "Usage: php send_sms.php <receiver> <message> [senderName]\n";
    exit(1);
}

$receiver = $argv[1];
$message = $argv[2];
$senderName = $argv[3] ?? 'superjet'; // لازم يكون sender مفعّل عند فودافون

function sendSMS($receiver, $message, $senderName = 'superjet')
{
    $accountId = '550182041';
    $password = 'Vodafone.1';
    $secretKey = 'CA7FAB8B6A4146FFB66513E912D1DEF4';

    // 1. تكوين string للـ hash
    $stringToHash = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=$receiver&SMSText=$message";

    // 2. حساب الـ HMAC SHA256 باستخدام مفتاح bin (من Hex)
    $secureHash = strtoupper(hash_hmac('sha256', $stringToHash, pack('H*', $secretKey)));

    // 3. بناء XML
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<SubmitSMSRequest xmlns="http://www.edafa.com/web2sms/sms/model/">
    <AccountId>' . $accountId . '</AccountId>
    <Password>' . $password . '</Password>
    <SecureHash>' . $secureHash . '</SecureHash>
    <SMSList>
        <SenderName>' . $senderName . '</SenderName>
        <ReceiverMSISDN>' . $receiver . '</ReceiverMSISDN>
        <SMSText>' . htmlspecialchars($message, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</SMSText>
    </SMSList>
</SubmitSMSRequest>';

    echo "Request XML:\n$xml\n\n";

    // 4. إرسال الطلب
    $url = 'https://e3len.vodafone.com.eg/web2sms/sms/submit/';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/xml; charset=utf-8'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_POST, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        fwrite(STDERR, "❌ cURL Error: " . curl_error($ch) . "\n");
    } elseif ($response === false) {
        fwrite(STDERR, "❌ curl_exec returned false.\n");
    } else {
        echo "✅ API Response:\n$response\n";
    }

    curl_close($ch);
}

sendSMS($receiver, $message, $senderName);
