@php
  /*
   * Payment Gateway Display Rules:
   * 1. Only show online gateways that exist in the user's package permissions (packagePermissions global).
   * 2. Only show a gateway if it has at least one non-empty value in its `information` JSON field
   *    (i.e. credentials have been configured).
   * 3. Offline gateways are always shown (they have no API keys, just manual instructions).
   *
   * Gateway name → permission key mapping:
   *   Paypal        → "Paypal"
   *   Stripe        → "Stripe"
   *   Razorpay      → "Razorpay"
   *   Paystack      → "Paystack"
   *   Instamojo     → "Instamojo"
   *   Mercadopago   → "Mercadopago"
   *   Flutterwave   → "Flutterwave"
   *   Authorize.net → "Authorize.net"
   *   Mollie        → "Mollie"
   *   Yoco          → "Yoco"
   *   Xendit        → "Xendit"
   *   Perfect Money → "Perfect Money"
   *   Myfatoorah    → "Myfatoorah"
   *   Toyyibpay     → "Toyyibpay"
   *   Paytabs       → "Paytabs"
   *   PhonePe       → "PhonePe"
   *   Midtrans      → "Midtrans"
   *   Iyzico        → "Iyzico"
   *   Paytm         → "Paytm"
   */

  /**
   * Check if a gateway has at least one non-empty credential configured.
   * $gateway is a UserPaymentGeteway model instance.
   */
  $hasCredentials = function ($gateway) {
      if (!$gateway || empty($gateway->information)) {
          return false;
      }
      $info = json_decode($gateway->information, true);
      if (!is_array($info) || empty($info)) {
          return false;
      }
      // Check that at least one value in the info array is non-empty
      foreach ($info as $val) {
          if (!empty(trim((string)$val))) {
              return true;
          }
      }
      return false;
  };

  /**
   * Determine if a gateway should be visible:
   * - packagePermissions must include the gateway name (permission key)
   * - Gateway must have credentials configured
   */
  $isGatewayVisible = function ($gateway) use ($packagePermissions, $hasCredentials) {
      if (!$gateway) {
          return false;
      }
      // The gateway `name` field matches the permission key (e.g. "Paypal", "Stripe", etc.)
      $permKey = $gateway->name;
      // packagePermissions is injected globally by AppServiceProvider
      $hasPermission = is_array($packagePermissions) && in_array($permKey, $packagePermissions);
      return $hasPermission && $hasCredentials($gateway);
  };
@endphp

<select name="payment_method" id="payment-gateway" class="olima_select form-control">
  <option value="" selected disabled>{{ $keywords['Select a payment gateway'] ?? __('Select a payment gateway') }}</option>

  @foreach ($payment_gateways as $payment)
    @php
      // Only render this option if: package allows it AND credentials are set
      $showGateway = $isGatewayVisible($payment);
    @endphp
    @if ($showGateway)
      <option value="{{ $payment->name }}" {{ old('payment_method') == $payment->name ? 'selected' : '' }}>
        @php $gateway_name = str_replace('_', ' ', $payment->name); @endphp
        {{ $keywords[$gateway_name] ?? __($gateway_name) }}
      </option>
    @endif
  @endforeach

  @foreach ($offlines as $offline)
    <option value="{{ $offline->name }}">
      {{ $keywords["$offline->name"] ?? __($offline->name) }}
    </option>
  @endforeach
</select>

@error('payment_method')
  <p class="text-danger">{{ $message }}</p>
@enderror

{{-- Inform if no gateway is available (all hidden due to package/config) --}}
@php
  $anyGatewayVisible = false;
  foreach ($payment_gateways as $payment) {
      if ($isGatewayVisible($payment)) {
          $anyGatewayVisible = true;
          break;
      }
  }
  $anyOfflineVisible = count($offlines) > 0;
@endphp
@if (!$anyGatewayVisible && !$anyOfflineVisible)
  <p class="text-warning mt-2">
    <i class="fas fa-exclamation-triangle me-1"></i>
    {{ $keywords['No payment gateway available'] ?? __('No payment gateway is currently available. Please contact the store owner.') }}
  </p>
@elseif (!$anyGatewayVisible && $anyOfflineVisible)
  {{-- Only offline gateways available - no inline notice needed --}}
@endif


{{-- START: Stripe Card Details Form --}}
@php
  $d_none = 'none';
  $d_block = 'block';
@endphp
<div class="row gateway-details py-3" id="tab-stripe" style="display: {{ $d_none }}">
  <div class="col-md-12">
    <div id="stripe-element" class="mb-2">
      <!-- A Stripe Element will be inserted here. -->
    </div>
    <!-- Used to display form errors -->
    <div id="stripe-errors" class="text-danger pb-2" role="alert"></div>
  </div>
</div>
{{-- END: Stripe Card Details Form --}}

<div class="row mt-2 iyzico-element {{ old('payment_method') == 'Iyzico' ? '' : 'd-none' }}">
  <div class="col-lg-12">
    <div class="form_group mb-3">
      <input type="text" name="identity_number" class="form-control mb-2"
        placeholder="{{ $keywords['Identity Number'] ?? __('Identity Number') }}" value="{{ old('identity_number') }}">
      @error('identity_number')
        <p class="text-danger text-left">{{ $message }}</p>
      @enderror
    </div>
    <div class="form_group mb-3">
      <input type="text" name="zip_code" class="form-control mb-2"
        placeholder="{{ $keywords['Zip Code'] ?? __('Zip Code') }}" value="{{ old('zip_code') }}">
      @error('zip_code')
        <p class="text-danger text-left">{{ $message }}</p>
      @enderror
    </div>
  </div>
</div>


{{-- START: Authorize.net Card Details Form --}}
<div class="row gateway-details py-3" id="tab-anet"
  style="display: {{ old('payment_method') == 'Authorize.net' ? $d_block : $d_none }}">
  <div class="col-lg-6">
    <div class="form_group mb-3">
      <input class="form-control" type="text" id="anetCardNumber"
        placeholder="{{ $keywords['Card Number'] ?? __('Card Number') }}" disabled />
    </div>
  </div>
  <div class="col-lg-6 mb-3">
    <div class="form_group">
      <input class="form-control" type="text" id="anetExpMonth"
        placeholder="{{ $keywords['Expire Month'] ?? __('Expire Month') }}" disabled />
    </div>
  </div>
  <div class="col-lg-6 ">
    <div class="form_group">
      <input class="form-control" type="text" id="anetExpYear"
        placeholder="{{ $keywords['Expire Year'] ?? __('Expire Year') }}" disabled />
    </div>
  </div>
  <div class="col-lg-6 ">
    <div class="form_group">
      <input class="form-control" type="text" id="anetCardCode"
        placeholder="{{ $keywords['Card Code'] ?? __('Card Code') }}" disabled />
    </div>
  </div>
  <input type="hidden" name="opaqueDataValue" id="opaqueDataValue" disabled />
  <input type="hidden" name="opaqueDataDescriptor" id="opaqueDataDescriptor" disabled />
  <ul id="anetErrors"></ul>
</div>
{{-- END: Authorize.net Card Details Form --}}


@if ($errors->has('receipt'))
  <p class="text-danger mb-4">{{ $errors->first('receipt') }}</p>
@endif
{{-- End: Offline Gateways Area --}}
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="lc" value="UK">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="ref_id" id="ref_id" value="">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
<input type="hidden" name="currency_sign" value="$">
