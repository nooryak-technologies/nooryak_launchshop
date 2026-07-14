<?php

use App\Models\User;

$domain = env('WEBSITE_HOST');

if (!app()->runningInConsole()) {
    if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
        $domain = 'www.' . env('WEBSITE_HOST');
    }
}
Route::fallback(function () {
    return view('errors.404');
})->middleware('setlang');

Route::get('/midtrans/bank-notify', 'MidtransBankNotifyController@bank_notify')->name('midtrans.bank_notify');
Route::get('/check-payment', 'CronJobController@check_payment')->name('cron.check_payment');

Route::get('/myfatoorah/callback', 'MyFatoorahController@callback')->name('myfatoorah.success');
Route::get('myfatoorah/cancel', 'MyFatoorahController@cancel')->name('myfatoorah.cancel');

Route::get('/invoice', 'Front\FrontendController@invoice')
    ->name('front.invoice');

Route::get('/seed-horizonium-100-orders', function() {
    $user = \App\Models\User::where('email', 'bahadabdul539@gmail.com')
        ->orWhere('username', 'horizonium')
        ->first();
        
    if (!$user) {
        return "User bahadabdul539@gmail.com or horizonium not found.";
    }

    \App\Models\User\UserOrder::where('user_id', $user->id)->delete();

    $customer = \App\Models\User\Customer::where('user_id', $user->id)->first();
    if (!$customer) {
        $customer = \App\Models\User\Customer::create([
            'user_id' => $user->id,
            'first_name' => 'Mohamed',
            'last_name' => 'Imran',
            'email' => 'bahadabdul539@gmail.com',
            'phone' => '9876543210',
            'status' => 1
        ]);
    }

    $user_currency = \App\Models\User\UserCurrency::where('user_id', $user->id)->where('is_default', 1)->first();
    if (!$user_currency) {
        $user_currency = \App\Models\User\UserCurrency::where('user_id', $user->id)->first();
    }
    $currency_code = $user_currency ? $user_currency->code : 'INR';
    $currency_sign = $user_currency ? $user_currency->symbol : '₹';

    $firstNames = ['John', 'Emily', 'Michael', 'Sarah', 'David', 'Jessica', 'James', 'Ashley', 'Robert', 'Amanda'];
    $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilson'];
    $gateways = ['Stripe', 'PayPal', 'Razorpay', 'Offline'];
    $statuses = ['completed', 'pending', 'processing', 'rejected'];

    for ($i = 0; $i < 100; $i++) {
        $daysAgo = rand(0, 29);
        $orderDate = \Carbon\Carbon::now()->subDays($daysAgo)->subHours(rand(0, 23))->subMinutes(rand(0, 59));
        
        $cart_total = rand(200, 3000);
        $tax = round($cart_total * 0.1, 2);
        $shipping_charge = rand(0, 1) ? 0 : rand(30, 120);
        $total = $cart_total + $tax + $shipping_charge;

        $status = $statuses[array_rand($statuses)];
        $payment_status = ($status == 'rejected') ? 'Pending' : 'Completed';

        \App\Models\User\UserOrder::create([
            'customer_id' => $customer->id,
            'user_id' => $user->id,
            'billing_country' => 'India',
            'billing_fname' => $firstNames[array_rand($firstNames)],
            'billing_lname' => $lastNames[array_rand($lastNames)],
            'billing_address' => 'Street ' . rand(1, 200),
            'billing_city' => 'Chennai',
            'billing_email' => 'customer' . rand(1, 100) . '@demo.com',
            'billing_number' => '98765' . rand(10000, 99999),
            'shipping_country' => 'India',
            'shipping_fname' => $firstNames[array_rand($firstNames)],
            'shipping_lname' => $lastNames[array_rand($lastNames)],
            'shipping_address' => 'Street ' . rand(1, 200),
            'shipping_city' => 'Chennai',
            'shipping_email' => 'customer' . rand(1, 100) . '@demo.com',
            'shipping_number' => '98765' . rand(10000, 99999),
            'cart_total' => $cart_total,
            'discount' => 0,
            'tax' => $tax,
            'tax_percentage' => 10.00,
            'total' => $total,
            'method' => $gateways[array_rand($gateways)],
            'gateway_type' => 'online',
            'currency_code' => $currency_code,
            'currency_sign' => $currency_sign,
            'currency_id' => $user_currency ? $user_currency->id : 1,
            'order_number' => strtoupper(\Illuminate\Support\Str::random(4)) . time() . rand(10, 99),
            'shipping_method' => 'Standard Delivery',
            'shipping_charge' => $shipping_charge,
            'payment_status' => $payment_status,
            'order_status' => $status,
            'created_at' => $orderDate,
            'updated_at' => $orderDate
        ]);
    }

    return "Successfully seeded 100 dummy orders for bahadabdul539@gmail.com (horizonium)!";
});

