<?php

namespace App\Services;

use App\Models\User;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

// class AuthService
// {
//     protected function getOtpExpiryMinutes()
//     {
//         return Config::get('auth.otp_expiry_minutes', 5);
//     }

//     protected function getMaxOtpAttempts()
//     {
//         return Config::get('auth.otp_max_attempts', 6);
//     }

//     protected function getBlockDurationMinutes()
//     {
//         return Config::get('auth.otp_block_duration_minutes', 30);
//     }

//     protected function getAttemptWaitMinutes()
//     {
//         $waitMinutes = Config::get('auth.otp_attempt_wait_minutes', '0.5,2,5,10,15,30');
//         return array_map('floatval', explode(',', $waitMinutes));
//     }

//     // تسجيل المستخدم
//     public function registerUser($data)
//     {
//         $existingUser = User::where('mobile', $data->phone)->first();

//         if ($existingUser && $existingUser->password) {
//             return null;  // إذا كان الرقم موجودًا ومسجلًا مسبقًا
//         }

//         $user = User::create([
//             'name' => $data->name,
//             'mobile' => $data->phone,
//             'password' => Hash::make($data->password),
//         ]);

//         $this->sendOtp($user->mobile, $user->id);  // إرسال OTP إلى الهاتف

//         return $user;
//     }

//     // إرسال OTP إلى المستخدم
//     public function sendOtp($phone, $userId = null)
//     {
//         $user = $userId ? User::find($userId) : User::where('mobile', $phone)->first();

//         if (!$user) {
//             return 'لم يتم العثور على المستخدم.';
//         }

//         // التحقق من حالة الحظر
//         $lastOtp = Otp::where('phone', $phone)
//             ->where('blocked_until', '>', now())
//             ->first();

//         if ($lastOtp) {
//             $remainingMinutes = $lastOtp->blocked_until->diffInMinutes(now());
//             return "تم حظر إرسال رمز التحقق مؤقتاً. يرجى المحاولة بعد {$remainingMinutes} دقيقة.";
//         }

//         // التحقق من المحاولات المفرطة في آخر 30 دقيقة
//         $recentAttempts = Otp::where('phone', $phone)
//             ->where('created_at', '>=', now()->subMinutes(30))
//             ->sum('attempts');

//         if ($recentAttempts >= $this->getMaxOtpAttempts()) {
//             $blockedUntil = now()->addMinutes($this->getBlockDurationMinutes());
//             Otp::create([
//                 'phone' => $phone,
//                 'blocked_until' => $blockedUntil
//             ]);
//             return "تم تجاوز الحد الأقصى للمحاولات. يرجى المحاولة بعد " . $this->getBlockDurationMinutes() . " دقيقة.";
//         }

//         // التحقق من الوقت بين المحاولات
//         $lastAttempt = Otp::where('phone', $phone)
//             ->where('created_at', '>=', now()->subMinutes(5))
//             ->first();

//         if ($lastAttempt) {
//             $waitMinutes = $this->getWaitMinutes($recentAttempts);
//             $remainingMinutes = $waitMinutes - $lastAttempt->created_at->diffInMinutes(now());
//             if ($remainingMinutes > 0) {
//                 return "يرجى الانتظار " . $this->formatWaitTime($remainingMinutes) . " قبل طلب رمز جديد.";
//             }
//         }

//         // إنشاء أو تحديث رمز OTP
//         $otp = rand(1000, 9999);

//         // TODO: إضافة كود إرسال OTP الفعلي هنا (مثل إرسال رسالة نصية عبر خدمة SMS)

//         // إذا كان هناك OTP غير مستخدم
//         $existingOtp = Otp::where('phone', $phone)
//             ->where('is_used', false)
//             ->where('expires_at', '>', now())
//             ->first();

//         if ($existingOtp) {
//             // تحديث OTP الموجود
//             $existingOtp->update([
//                 'otp' => $otp,
//               'expires_at' => now()->addMinutes($this->getOtpExpiryMinutes()),

//                 'attempts' => 0
//             ]);
//         } else {
//             // إنشاء OTP جديد
//             Otp::create([
//                 'user_id' => $user->id,
//                 'phone' => $phone,
//                 'otp' => $otp,
//                 'expires_at' => now()->addMinutes($this->getOtpExpiryMinutes()),

//                 'is_used' => false,
//                 'attempts' => 0
//             ]);
//         }

//         return 'تم إرسال رمز التحقق بنجاح.';
//     }


//     // التحقق من OTP
//     public function verifyOtp($otpNumber, $phone)
//     {
//         $otp = Otp::where('otp', $otpNumber)
//             ->where('phone', $phone)
//             ->first();
//         // dd($otp);
//         if (!$otp) {
//             return ['success' => false, 'message' => 'الرمز غير صحيح.'];
//         }

