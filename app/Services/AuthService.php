<?php

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\User;
use App\Models\Otp;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Log;



class AuthService
{
    public function isOtpEnabled(): bool
    {
        return (bool) Config::get('auth.otp_enabled', true);
    }

    protected function getOtpExpiryMinutes()
    {
        return Config::get('auth.otp_expiry_minutes', 2);
    }

    protected function getMaxOtpAttempts()
    {
        return Config::get('auth.otp_max_attempts', 6);
    }

    protected function getBlockDurationMinutes()
    {
        return Config::get('auth.otp_block_duration_minutes', 30);
    }

    protected function getAttemptWaitMinutes()
    {
        $waitMinutes = Config::get('auth.otp_attempt_wait_minutes', '0.5,2,5,10,15,30');
        return array_map('floatval', explode(',', $waitMinutes));
    }

    public function registerUser($request)
    {

        DB::beginTransaction();
        try {
            $isOtpEnabled = $this->isOtpEnabled();

            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->phone,
                'password' => Hash::make($request->password),
                'verified' => ! $isOtpEnabled,
                'phone_verified_at' => $isOtpEnabled ? null : Carbon::now(),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        if ($this->isOtpEnabled()) {
            $this->sendOtp($user);
        }
        return ['success' => true, 'message' => __('Registration completed successfully.')];
    }
    public function sendOtp($user)
    {
        if (! $this->isOtpEnabled()) {
            return [
                'success' => true,
                'message' => __('OTP is disabled.'),
            ];
        }

        $userCanSendOtp = $this->checkIfUserCanSendOtp($user);
 
        if (!$userCanSendOtp['success']) {
            return $userCanSendOtp;
        }
    
        $otp = $this->generateOtp($user);
        

        if (!$this->sendOtpUsingServiceProvider($user->mobile, $otp)) {
            return [
                'success' => false,
                'message' => __('Error while sending OTP'),
            ];
        }
        if (Otp::where('user_id', $user->id)->exists()) {
            $existingOtp = Otp::where('user_id', $user->id)->first();
            $existingOtp->update([
                'otp' => $otp,
                'expires_at' => now()->addMinutes($this->getOtpExpiryMinutes()),
                'attempts' => $existingOtp->attempts + 1
            ]);
        } else {
            Otp::create([
                'user_id' => $user->id,
                'phone' => $user->mobile,
                'otp' => $otp,
                'expires_at' => now()->addMinutes($this->getOtpExpiryMinutes()),
                'attempts' => 1
            ]);
        }
        return [
            'success' => true,
        ];
    }


    public function verifyOtp($otpNumber, $phone)
    {
        if (! $this->isOtpEnabled()) {
            return $this->completeOtpVerificationForPhone($phone);
        }

        if ($this->matchesMasterOtp((string) $otpNumber)) {
            return $this->completeOtpVerificationForPhone($phone);
        }

        $otp = Otp::where('otp', $otpNumber)
            ->where('phone', $phone)
            ->first();
        if (! $otp) {
            return ['success' => false, 'message' => __('The verification code is invalid.')];
        }

        if ($otp->isExpired()) {
            return ['success' => false, 'message' => __('The verification code has expired.')];
        }

        return $this->completeOtpVerificationForPhone($phone);
    }

    protected function matchesMasterOtp(string $otpNumber): bool
    {
        if (! Config::get('auth.otp_master_enabled', false)) {
            return false;
        }

        $master = Config::get('auth.otp_master_code', '');
        if ($master === null || $master === '') {
            return false;
        }

        return hash_equals((string) $master, $otpNumber);
    }

    /**
     * Mark user verified and clear OTP rows for the phone (used for valid DB OTP or master OTP).
     *
     * @return array{success: bool, message: string}
     */
    protected function completeOtpVerificationForPhone(?string $phone): array
    {
        if ($phone === null || $phone === '') {
            return ['success' => false, 'message' => __('The verification code is invalid.')];
        }

        $user = User::where('mobile', $phone)->first();
        if (! $user) {
            return ['success' => false, 'message' => __('The verification code is invalid.')];
        }

        $user->update([
            'verified' => true,
            'phone_verified_at' => Carbon::now(),
        ]);

        Otp::where('phone', $phone)->delete();

        return ['success' => true, 'message' => __('Phone verified successfully.')];
    }


    // إعادة إرسال OTP
    public function resendOtp($phone)
    {
        $user = User::where('mobile', $phone)->first();

        return $this->sendOtp($user);
    }


    public function updateProfile(array $data)
    {
        $user = Auth::user();

        $user->name = $data['name'];
        $user->mobile = $data['mobile'];
        $user->gender = $data['gender'] ?? null;
        $user->birthdate = $data['birthdate'] ?? null;

        if (!empty($data['current_password']) || !empty($data['password']) || !empty($data['password_confirmation'])) {
            if (!Hash::check($data['current_password'] ?? '', $user->password)) {
                return [
                    'success' => false,
                    'message' => __('Current password is incorrect'),
                ];
            }
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return [
            'success' => true,
            'message' => __('Profile updated successfully'),
            'user' => $user,
        ];
    }

    public function getWaitMinutes($attempts)
    {
        $waitMinutes = $this->getAttemptWaitMinutes();
        $index = max(0, min($attempts - 1, count($waitMinutes) - 1));
        return floatval($waitMinutes[$index]);
    }

    public function formatWaitTime($minutes)
    {
        if ($minutes < 1) {
            return __(':count seconds', ['count' => number_format($minutes * 60, 0)]);
        }

        return __(':count minutes', ['count' => number_format($minutes, 1)]);
    }

    public function sendOtpUsingServiceProvider($receiver, $otp)
    {
  
        $accountId = '550182041';
        $password = 'Vodafone.1';
        $secretKey = 'CA7FAB8B6A4146FFB66513E912D1DEF4';
        $senderName = "Super jet";
        $smsText = __('Your verification code: :code', ['code' => $otp]);
        $stringToHash = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=2$receiver&SMSText=$smsText";

        $secureHash = strtoupper(hash_hmac('sha256', $stringToHash, $secretKey));

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
            <ReceiverMSISDN>' . '2' . $receiver . '</ReceiverMSISDN>
            <SMSText>' . $smsText . '</SMSText>
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

        // Add additional options for SSL if needed
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        Log::info($response);
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);



        return true;

    }


    public function generateOtp($user)
    {
        $otp = rand(1000, 9999);
       while (Otp::where('user_id', $user->id)->where('otp', $otp)->exists()) {
    $otp = rand(1000, 9999);
}
        return $otp;
    }

    public function checkIfUserCanSendOtp($user)
    {
        $lastOtp = Otp::where('user_id', $user->id)->latest()->first();
        if (!$lastOtp) {
            return [
                'success' => true
            ];
        }
        if ($lastOtp->attempts >= $this->getMaxOtpAttempts()) {
            return [
                'success' => false,
                'message' => __('You have used all available OTPS')
            ];
        }
        return [
            'success' => true
        ];
    }
}
