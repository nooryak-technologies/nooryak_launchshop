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
        if (Auth::check() && Auth::user()->status != 1) {
            Auth::guard('web')->logout();
            Session::forget('secrect_login');
            abort(404);
        }

        $response = $next($request);

        // Safeguard: if a non-AJAX form submission in user dashboard receives raw "success",
        // redirect back so the browser displays the page with the flashed success message
        // instead of a raw white screen with the word "success".
        if (!$request->ajax() && !$request->wantsJson() && is_a($response, \Illuminate\Http\Response::class)) {
            $content = trim($response->getContent());
            if ($content === 'success') {
                return redirect()->back();
            }
        }

        return $response;
    }
}
