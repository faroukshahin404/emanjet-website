<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait SendSmsVodafone
{
    public function sendSms(string $phone, string $message): string
    {
        $accountId = '1';
        $password = 'password';
        $secretKey = '09CDA47A15F241399269DFCE33133948';
        $senderName = 'sender1'; // must be a pre-approved sender

        // Format MSISDN if needed
        $receiver = $this->formatPhoneNumber($phone);

        // Step 1: Create string to hash
        $hashString = "AccountId={$accountId}&Password={$password}&SenderName={$senderName}&ReceiverMSISDN={$receiver}&SMSText={$message}";

        // Step 2: Generate SecureHash (uppercase hex)
        $binaryKey = hex2bin($secretKey);
        $secureHash = strtoupper(hash_hmac('sha256', $hashString, $binaryKey));

        // Step 3: Build XML request
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><SubmitSMSRequest xmlns="http://www.edafa.com/web2sms/sms/model/"/>');
        $xml->addChild('AccountId', $accountId);
        $xml->addChild('Password', $password);
        $xml->addChild('SecureHash', $secureHash);

        $smsNode = $xml->addChild('SMSList');
        $smsNode->addChild('SenderName', $senderName);
        $smsNode->addChild('ReceiverMSISDN', $receiver);
        $smsNode->addChild('SMSText', $message);

        // Step 4: Send request
        $response = Http::withHeaders([
            'Content-Type' => 'application/xml',
        ])->withBody($xml->asXML(), 'application/xml')
          ->post('https://<serverip>:<port>/web2sms/sms/submit');

        if ($response->successful()) {
            return $response->body(); // XML response string
        }

        return 'Error: ' . $response->status();
    }

    private function formatPhoneNumber(string $phone): string
    {
        // Auto-format to international if needed (e.g., start with 201...)
        $phone = preg_replace('/[^0-9]/', '', $phone); // remove non-numeric

        if (preg_match('/^01[0-9]{9}$/', $phone)) {
            return '2' . $phone; // converts 010xxxxxx to 2010xxxxxx
        }

        return $phone;
    }
}
