<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    protected function otpEnabled(): bool
    {
        return $this->authService->isOtpEnabled();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|min:10',
            'password' => 'required',
        ], [
            'phone.required' => __('Phone is required'),
            'phone.numeric' => __('Phone must be numeric'),
            'phone.min' => __('Phone must be at least 10 digits'),
            'password.required' => __('Password is required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $phone = $request->phone;
        $password = $request->password;
        $user = User::where('mobile', $phone)->first();


        if (!$user) {
            return response()->json(['status' => false, 'message' => __('User not found')]);
        } else {

            if (Hash::check($password, $user->password)) {
                $refreshToken = bin2hex(random_bytes(32));
                $user->remember_token =  $refreshToken;
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => null,
                    'is_user_registered' => $user->name != 'Guest',
                    'refresh_token' => $refreshToken,
                    'access_token' => $user->createToken('reservation')->plainTextToken,
                    'data' => $user,
                ]);
            } else {
                return response()->json(['status' => false, 'message' => __('Password is incorrect')]);
            }
        }
    }
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required|numeric|min:10|unique:users,mobile',
                'password' => 'required|confirmed',
            ], [
                'name.required' => __('Name is required'),
                'phone.required' => __('Phone is required'),
                'phone.numeric' => __('Phone must be numeric'),
                'phone.min' => __('Phone must be at least 10 digits'),
                'phone.unique' => __('Phone already exists'),
                'password.required' => __('Password is required'),
                'password.confirmed' => __('Password confirmation does not match'),
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }
            $this->authService->registerUser($request);
            return response()->json(['status' => true, 'message' => __('User registered successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    public function resendOtp(Request $request)
    {
        if (! $this->otpEnabled()) {
            return response()->json(['status' => false, 'message' => __('OTP is disabled')], 404);
        }

        $validator = Validator::make($request->all(), [

            'phone' => 'required|numeric|min:10|unique:users,mobile',

        ], [

            'phone.required' => __('Phone is required'),
            'phone.numeric' => __('Phone must be numeric'),
            'phone.min' => __('Phone must be at least 10 digits'),
            'phone.unique' => __('Phone already exists'),

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = User::where('mobile', $request->phone)->first();
        $this->authService->sendOtp($user);
        return response()->json(['status' => true, 'message' => __('OTP sent successfully')]);
    }

    public function verify_register_otp(Request $request)
    {
        if (! $this->otpEnabled()) {
            return response()->json(['status' => false, 'message' => __('OTP is disabled')], 404);
        }

        try {
            $validator = Validator::make($request->all(), [

                'phone' => 'required|numeric|min:10|exists:users,mobile',
                'otp' => 'required|numeric|digits:4',
            ], [

                'phone.required' => __('Phone is required'),
                'phone.numeric' => __('Phone must be numeric'),
                'phone.min' => __('Phone must be at least 10 digits'),
                'phone.exists' => __('Phone does not exist'),
                'otp.required' => __('OTP is required'),
                'otp.numeric' => __('OTP must be an numeric'),
                'otp.digits' => __('OTP must be 4 digits'),
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }
            $otpNumber = $request->otp;
            $phone = $request->phone;

            $result = $this->authService->verifyOtp($otpNumber, $phone);

            if ($result['success']) {
                $user = User::where('mobile', $phone)->first();
                $refreshToken = bin2hex(random_bytes(32));
                $user->remember_token =  $refreshToken;
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => null,
                    'is_user_registered' => $user->name != 'Guest',
                    'refresh_token' => $refreshToken,
                    'access_token' => $user->createToken('reservation')->plainTextToken,
                    'data' => $user,
                ]);
            } else {
                return response()->json(['status' => false, 'message' => $result['message']]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function forgot_password(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

                'phone' => 'required|numeric|min:10|exists:users,mobile',

            ], [

                'phone.required' => __('Phone is required'),
                'phone.numeric' => __('Phone must be numeric'),
                'phone.min' => __('Phone must be at least 10 digits'),
                'phone.unique' => __('Phone already exists'),

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }
            $user = User::where('mobile', $request->phone)->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => __('Phone does not exist')
                ]);
            }

            if (! $this->otpEnabled()) {
                return response()->json([
                    'status' => true,
                    'message' => __('Proceed to reset password')
                ]);
            }

            $otp = $this->authService->sendOtp($user);
            if ($otp['success']) {
                return response()->json([
                    'status' => true,
                    'message' => __('OTP sent successfully')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => $otp['message']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function reset_password(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|numeric|min:10|exists:users,mobile',
                'password' => 'required|confirmed',
            ], [
                'phone.required' => __('Phone is required'),
                'phone.numeric' => __('Phone must be numeric'),
                'phone.min' => __('Phone must be at least 10 digits'),
                'phone.unique' => __('Phone already exists'),
                'password.required' => __('Password is required'),
                'password.confirmed' => __('Password confirmation does not match'),
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }
            $user = User::where('mobile', $request->phone)->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => __('Phone does not exist')
                ]);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'status' => true,
                'message' => __('Password reset successfully')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function refresh_token(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'refresh_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        $user = User::where('remember_token',  $request->refresh_token)->first();
        $refreshToken = bin2hex(random_bytes(32));
        if ($user) {
            $user->remember_token =  $refreshToken;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => null,
                'is_user_registered' => $user->name != 'Guest',
                'refresh_token' => $refreshToken,
                'access_token' => $user->createToken('reservation')->plainTextToken,
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found!',
                'data' => null,
            ], 404);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => true, 'message' => 'Logged out successfully']);
    }
}

