@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Shipping Gateways') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('user-dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Shop Settings') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Shipping Gateways') }}</a>
      </li>
    </ul>
  </div>
  
  <div class="row">
    {{-- Commented out AfterShip
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('user.shipping_gateway.aftership_update') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('AfterShip') }}</div>
              </div>
            </div>
          </div>
          <div class="card-body">
            @php
              if ($aftership && !is_null($aftership->information)) {
                  $aftershipInfo = json_decode($aftership->information, true);
              } else {
                  $aftershipInfo = [];
              }
            @endphp
            <div class="form-group">
              <label>{{ __('Status') }}</label>
              <div class="selectgroup w-100">
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="1" class="selectgroup-input"
                    {{ $aftership && $aftership->status == 1 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Active') }}</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="0" class="selectgroup-input"
                    {{ !$aftership || $aftership->status == 0 ? 'checked' : '' }}>
                  <span class="selectgroup-button">{{ __('Deactive') }}</span>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>{{ __('AfterShip API Key') }}</label>
              <input class="form-control" name="api_key" value="{{ $aftershipInfo['api_key'] ?? '' }}" placeholder="Enter API Key">
              @if ($errors->has('api_key'))
                <p class="mb-0 text-danger">{{ $errors->first('api_key') }}</p>
              @endif
            </div>
          </div>
          <div class="card-footer text-center">
            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
          </div>
        </form>
      </div>
    </div>
    --}}    {{-- Shiprocket --}}
    <div class="col-lg-7">
      <div class="card card-premium h-100">
        <form action="{{ route('user.shipping_gateway.shiprocket_update') }}" method="post" class="d-flex flex-column h-100" style="height: 100%;">
          @csrf
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <div class="card-icon-wrap" style="background: transparent; padding: 0; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="18" cy="18" r="18" fill="url(#shiprocketGrad)"/>
                  <path d="M13 11L26 18L13 25V11Z" fill="white"/>
                  <defs>
                    <linearGradient id="shiprocketGrad" x1="0" y1="0" x2="36" y2="36" gradientUnits="userSpaceOnUse">
                      <stop stop-color="#7C3AED"/>
                      <stop offset="1" stop-color="#2563EB"/>
                    </linearGradient>
                  </defs>
                </svg>
              </div>
              <div class="card-title mb-0" style="font-size: 16px; font-weight: 600; color: #1e293b;">{{ __('Shiprocket') }}</div>
            </div>
            <div class="d-flex align-items-center" style="gap: 8px;">
              <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#shiprocketGuideModal" style="border-radius: 20px; font-size: 12px; font-weight: 600; padding: 4px 12px; border: 1px solid #7c3aed; color: #7c3aed; background: #faf5ff;">
                <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
              </button>
              @if($shiprocket && $shiprocket->status == 1)
                <span class="badge" style="background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; border-radius: 20px; font-size: 12px; padding: 4px 12px; display: inline-flex; align-items: center; gap: 4px;">
                  <i class="fas fa-check" style="font-size: 10px;"></i> Active
                </span>
              @endif
            </div>
          </div>
          <div class="card-body">
            @php
              if ($shiprocket && !is_null($shiprocket->information)) {
                  $shiprocketInfo = json_decode($shiprocket->information, true);
              } else {
                  $shiprocketInfo = [];
              }
            @endphp

            <div class="alert alert-info py-2 px-3 mb-3" style="font-size: 12px; border-radius: 8px; background-color: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af;">
              <i class="fas fa-info-circle mr-1"></i> <strong>Important:</strong> Enter your dedicated <strong>Shiprocket API User</strong> email & password here (not your main website login, which causes <em>"Access forbidden"</em> errors). 
              <a href="javascript:void(0);" data-toggle="modal" data-target="#shiprocketGuideModal" class="text-primary font-weight-bold ml-1"><u>View Guide</u></a>
            </div>
            <div class="form-group pt-0">
              <label style="font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 8px;">{{ __('Status') }}</label>
              <div class="status-toggle-wrapper">
                <input type="radio" name="status" id="status-active" value="1"
                  {{ $shiprocket && $shiprocket->status == 1 ? 'checked' : '' }}>
                <label for="status-active" class="toggle-btn toggle-active">{{ __('Active') }}</label>
                <input type="radio" name="status" id="status-deactive" value="0"
                  {{ !$shiprocket || $shiprocket->status == 0 ? 'checked' : '' }}>
                <label for="status-deactive" class="toggle-btn toggle-deactive">{{ __('Deactivate') }}</label>
              </div>
            </div>
            
            <div class="form-group">
              <label style="font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 8px;">{{ __('Shiprocket Login Email') }}</label>
              <div class="input-icon-wrapper">
                <i class="far fa-envelope input-icon-prefix"></i>
                <input class="form-control" name="email" value="{{ $shiprocketInfo['email'] ?? '' }}" placeholder="Enter Email">
              </div>
              @if ($errors->has('email'))
                <p class="mb-0 text-danger" style="font-size: 12px; margin-top: 4px;">{{ $errors->first('email') }}</p>
              @endif
            </div>
            
            <div class="form-group">
              <label style="font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 8px;">{{ __('Shiprocket Password') }}</label>
              <div class="input-icon-wrapper">
                <i class="fas fa-lock input-icon-prefix"></i>
                <input type="password" id="shiprocket-password" class="form-control" name="password" value="{{ $shiprocketInfo['password'] ?? '' }}" placeholder="Enter Password">
                <i class="far fa-eye input-icon-suffix" onclick="togglePasswordVisibility('shiprocket-password', this)"></i>
              </div>
              @if ($errors->has('password'))
                <p class="mb-0 text-danger" style="font-size: 12px; margin-top: 4px;">{{ $errors->first('password') }}</p>
              @endif
            </div>
            
            <div class="form-group mb-0">
              <button type="submit" class="btn w-100 btn-premium-gradient" style="background: linear-gradient(135deg, #2563eb, #7c3aed) !important; border: none !important; border-radius: 8px !important; padding: 12px !important; font-size: 14px !important; font-weight: 600 !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2) !important;">{{ __('Update') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    {{-- About Shiprocket --}}
    <div class="col-lg-5">
      <div class="card card-premium h-100">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <div class="card-icon-wrap" style="background: #faf5ff; color: #a855f7;">
              <i class="fas fa-info-circle"></i>
            </div>
            <div class="card-title mb-0" style="font-size: 16px; font-weight: 600; color: #1e293b;">{{ __('About Shiprocket') }}</div>
          </div>
        </div>
        <div class="card-body">
          <p class="text-muted" style="font-size: 13px; line-height: 1.6; color: #64748b; margin-bottom: 20px;">
            {{ __('Shiprocket is a leading shipping solution that helps you automate your order fulfillment and manage shipments efficiently. Connect your Shiprocket account to streamline your shipping process.') }}
          </p>
          
          <div class="info-features-list">
            <div class="info-feature-item">
              <div class="info-feature-icon-box blue">
                <i class="fas fa-shield-alt"></i>
              </div>
              <div class="info-feature-content">
                <div class="info-feature-title">{{ __('Secure Connection') }}</div>
                <div class="info-feature-desc">{{ __('Your credentials are encrypted and stored securely.') }}</div>
              </div>
            </div>
            
            <div class="info-feature-item">
              <div class="info-feature-icon-box purple">
                <i class="fas fa-bolt"></i>
              </div>
              <div class="info-feature-content">
                <div class="info-feature-title">{{ __('Real-time Sync') }}</div>
                <div class="info-feature-desc">{{ __('Orders and tracking details sync in real-time.') }}</div>
              </div>
            </div>
            
            <div class="info-feature-item">
              <div class="info-feature-icon-box blue">
                <i class="fas fa-headset"></i>
              </div>
              <div class="info-feature-content">
                <div class="info-feature-title">{{ __('24/7 Support') }}</div>
                <div class="info-feature-desc">{{ __('Get help anytime from Shiprocket support.') }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Shiprocket Guide Modal --}}
  <div class="modal fade" id="shiprocketGuideModal" tabindex="-1" role="dialog" aria-labelledby="shiprocketGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #2563eb, #7c3aed); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fas fa-shipping-fast text-primary" style="font-size: 18px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0" id="shiprocketGuideModalLabel" style="color: #ffffff;">{{ __('How to Get Shiprocket API Credentials') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Step-by-step guide to connect Shiprocket with your store') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <!-- Warning box explaining Access Forbidden -->
          <div class="alert alert-warning d-flex align-items-start mb-4" style="border-radius: 8px; border-left: 4px solid #f59e0b; background-color: #fffbeb;">
            <i class="fas fa-exclamation-triangle mr-3 mt-1 text-warning" style="font-size: 20px;"></i>
            <div style="font-size: 13px; color: #92400e;">
              <strong>{{ __('Why does "Shiprocket Error: Access forbidden" happen?') }}</strong><br>
              {{ __('Shiprocket prohibits using your main account login credentials for external API sync. You must create a dedicated') }} <strong>{{ __('API User') }}</strong> {{ __('inside Shiprocket. Follow the 4 simple steps below:') }}
            </div>
          </div>

          <!-- Step 1 -->
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #2563eb;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Log in to Shiprocket') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Open') }} <a href="https://app.shiprocket.in" target="_blank" class="text-primary font-weight-bold">app.shiprocket.in <i class="fas fa-external-link-alt fa-xs"></i></a> {{ __('and sign in to your Shiprocket account.') }}
              </p>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #7c3aed;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Create a Dedicated API User') }}</h6>
              <p class="text-muted mb-2" style="font-size: 13px;">
                {{ __('In the left navigation bar, go to:') }} <strong>{{ __('Settings (Gear Icon)') }} &rarr; {{ __('API') }} &rarr; {{ __('Configure') }}</strong> (or <em>API Users</em>).
              </p>
              <ul class="text-muted mb-0 pl-3" style="font-size: 13px; line-height: 1.6;">
                <li>{{ __('Click the') }} <strong>"{{ __('Create API User') }}"</strong> {{ __('button in the top-right corner.') }}</li>
                <li>{{ __('Enter an email address (e.g.') }} <code>api@yourdomain.com</code> {{ __('or any alternate active email).') }}</li>
                <li>{{ __('Create a strong password and click') }} <strong>{{ __('Generate / Save') }}</strong>.</li>
              </ul>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Paste Credentials into LaunchShop') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Return to this page in LaunchShop, enter the') }} <strong>{{ __('API User Email') }}</strong> {{ __('and') }} <strong>{{ __('API Password') }}</strong> {{ __('you just created, select') }} <strong>{{ __('Status: Active') }}</strong>, {{ __('and click') }} <strong>{{ __('Update') }}</strong>.
              </p>
            </div>
          </div>

          <!-- Step 4 -->
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #ea580c;">4</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Configure Store Pickup Address (Essential)') }}</h6>
              <p class="text-muted mb-1" style="font-size: 13px;">
                {{ __('In Shiprocket, navigate to') }} <strong>{{ __('Settings') }} &rarr; {{ __('Pickup Addresses') }}</strong>.
              </p>
              <ul class="text-muted mb-0 pl-3" style="font-size: 13px; line-height: 1.6;">
                <li>{{ __('Add your store/warehouse address and a valid 6-digit Indian Pincode.') }}</li>
                <li>{{ __('Verify the contact number via OTP. Without a verified pickup location, Shiprocket will reject shipment creation.') }}</li>
                <li>{{ __('Complete your KYC and ensure your Shiprocket shipping wallet has balance (minimum ₹200–₹500).') }}</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
          <a href="https://app.shiprocket.in/seller/settings/api" target="_blank" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #2563eb, #7c3aed); border: none; border-radius: 6px;">
            <i class="fas fa-external-link-alt mr-1"></i> {{ __('Open Shiprocket Settings') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  @section('scripts')
  <script>
    function togglePasswordVisibility(inputId, iconEl) {
      var x = document.getElementById(inputId);
      if (x.type === "password") {
        x.type = "text";
        iconEl.classList.remove('fa-eye');
        iconEl.classList.add('fa-eye-slash');
      } else {
        x.type = "password";
        iconEl.classList.remove('fa-eye-slash');
        iconEl.classList.add('fa-eye');
      }
    }
  </script>
  @endsection
@endsection
