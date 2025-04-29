<?php

$receiver = $argv[1];
$smsText = $argv[2];

function sendSMS($receiver , $smsText)
{
    // $accountId = '550182041';
    // $password = 'Vodafone.1';
    // $secretKey = 'CA7FAB8B6A4146FFB66513E912D1DEF4';
    // $senderName = "Super jet";

    // $stringToHash = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=$receiver&SMSText=$smsText";
    // $secureHash = strtoupper(hash_hmac('sha256', $stringToHash, pack('H*', $secretKey)));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<SubmitSMSRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:="http://www.edafa.com/web2sms/sms/model/" xsi:schemaLocation="http://www.edafa.com/web2sms/sms/model/SMSAPI.xsd "
 
xsi:type="SubmitSMSRequest">
<AccountId>550182041</AccountId>
<Password>Vodafone.1</Password>
<SecureHash>34D0B102C00D23F7A774597CFE0A76DCF3E6724A18CA7ED2BDF6DA7CC4BB41E1</SecureHash>
<SMSList>
    <SenderName>Super jet</SenderName>
    <ReceiverMSISDN>201149737837</ReceiverMSISDN>
    <SMSText>test</SMSText>
</SMSList>
</SubmitSMSRequest>';

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
}

sendSMS($receiver, $smsText);