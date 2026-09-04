<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use Illuminate\Support\Facades\Route;

class UserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('secrect_login') != true) {
            if (Auth::user()->status != 1) {
                Auth::guard('web')->logout();
                Session::flash('error', 'Your account has been banned!');
                return redirect(Route::has('front.index') ? route('front.index') : url('/'));
            }
        }
        return $next($request);
    }
}
