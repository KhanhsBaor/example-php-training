<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SingleLogin
{
    public function handle($request, Closure $next)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $currentSessionId = Session::getId();
            $storedSessionId = Auth::user()->session_id;

            // Nếu session hiện tại khác với session trong DB => logout user
            if ($storedSessionId && $storedSessionId !== $currentSessionId) {
                Auth::logout();
                return redirect()->route('login.view')->with('error', 'You have been logged out because your account is logged in from another device.');
            }
        }

        return $next($request);
    }
}
