<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        Log::info('Attempting login for admin: ' . $credentials['email']);
        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Log::info('Password is correct');
        } else {
            Log::warning('Password is incorrect or admin not found');
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            Log::info('Login successful for admin: ' . $credentials['email']);
            return redirect()->route('admin.dashboard.index');
        }

        Log::warning('Login failed for admin: ' . $credentials['email']);
        return back()->withErrors(['email' => 'بيانات تسجيل الدخول غير صحيحة.']);
    }


    public function dashboard()
    {
        return view('admin.pages.dashboard.index');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
