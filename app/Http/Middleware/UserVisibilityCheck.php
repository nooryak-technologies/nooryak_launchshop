<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserVisibilityCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = getUser();
        if (empty($user) || !is_object($user) || !isset($user->id)) {
            return $next($request);
        }
        $safeRedirect = Route::has('front.index')
            ? route('front.index')
            : (Route::has('front.user.detail.view') ? route('front.user.detail.view', getParam()) : url('/'));

        if (Auth::check() && Auth::user()->id != $user->id && $user->online_status != 1 && $user->preview_template != 1) {
            return redirect($safeRedirect);
        } elseif (!Auth::check() && $user->online_status != 1 && $user->preview_template != 1) {
            return redirect($safeRedirect);
        }
        return $next($request);
    }
}
