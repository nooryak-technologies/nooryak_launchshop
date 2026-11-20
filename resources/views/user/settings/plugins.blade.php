@extends('user.layout')

@section('content')
  @php
    $userStoreUrl = detailsUrl(Auth::guard('web')->user());
    $storeDomain = parse_url($userStoreUrl, PHP_URL_HOST);
    $googleCallbackUrl = rtrim($userStoreUrl, '/') . '/login/google/callback';
  @endphp
  <div class="page-header">
    <h4 class="page-title">{{ __('Plugins') }}</h4>
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
        <a href="#">{{ __('Site Settings') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Plugins') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="row">

        {{-- Disqus --}}
        @if (in_array('Disqus', $features))
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">{{ __('Disqus') }}</div>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#disqusGuideModal" style="border-radius: 20px; font-size: 11px; font-weight: 600; padding: 3px 10px; border: 1px solid #2e9fff; color: #2e9fff; background: #f0f9ff;">
                  <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
                </button>
              </div>
              <div class="card-body">
                <form action="{{ route('user.disqus.update') }}" id="disqusForm" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label>{{ __('Disqus Status') }}</label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="is_disqus" value="1" class="selectgroup-input"
                              {{ $userBs->is_disqus == 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Active') }}</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="is_disqus" value="0" class="selectgroup-input"
                              {{ $userBs->is_disqus == 0 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                          </label>
                        </div>
                        @if ($errors->has('is_disqus'))
                          <p class="mb-0 text-danger">{{ $errors->first('is_disqus') }}</p>
                        @endif
                      </div>

                      <div class="form-group">
                        <label>{{ __('Disqus Shortname') }}</label>
                        <input class="form-control" name="disqus_shortname" value="{{ $userBs->disqus_shortname }}">
                        @if ($errors->has('disqus_shortname'))
                          <p class="mb-0 text-danger">{{ $errors->first('disqus_shortname') }}</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <button class="btn btn-success" type="submit" form="disqusForm">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        @endif

        @if (in_array('Google Analytics', $features))
          {{-- Google Analytics --}}
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">{{ __('Google Analytics') }}</div>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#gaGuideModal" style="border-radius: 20px; font-size: 11px; font-weight: 600; padding: 3px 10px; border: 1px solid #2563eb; color: #2563eb; background: #eff6ff;">
                  <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
                </button>
              </div>
              <div class="card-body">
                <form action="{{ route('user.google.analytics.update') }}" method="POST" id="gaForm">
                  @csrf
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label>{{ __('Google Analytics Status') }}</label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="is_analytics" value="1" class="selectgroup-input"
                              {{ isset($userBs) && $userBs->is_analytics == 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Active') }}</span>
                          </label>

                          <label class="selectgroup-item">
                            <input type="radio" name="is_analytics" value="0" class="selectgroup-input"
                              {{ !isset($userBs) || $userBs->is_analytics != 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                          </label>
                        </div>

                        @if ($errors->has('is_analytics'))
                          <p class="mt-1 mb-0 text-danger">{{ $errors->first('is_analytics') }}</p>
                        @endif
                      </div>

                      <div class="form-group">
                        <label>{{ __('Measurement ID') }} </label>
                        <input type="text" class="form-control" name="measurement_id"
                          value="{{ isset($userBs) && $userBs->measurement_id ? $userBs->measurement_id : null }}">
                        @if ($errors->has('measurement_id'))
                          <p class="mt-1 mb-0 text-danger">{{ $errors->first('measurement_id') }}</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <button class="btn btn-success" type="submit" form="gaForm">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        @endif



        @if (in_array('Google Login', $features))
          {{-- Google Login --}}
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">{{ __('Google Login') }}</div>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#googleLoginGuideModal" style="border-radius: 20px; font-size: 11px; font-weight: 600; padding: 3px 10px; border: 1px solid #ea4335; color: #ea4335; background: #fef2f2;">
                  <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
                </button>
              </div>
              <div class="card-body">
                <form action="{{ route('user.googlelogin.update') }}" method="POST" id="googleLoginForm">
                  @csrf
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label>{{ __('Status') }}</label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="is_google_login" value="1" class="selectgroup-input"
                              {{ $userBs->is_google_login == 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Active') }}</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="is_google_login" value="0" class="selectgroup-input"
                              {{ $userBs->is_google_login == 0 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                          </label>
                        </div>
                        @if ($errors->has('is_google_login'))
                          <p class="mb-0 text-danger">{{ $errors->first('is_google_login') }}</p>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>{{ __('Google Client ID') }}</label>
                        <input class="form-control" name="google_client_id" value="{{ $userBs->google_client_id }}">
                        @if ($errors->has('google_client_id'))
                          <p class="text-danger">{{ $errors->first('google_client_id') }}</p>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>{{ __('Google Client Secret') }}</label>
                        <input class="form-control" name="google_client_secret"
                          value="{{ $userBs->google_client_secret }}">
                        @if ($errors->has('google_client_secret'))
                          <p class="text-danger">{{ $errors->first('google_client_secret') }}</p>
                        @endif
                        <p class="text-warning mb-0">
                          {{ __('Google Client ID & Client Secret are required for Google Login.') }}
                        </p>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-success" form="googleLoginForm">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        @endif

        @if (in_array('Google Recaptcha', $features))
          {{-- Google rechaptcha --}}
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">{{ __('Google Recaptcha') }}</div>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#recaptchaGuideModal" style="border-radius: 20px; font-size: 11px; font-weight: 600; padding: 3px 10px; border: 1px solid #4285f4; color: #4285f4; background: #eff6ff;">
                  <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
                </button>
              </div>
              <div class="card-body">
                <form action="{{ route('user.recaptcha.update') }}" id="grForm" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label>{{ __('Google Recaptcha Status') }}</label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="is_recaptcha" value="1" class="selectgroup-input"
                              {{ $userBs->is_recaptcha == 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Active') }}</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="is_recaptcha" value="0" class="selectgroup-input"
                              {{ $userBs->is_recaptcha == 0 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                          </label>
                        </div>
                        @if ($errors->has('is_recaptcha'))
                          <p class="mb-0 text-danger">{{ $errors->first('is_recaptcha') }}</p>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>{{ __('Google Recaptcha Site key') }}</label>
                        <input class="form-control" name="google_recaptcha_site_key"
                          value="{{ $userBs->google_recaptcha_site_key }}">
                        @if ($errors->has('google_recaptcha_site_key'))
                          <p class="mb-0 text-danger">{{ $errors->first('google_recaptcha_site_key') }}</p>
                        @endif
                      </div>
                      <div class="form-group">
                        <label>{{ __('Google Recaptcha Secret key') }}</label>
                        <input class="form-control" name="google_recaptcha_secret_key"
                          value="{{ $userBs->google_recaptcha_secret_key }}">
                        @if ($errors->has('google_recaptcha_secret_key'))
                          <p class="mb-0 text-danger">{{ $errors->first('google_recaptcha_secret_key') }}</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <button class="btn btn-success" type="submit" form="grForm">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        @endif

        @if (in_array('Facebook Pixel', $features))
          {{-- Facebook Pixel --}}
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">{{ __('Facebook Pixel') }}</div>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#fbPixelGuideModal" style="border-radius: 20px; font-size: 11px; font-weight: 600; padding: 3px 10px; border: 1px solid #0666eb; color: #0666eb; background: #eff6ff;">
                  <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
                </button>
              </div>
              <div class="card-body">
                <form action="{{ route('user.pixel.update') }}" id="pixelForm" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label>{{ __('Facebook Pixel Status') }}</label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="is_facebook_pixel" value="1" class="selectgroup-input"
                              {{ $userBs->is_facebook_pixel == 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Active') }}</span>
                          </label>

                          <label class="selectgroup-item">
                            <input type="radio" name="is_facebook_pixel" value="0" class="selectgroup-input"
                              {{ $userBs->is_facebook_pixel != 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                          </label>
                        </div>
                        <p id="erris_facebook_pixel" class="mb-0 text-danger em"></p>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                          <i class="fas fa-info-circle text-primary mr-1"></i> {{ __('Need help finding your Pixel ID?') }}
                          <a href="javascript:void(0);" data-toggle="modal" data-target="#fbPixelGuideModal" class="text-primary font-weight-bold"><u>{{ __('View Step-by-Step Guide') }}</u></a>
                        </p>
                        @if ($errors->has('is_facebook_pixel'))
                          <p class="text-danger">{{ $errors->first('is_facebook_pixel') }}</p>
                        @endif
                      </div>

                      <div class="form-group">
                        <label>{{ __('Facebook Pixel ID') }}</label>
                        <input type="text" class="form-control" name="pixel_id" value="{{ $userBs->pixel_id }}">
                        <p id="errpixel_id" class="mb-0 text-danger em"></p>
                        @if ($errors->has('pixel_id'))
                          <p class="text-danger">{{ $errors->first('pixel_id') }}</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-success" form="pixelForm">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        @endif

        @if (in_array('WhatsApp Chat Button', $features) || (Auth::check() && Auth::user()->whatsapp_status == 1))
          {{-- Whatsapp Chat Button --}}
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">{{ __('WhatsApp Chat Button') }}</div>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#whatsappGuideModal" style="border-radius: 20px; font-size: 11px; font-weight: 600; padding: 3px 10px; border: 1px solid #10b981; color: #10b981; background: #ecfdf5;">
                  <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
                </button>
              </div>
              <div class="card-body">
                <form action="{{ route('user.whatsapp.update') }}" method="POST" id="waForm">
                  @csrf
                  <div class="form-group">
                    <label>Status</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="is_whatsapp" value="1" class="selectgroup-input"
                          {{ $userBs->is_whatsapp == 1 ? 'checked' : '' }}>
                        <span class="selectgroup-button">{{ __('Active') }}</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="is_whatsapp" value="0" class="selectgroup-input"
                          {{ $userBs->is_whatsapp == 0 ? 'checked' : '' }}>
                        <span class="selectgroup-button">{{ __('Deactive') }}</span>
                      </label>
                    </div>

                  </div>
                  <div class="form-group">
                    <label>{{ __('WhatsApp Number') }}</label>
                    <input class="form-control" type="text" name="whatsapp_number"
                      value="{{ $userBs->whatsapp_number }}">
                    <p class="text-warning mb-0">
                      {{ __('Enter Phone number with Country Code') }}
                    </p>
                  </div>
                  <div class="form-group">
                    <label>{{ __('WhatsApp Header Title') }}</label>
                    <input class="form-control" type="text" name="whatsapp_header_title"
                      value="{{ $userBs->whatsapp_header_title }}">
                    @if ($errors->has('whatsapp_header_title'))
                      <p class="mb-0 text-danger">{{ $errors->first('whatsapp_header_title') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label>{{ __('WhatsApp Popup Message') }}</label>
                    <textarea class="form-control" name="whatsapp_popup_message" rows="2">{{ $userBs->whatsapp_popup_message }}</textarea>
                    @if ($errors->has('whatsapp_popup_message'))
                      <p class="mb-0 text-danger">{{ $errors->first('whatsapp_popup_message') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label>{{ __('Popup') }}</label>
                    <div class="selectgroup w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="whatsapp_popup" value="1" class="selectgroup-input"
                          {{ $userBs->whatsapp_popup == 1 ? 'checked' : '' }}>
                        <span class="selectgroup-button">{{ __('Active') }}</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="whatsapp_popup" value="0" class="selectgroup-input"
                          {{ $userBs->whatsapp_popup == 0 ? 'checked' : '' }}>
                        <span class="selectgroup-button">{{ __('Deactive') }}</span>
                      </label>
                    </div>
                    @if ($errors->has('whatsapp_popup'))
                      <p class="mb-0 text-danger">{{ $errors->first('whatsapp_popup') }}</p>
                    @endif
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-success" form="waForm">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        @endif

        @php
          $currentPackage = \App\Http\Helpers\UserPermissionHelper::currentPackagePermission(Auth::guard('web')->user()->id);
          $pkgName = $currentPackage ? strtolower($currentPackage->title) : '';
          $hasRazorpayPlugin = in_array('Razor Pay Payment Integration', (array)$features)
              || in_array('Razorpay', (array)$features)
              || str_contains($pkgName, 'standard')
              || str_contains($pkgName, 'premium')
              || str_contains($pkgName, 'enterprise');
        @endphp
        @if ($hasRazorpayPlugin)
          {{-- Razorpay Plugin --}}
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">{{ __('Razorpay') }}</div>
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#razorpayGuideModal" style="border-radius: 20px; font-size: 11px; font-weight: 600; padding: 3px 10px; border: 1px solid #0284c7; color: #0284c7; background: #f0f9ff;">
                  <i class="fas fa-question-circle mr-1"></i> {{ __('Setup Guide') }}
                </button>
              </div>
              <div class="card-body">
                @php
                  $razorpayData = \App\Models\User\UserPaymentGeteway::where([
                      ['user_id', Auth::guard('web')->user()->id],
                      ['keyword', 'razorpay']
                  ])->first();
                  $razorpayInfo = ($razorpayData && !is_null($razorpayData->information))
                      ? json_decode($razorpayData->information, true)
                      : [];
                @endphp
                <form action="{{ route('user.razorpay.update') }}" method="POST" id="razorpayPluginForm">
                  @csrf
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label>{{ __('Razorpay Status') }}</label>
                        <div class="selectgroup w-100">
                          <label class="selectgroup-item">
                            <input type="radio" name="status" value="1" class="selectgroup-input"
                              {{ $razorpayData && $razorpayData->status == 1 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Active') }}</span>
                          </label>
                          <label class="selectgroup-item">
                            <input type="radio" name="status" value="0" class="selectgroup-input"
                              {{ !$razorpayData || $razorpayData->status == 0 ? 'checked' : '' }}>
                            <span class="selectgroup-button">{{ __('Deactive') }}</span>
                          </label>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>{{ __('Razorpay Key') }}</label>
                        <input class="form-control" name="key" value="{{ @$razorpayInfo['key'] ?? '' }}" placeholder="{{ __('Enter Razorpay Key') }}">
                      </div>

                      <div class="form-group">
                        <label>{{ __('Razorpay Secret') }}</label>
                        <input class="form-control" name="secret" value="{{ @$razorpayInfo['secret'] ?? '' }}" placeholder="{{ __('Enter Razorpay Secret') }}">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <button type="submit" class="btn btn-success" form="razorpayPluginForm">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        @endif

      </div>
    </div>
  </div>

  {{-- Google Analytics Guide Modal --}}
  <div class="modal fade" id="gaGuideModal" tabindex="-1" role="dialog" aria-labelledby="gaGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fab fa-google text-primary" style="font-size: 18px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0 text-white" id="gaGuideModalLabel">{{ __('How to Get Google Analytics Measurement ID') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Step-by-step guide to connect GA4 tracking with your store') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #2563eb;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Sign in to Google Analytics') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Open') }} <a href="https://analytics.google.com" target="_blank" class="text-primary font-weight-bold">analytics.google.com <i class="fas fa-external-link-alt fa-xs"></i></a> {{ __('and sign in with your Google account. Select or create your store analytics property.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #3b82f6;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Navigate to Data Streams') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('In the bottom-left corner, click the') }} <strong>{{ __('Admin (Gear Icon)') }}</strong> &rarr; {{ __('under Property column, click') }} <strong>{{ __('Data Streams') }}</strong> &rarr; {{ __('select the') }} <strong>{{ __('Web') }}</strong> {{ __('tab.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Copy your Measurement ID') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Click on your web stream (or add a stream for your store URL). In the Stream Details panel, find the') }} <strong>{{ __('MEASUREMENT ID') }}</strong> (e.g. <code>G-XXXXXXXXXX</code>) {{ __('and copy it.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #ea580c;">4</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Paste and Activate in LaunchShop') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Paste the Measurement ID into the box above, select') }} <strong>{{ __('Status: Active') }}</strong>, {{ __('and click') }} <strong>{{ __('Update') }}</strong>. {{ __('Google Analytics tracking is now live!') }}
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
          <a href="https://analytics.google.com" target="_blank" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); border: none; border-radius: 6px;">
            <i class="fas fa-external-link-alt mr-1"></i> {{ __('Open Google Analytics') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Google Login Guide Modal --}}
  <div class="modal fade" id="googleLoginGuideModal" tabindex="-1" role="dialog" aria-labelledby="googleLoginGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #ea4335, #f97316); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fab fa-google text-danger" style="font-size: 18px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0 text-white" id="googleLoginGuideModalLabel">{{ __('How to Set Up Google One-Click Login') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Step-by-step guide to get Google Client ID and Secret') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #ea4335;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Open Google Cloud Console') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Visit') }} <a href="https://console.cloud.google.com/apis/credentials" target="_blank" class="text-primary font-weight-bold">console.cloud.google.com <i class="fas fa-external-link-alt fa-xs"></i></a> {{ __('and create or select a project for your store.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #f97316;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Configure OAuth Consent Screen') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Go to') }} <strong>{{ __('OAuth consent screen') }}</strong> &rarr; {{ __('select') }} <strong>{{ __('External') }}</strong> &rarr; {{ __('fill in your Store Name and support email address, then click Save.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #2563eb;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Create OAuth Client ID & Add Redirect URI') }}</h6>
              <p class="text-muted mb-2" style="font-size: 13px;">
                {{ __('Go to') }} <strong>{{ __('Credentials') }} &rarr; {{ __('Create Credentials') }} &rarr; {{ __('OAuth client ID') }}</strong>. {{ __('Choose') }} <strong>{{ __('Web application') }}</strong>. {{ __('Under') }} <strong>{{ __('Authorized redirect URIs') }}</strong>, {{ __('click + Add URI and paste your store callback URL:') }}
              </p>
              <div class="input-group">
                <input type="text" id="googleRedirectUriInput" class="form-control form-control-sm" value="{{ $googleCallbackUrl }}" readonly style="background: #f8fafc; font-family: monospace; font-size: 12px;">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyPluginText('googleRedirectUriInput', this)">
                    <i class="fas fa-copy mr-1"></i> {{ __('Copy URL') }}
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">4</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Copy Credentials to LaunchShop') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Click Create in Google Cloud. Copy your') }} <strong>{{ __('Client ID') }}</strong> {{ __('and') }} <strong>{{ __('Client Secret') }}</strong>, {{ __('paste them into the form above, set Status to Active, and click Update.') }}
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
          <a href="https://console.cloud.google.com/apis/credentials" target="_blank" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #ea4335, #f97316); border: none; border-radius: 6px;">
            <i class="fas fa-external-link-alt mr-1"></i> {{ __('Open Google Cloud Console') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Google Recaptcha Guide Modal --}}
  <div class="modal fade" id="recaptchaGuideModal" tabindex="-1" role="dialog" aria-labelledby="recaptchaGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #1d4ed8, #60a5fa); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fas fa-shield-alt text-primary" style="font-size: 18px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0 text-white" id="recaptchaGuideModalLabel">{{ __('How to Get Google reCAPTCHA Keys') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Step-by-step guide to protect your store with reCAPTCHA v2') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #1d4ed8;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Open Google reCAPTCHA Admin') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Go to') }} <a href="https://www.google.com/recaptcha/admin/create" target="_blank" class="text-primary font-weight-bold">google.com/recaptcha/admin <i class="fas fa-external-link-alt fa-xs"></i></a> {{ __('and sign in with your Google account.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #2563eb;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Register New Site') }}</h6>
              <p class="text-muted mb-2" style="font-size: 13px;">
                {{ __('Enter a Label (e.g. your store name), select') }} <strong>{{ __('reCAPTCHA v2') }}</strong> &rarr; <strong>"{{ __('I\'m not a robot" Checkbox') }}</strong>. {{ __('Under Domains, add your store domain:') }}
              </p>
              <div class="input-group">
                <input type="text" id="recaptchaDomainInput" class="form-control form-control-sm" value="{{ $storeDomain }}" readonly style="background: #f8fafc; font-family: monospace; font-size: 12px;">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyPluginText('recaptchaDomainInput', this)">
                    <i class="fas fa-copy mr-1"></i> {{ __('Copy Domain') }}
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Copy Keys to LaunchShop') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Accept the Terms of Service and click Submit. Copy the generated') }} <strong>{{ __('Site Key') }}</strong> {{ __('and') }} <strong>{{ __('Secret Key') }}</strong>, {{ __('paste them into LaunchShop, choose Status: Active, and click Update.') }}
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
          <a href="https://www.google.com/recaptcha/admin" target="_blank" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #1d4ed8, #60a5fa); border: none; border-radius: 6px;">
            <i class="fas fa-external-link-alt mr-1"></i> {{ __('Open reCAPTCHA Console') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Facebook Pixel Guide Modal --}}
  <div class="modal fade" id="fbPixelGuideModal" tabindex="-1" role="dialog" aria-labelledby="fbPixelGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #1877f2, #0052cc); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fab fa-facebook-f text-primary" style="font-size: 18px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0 text-white" id="fbPixelGuideModalLabel">{{ __('How to Get Meta (Facebook) Pixel ID') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Step-by-step guide to connect Facebook Pixel for ads & tracking') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #1877f2;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Open Meta Events Manager') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Go to') }} <a href="https://business.facebook.com/events_manager2" target="_blank" class="text-primary font-weight-bold">business.facebook.com/events_manager2 <i class="fas fa-external-link-alt fa-xs"></i></a> {{ __('and select your Business Account.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #0052cc;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Connect Data Source') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Click') }} <strong>{{ __('+ Connect Data Sources') }}</strong> &rarr; {{ __('select') }} <strong>{{ __('Web') }}</strong> &rarr; {{ __('click Connect. Name your Pixel / Dataset (e.g. My Store) and enter your store URL:') }} <code>{{ $userStoreUrl }}</code>.
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Copy your Dataset / Pixel ID') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('In your Pixel overview, click') }} <strong>{{ __('Settings') }}</strong> {{ __('tab. Find your 15–16 digit') }} <strong>{{ __('Dataset ID') }}</strong> (e.g. <code>1234567890123456</code>) {{ __('and copy it.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #ea580c;">4</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Paste and Save in LaunchShop') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Paste the ID into the') }} <strong>{{ __('Facebook Pixel ID') }}</strong> {{ __('input above, set Status to Active, and click Update. Your store will immediately track page views and events.') }}
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
          <a href="https://business.facebook.com/events_manager2" target="_blank" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #1877f2, #0052cc); border: none; border-radius: 6px;">
            <i class="fas fa-external-link-alt mr-1"></i> {{ __('Open Meta Events Manager') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- WhatsApp Chat Button Guide Modal --}}
  <div class="modal fade" id="whatsappGuideModal" tabindex="-1" role="dialog" aria-labelledby="whatsappGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fab fa-whatsapp text-success" style="font-size: 20px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0 text-white" id="whatsappGuideModalLabel">{{ __('How to Set Up WhatsApp Chat Button') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Step-by-step guide to enable instant WhatsApp customer support') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Enter Mobile Number with Country Code') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Enter your active WhatsApp Business or personal phone number with country code, without + or dashes (e.g. For India:') }} <code>919876543210</code>, {{ __('for US:') }} <code>14155552671</code>).
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #10b981;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Set Header Title & Greeting Message') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                <strong>{{ __('Header Title:') }}</strong> {{ __('Displays at top of chat popup (e.g. "Customer Support" or "Chat with us").') }}<br>
                <strong>{{ __('Popup Message:') }}</strong> {{ __('Custom greeting shown to shoppers (e.g. "Hi there! How can we assist you with your order?").') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #2563eb;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Activate Widget & Auto-Popup') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Set') }} <strong>{{ __('Status: Active') }}</strong>. {{ __('If you want the greeting bubble to pop up automatically when customers browse your store, set') }} <strong>{{ __('Popup: Active') }}</strong>. {{ __('Click Update to save.') }}
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Razorpay Guide Modal --}}
  <div class="modal fade" id="razorpayGuideModal" tabindex="-1" role="dialog" aria-labelledby="razorpayGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #0284c7, #0369a1); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fas fa-credit-card text-info" style="font-size: 18px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0 text-white" id="razorpayGuideModalLabel">{{ __('How to Get Razorpay Key & Secret') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Accept UPI, Debit/Credit Cards, and NetBanking with Razorpay') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #0284c7;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Log in to Razorpay Dashboard') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Open') }} <a href="https://dashboard.razorpay.com" target="_blank" class="text-primary font-weight-bold">dashboard.razorpay.com <i class="fas fa-external-link-alt fa-xs"></i></a> {{ __('and sign in to your Razorpay account.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #0369a1;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Navigate to API Keys') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('In the left sidebar, click') }} <strong>{{ __('Account & Settings') }}</strong> &rarr; {{ __('under') }} <em>{{ __('Website and app settings') }}</em>, {{ __('click') }} <strong>{{ __('API Keys') }}</strong>.
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Generate Key & Copy Secret') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Click') }} <strong>{{ __('Generate Key') }}</strong> (or Regenerate Key). {{ __('A popup will show your') }} <strong>{{ __('Key Id') }}</strong> (e.g. <code>rzp_live_...</code>) {{ __('and') }} <strong>{{ __('Key Secret') }}</strong>. {{ __('Copy them immediately.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #ea580c;">4</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Paste into LaunchShop and Activate') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Paste the') }} <strong>{{ __('Razorpay Key') }}</strong> {{ __('and') }} <strong>{{ __('Razorpay Secret') }}</strong> {{ __('into the fields above, set Status to Active, and click Update. Your store can now receive online payments!') }}
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
          <a href="https://dashboard.razorpay.com/app/keys" target="_blank" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #0284c7, #0369a1); border: none; border-radius: 6px;">
            <i class="fas fa-external-link-alt mr-1"></i> {{ __('Open Razorpay API Keys') }}
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Disqus Guide Modal --}}
  <div class="modal fade" id="disqusGuideModal" tabindex="-1" role="dialog" aria-labelledby="disqusGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background: linear-gradient(135deg, #2e9fff, #0077cc); color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 18px 24px;">
          <div class="d-flex align-items-center">
            <div style="background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
              <i class="fas fa-comments text-info" style="font-size: 18px;"></i>
            </div>
            <div>
              <h5 class="modal-title font-weight-bold mb-0 text-white" id="disqusGuideModalLabel">{{ __('How to Get Disqus Shortname') }}</h5>
              <small style="color: rgba(255,255,255,0.85);">{{ __('Step-by-step guide to connect Disqus comments with your store blog') }}</small>
            </div>
          </div>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #2e9fff;">1</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Go to Disqus Site Registration') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Open') }} <a href="https://disqus.com/admin/create" target="_blank" class="text-primary font-weight-bold">disqus.com/admin/create <i class="fas fa-external-link-alt fa-xs"></i></a> {{ __('and sign in or create an account.') }}
              </p>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #0077cc;">2</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Choose "I want to install Disqus on my site"') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Select this option, enter your Website Name, and choose your unique') }} <strong>{{ __('Disqus Shortname') }}</strong> (e.g. <code>my-store-comments</code>).
              </p>
            </div>
          </div>
          <div class="d-flex mb-2">
            <div class="mr-3">
              <span class="badge badge-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; background: #059669;">3</span>
            </div>
            <div>
              <h6 class="font-weight-bold mb-1" style="color: #1e293b;">{{ __('Paste into LaunchShop') }}</h6>
              <p class="text-muted mb-0" style="font-size: 13px;">
                {{ __('Paste your Shortname into the box above, select Status: Active, and click Update. Your blog posts will now have live interactive customer comments!') }}
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 14px 24px;">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">{{ __('Got it, Close') }}</button>
          <a href="https://disqus.com/admin/create" target="_blank" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #2e9fff, #0077cc); border: none; border-radius: 6px;">
            <i class="fas fa-external-link-alt mr-1"></i> {{ __('Open Disqus Admin') }}
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  function copyPluginText(elementId, btnEl) {
    var input = document.getElementById(elementId);
    if (!input) return;
    var copyText = input.innerText || input.value;
    navigator.clipboard.writeText(copyText).then(function() {
      var originalHtml = btnEl.innerHTML;
      btnEl.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
      btnEl.classList.remove('btn-outline-primary');
      btnEl.classList.add('btn-success');
      setTimeout(function() {
        btnEl.innerHTML = originalHtml;
        btnEl.classList.add('btn-outline-primary');
        btnEl.classList.remove('btn-success');
      }, 2000);
    }).catch(function() {
      input.select();
      document.execCommand('copy');
      var originalHtml = btnEl.innerHTML;
      btnEl.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
      btnEl.classList.remove('btn-outline-primary');
      btnEl.classList.add('btn-success');
      setTimeout(function() {
        btnEl.innerHTML = originalHtml;
        btnEl.classList.add('btn-outline-primary');
        btnEl.classList.remove('btn-success');
      }, 2000);
    });
  }
</script>
@endsection
