@extends('front.layout')

@section('meta-description', !empty($seo) ? $seo->login_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->login_meta_keywords : '')

@section('pagename')
  - {{ $pageHeading ?? __('Login') }}
@endsection
@section('breadcrumb-title')
  {{ $pageHeading ?? __('Login') }}
@endsection
@section('breadcrumb-link')
  {{ $pageHeading ?? __('Login') }}
@endsection

@section('styles')
<style>
  /* Hide default breadcrumb */
  .page-title-area {
    display: none !important;
  }

  /* ========== Login Split-Screen Layout ========== */
  .login-split-area {
    background: #f8fafc;
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 60px 0;
  }

  .login-split-wrapper {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    border: 1px solid #eef2f6;
    width: 100%;
    display: flex;
    min-height: 600px;
  }

  /* ========== Left Illustration Panel ========== */
  .login-illustration-panel {
    background: linear-gradient(135deg, #0e1b3d 0%, #1a3060 60%, #ff5a2c 150%);
    flex: 0 0 45%;
    max-width: 45%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 40px;
    position: relative;
    overflow: hidden;
  }

  .login-illustration-panel::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: radial-gradient(rgba(255,255,255,0.06) 1.5px, transparent 1.5px);
    background-size: 26px 26px;
    pointer-events: none;
  }

  .login-illustration-panel::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(255, 90, 44, 0.25) 0%, transparent 70%);
    bottom: -100px; right: -100px;
    border-radius: 50%;
    pointer-events: none;
  }

  .login-brand-logo {
    position: relative;
    z-index: 1;
    margin-bottom: 40px;
  }

  .login-brand-logo img {
    height: 40px;
    filter: brightness(0) invert(1);
  }

  .login-illustration-img {
    position: relative;
    z-index: 1;
    display: block;
    margin: 0 auto 40px;
    width: auto;
    height: auto;
    max-width: 90%;
    max-height: 360px;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
  }

  .login-panel-heading {
    position: relative;
    z-index: 1;
    text-align: center;
    color: #ffffff;
  }

  .login-panel-heading h2 {
    font-size: 26px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
    line-height: 1.3;
  }

  .login-panel-heading p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.6;
    max-width: 280px;
    margin: 0 auto;
  }

  .login-panel-trust-badges {
    position: relative;
    z-index: 1;
    display: flex;
    gap: 16px;
    margin-top: 32px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .login-trust-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 50px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
  }

  .login-trust-badge i {
    color: #10b981;
    font-size: 12px;
  }

  /* ========== Right Form Panel ========== */
  .login-form-panel {
    flex: 0 0 55%;
    max-width: 55%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px 60px;
  }

  .login-form-header {
    margin-bottom: 40px;
  }

  .login-form-header .badge-label {
    display: inline-block;
    font-size: 11px;
    font-weight: 800;
    color: #ff5a2c;
    background: rgba(255, 90, 44, 0.08);
    padding: 5px 14px;
    border-radius: 50px;
    letter-spacing: 1px;
    margin-bottom: 16px;
    text-transform: uppercase;
    border: 1px solid rgba(255, 90, 44, 0.12);
  }

  .login-form-header h1 {
    font-size: 34px;
    font-weight: 800;
    color: #0e1b3d;
    margin-bottom: 10px;
    letter-spacing: -0.5px;
    line-height: 1.2;
  }

  .login-form-header p {
    font-size: 15px;
    color: #64748b;
    margin: 0;
    line-height: 1.6;
  }

  /* ========== Form Inputs ========== */
  .login-field-group {
    margin-bottom: 20px;
  }

  .login-field-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
    letter-spacing: 0.3px;
  }

  .login-input-wrap {
    position: relative;
  }

  .login-input-wrap .field-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 15px;
    color: #94a3b8;
    pointer-events: none;
    transition: color 0.2s;
  }

  .login-input-field {
    width: 100%;
    height: 52px;
    padding: 0 16px 0 46px;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s;
    outline: none;
    font-family: inherit;
  }

  .login-input-field:focus {
    border-color: #ff5a2c;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(255, 90, 44, 0.08);
  }

  .login-input-wrap:focus-within .field-icon {
    color: #ff5a2c;
  }

  /* Password toggle */
  .pass-toggle-btn {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #94a3b8;
    font-size: 15px;
    padding: 4px;
    transition: color 0.2s;
  }
  .pass-toggle-btn:hover {
    color: #ff5a2c;
  }

  /* ========== Links Row ========== */
  .login-links-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 8px;
  }

  .login-forgot-link {
    font-size: 13px;
    font-weight: 600;
    color: #ff5a2c;
    text-decoration: none !important;
    transition: opacity 0.2s;
  }

  .login-forgot-link:hover {
    opacity: 0.8;
  }

  .login-signup-text {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
  }

  .login-signup-text a {
    color: #ff5a2c;
    font-weight: 700;
    text-decoration: none !important;
    transition: opacity 0.2s;
  }

  .login-signup-text a:hover {
    opacity: 0.8;
  }

  /* ========== Submit Button ========== */
  .login-submit-btn {
    width: 100%;
    height: 56px;
    background: #ff5a2c;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.25s;
    font-family: inherit;
    box-shadow: 0 4px 14px rgba(255, 90, 44, 0.25);
  }

  .login-submit-btn:hover {
    background: #e0451a;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(255, 90, 44, 0.35);
  }

  .login-submit-btn:active {
    transform: translateY(0);
  }

  /* ========== Responsive ========== */
  @media (max-width: 991.98px) {
    .login-illustration-panel {
      display: none;
    }
    .login-form-panel {
      flex: 0 0 100%;
      max-width: 100%;
      padding: 40px;
    }
    .login-split-wrapper {
      border-radius: 0;
      border: none;
      box-shadow: none;
      min-height: 100vh;
    }
    .login-split-area {
      padding: 0;
      background: #ffffff;
    }
  }

  @media (max-width: 575.98px) {
    .login-form-panel {
      padding: 30px 24px;
    }
    .login-form-header h1 {
      font-size: 28px;
    }
  }
