<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Services\AuthService;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login()
    {
        return view('auth.login');
    }

    // عرض صفحة التسجيل
    public function register()
    {
        return view('auth.register');
    }

    // معالجة التسجيل
    public function postRegister(RegisterRequest $request)
    {
        $user = $this->authService->registerUser($request);

        if (!$user) {
            return redirect()->back()->withErrors(['phone' => 'رقم الهاتف مستخدم بالفعل.']);
        }

        session(['otp_phone' => $request->phone]);  // تخزين رقم الهاتف مؤقتًا
        return redirect()->route('auth.otp')->with('success', 'تم إرسال OTP إلى رقم الهاتف الخاص بك.');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
            'password' => 'required|string',
        ]);

        $user = User::where('mobile', $request->phone)->first();

        if (!$user) {
            return redirect()->back()->with([
                'error' => 'بيانات الدخول غير صحيحة.',
            ]);
        }
        $credentials = $request->only('phone', 'password');
        $credentials['mobile'] = $credentials['phone'];
        unset($credentials['phone']);
        if (!Auth::attempt($credentials)) {
            return redirect()->back()->with([
                'error' => 'بيانات الدخول غير صحيحة.',
            ]);
        }
        auth()->login($user);
        if (!$user->verified) {
            return redirect()->route('auth.otp')->with('success', 'تم إرسال OTP إلى رقم الهاتف الخاص بك.');
        }

        return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح.');
    }

    // عرض صفحة OTP
    public function otp()
    {
        $phone = session('otp_phone');

        if (Auth::check() && !Auth::user()->verified) {
            $user = Auth::user();
            $phone = $user->mobile;
            $this->authService->sendOtp($phone, $user->id);  // إرسال OTP جديد
        }

        if (!$phone) {
            return redirect()->route('auth.register')->withErrors(['error' => 'غير مسموح بالوصول المباشر إلى صفحة التحقق.']);
        }

        return view('auth.otp', compact('phone'));
    }

    // معالجة OTP
    public function postOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:4',
        ]);

        $otpNumber = implode('', $request->otp);
        $phone = session('otp_phone');
        if (Auth::check() && !Auth::user()->verified) {
            $user = Auth::user();
            $phone = $user->mobile;
        }

        $result = $this->authService->verifyOtp($otpNumber, $phone);

        if (!$result['success']) {

            return redirect()->back()->withErrors(['otp' => $result['message']]);
        }

        session()->forget('otp_phone');
        auth()->login(User::where('mobile', $phone)->first());

        return redirect()->route('home')->with('success', 'تم التحقق من رقم الهاتف بنجاح.');
    }


    // إعادة إرسال OTP
    public function resendOtp(Request $request)
    {
        $phone = session('otp_phone');

        if (!$phone) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }
        $this->authService->resendOtp($phone);  // إرسال OTP جديد
        return response()->json(['success' => 'تم إرسال OTP جديد.']);
    }

    // تسجيل الخروج
    public function logout()
    {
        auth()->logout();
        return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح.');
    }

    // عرض صفحة التحقق
    public function showVerifyPage()
    {
        return view('auth.verify');
    }




    public function profile()
    {

        $user = Auth::user();
        return view('profile.index', compact('user'));
    }


    public function updateProfile(ProfileRequest $request)
    {
        $response = $this->authService->updateProfile($request->validated());
        if (!$response['success']) {
            return redirect()->back()->with('error', $response['message']);
        }
        return redirect()->back()->with('success', $response['message']);
    }



}
