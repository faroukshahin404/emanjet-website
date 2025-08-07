<?php

namespace App\Traits;

use App\Models\BookingSeat;
use App\Models\Les;
use App\Models\PaymentDataSave;
use App\Models\ReservationBookingRequest;
use App\Models\ThrowError;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait QNBPaymentIntegration
{
    protected $qnbBaseUrl = 'https://qnbalahli.test.gateway.mastercard.com/api/rest/version/67/merchant/';
    protected $qnbMerchantId = 'TESTQNBAATEST001';
    protected $qnbUserName = 'merchant.TESTQNBAATEST001';
    protected $qnbPassword = '9c6a123857f1ea50830fa023ad8c8d1b';
    // url and logo image
    protected $qnbUrl = 'https://www.superjet.com.eg/ar';
    protected $qnbLogo = 'https://www.superjet.com.eg/images/logo.png';

    public function initiateQNBPaymentLink(array $data)
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
            dd($e);
            // Log::error('QNB Payment Error', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'error' => 'Internal error: ' . $e->getMessage(),
                'status' => 500,
            ];
        }
    }
  

    
   
}
