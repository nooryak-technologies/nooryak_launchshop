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
        if (env('DEMO_MODE') == 'active' && $isWriteMethod) {
            session()->flash('warning', __('This is Demo version. You can not change anything.'));
            return redirect()->back();
        }

        // Block writes / CRUD operations ONLY for demo theme template users (preview_template == 1)
        $isTemplateDemoUser = Auth::guard('web')->check() && ((int) Auth::guard('web')->user()->preview_template === 1);
        if ($isWriteMethod && !$request->is('X9_AdMiN-Portal_V7') && !$request->is('X9_AdMiN-Portal_V7/*') && $isTemplateDemoUser) {
            // Don't block store-front customer ordering, cart or checkout requests
            if ($request->is('*/add-to-cart') || $request->is('*/cart') || $request->is('*/cart/*') || $request->is('*/checkout') || $request->is('*/checkout/*') || $request->is('*/order/*') || $request->is('*/itemcheckout/*') || $request->is('add-to-cart') || $request->is('checkout')) {
                return $next($request);
            }
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'warning',
                    'message' => __('This is a demo store. CRUD operations are disabled in demo mode.')
                ]);
            }
            session()->flash('warning', __('This is a demo store. CRUD operations are disabled in demo mode.'));
            return redirect()->back();
        }

        return $next($request);
    }
}
