<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

class Demo
{
    /**
     * Handle an incoming request.
     *
     * Block all write operations (POST / PUT / PATCH / DELETE) when either:
     *   1. The app is running in DEMO_MODE (env), OR
     *   2. The visitor is browsing via the template "Admin" button (secrect_login session).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isWriteMethod = $request->isMethod('POST')
            || $request->isMethod('PUT')
            || $request->isMethod('PATCH')
            || $request->isMethod('DELETE');

        // Block writes in DEMO_MODE
        if (env('DEMO_MODE') == 'inactive' && $isWriteMethod) {
            session()->flash('warning', __('This is Demo version. You can not change anything.'));
            return redirect()->back();
        }

        // Block writes for template-preview (secret login) sessions
        if (Session::get('secrect_login') == true && $isWriteMethod && !Auth::guard('admin')->check() && !$request->is('admin/*') && !$request->is('admin')) {
            session()->flash('warning', __('This is template demo dashboard message'));
            return redirect()->back();
        }

        return $next($request);
    }
}
