<?php

namespace App\Services;

use App\Models\User;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthService
{
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

        $this->sendOtp($user->mobile, $user->id);  // إرسال OTP إلى الهاتف

        return $user;
    }

    // إرسال OTP إلى المستخدم
    public function sendOtp($phone, $userId = null, $isResend = false)
    {


        $existingOtp = Otp::where('phone', $phone)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        // لو لسه فيه OTP فعال، منبعتش واحد جديد
        if ($existingOtp && !$isResend) {
            return;
        }

        $otp = rand(1000, 9999);
        $expiresAt = now()->addMinutes(5);
        Otp::updateOrCreate(
            ['phone' => $phone],
            [
                'user_id' => $userId,
                'otp' => $otp,
                'expires_at' => $expiresAt,
                'is_used' => false,
            ]
        );
    }

    // التحقق من OTP
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

        if ($otp->isUsed()) {
            return ['success' => false, 'message' => 'الرمز قد تم استخدامه مسبقًا.'];
        }

        $user = User::where('mobile', $phone)->first();
        $user->update([
            'verified' => true,
            'phone_verified_at' => Carbon::now(),
        ]);

        $otp->is_used = true;
        $otp->expires_at = Carbon::now();
        $otp->save();

        return ['success' => true];
    }

    // إعادة إرسال OTP
    public function resendOtp($phone)
    {
        $user = User::where('mobile', $phone)->first();
        $this->sendOtp($phone, $user->id, true);  // إرسال OTP جديد
    }


    public function updateProfile(array $data)
    {
        $user = auth()->user();

        $user->name = $data['name'];
        $user->mobile = $data['mobile'];
        $user->gender = $data['gender'] ?? null;
        $user->birthdate = $data['birthdate'] ?? null;

        if (!empty($data['current_password']) || !empty($data['password']) || !empty($data['password_confirmation'])) {
            if (!\Hash::check($data['current_password'] ?? '', $user->password)) {
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
}