Route::domain($domain)->group(function () {
    Route::get('/changelanguage/{lang}', 'Front\FrontendController@changeLanguage')->name('changeLanguage');

    // cron job for sending expiry mail
    Route::get('/subcheck', 'CronJobController@expired')->name('cron.expired');
    Route::post('/push', 'Front\PushController@store')->name('push-notification.store_endpoint');

    Route::group(['middleware' => 'setlang'], function () {
        Route::get('/', 'Front\FrontendController@index')->name('front.index');
        Route::post('/subscribe', 'Front\FrontendController@subscribe')->name('front.subscribe');
        Route::get('/shops', 'Front\FrontendController@shops')->name('front.user.view');
        Route::get('/templates', 'Front\FrontendController@templates')->name('front.templates.view');
        Route::get('/templates/autologin/{username}', 'Front\FrontendController@autoLoginTemplate')->name('front.templates.autologin');
        Route::get('/contact', 'Front\FrontendController@contactView')->name('front.contact');
        Route::post('/admin/contact-msg', 'Front\FrontendController@adminContactMessage')->name('front.admin.contact.message')->middleware('Demo');
        Route::get('/faqs', 'Front\FrontendController@faqs')->name('front.faq.view');
        Route::get('/blog', 'Front\FrontendController@blogs')->name('front.blogs');
        Route::get('/blog/{slug}/{id}', 'Front\FrontendController@blogdetails')->name('front.blogdetails');
        Route::get('/pricing', 'Front\FrontendController@pricing')->name('front.pricing');
        Route::get('/registration/select-template/{status}/{id}', 'Front\FrontendController@selectTemplate')->name('front.select.template');
        Route::get('/registration/step-1/{status}/{id}', 'Front\FrontendController@step1')->name('front.register.view');
        Route::get('/check/{username}/username', 'Front\FrontendController@checkUsername')->name('front.username.check');
        Route::post('/otp/send', 'Front\FrontendController@sendOtp')->name('front.otp.send');
        Route::post('/otp/verify', 'Front\FrontendController@verifyOtp')->name('front.otp.verify');
        Route::get('/p/{slug}', 'Front\FrontendController@dynamicPage')->name('front.dynamicPage');
        Route::get('/success', 'Front\CheckoutController@paymentSuccess')->name('success.page');
        Route::get('/about', 'Front\FrontendController@about')->name('front.about');
    });

    Route::group(['middleware' => ['web', 'guest', 'setlang']], function () {
        Route::get('/registration/final-step', 'Front\FrontendController@step2')->name('front.registration.step2');
        Route::post('/checkout', 'Front\FrontendController@checkout')->name('front.checkout.view');

        Route::get('/login', 'User\Auth\LoginController@showLoginForm')->name('user.login');
        Route::post('/login', 'User\Auth\LoginController@login')->name('user.login.submit');
        Route::post('/login/otp', 'User\Auth\LoginController@loginWithOtp')->name('user.login.otp.submit');
        Route::post('/register/submit', 'User\Auth\RegisterController@register')->name('user-register-submit')->middleware('Demo');
        Route::get('/register/mode/{mode}/verify/{token}', 'User\Auth\RegisterController@token')->name('user-register-token');

        Route::post('/password/email', 'User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.forgot.password.submit')->middleware('Demo');

        Route::get('/password/reset', 'User\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.forgot.password.form');
        Route::post('/password/reset', 'User\Auth\ResetPasswordController@reset')->name('user.reset.password.submit')->middleware('Demo');
        Route::get('/password/reset/{token}/email/{email}', 'User\Auth\ResetPasswordController@showResetForm')->name('user.reset.password.form');

        // Route::get('/forgot', 'User\ForgotController@showforgotform')->name('user-forgot');
        Route::post('/forgot', 'User\Auth\ForgotPasswordController@forgetPasswordMail')->name('user-forgot-submit')->middleware('Demo');
    });

    /*=======================================================
    ******************** Admin Dashboard Routes **********************
    =======================================================*/

    Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
        Route::get('/', 'Admin\LoginController@login')->name('admin.login');
        Route::post('/login', 'Admin\LoginController@authenticate')->name('admin.auth');

        Route::get('/mail-form', 'Admin\ForgetController@mailForm')->name('admin.forget.form');
        Route::post('/sendmail', 'Admin\ForgetController@sendmail')->name('admin.forget.mail')->middleware('Demo');
    });

    Route::group(['middleware' => ['web', 'setlang']], function () {

        Route::post('/membership/checkout', 'Front\CheckoutController@checkout')->name('front.membership.checkout')->middleware('Demo');
        Route::post('/payment/instructions', 'Front\FrontendController@paymentInstruction')->name('front.payment.instructions');
        //checkout payment gateway routes
        Route::prefix('membership')->group(function () {
            Route::get('paypal/success', "Payment\PaypalController@successPayment")->name('membership.paypal.success');
            Route::get('paypal/cancel', "Payment\PaypalController@cancelPayment")->name('membership.paypal.cancel');
            Route::get('stripe/cancel', "Payment\StripeController@cancelPayment")->name('membership.stripe.cancel');
            Route::post('paytm/payment-status', "Payment\PaytmController@paymentStatus")->name('membership.paytm.status');
            Route::get('paystack/success', 'Payment\PaystackController@successPayment')->name('membership.paystack.success');
            Route::post('mercadopago/cancel', 'Payment\MercadopagoController@cancelPayment')->name('membership.mercadopago.cancel');
            Route::get('mercadopago/success', 'Payment\MercadopagoController@successPayment')->name('membership.mercadopago.success');
            Route::post('razorpay/success', 'Payment\RazorpayController@successPayment')->name('membership.razorpay.success');
            Route::post('razorpay/cancel', 'Payment\RazorpayController@cancelPayment')->name('membership.razorpay.cancel');
            Route::get('instamojo/success', 'Payment\InstamojoController@successPayment')->name('membership.instamojo.success');
            Route::post('instamojo/cancel', 'Payment\InstamojoController@cancelPayment')->name('membership.instamojo.cancel');
            Route::post('flutterwave/success', 'Payment\FlutterWaveController@successPayment')->name('membership.flutterwave.success');

            Route::get('/mollie/success', 'Payment\MollieController@successPayment')->name('membership.mollie.success');
            Route::post('mollie/cancel', 'Payment\MollieController@cancelPayment')->name('membership.mollie.cancel');
            Route::get('anet/cancel', 'Payment\AuthorizenetController@cancelPayment')->name('membership.anet.cancel');

            Route::get('yoco/success', 'Payment\YocoController@successPayment')->name('membership.yoco.success');
            Route::get('xendit/success', 'Payment\XenditController@successPayment')->name('membership.xendit.success');
            Route::get('perfect_money/success', 'Payment\PerfectMoneyController@successPayment')->name('membership.perfect_money.success');
            Route::get('midtrans/success', 'Payment\MidtransController@successPayment')->name('membership.midtrans.success');
            Route::post('iyzico/success', 'Payment\IyzicoController@successPayment')->name('membership.iyzico.success');
            Route::get('toyyibpay/success', 'Payment\ToyyibpayController@successPayment')->name('membership.toyyibpay.success');
            Route::post('paytabs/success', 'Payment\PaytabsController@successPayment')->name('membership.paytabs.success');
            Route::post('phonepe/success', 'Payment\PaytabsController@successPayment')->name('membership.phonepe.success');
            Route::post('phonepe/success', 'Payment\PaytabsController@successPayment')->name('membership.phonepe.success');

            Route::get('/offline/success', 'Front\CheckoutController@offlineSuccess')->name('membership.offline.success');
            Route::get('/trial/success', 'Front\CheckoutController@trialSuccess')->name('membership.trial.success');
        });

        Route::any('membership/cancel', 'Front\CheckoutController@cancelPayment')->name('membership.cancel');
    });
});