</style>
@endsection

@section('content')
<div class="login-split-area">
  <div class="container-fluid p-0">
    <div class="login-split-wrapper">

      {{-- Left: Illustration Panel --}}
      <div class="login-illustration-panel">
        <div class="login-brand-logo">
          <img src="{{ asset('assets/front/img/' . $bs->logo) }}" alt="{{ $bs->website_title }}">
        </div>
        <img class="login-illustration-img"
          src="{{ asset('images/signup.gif') }}"
          alt="Welcome back">
        <div class="login-panel-heading">
          <h2>{{ __('Welcome Back!') }}</h2>
          <p>{{ __('Sign in to manage your store, track orders, and grow your business.') }}</p>
        </div>
        <div class="login-panel-trust-badges">
          <span class="login-trust-badge"><i class="fas fa-check-circle"></i> {{ __('Secure Login') }}</span>
          <span class="login-trust-badge"><i class="fas fa-check-circle"></i> {{ __('24/7 Support') }}</span>
          <span class="login-trust-badge"><i class="fas fa-check-circle"></i> {{ __('Trusted Platform') }}</span>
        </div>
      </div>

      {{-- Right: Form Panel --}}
      <div class="login-form-panel">
        <div class="login-form-header">
          <span class="badge-label">{{ __('Merchant Portal') }}</span>
          <h1>{{ __('Sign In to Your Store') }}</h1>
          <p>{{ __("Enter your credentials to access your store's dashboard and tools.") }}</p>
        </div>

        <form id="authForm" action="{{ route('user.login') }}" method="post" enctype="multipart/form-data">
          @csrf

          {{-- Tab Switcher --}}
          <div class="login-type-switch mb-30" style="display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 1.5px solid #e2e8f0; padding-bottom: 12px;">
            <button type="button" class="btn btn-link p-0 text-decoration-none" id="tab-password" style="font-weight: 700; color: var(--primary-color, #ff5a2c); border-bottom: 2px solid var(--primary-color, #ff5a2c); padding-bottom: 8px; font-size: 15px; background: none; border-top: none; border-left: none; border-right: none; outline: none; box-shadow: none;">
              {{ __('Password Login') }}
            </button>
            <button type="button" class="btn btn-link p-0 text-decoration-none text-muted" id="tab-otp" style="font-weight: 700; padding-bottom: 8px; font-size: 15px; margin-left: 20px; background: none; border: none; outline: none; box-shadow: none;">
              {{ __('OTP Login') }}
            </button>
          </div>

          {{-- Password Login Wrapper --}}
          <div id="password-login-wrap">
            {{-- Email or Phone Number --}}
            <div class="login-field-group">
              <label class="login-field-label" for="loginEmail">{{ __('Email or Phone Number') }}</label>
              <div class="login-input-wrap">
                <i class="fal fa-envelope field-icon"></i>
                <input type="text" id="loginEmail" name="email" class="login-input-field"
                  placeholder="{{ __('Enter email or phone number') }}" required>
              </div>
              @if (Session::has('err'))
                <p class="text-danger small mt-1">{{ Session::get('err') }}</p>
              @endif
              @error('email')
                <p class="text-danger small mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Password --}}
            <div class="login-field-group">
              <label class="login-field-label" for="loginPassword">{{ __('Password') }}</label>
              <div class="login-input-wrap">
                <i class="fal fa-lock field-icon"></i>
                <input type="password" id="loginPassword" name="password" class="login-input-field"
                  placeholder="{{ __('Enter your password') }}" required>
                <button type="button" class="pass-toggle-btn" onclick="togglePassword()">
                  <i class="fal fa-eye" id="passEyeIcon"></i>
                </button>
              </div>
              @error('password')
                <p class="text-danger small mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Recaptcha --}}
            @if ($bs->is_recaptcha == 1)
              <div class="mb-4">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
                @if ($errors->has('g-recaptcha-response'))
                  @php $errmsg = $errors->first('g-recaptcha-response'); @endphp
                  <p class="text-danger small mt-2">{{ __($errmsg) }}</p>
                @endif
              </div>
            @endif

            {{-- Links Row --}}
            <div class="login-links-row">
              <a href="{{ route('user.forgot.password.form') }}" class="login-forgot-link">
                {{ __('Forgot your password?') }}
              </a>
              <span class="login-signup-text">
                {{ __("Don't have an account?") }}
                <a href="{{ route('front.pricing') }}">{{ __('Sign Up') }}</a>
              </span>
            </div>

            {{-- Submit --}}
            <button type="submit" class="login-submit-btn">
              <i class="fas fa-sign-in-alt"></i> {{ __('Sign In') }}
            </button>
          </div>

          {{-- OTP Login Wrapper --}}
          <div id="otp-login-wrap" class="d-none">
            <!-- Country Code & Phone -->
            <div class="login-field-group mb-20">
              <label class="login-field-label">{{ __('Phone Number') }}</label>
              <div class="row g-2 align-items-center">
                <div class="col-4 col-sm-4">
                  <div class="d-flex align-items-center justify-content-center gap-1" style="height: 50px; border-radius: 8px; border: 1.5px solid #cbd5e1; background: #f8fafc; padding: 0 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480" width="22" height="16" style="border-radius: 2px; flex-shrink: 0; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                      <path fill="#f93" d="M0 0h640v160H0z"/>
                      <path fill="#fff" d="M0 160h640v160H0z"/>
                      <path fill="#128807" d="M0 320h640v160H0z"/>
                      <g transform="translate(320 240)">
                        <circle r="70" fill="none" stroke="#008" stroke-width="8"/>
                        <path fill="#008" d="M0 0l-5-70h10zm0 0l5 70h-10zm0 0l70-5v10zm0 0l-70 5v-10zm0 0l-53-46 7 7zm0 0l53 46-7-7zm0 0l46-53-7 7zm0 0l-46 53 7-7zm0 0l-46 53-7-7zm0 0l46-53 7 7zm0 0l53-46-7 7zm0 0l-53 46 7-7zm0 0l-68-18 2 10zm0 0l68 18-2-10zm0 0l18-68-10 2zm0 0l-18 68 10-2zm0 0l-18 68-10-2zm0 0l18-68 10 2zm0 0l68-18-2-10zm0 0l-68 18 2 10z"/>
                      </g>
                    </svg>
                    <input type="text" id="otp_country_code" value="+91" placeholder="{{ __('Code') }}" inputmode="numeric" style="border: none; background: transparent; width: 45px; font-weight: 600; text-align: center; font-size: 14px; padding: 0; outline: none; color: #1e293b;">
                  </div>
                </div>
                <div class="col-8 col-sm-8">
                  <input class="login-input-field" type="number" id="otp_phone" placeholder="81234 56789" min="0" step="1" inputmode="numeric" style="height: 50px; border-radius: 8px; border: 1.5px solid #cbd5e1; width: 100%;">
                </div>
              </div>
              <div id="otp-phone-feedback" class="small mt-2" style="font-weight: 600; text-align: left;"></div>
            </div>

            <!-- Get OTP button -->
            <button type="button" class="login-submit-btn mb-20" id="btn-login-send-otp" style="background-color: transparent; border: 1.5px solid var(--primary-color, #ff5a2c); color: var(--primary-color, #ff5a2c); font-weight: 600;">
              {{ __('Get OTP') }}
            </button>

            <!-- OTP Code input -->
            <div class="login-field-group d-none" id="login-otp-code-group" style="margin-top: 20px;">
              <label class="login-field-label" for="login_otp_code">{{ __('Enter 6-digit OTP') }} *</label>
              <div class="row g-2 align-items-center">
                <div class="col-8 col-sm-9">
                  <input class="login-input-field" type="text" id="login_otp_code" placeholder="Enter OTP" maxlength="6" inputmode="numeric" style="height: 50px; border-radius: 8px; border: 1.5px solid #cbd5e1; width: 100%;">
                </div>
                <div class="col-4 col-sm-3">
                  <button type="button" class="btn w-100 py-2" id="btn-login-submit-otp" style="height: 50px !important; border-radius: 8px; font-weight: 600; font-size: 14px; background-color: var(--primary-color, #ff5a2c); border-color: var(--primary-color, #ff5a2c); color: #fff;">
                    {{ __('Sign In') }}
                  </button>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <span id="login-otp-timer" class="small text-muted" style="font-weight: 600;"></span>
                <button type="button" class="btn btn-link p-0 small d-none" id="btn-login-resend-otp" style="color: var(--primary-color, #ff5a2c); font-weight: 600; text-decoration: none; border: none; background: none;">
                  {{ __('Resend OTP') }}
                </button>
              </div>
              <div id="login-otp-feedback" class="small mt-2" style="font-weight: 600; text-align: left;"></div>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function togglePassword() {
    var field = document.getElementById('loginPassword');
    var icon = document.getElementById('passEyeIcon');
    if (field.type === 'password') {
      field.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      field.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }

  $(document).ready(function() {
    // Tab switching logic
    $('#tab-password').on('click', function(e) {
      e.preventDefault();
      $(this).css({
        'color': 'var(--primary-color, #ff5a2c)',
        'border-bottom': '2px solid var(--primary-color, #ff5a2c)'
      }).removeClass('text-muted');
      $('#tab-otp').css({
        'color': '',
        'border-bottom': 'none'
      }).addClass('text-muted');
      $('#password-login-wrap').removeClass('d-none');
      $('#otp-login-wrap').addClass('d-none');
      
      // Enforce validation on password fields when visible
      $('#loginEmail').prop('required', true);
      $('#loginPassword').prop('required', true);
    });

    $('#tab-otp').on('click', function(e) {
      e.preventDefault();
      $(this).css({
        'color': 'var(--primary-color, #ff5a2c)',
        'border-bottom': '2px solid var(--primary-color, #ff5a2c)'
      }).removeClass('text-muted');
      $('#tab-password').css({
        'color': '',
        'border-bottom': 'none'
      }).addClass('text-muted');
      $('#password-login-wrap').addClass('d-none');
      $('#otp-login-wrap').removeClass('d-none');
      
      // Disable validation on password fields when hidden
      $('#loginEmail').prop('required', false);
      $('#loginPassword').prop('required', false);
    });

    // OTP timer logic
    let loginCountdownSeconds = 120;
    let loginOtpTimer = null;

    function startLoginOtpTimer() {
      clearInterval(loginOtpTimer);
      loginCountdownSeconds = 120;
      $('#login-otp-timer').removeClass('d-none').text('{{ __("Resend OTP in") }} ' + loginCountdownSeconds + 's');
      $('#btn-login-resend-otp').addClass('d-none');
      
      loginOtpTimer = setInterval(function() {
        loginCountdownSeconds--;
        if (loginCountdownSeconds <= 0) {
          clearInterval(loginOtpTimer);
          $('#login-otp-timer').addClass('d-none');
          $('#btn-login-resend-otp').removeClass('d-none');
        } else {
          $('#login-otp-timer').text('{{ __("Resend OTP in") }} ' + loginCountdownSeconds + 's');
        }
      }, 1000);
    }

    // Request Login OTP
    $('#btn-login-send-otp, #btn-login-resend-otp').on('click', function(e) {
      e.preventDefault();
      let phoneVal = $('#otp_phone').val().trim();
      let countryCode = $('#otp_country_code').val().trim();

      if (!phoneVal) {
        $('#otp-phone-feedback').html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ __("Please enter a valid phone number.") }}</span>');
        $('#otp_phone').addClass('is-invalid');
        return;
      }

      $('#otp_phone').removeClass('is-invalid');
      $('#otp-phone-feedback').html('<span class="text-info"><i class="fas fa-spinner fa-spin"></i> {{ __("Sending OTP...") }}</span>');
      let $btn = $('#btn-login-send-otp');
      $btn.prop('disabled', true);

      $.post("{{ route('front.otp.send') }}", {
        _token: "{{ csrf_token() }}",
        phone_number: phoneVal,
        country_code: countryCode
      }, function(response) {
        if (response.success) {
          $('#otp-phone-feedback').html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
          $('#login-otp-code-group').removeClass('d-none');
          $btn.text('{{ __("Sent") }}');
          startLoginOtpTimer();
        } else {
          $('#otp-phone-feedback').html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + response.message + '</span>');
          $btn.prop('disabled', false);
        }
      }).fail(function(xhr) {
        let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __("Failed to send OTP. Please try again.") }}';
        $('#otp-phone-feedback').html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + msg + '</span>');
        $btn.prop('disabled', false);
      });
    });

    // Submit and verify login OTP
    $('#btn-login-submit-otp').on('click', function(e) {
      e.preventDefault();
      let enteredOtp = $('#login_otp_code').val().trim();
      let phoneVal = $('#otp_phone').val().trim();
      let countryCode = $('#otp_country_code').val().trim();

      if (!enteredOtp) {
        $('#login-otp-feedback').html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ __("Please enter the OTP.") }}</span>');
        return;
      }

      $('#login-otp-feedback').html('<span class="text-info"><i class="fas fa-spinner fa-spin"></i> {{ __("Verifying & Logging in...") }}</span>');

      $.post("{{ route('user.login.otp.submit') }}", {
        _token: "{{ csrf_token() }}",
        phone: countryCode + phoneVal,
        otp: enteredOtp
      }, function(response) {
        if (response.success) {
          $('#login-otp-feedback').html('<span class="text-success"><i class="fas fa-check-circle"></i> {{ __("Login successful! Redirecting...") }}</span>');
          window.location.href = response.redirect;
        } else {
          $('#login-otp-feedback').html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + response.message + '</span>');
        }
      }).fail(function(xhr) {
        let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __("Invalid OTP or Account not found.") }}';
        $('#login-otp-feedback').html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + msg + '</span>');
      });
    });
  });
</script>
@endsection
