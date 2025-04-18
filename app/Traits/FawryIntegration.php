<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\MainSetting;
use App\Models\PaymentConfigration;
use App\Models\ReservationBookingRequest;
use App\Models\User;
use App\Models\PaymentDataSave;
use Carbon\Carbon;
use Exception;

trait FawryIntegration
{
    public function getPaymentLink($ticket_id, $total, $user_id, $service, $return_url = null)
    {
        $main_setting  = MainSetting::first();
        $payment_config = PaymentConfigration::first();
        $merchantCode    = @$payment_config->merchantCode;
        $merchant_sec_key = @$payment_config->merchant_sec_key;
        $merchantRefNum  =  $ticket_id;
        $merchant_cust_prof_id  = '';
        $payment_method = 'PayAtFawry';

        $amount = round($total) . '.00';
        $item_id = $ticket_id;
        $quantity = 1;
        $return_url = $return_url ?? $payment_config->return_url;
        $signature = hash('sha256', $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $return_url . $item_id . $quantity . $amount . $merchant_sec_key);
        $httpClient = new \GuzzleHttp\Client();
        $user = $this->getUser($user_id);
        $body = json_encode(
            [

                'merchantCode' => $merchantCode,
                'customerName' => $user->name,
                'customerMobile' => $user->mobile,
                'customerEmail' => $user->email ?? str_replace(' ', '', $user->mobile) . '@superjet.com',
                "customerProfileId" => "",
                'merchantRefNum' => $merchantRefNum,
                'amount' =>  $total,
                "paymentExpiry" => "",
                "currencyCode" => "EGP",
                "language" => "en-gb",
                "chargeItems" => [
                    [
                        "itemId" => $item_id,
                        "description" => $main_setting->name,
                        "price" =>  $total,
                        "quantity" => $quantity
                    ]
                ],
                "paymentMethod" => "",
                "enable3DS" => true,
                "returnUrl" => $return_url,
                "description" => $main_setting->name,
                'signature' => $signature,

            ],
            true
        );
        //    dd($body);
        $response = $httpClient->request('POST', 'https://atfawry.com/fawrypay-api/api/payments/init', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $this->handleFawryPaymentData($item_id, null, $service, $signature);
        $tickets = ReservationBookingRequest::where('id', $item_id)->orWhere('payment_key', $item_id)->get();
        foreach ($tickets as $key => $ticket) {
            $ticket->reserv_type = 'New';
            $ticket->save();
        }
        return $response->getBody()->getContents();
    }

    public function handleFawryPaymentData($orderId, $merchantID, $service, $signature)
    {
        $paymentInfo = new PaymentDataSave();
        $paymentInfo->date = Carbon::now()->format('y-m-d');
        $paymentInfo->time = Carbon::now()->format('H:i:s');
        $paymentInfo->item_id = $orderId;
        $paymentInfo->referance_num = $merchantID;
        $paymentInfo->signature = $signature;
        $paymentInfo->status = 'New';
        $paymentInfo->service = $service;
        $paymentInfo->payment_method = "Fawry";
        $paymentInfo->save();
        $tickets = ReservationBookingRequest::where('id', $orderId)->orWhere('payment_key', $orderId)->get();
        foreach ($tickets as $key => $ticket) {
            $ticket->reserv_type = 'New';
            $ticket->save();
        }
    }

    public function getUser($user_id)
    {
        $user = User::find($user_id);
        return $user;
    }

    public function getFawryPaymentStatus($ticketId)
    {
        try {
            $payment_config = PaymentConfigration::first();
            $merchantCode    = @$payment_config->merchantCode;
            $merchant_sec_key = @$payment_config->merchant_sec_key;
            $ticket = ReservationBookingRequest::find($ticketId);
            $merchantRefNumber  = $ticket->payment_key;
            $signature = hash('sha256', $merchantCode . $merchantRefNumber . $merchant_sec_key);
            
            $httpClient = new \GuzzleHttp\Client();
            $response = $httpClient->request('GET', 'https://atfawry.com/ECommerceWeb/Fawry/payments/status/v2', [
                'query' => [
                    'merchantCode' => $merchantCode,
                    'merchantRefNumber' => $merchantRefNumber,
                    'signature' => $signature
                ]
            ]);
    
            // ✅ Decode response body to an array
            $responseData = json_decode($response->getBody()->getContents(), true);
    
            // ✅ Check if 'orderExpiryDate' exists
            if (!isset($responseData['orderExpiryDate'])) {
                return 'FAILED';
            }
    
            // Convert from milliseconds to seconds
            $timestamp = $responseData['orderExpiryDate'] / 1000;
    
            // Format time
            $formattedDate = date("Y-m-d H:i:s", $timestamp);
            $diff = Carbon::parse($formattedDate)->diffInDays($ticket->created_at);
    
            if ($diff < 1) {
                PaymentDataSave::where([
                    'item_id' => $ticket->payment_key,
                ])->update([
                    'reference_number' => $responseData['fawryRefNumber']
                ]);
    
                $status = $responseData['orderStatus'];
                $ticket->reserv_type = $status;
                $ticket->save();
    
                return $status;
            } else {
                return 'FAILED';
            }
    
        } catch (Exception $e) {
            return 'FAILED';
        }
    }
    
    public function getFawryInfo($ticketId)
    {
        try {
            $payment_config = PaymentConfigration::first();
            $merchantCode    = @$payment_config->merchantCode;
            $merchant_sec_key = @$payment_config->merchant_sec_key;
            $ticket = ReservationBookingRequest::find($ticketId);
            $merchantRefNumber  = $ticket->payment_key;
            $signature = hash('sha256', $merchantCode . $merchantRefNumber . $merchant_sec_key);
            $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
            $response = $httpClient->request('GET', 'https://atfawry.com/ECommerceWeb/Fawry/payments/status/v2', [
                'query' => [
                    'merchantCode' => $merchantCode,
                    'merchantRefNumber' => $merchantRefNumber,
                    'signature' => $signature
                ]
            ]);
            $response = json_decode($response->getBody()->getContents(), true);
           
            return $response;
        } catch (Exception $e) {
            return null;
        }
    }
}
