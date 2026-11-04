@extends('admin.layout')

@section('content')
<div class="page-header">
  <h4 class="page-title"><i class="fab fa-whatsapp text-success mr-2"></i>{{ __('WhatsApp & Dual OTP Settings') }}</h4>
  <ul class="breadcrumbs">
    <li class="nav-home">
      <a href="{{ route('admin.dashboard') }}">
        <i class="flaticon-home"></i>
      </a>
    </li>
    <li class="separator">
      <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
      <a href="#">{{ __('Settings') }}</a>
    </li>
    <li class="separator">
      <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
      <a href="#">{{ __('WhatsApp & Dual OTP') }}</a>
    </li>
  </ul>
</div>

<div class="row">
  {{-- Main Settings Form --}}
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <h5 class="card-title mb-0 font-weight-bold text-dark">
          <i class="fas fa-key text-primary mr-2"></i>{{ __('WhatsApp Gateway API Configuration') }}
        </h5>
        <span class="badge badge-success px-3 py-2 text-uppercase font-weight-bold" style="letter-spacing: 0.5px;">
          <i class="fas fa-bolt mr-1"></i> {{ __('Dual Channel (SMS/WA + Email)') }}
        </span>
      </div>

      <div class="card-body">
        <form action="{{ route('admin.whatsapp_otp.update') }}" method="POST" id="whatsappSettingsForm">
          @csrf

          {{-- Switches Row --}}
          <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
              <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="font-weight-bold mb-1">{{ __('WhatsApp Notifications') }}</h6>
                  <small class="text-muted">{{ __('Enable gateway for alerts & receipts') }}</small>
                </div>
                <div>
                  <label class="switch">
                    <input type="checkbox" name="whatsapp_status" value="1" {{ (!isset($bs->whatsapp_status) || $bs->whatsapp_status == 1) ? 'checked' : '' }}>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="font-weight-bold mb-1 text-primary">{{ __('Dual OTP Dispatch') }}</h6>
                  <small class="text-muted">{{ __('Send OTP to Phone + Email simultaneously') }}</small>
                </div>
                <div>
                  <label class="switch">
                    <input type="checkbox" name="dual_otp_status" value="1" {{ (!isset($bs->dual_otp_status) || $bs->dual_otp_status == 1) ? 'checked' : '' }}>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          {{-- API Credentials --}}
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark">{{ __('API Key (Team Token)') }} <span class="text-danger">*</span></label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white"><i class="fas fa-lock text-warning"></i></span>
              </div>
              <input type="text" class="form-control" name="whatsapp_access_token"
                value="{{ old('whatsapp_access_token', $bs->whatsapp_access_token ?? 'token_6005c0f6de385fe7') }}"
                placeholder="token_6005c0f6de385fe7" required>
            </div>
            <small class="form-text text-muted">{{ __('Your unique secret team authentication token from your WhatsApp server (e.g. waziper).') }}</small>
          </div>

          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark">{{ __('Active Instance ID') }} <span class="text-danger">*</span></label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white"><i class="fas fa-mobile-alt text-success"></i></span>
              </div>
              <input type="text" class="form-control" name="whatsapp_instance_id"
                value="{{ old('whatsapp_instance_id', $bs->whatsapp_instance_id ?? 'E6C34AF85064') }}"
                placeholder="E6C34AF85064" required>
            </div>
            <small class="form-text text-muted">{{ __('The identifier for your linked WhatsApp profile instance.') }}</small>
          </div>

          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark">{{ __('Send Message Endpoint URL') }} <span class="text-danger">*</span></label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white"><i class="fas fa-server text-info"></i></span>
              </div>
              <input type="text" class="form-control ltr" name="whatsapp_endpoint"
                value="{{ old('whatsapp_endpoint', $bs->whatsapp_endpoint ?? 'http://localhost:8000') }}"
                placeholder="http://localhost:8000/send_message" required>
            </div>
            <small class="form-text text-muted">{{ __('HTTP POST endpoint provided by the Waziper Node engine (e.g. http://localhost:8000 or http://localhost:8000/send_message).') }}</small>
          </div>

          <div class="form-group mb-4">
            <label class="font-weight-bold text-dark">{{ __('WhatsApp OTP Message Template') }}</label>
            <textarea class="form-control" name="whatsapp_otp_template" rows="4">{{ old('whatsapp_otp_template', $bs->whatsapp_otp_template ?? "🔒 *Your LaunchShop Verification Code*\n\nYour OTP is: *{otp}*\n\nValid for {validity_minutes} minutes. Do not share this OTP with anyone.\n\n– Team LaunchShop 🚀") }}</textarea>
            <div class="mt-2">
              <small class="text-muted d-block">{{ __('Available tags: ') }}
                <code class="badge badge-light border text-dark font-weight-bold">{otp}</code>
                <code class="badge badge-light border text-dark font-weight-bold">{product_name}</code>
                <code class="badge badge-light border text-dark font-weight-bold">{validity_minutes}</code>
              </small>
            </div>
          </div>

          <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <button type="submit" class="btn btn-success px-4 py-2 font-weight-bold">
              <i class="fas fa-save mr-1"></i> {{ __('Save & Update Settings') }}
            </button>
            <button type="button" class="btn btn-outline-info font-weight-bold" data-toggle="modal" data-target="#testModal">
              <i class="fas fa-paper-plane mr-1"></i> {{ __('Test WhatsApp Connection') }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

  {{-- Right Info Column --}}
  <div class="col-lg-4">
    {{-- How Dual OTP Works Card --}}
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-header bg-white py-3">
        <h6 class="card-title mb-0 font-weight-bold text-dark">
          <i class="fas fa-info-circle text-info mr-2"></i>{{ __('How Dual OTP Works') }}
        </h6>
      </div>
      <div class="card-body">
        <div class="d-flex align-items-start mb-3" style="gap: 12px;">
          <div class="badge badge-success p-2 rounded-circle mt-1"><i class="fab fa-whatsapp fa-lg"></i></div>
          <div>
            <h6 class="font-weight-bold mb-1">{{ __('1. Instant WhatsApp Delivery') }}</h6>
            <p class="small text-muted mb-0">{{ __('OTP is immediately posted to your WhatsApp Node engine using your configured instance and team token.') }}</p>
          </div>
        </div>

        <div class="d-flex align-items-start mb-3" style="gap: 12px;">
          <div class="badge badge-primary p-2 rounded-circle mt-1"><i class="fas fa-envelope fa-lg"></i></div>
          <div>
            <h6 class="font-weight-bold mb-1">{{ __('2. Instant Email Delivery') }}</h6>
            <p class="small text-muted mb-0">{{ __('Simultaneously, the exact same verification code is dispatched via SMTP to the user email.') }}</p>
          </div>
        </div>

        <div class="d-flex align-items-start" style="gap: 12px;">
          <div class="badge badge-warning p-2 rounded-circle mt-1"><i class="fas fa-shield-alt fa-lg text-white"></i></div>
          <div>
            <h6 class="font-weight-bold mb-1">{{ __('3. Unified Session Verification') }}</h6>
            <p class="small text-muted mb-0">{{ __('Entering the code from either WhatsApp or Email validates the registration instantly without delay.') }}</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Test Connection Card --}}
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white py-3">
        <h6 class="card-title mb-0 font-weight-bold text-dark">
          <i class="fas fa-vial text-primary mr-2"></i>{{ __('Live Test Dispatch') }}
        </h6>
      </div>
      <div class="card-body">
        <p class="small text-muted mb-3">{{ __('Test sending an OTP message to any WhatsApp number right now using the saved settings.') }}</p>
        <div class="form-group p-0 mb-3">
          <label class="small font-weight-bold text-dark">{{ __('Mobile Number with Country Code') }}</label>
          <input type="text" class="form-control" id="sideTestPhone" placeholder="918667702473" value="918667702473">
          <small class="text-muted">{{ __('E.g. 91 followed by 10 digit number.') }}</small>
        </div>
        <button type="button" class="btn btn-primary btn-block font-weight-bold" id="btnSideTest">
          <i class="fas fa-paper-plane mr-1"></i> {{ __('Send Test Message') }}
        </button>
        <div id="sideTestResult" class="mt-3" style="display: none;"></div>
      </div>
    </div>
  </div>
