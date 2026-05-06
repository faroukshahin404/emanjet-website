<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserNotVerified
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
        if (! config('auth.otp_enabled', true)) {
            return redirect()->route('home');
        }

        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', __('Please Login First.'));
        }
        $user = Auth::user();
        if ($user->verified || $user->phone_verified_at) {
            return redirect()->route('home')->with('error', __('You cannot access this page.'));
        }
        return $next($request);
    }
}