//         if ($otp->isExpired()) {
//             // dd($otp);
//             return ['success' => false, 'message' => 'الرمز قد انتهت صلاحيته.'];
//         }
//         // dd('here');
//         if ($otp->isUsed()) {
//             return ['success' => false, 'message' => 'الرمز قد تم استخدامه مسبقًا.'];
//         }

//         $user = User::where('mobile', $phone)->first();
//         // dd($user);
//         $user->update([
//             'verified' => true,
//             'phone_verified_at' => Carbon::now(),
//         ]);

//         // مباشرة بعد التحقق: حذف الـ OTP
//         $otp->delete();

//         return ['success' => true, 'message' => 'تم التحقق بنجاح.'];
//     }


//     // إعادة إرسال OTP
//     public function resendOtp($phone)
//     {
//         $user = User::where('mobile', $phone)->first();
//         return $this->sendOtp($phone, $user->id);  // إرسال OTP جديد
//     }


//     public function updateProfile(array $data)
//     {
//         $user = Auth::user();

//         $user->name = $data['name'];
//         $user->mobile = $data['mobile'];
//         $user->gender = $data['gender'] ?? null;
//         $user->birthdate = $data['birthdate'] ?? null;

//         if (!empty($data['current_password']) || !empty($data['password']) || !empty($data['password_confirmation'])) {
//             if (!Hash::check($data['current_password'] ?? '', $user->password)) {
//                 return [
//                     'success' => false,
//                     'message' => 'كلمة المرور الحالية غير صحيحة.',
//                 ];
//             }
//             $user->password = Hash::make($data['password']);
//         }

//         $user->save();

//         return [
//             'success' => true,
//             'message' => 'تم تحديث الملف الشخصي بنجاح.',
//             'user' => $user,
//         ];
//     }

//     public function getWaitMinutes($attempts)
//     {
//         $waitMinutes = $this->getAttemptWaitMinutes();
//         $index = max(0, min($attempts - 1, count($waitMinutes) - 1));
//         return floatval($waitMinutes[$index]);
//     }

//     public function formatWaitTime($minutes)
//     {
//         if ($minutes < 1) {
//             return number_format($minutes * 60, 0) . ' ثانية';
//         }
//         return number_format($minutes, 1) . ' دقيقة';
//     }
// }



class AuthService
{
    protected function getOtpExpiryMinutes()
    {
        return Config::get('auth.otp_expiry_minutes', 5);
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

    // تسجيل المستخدم
    public function registerUser($data)
    {
        $existingUser = User::where('mobile', $data->phone)->first();

        if ($existingUser && $existingUser->password) {
            return null;  // إذا كان الرقم موجودًا ومسجلًا مسبقًا
        }

        $user = User::create([
            'name' => $data->name,
            'mobile' => $data->phone,
            'password' => Hash::make($data->password),
        ]);

        $this->sendOtp($user);

        return $user;
    }

   public function sendOtp($user)
    {
        $otp = rand(1000, 9999);
   
        $this->sendOtpUsingServiceProvider($user->mobile, $otp);
        Otp::create([
            'user_id' => $user->id,
            'phone' => $user->mobile,
            'otp' => $otp,
            'expires_at' => now()->addMinutes($this->getOtpExpiryMinutes()),
            'attempts' => 0
        ]);
        return [
            'success' => true,
            'message' => 'تم إرسال رمز التحقق بنجاح.'
        ];
    }


    public function verifyOtp($otpNumber, $phone)
    {
        $otp = Otp::where('otp', $otpNumber)
            ->where('phone', $phone)
            ->first();
        if (!$otp) {
            return ['success' => false, 'message' => 'الرمز غير صحيح.'];
        }

        if ($otp->isExpired()) {
            return ['success' => false, 'message' => 'الرمز قد انتهت صلاحيته.'];
        }


        $user = User::where('mobile', $phone)->first();
        $user->update([
            'verified' => true,
            'phone_verified_at' => Carbon::now(),
        ]);

        $otp->delete();

        return ['success' => true, 'message' => 'تم التحقق بنجاح.'];
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
                    'message' => 'كلمة المرور الحالية غير صحيحة.',
                ];
            }
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return [
            'success' => true,
            'message' => 'تم تحديث الملف الشخصي بنجاح.',
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
            return number_format($minutes * 60, 0) . ' ثانية';
        }
        return number_format($minutes, 1) . ' دقيقة';
    }

 public function sendOtpUsingServiceProvider($receiver, $otp)
    {
        $accountId = '550182041';
        $password = 'Vodafone.1';
        $secretKey = 'CA7FAB8B6A4146FFB66513E912D1DEF4';
        $senderName = "Super jet";
        $smsText = "رمز التحقق الخاص بك:$otp";
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
            <ReceiverMSISDN>' .'2'.$receiver . '</ReceiverMSISDN>
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

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200 && strpos($response, '<Status>Success</Status>') !== false) {
            return true;
        }

        return false;

    }
}
