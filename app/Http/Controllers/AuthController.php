<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\ProfileRequest;
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

    //done
    public function login()
    {
        return view('auth.login');
    }

    // عرض صفحة
    //done
    public function register()
    {
        return view('auth.register');
    }
    //done
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
        ], [
            'mobile.required' => __("Mobile number is required."),
            'password.required' => __("Password is required."),
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'لم يتم العثور على المستخدم.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور غير صحيحة.');
        }

        Auth::login($user);

        if (!$user->verified) {
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

        $user = User::where('mobile', $request->phone)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'رقم الهاتف غير صحيح.'], 400);
        }
             
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

            $otp = $this->authService->sendOtp($user);
             
            if ($otp['success']) {
                session([
                    'reset_password_phone' => $request->phone
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $otp['message'],
                    'remainingTime' => 30
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $otp['message']
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
            $otp = $this->authService->sendOtp($user);

         if ($otp['success']) {
                session([
                    'reset_password_phone' => $request->phone
                ]);

                return redirect()->route('auth.showResetPassword');
            }

            return redirect()->back()->withErrors(['phone' => $otp['message']]);
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
            $this->authService->sendOtp( $user);
        }

        if (!$phone) {
            return redirect()->route('auth.register')->withErrors(['error' => 'غير مسموح بالوصول المباشر إلى صفحة التحقق.']);
        }

        $otp = Otp::where('phone', $phone)->latest()->first();

        return view('auth.otp', compact('phone', 'otp'));
    }


    // معالجة OTP
    public function postOtp(Request $request)
    {
        // التحقق من الـ OTP المدخل
        $request->validate([
            'otp' => 'required|array|size:4',
        ]);

        // تحويل الـ OTP إلى سلسلة من الأرقام
        $otpNumber = implode('', $request->otp);
        $phone = session('otp_phone');

        // التحقق من صحة الـ OTP عبر الخدمة
        $result = $this->authService->verifyOtp($otpNumber, $phone);

        if (!$result['success']) {
            return redirect()->back()->withErrors(['otp' => $result['message']]);
        }

        // التحقق إذا كان المستخدم مسجل دخوله بالفعل
        if (Auth::check()) {
            return redirect()->route('home')->with('success', 'تم التحقق من رقم الهاتف بنجاح.');
        }

        // في حالة عدم تسجيل الدخول، نقوم بتسجيل المستخدم مباشرة
        $user = User::where('mobile', $phone)->first();
        Auth::login($user);

        // مسح الـ OTP من الجلسة
        session()->forget('otp_phone');

        return redirect()->route('home')->with('success', 'تم التحقق من رقم الهاتف بنجاح.');
    }


    public function postOtpForPasswordReset(Request $request)
    {
        // التحقق من الـ OTP المدخل
        $request->validate([
            'otp' => 'required|array|size:4',
        ]);

        // تحويل الـ OTP إلى سلسلة من الأرقام
        $otpNumber = implode('', $request->otp);
        $phone = session('reset_password_phone');

        // التأكد من وجود الرقم في الجلسة
        if (!$phone) {
            return redirect()->route('auth.login')->with('error', 'حدث خطأ أثناء إعادة تعيين كلمة المرور.');
        }

        // التحقق من صحة الـ OTP
        $result = $this->authService->verifyOtp($otpNumber, $phone);

        if (!$result['success']) {
            return redirect()->back()->withErrors(['otp' => $result['message']]);
        }

        // تخزين الـ OTP لإعادة تعيين كلمة المرور
        session()->put('reset_password_otp', $otpNumber);

        // إعادة التوجيه إلى صفحة تغيير كلمة المرور
        return redirect()->route('auth.showNewPasswordForm');
    }




    public function showNewPasswordForm()
    {
        if (!session()->has('reset_password_phone') || !session()->has('reset_password_otp')) {
            return redirect()->route('auth.login')->with('error', 'انتهت صلاحية الرابط أو تم الوصول إليه بشكل غير صحيح.');
        }

        return view('auth.new-password');
    }


    // عرض صفحة إعادة تعيين كلمة المرور
    public function showResetPassword()
    {
        $phone = session('reset_password_phone');

        if (!$phone) {
            return redirect()->route('auth.login')->with('error', 'غير مسموح بالوصول المباشر إلى صفحة إعادة تعيين كلمة المرور.');
        }
        $remainingTime = 60;
        return view('auth.show-reset-password', compact('phone', 'remainingTime'));
    }

    // التحقق من OTP لإعادة تعيين كلمة المرور
    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:4',
        ], [
            'otp.required' => __("OTP is required. Please enter the code sent to your phone."),
            'otp.size' => __("OTP must be 4 digits. Please enter exactly 4 digits."),
            'otp.array' => __("OTP must be an array. Please ensure the code is entered in the correct format."),
        ]);

        // dd($request->otp);
        $otpNumber = implode('', $request->otp);
        $phone = session('reset_password_phone');
        // dd($phone);
        $result = $this->authService->verifyOtp($otpNumber, $phone);

        // إذا لم يكن التحقق ناجحًا
        if (!$result['success']) {
            return redirect()->back()->withErrors(['otp' => $result['message']]);
        }
        // dd($phone);
        // تخزين OTP في الجلسة للخطوة التالية
        session(['reset_password_otp' => $otpNumber]);

        return redirect()->route('auth.resetPasswordNew');
    }

    // عرض صفحة إدخال كلمة المرور الجديدة
    public function resetPasswordNew()
    {
        $phone = session('reset_password_phone');
        $otp = session('reset_password_otp');

        if (!$phone || !$otp) {
            return redirect()->route('auth.login')->with('error', 'غير مسموح بالوصول المباشر إلى صفحة إعادة تعيين كلمة المرور.');
        }
        return view('auth.new-password', compact('phone', 'otp'));
    }

    // تحديث كلمة المرور
    public function updatePassword(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'password' => 'required|string|confirmed',
            'otp' => 'required|numeric|digits:4',
        ]);

        // استرجاع الهاتف من الجلسة
        $phone = session('reset_password_phone');

        // التأكد أن الهاتف موجود في الجلسة
        if (!$phone) {
            return redirect()->route('auth.login')->with('error', 'حدث خطأ أثناء إعادة تعيين كلمة المرور.');
        }

        // البحث عن المستخدم بناءً على الهاتف
        $user = User::where('mobile', $phone)->first();
        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'لم يتم العثور على المستخدم.');
        }

        // تحديث كلمة المرور
        $user->password = Hash::make($request->password);
        $user->save();

        // تسجيل الدخول للمستخدم بعد تحديث كلمة المرور
        Auth::login($user);

        // مسح بيانات الجلسة
        session()->forget(['reset_password_phone']);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('home')->with('success', 'تم إعادة تعيين كلمة المرور بنجاح وتسجيل الدخول.');
    }



    // إعادة إرسال OTP
    public function resendOtp(Request $request)
    {
        // التحقق من وجود رقم الهاتف في الطلب أو في الجلسة
        $phone = $request->phone ?? session('otp_phone');

        // dd($phone);
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





        $otp = $this->authService->sendOtp($user);

        if ($otp['success']) {
            return response()->json([
                'success' => true,
                'message' => $otp['message'],
                'remainingTime' => 30
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $otp['message']
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