</div>

{{-- Test Modal --}}
<div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="testModalLabel"><i class="fab fa-whatsapp text-success mr-2"></i>{{ __('Test WhatsApp Gateway Connection') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-muted small">{{ __('Enter a recipient WhatsApp number with country code. A verification OTP code will be sent immediately.') }}</p>
        <div class="form-group p-0 mb-3">
          <label class="font-weight-bold">{{ __('Phone Number') }}</label>
          <input type="text" class="form-control" id="modalTestPhone" placeholder="918667702473" value="918667702473">
        </div>
        <div id="modalTestResult" class="mt-2" style="display: none;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        <button type="button" class="btn btn-success font-weight-bold" id="btnModalTest">
          <i class="fas fa-paper-plane mr-1"></i> {{ __('Send Now') }}
        </button>
      </div>
    </div>
  </div>
</div>

<style>
/* Switch UI */
.switch {
  position: relative;
  display: inline-block;
  width: 48px;
  height: 26px;
}
.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cbd5e1;
  transition: .3s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .3s;
}
input:checked + .slider {
  background-color: #10b981;
}
input:focus + .slider {
  box-shadow: 0 0 1px #10b981;
}
input:checked + .slider:before {
  transform: translateX(22px);
}
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  function performTestSend(phone, resultDivId, btnId) {
    var $btn = $(btnId);
    var $res = $(resultDivId);
    
    if (!phone) {
      $res.html('<div class="alert alert-danger p-2 small mb-0">{{ __("Please enter a phone number.") }}</div>').show();
      return;
    }

    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> {{ __("Sending...") }}');
    $res.hide();

    $.ajax({
      url: "{{ route('admin.whatsapp_otp.test') }}",
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        test_phone: phone
      },
      success: function(resp) {
        $btn.prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i> {{ __("Send Test Message") }}');
        if (resp.success) {
          $res.html('<div class="alert alert-success p-2 small mb-0"><i class="fas fa-check-circle mr-1"></i> ' + resp.message + '</div>').fadeIn();
        } else {
          $res.html('<div class="alert alert-danger p-2 small mb-0"><i class="fas fa-exclamation-triangle mr-1"></i> ' + resp.message + '</div>').fadeIn();
        }
      },
      error: function(xhr) {
        $btn.prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i> {{ __("Send Test Message") }}');
        var err = xhr.responseJSON ? xhr.responseJSON.message : "{{ __('Server communication error.') }}";
        $res.html('<div class="alert alert-danger p-2 small mb-0"><i class="fas fa-times-circle mr-1"></i> ' + err + '</div>').fadeIn();
      }
    });
  }

  $('#btnSideTest').on('click', function() {
    performTestSend($('#sideTestPhone').val(), '#sideTestResult', '#btnSideTest');
  });

  $('#btnModalTest').on('click', function() {
    performTestSend($('#modalTestPhone').val(), '#modalTestResult', '#btnModalTest');
  });
});
</script>
@endsection
