<?php

namespace App\Exceptions;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // 1. Normal Laravel Form Validation & Auth exceptions must flow through naturally
        if ($exception instanceof ValidationException || $exception instanceof AuthenticationException || $exception instanceof TokenMismatchException) {
            return parent::render($request, $exception);
        }

        // 2. 404 Model Not Found or Not Found Http Exception
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $this->render404($request, $exception);
        }

        // 3. Check environment / debug setting
        // When APP_DEBUG is true (development mode), display full stack traces for developers
        // unless explicitly testing the error guard page via ?preview_error_guard=1
        $isDebug = (bool) config('app.debug', false);
        $previewGuard = $request->has('preview_error_guard');

        if ($isDebug && !$previewGuard) {
            return parent::render($request, $exception);
        }

        // 4. In Production Mode (or when previewing guard):
        // Intercept any crash / 500 error / unhandled exception and show the friendly "We are working on it" page
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'status'  => 500,
                'message' => __('We are currently experiencing a technical issue. Our team is working on it, please check back shortly.'),
            ], 500);
        }

        $context = $this->getStoreContext();
        $storeName = $context['storeName'];
        $homeUrl = $context['homeUrl'];
        $favicon = $context['favicon'];

        return response()->view('errors.500', [
            'exception' => $exception,
            'storeName' => $storeName,
            'homeUrl'   => $homeUrl,
            'favicon'   => $favicon,
        ], 500);
    }

    /**
     * Render custom 404 page based on domain/subdomain context
     */
    protected function render404($request, Throwable $exception)
    {
        try {
            // path based user URL
            if ((str_replace("www.", "", Request::getHost()) == env('WEBSITE_HOST') && Request::route() && strpos(Request::route()->getPrefix(), '{username}') !== false)) {
                $user = User::where('username', Request::route('username'))->where('online_status', 1);
                if ($user->count() > 0) {
                    $user = $user->first();
                    $userBs = $user->basic_setting;
                    return response()->view('errors.404', ['userBs' => $userBs, 'exception' => $exception], 404);
                } else {
                    return response()->view('errors.404', ['exception' => $exception], 404);
                }
            }

            // custom domain & subdomain based user URL
            elseif (Request::getHost() != env('WEBSITE_HOST')) {
                // if its a subdomain
                if (strpos(Request::getHost(), env('WEBSITE_HOST')) !== false) {
                    $host = Request::getHost();
                    $host = str_replace("www.", "", $host);
                    $hostArr = explode('.', $host);
                    $username = $hostArr[0];
                    $user = User::where('username', $username);
                    if ($user->count() > 0) {
                        $userBs = $user->first()->basic_setting;
                        return response()->view('errors.404', ['userBs' => $userBs, 'exception' => $exception], 404);
                    }
                } else {
                    $host = Request::getHost();
                    if (substr($host, 0, 4) != 'www.') {
                        $host = 'www.' . $host;
                    }

                    $user = User::whereHas('user_custom_domains', function ($q) use ($host) {
                        $cleanHost = preg_replace('/^www\./i', '', strtolower($host));
                        $q->where(function ($sq) {
                                $sq->where('status', 1)->orWhere('status', '1')->orWhere('status', 0);
                            })
                            ->where(function ($query) use ($host, $cleanHost) {
                                $query->where('requested_domain', '=', $host)
                                    ->orWhere('requested_domain', '=', $cleanHost)
                                    ->orWhere('requested_domain', 'LIKE', '%' . $cleanHost . '%')
                                    ->orWhere('current_domain', '=', $host)
                                    ->orWhere('current_domain', '=', $cleanHost)
                                    ->orWhere('current_domain', 'LIKE', '%' . $cleanHost . '%');
                            });
                    });

                    if ($user->count() > 0) {
                        $user = $user->first();
                        $userBs = $user->basic_setting;
                        return response()->view('errors.404', ['userBs' => $userBs, 'exception' => $exception], 404);
                    }
                }
            }
        } catch (\Throwable $e) {
            // Fall through to basic 404 view
        }

        return response()->view('errors.404', ['exception' => $exception], 404);
    }

    /**
     * Safely resolve store context (name, home URL, favicon) without throwing errors
     */
    protected function getStoreContext()
    {
        $context = [
            'storeName' => null,
            'homeUrl'   => url('/'),
            'favicon'   => null,
        ];

        try {
            $host = Request::getHost();
            $websiteHost = env('WEBSITE_HOST', 'launchshop.in');
            $cleanHost = str_replace('www.', '', strtolower($host));
            $cleanWebsiteHost = str_replace('www.', '', strtolower($websiteHost));

            // 1. Path-based username URL: launchshop.in/{username}
            if ($cleanHost == $cleanWebsiteHost && Request::route() && Request::route('username')) {
                $user = User::where('username', Request::route('username'))->first();
                if ($user) {
                    $context['storeName'] = $user->shop_name ?? $user->username;
                    if (\Illuminate\Support\Facades\Route::has('front.user.detail.view')) {
                        $context['homeUrl'] = route('front.user.detail.view', $user->username);
                    }
                    if (!empty($user->basic_setting->favicon)) {
                        $context['favicon'] = asset('assets/front/img/user/' . $user->basic_setting->favicon);
                    }
                    return $context;
                }
            }

            // 2. Subdomain: {username}.launchshop.in
            if (strpos($cleanHost, $cleanWebsiteHost) !== false && $cleanHost != $cleanWebsiteHost) {
                $hostArr = explode('.', $cleanHost);
                $username = $hostArr[0];
                $user = User::where('username', $username)->first();
                if ($user) {
                    $context['storeName'] = $user->shop_name ?? $user->username;
                    $context['homeUrl'] = Request::getSchemeAndHttpHost();
                    if (!empty($user->basic_setting->favicon)) {
                        $context['favicon'] = asset('assets/front/img/user/' . $user->basic_setting->favicon);
                    }
                    return $context;
                }
            }

            // 3. Custom domain
            if ($cleanHost != $cleanWebsiteHost) {
                $user = User::whereHas('user_custom_domains', function ($q) use ($cleanHost) {
                    $q->where(function ($query) use ($cleanHost) {
                        $query->where('requested_domain', '=', $cleanHost)
                            ->orWhere('requested_domain', '=', 'www.' . $cleanHost)
                            ->orWhere('current_domain', '=', $cleanHost)
                            ->orWhere('current_domain', '=', 'www.' . $cleanHost);
                    });
                })->first();

                if ($user) {
                    $context['storeName'] = $user->shop_name ?? $user->username;
                    $context['homeUrl'] = Request::getSchemeAndHttpHost();
                    if (!empty($user->basic_setting->favicon)) {
                        $context['favicon'] = asset('assets/front/img/user/' . $user->basic_setting->favicon);
                    }
                    return $context;
                }
            }
        } catch (\Throwable $t) {
            // Silently ignore to avoid secondary exceptions
        }

        return $context;
    }
}
