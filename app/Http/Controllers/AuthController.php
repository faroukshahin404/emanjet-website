<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\TicketResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Otp;
use App\Models\ReservationBookingRequest;
use App\ViewModels\TicketViewModel;

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
            'mobile' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'لم يتم العثور على المستخدم.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور غير صحيحة.');
        }

        Auth::login($user);

        if (!$user->is_verified) {
            return redirect()->route('auth.verify');
        }

        return redirect()->route('home');
    }

    // عرض صفحة إعادة تعيين كلمة المرور
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    // معالجة طلب إعادة تعيين كلمة المرور
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        // إذا كان الطلب لإعادة إرسال OTP
        if ($request->ajax()) {
            // Check if we need to wait before sending new OTP
            $lastOtp = Otp::where('phone', $request->phone)
                ->where('created_at', '>=', now()->subMinutes(30))
                ->latest()
                ->first();

            if ($lastOtp) {
                $waitTime = 30; // 30 seconds wait time
                $timeSinceLastOtp = now()->diffInSeconds($lastOtp->created_at);

                if ($timeSinceLastOtp < $waitTime) {
                    $remainingTime = $waitTime - $timeSinceLastOtp;
                    return response()->json([
                        'success' => false,
                        'message' => "يرجى المحاولة بعد {$remainingTime} ثانية.",
                        'remainingTime' => $remainingTime
                    ], 429);
                }
            }

            $message = $this->authService->sendOtp($request->phone);

            if ($message === 'تم إرسال رمز التحقق بنجاح.') {
                session([
                    'reset_password_phone' => $request->phone
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'remainingTime' => 30
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $message
            ], 400);
        }

        // إذا كان الطلب للتحقق من OTP
        if ($request->has('otp')) {
            $otpNumber = implode('', $request->otp);
            $message = $this->authService->verifyOtp($otpNumber, $request->phone);

            if ($message === 'تم التحقق بنجاح.') {
                // تسجيل دخول المستخدم
                $user = User::where('mobile', $request->phone)->first();
                if ($user) {
                    Auth::login($user);
                }
                return redirect()->route('home')->with('success', 'تم التحقق بنجاح');
            }

            return redirect()->back()->withErrors(['otp' => $message]);
        }

        // إذا كان الطلب لعرض صفحة إعادة تعيين كلمة المرور
        $phone = session('reset_password_phone');

        // إذا كان الطلب لإدخال رقم الهاتف لأول مرة
        if ($request->has('phone') && !$phone) {
            // التحقق من وجود المستخدم
            $user = User::where('mobile', $request->phone)->first();
            if (!$user) {
                return redirect()->back()->withErrors(['phone' => 'لم يتم العثور على مستخدم بهذا الرقم.']);
            }

            // إرسال OTP
            $message = $this->authService->sendOtp($request->phone);

            if ($message === 'تم إرسال رمز التحقق بنجاح.') {
                session([
                    'reset_password_phone' => $request->phone
                ]);

                return redirect()->route('auth.showResetPassword');
            }

            return redirect()->back()->withErrors(['phone' => $message]);
        }

        if (!$phone) {
            return redirect()->route('auth.login')->with('error', 'غير مسموح بالوصول المباشر إلى صفحة إعادة تعيين كلمة المرور.');
        }

        // Get latest OTP for this phone
        $latestOtp = Otp::where('phone', $phone)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->latest()
            ->first();

        $remainingTime = 0;
        if ($latestOtp) {
            $expiryTime = $latestOtp->created_at->addSeconds(30);
            if ($expiryTime->isFuture()) {
                $remainingTime = now()->diffInSeconds($expiryTime);
            }
        }

        return view('mobile.auth.show-reset-password', compact('phone', 'remainingTime'));
    }

    // عرض صفحة OTP
    public function otp()
    {
        $phone = session('otp_phone');

        if (Auth::check() && !Auth::user()->verified) {
            $user = Auth::user();
            $phone = $user->mobile;
            $this->authService->sendOtp($phone, $user->id);
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

        $message = $this->authService->verifyOtp($otpNumber, $phone);

        if ($message !== 'تم التحقق بنجاح.') {
            return redirect()->back()->withErrors(['otp' => $message]);
        }
        if (session('reset_password_phone')) {
            session()->forget('otp_phone');
            return redirect()->route('auth.showResetPassword');
        }

        session()->forget('otp_phone');
        Auth::login(User::where('mobile', $phone)->first());

        return redirect()->route('home')->with('success', 'تم التحقق من رقم الهاتف بنجاح.');
    }

    // عرض صفحة إعادة تعيين كلمة المرور
    public function showResetPassword()
    {
        $phone = session('reset_password_phone');

        if (!$phone) {
            return redirect()->route('auth.login')->with('error', 'غير مسموح بالوصول المباشر إلى صفحة إعادة تعيين كلمة المرور.');
        }

        // Get latest OTP for this phone
        $latestOtp = Otp::where('phone', $phone)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->latest()
            ->first();

        $remainingTime = 0;
        if ($latestOtp) {
            $expiryTime = $latestOtp->created_at->addSeconds(30);
            if ($expiryTime->isFuture()) {
                $remainingTime = now()->diffInSeconds($expiryTime);
            }
        }
        return view('auth.show-reset-password', compact('phone', 'remainingTime'));
    }

    // معالجة إعادة تعيين كلمة المرور
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed',
            'otp' => 'required|array|size:4',
        ]);

        $phone = session('reset_password_phone');

        if (!$phone) {
            return redirect()->route('auth.login')->with('error', 'غير مسموح بالوصول المباشر إلى صفحة إعادة تعيين كلمة المرور.');
        }

        $otpNumber = implode('', $request->otp);
        $message = $this->authService->verifyOtp($otpNumber, $phone);

        if ($message !== 'تم التحقق بنجاح.') {
            return redirect()->back()->withErrors(['otp' => $message]);
        }

        $user = User::where('mobile', $phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('reset_password_phone');
        Auth::login($user);

        return redirect()->route('home')->with('success', 'تم تحديث كلمة المرور بنجاح.');
    }

    // إعادة إرسال OTP
    public function resendOtp(Request $request)
    {
        // التحقق من وجود رقم الهاتف في الطلب أو في الجلسة
        $phone = $request->phone ?? session('otp_phone');

        if (!$phone) {
            return response()->json([
                'success' => false,
                'message' => 'غير مسموح بالوصول المباشر إلى صفحة إعادة إرسال الرمز.'
            ], 403);
        }

        $user = User::where('mobile', $phone)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على المستخدم.'
            ], 404);
        }

        // التحقق من وقت آخر OTP
        $lastOtp = Otp::where('phone', $phone)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->latest()
            ->first();

        if ($lastOtp) {
            $waitTime = 30; // 30 seconds wait time
            $timeSinceLastOtp = now()->diffInSeconds($lastOtp->created_at);

            if ($timeSinceLastOtp < $waitTime) {
                $remainingTime = $waitTime - $timeSinceLastOtp;
                return response()->json([
                    'success' => false,
                    'message' => "يرجى المحاولة بعد {$remainingTime} ثانية.",
                    'remainingTime' => $remainingTime
                ], 429);
            }
        }

        $message = $this->authService->sendOtp($phone);

        if ($message === 'تم إرسال رمز التحقق بنجاح.') {
            return response()->json([
                'success' => true,
                'message' => $message,
                'remainingTime' => 30
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $message
        ], 400);
    }

    // تسجيل الخروج
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('auth.login');
    }

    // عرض صفحة التحقق
    public function showVerifyPage()
    {
        return view('auth.verify');
    }




    public function profile()
    {

        $user = Auth::user();
        $requests = ReservationBookingRequest::where('user_id', $user->id)->whereHas('bookingSeats')->get();
        $tickets = $requests->map(fn($res) => (new TicketViewModel($res))->toArray());


        
        return view('profile.index', compact('user', 'tickets'));
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
