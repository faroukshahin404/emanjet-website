<?php

namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class QNBPaymentService
{

    protected $qnbBaseUrl = 'https://qnbalahli.gateway.mastercard.com/api/rest/version/67/merchant/';
    protected $qnbMerchantId = 'SUPERJETPL';
    protected $qnbUserName = 'merchant.SUPERJETPL';
    protected $qnbPassword = '79505d7ceb2c0e29674ce461a83871b8';
    // url and logo image
    protected $qnbUrl = 'https://www.superjet.com.eg/ar';
    protected $qnbLogo = 'https://www.superjet.com.eg/images/logo.png';

    public function __construct($source ='system'){
        
        if($source == 'web'){
            $this->qnbMerchantId = "SUPERJET1";
            $this->qnbUserName = "merchant.SUPERJET1";
            $this->qnbPassword = "cc199a764f6d412b39c09ae95848f9c5";
        } else if($source =='app'){
            $this->qnbMerchantId = "SUPERJET2";
            $this->qnbUserName = "merchant.SUPERJET2";
            $this->qnbPassword = "e04fd3cc7be001b77a4291ab99ebcc3a";
        }else {
            $this->qnbMerchantId = $qnbMerchantId ?? $this->qnbMerchantId;
            $this->qnbUserName = $qnbUserName ?? $this->qnbUserName;
            $this->qnbPassword = $qnbPassword ?? $this->qnbPassword;
           
        } 
      
    }

    public  function initiateQNBPaymentLink(array $data)
    {
        $url = $this->qnbBaseUrl . $this->qnbMerchantId . '/session';

        try {
            $data = [
                'apiOperation' => 'INITIATE_CHECKOUT',
                'checkoutMode' => 'PAYMENT_LINK',
                'paymentLink' => [
                    'expiryDateTime' => Carbon::now()->addMinutes(10), // Example: "2025-08-06T13:16:23.123Z"
                    'numberOfAllowedAttempts' => 20,
                ],
                'interaction' => [
                    'displayControl' => [
                        'billingAddress' => 'OPTIONAL',
                        'customerEmail' => 'OPTIONAL',
                    ],
                    'operation' => 'PURCHASE',
                    'merchant' => [
                        'name' => $this->qnbMerchantId,
                        'url' => $this->qnbUrl,
                        'logo' => $this->qnbLogo,
                    ],
                ],
                'order' => [
                    'currency' => 'EGP',
                    'id' => $data['order_id'],       // Must be unique
                    'description' => 'Ticket Booking',
                    'reference' => $data['order_id'],
                    'amount' => $data['amount'],     // As string
                ],
                'transaction' => [
                    'reference' => $data['order_id'],
                ],
            ];

            // basic auth
            $response = Http::withBasicAuth($this->qnbUserName, $this->qnbPassword)->post($url, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'url' => $response->json()['paymentLink']['url'],
                    'data' => $response->json(),
                ];
                
            }

            return [
                'success' => false,
                'error' => $response->json(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            // Log::error('QNB Payment Error', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'error' => 'Internal error: ' . $e->getMessage(),
                'status' => 500,
            ];
        }
    }

}