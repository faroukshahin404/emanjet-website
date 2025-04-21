<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'الرجاء تسجيل الدخول أولاً.');
        }
        // $user = Auth::user();
        // if (!$user->verified || !$user->phone_verified_at) {
        //     return redirect()->route('auth.verify')->with('error', 'يجب التحقق من بريدك الإلكتروني ورقم هاتفك أولاً.');
        // }

        return $next($request);
    }
}
