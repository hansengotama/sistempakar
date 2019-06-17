<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotLogin
{
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::user();

        if($user)
            if($user->role == 'admin')
                return redirect()->route('home-admin');
            else
                return redirect()->route('home-patient');

        return $next($request);
    }
}
