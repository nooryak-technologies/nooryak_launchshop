@extends('user.layout')
@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/css/buy_plan.css') }}">
  <style>
    /* Header styling override */
    .page-header {
      border-bottom: none !important;
      padding-bottom: 0 !important;
      margin-bottom: 25px !important;
    }
    .page-title {
      font-size: 24px !important;
      font-weight: 700 !important;
      color: #0f172a !important;
    }
    .breadcrumbs {
      font-size: 13px !important;
      color: #64748b !important;
    }
    
    /* Current Plan Info Bar */
    .info-bar-current {
      background: #eff6ff !important;
      border: 1px solid #dbeafe !important;
      border-radius: 12px !important;
      padding: 16px 20px !important;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 30px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .info-bar-icon-wrap {
      width: 38px;
      height: 38px;
      background: #3b82f6;
      color: #ffffff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
    }
    .info-bar-content {
      font-size: 14px;
      font-weight: 500;
      color: #1e3a8a;
    }
    .info-bar-content strong {
      font-weight: 700;
      color: #1e3a8a;
    }
    .info-bar-badge {
      background: #3b82f6;
      color: #ffffff;
      padding: 2px 8px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      margin-left: 6px;
      text-transform: uppercase;
    }

    /* Pricing Cards grid */
    .pricing-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 24px;
      transition: all 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      position: relative;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .pricing-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
      border-color: var(--theme-color);
    }
    .pricing-card-header {
      margin-bottom: 16px;
    }
    .plan-name {
      font-size: 20px;
      font-weight: 700;
      color: #0f172a;
    }
    .badge-current {
      background: #d1fae5;
      color: #065f46;
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
    }

    /* Hexagonal price container */
    .hexagon-price {
      width: 130px;
      height: 145px;
      background: var(--theme-color);
      clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 20px auto;
      position: relative;
    }
    .hexagon-price-inner {
      position: absolute;
      top: 3px;
      left: 3px;
      right: 3px;
      bottom: 3px;
      background: #ffffff;
      clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 2;
    }
    .price-val {
      font-size: 26px;
      font-weight: 800;
      color: var(--theme-color);
    }
    .price-term {
      font-size: 11px;
      font-weight: 600;
      color: #64748b;
      margin-top: -2px;
    }

    /* Features list */
    .features-list-wrapper {
      flex-grow: 1;
      margin-bottom: 24px;
      margin-top: 10px;
    }
    .features-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    .features-list li {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      color: #475569;
      font-weight: 500;
    }
    .feature-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 18px;
      height: 18px;
      background: var(--theme-color);
      color: #ffffff;
      border-radius: 50%;
      font-size: 9px;
      flex-shrink: 0;
    }
    .feature-text {
      line-height: 1.4;
    }

    /* Buttons */
    .pricing-card-footer {
      margin-top: auto;
    }
    .btn-current-plan {
      background: #d1fae5 !important;
      color: #065f46 !important;
      border: none !important;
      font-size: 14px;
      font-weight: 700;
      padding: 12px;
      border-radius: 8px;
      cursor: default;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-buy-now {
      background: var(--theme-color) !important;
      color: #ffffff !important;
      border: none !important;
      font-size: 14px;
      font-weight: 700;
      padding: 12px;
      border-radius: 8px;
      transition: background 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none !important;
    }
    .btn-buy-now:hover {
      filter: brightness(0.9);
    }

    /* Bottom features block */
    .bottom-features-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .feature-icon-circle {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }
    .bg-blue-light { background: #eff6ff; }
    .text-blue { color: #2563eb; }
    .bg-green-light { background: #ecfdf5; }
    .text-green { color: #10b981; }
    .bg-purple-light { background: #faf5ff; }
    .text-purple { color: #7c3aed; }
    .bg-orange-light { background: #fff7ed; }
    .text-orange { color: #ea580c; }
    
    .feature-title {
      font-size: 14px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 4px;
    }
    .feature-desc {
      font-size: 12px;
      color: #64748b;
      margin: 0;
      line-height: 1.4;
    }
    .gap-3 {
      gap: 12px;
    }
  </style>
@endsection
@php
  $user = Auth::guard('web')->user();
  $package = \App\Http\Helpers\UserPermissionHelper::currentPackagePermission($user->id);
@endphp

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Membership Plans') }}</h4>
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
        <a href="#">{{ __('Membership') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Plans') }}</a>
      </li>
    </ul>
  </div>

  @if (is_null($package))
    @php
      $pendingMemb = \App\Models\Membership::query()
          ->where([['user_id', '=', Auth::id()], ['status', 0]])
          ->whereYear('start_date', '<>', '9999')
          ->orderBy('id', 'DESC')
          ->first();
      $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
    @endphp

    @if ($pendingPackage)
      <div class="alert alert-warning" style="border-radius: 12px;">
        {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
      </div>
      <div class="alert alert-warning" style="border-radius: 12px;">
        <strong>{{ __('Pending Package') . ':' }} </strong> {{ $pendingPackage->title }}
        <span class="badge badge-secondary">{{ __($pendingPackage->term) }}</span>
        <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
      </div>
    @else
      <div class="alert alert-warning" style="border-radius: 12px;">
        {{ __('Your membership is expired. Please purchase a new package / extend the current package.') }}
      </div>
    @endif
  @else
    @if ($package_count >= 2)
      @if ($next_membership->status == 0)
        <div class="alert alert-warning" style="border-radius: 12px;">
          <strong>{{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}</strong>
        </div>
      @elseif ($next_membership->status == 1)
        <div class="alert alert-warning" style="border-radius: 12px;">
          <strong>{{ __('You have another package to activate after the current package expires. You cannot purchase / extend any package, until the next package is activated') }}</strong>
        </div>
      @endif
    @endif

    <div class="info-bar-current">
      <div class="info-bar-icon-wrap">
        <i class="fas fa-crown"></i>
      </div>
      <div class="info-bar-content">
        {{ __('Current Package') }}: <strong>{{ $current_package->title }}</strong>
        <span class="info-bar-badge">{{ __($current_package->term) }}</span>
        <span style="margin: 0 10px; color: #cbd5e1;">|</span>
        {{ __('Expire Date') }}: <strong>
        @if ($current_membership->is_trial == 1)
          {{ Carbon\Carbon::parse($current_membership->expire_date)->format('M-d-Y') }} ({{ __('Trial') }})
        @else
          {{ $current_package->term === 'lifetime' ? __('Lifetime') : Carbon\Carbon::parse($current_membership->expire_date)->format('M-d-Y') }}
        @endif
        </strong>
      </div>
    </div>
  @endif

  <div class="row mb-5 justify-content-center">
    @foreach ($packages as $key => $package)
      @php
        $features = json_decode($package->features, true);
        $titleLower = strtolower($package->title);
        $termLower = strtolower($package->term);
        
        $themeClass = 'theme-blue';
        $themeColor = '#2563eb';
        
        if (strpos($titleLower, 'basic') !== false) {
            if ($termLower === 'monthly') {
                $themeClass = 'theme-green';
                $themeColor = '#10b981';
            } else {
                $themeClass = 'theme-blue';
                $themeColor = '#2563eb';
            }
        } elseif (strpos($titleLower, 'standard') !== false) {
            $themeClass = 'theme-purple';
            $themeColor = '#7c3aed';
        } elseif (strpos($titleLower, 'premium') !== false) {
            $themeClass = 'theme-orange';
            $themeColor = '#ea580c';
        }
      @endphp

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="pricing-card {{ $themeClass }}" style="--theme-color: {{ $themeColor }};">
          <div class="pricing-card-header d-flex justify-content-between align-items-center">
            <span class="plan-name">{{ __($package->title) }}</span>
            @if (isset($current_package->id) && $current_package->id === $package->id)
              <span class="badge-current">{{ __('Current') }}</span>
            @endif
          </div>
          
          <div class="hexagon-price">
            <div class="hexagon-price-inner">
              <span class="price-val">₹{{ round($package->price) }}</span>
              <span class="price-term">/{{ __($package->term) }}</span>
            </div>
          </div>
          
          <div class="features-list-wrapper">
            <ul class="features-list">
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Categories Limit') }} : {{ $package->categories_limit != '999999' ? $package->categories_limit : __('Unlimited') }}</span>
              </li>
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Subcategories Limit') }} : {{ $package->subcategories_limit != '999999' ? $package->subcategories_limit : __('Unlimited') }}</span>
              </li>
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Products Limit') }} : {{ $package->product_limit != '999999' ? $package->product_limit : __('Unlimited') }}</span>
              </li>
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Orders Limit') }} : {{ $package->order_limit != '999999' ? $package->order_limit : __('Unlimited') }}</span>
              </li>
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Additional Languages') }} : {{ $package->language_limit != '999999' ? $package->language_limit : __('Unlimited') }}</span>
              </li>
              @if (is_array($features) && in_array('Blog', $features))
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Posts Limit') }} : {{ $package->post_limit != '999999' ? $package->post_limit : __('Unlimited') }}</span>
              </li>
              @endif
              @if (is_array($features) && in_array('Custom Page', $features))
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Custom Pages Limit') }} : {{ $package->number_of_custom_page != '999999' ? $package->number_of_custom_page : __('Unlimited') }}</span>
              </li>
              @endif
              @if (is_array($features) && in_array('Subdomain', $features))
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Subdomain') }}</span>
              </li>
              @endif
              @if (is_array($features) && in_array('QR Builder', $features))
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('QR Builder') }}</span>
              </li>
              @endif
              @if (is_array($features) && in_array('Unlimited Customers', $features))
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Unlimited Customers') }}</span>
              </li>
              @endif
              @if (is_array($features) && in_array('Free .in Domain', $features))
              <li>
                <span class="feature-icon"><i class="fas fa-check"></i></span>
                <span class="feature-text">{{ __('Free .in Domain') }}</span>
              </li>
              @endif
            </ul>
          </div>
          
          @php
            $hasPendingMemb = \App\Http\Helpers\UserPermissionHelper::hasPendingMembership(Auth::id());
          @endphp
          <div class="pricing-card-footer">
            @if (isset($current_package->id) && $current_package->id === $package->id)
              <button class="btn btn-current-plan w-100" disabled>
                <i class="fas fa-crown mr-2"></i> {{ __('Current Plan') }}
              </button>
            @elseif ($package_count < 2 && !$hasPendingMemb)
              <a href="{{ route('user.plan.extend.checkout', $package->id) }}" class="btn btn-buy-now w-100">
                <i class="fas fa-shopping-cart mr-2"></i> {{ __('Buy Now') }}
              </a>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Bottom Features Row -->
  <div class="row mt-5 mb-4">
    <div class="col-12">
      <div class="bottom-features-card p-4">
        <div class="row">
          <!-- Feature 1 -->
          <div class="col-lg-3 col-md-6 mb-3 mb-lg-0 d-flex align-items-start gap-3">
            <div class="feature-icon-circle bg-blue-light">
              <i class="fas fa-shield-alt text-blue"></i>
            </div>
            <div>
              <h5 class="feature-title">{{ __('Secure & Reliable') }}</h5>
              <p class="feature-desc">{{ __('Your data is secure with enterprise-grade protection.') }}</p>
            </div>
          </div>
          <!-- Feature 2 -->
          <div class="col-lg-3 col-md-6 mb-3 mb-lg-0 d-flex align-items-start gap-3">
            <div class="feature-icon-circle bg-green-light">
              <i class="fas fa-rocket text-green"></i>
            </div>
            <div>
              <h5 class="feature-title">{{ __('Powerful Features') }}</h5>
              <p class="feature-desc">{{ __('Everything you need to grow your business online.') }}</p>
            </div>
          </div>
          <!-- Feature 3 -->
          <div class="col-lg-3 col-md-6 mb-3 mb-lg-0 d-flex align-items-start gap-3">
            <div class="feature-icon-circle bg-purple-light">
              <i class="fas fa-headset text-purple"></i>
            </div>
            <div>
              <h5 class="feature-title">{{ __('24/7 Support') }}</h5>
              <p class="feature-desc">{{ __('Our support team is always ready to help you.') }}</p>
            </div>
          </div>
          <!-- Feature 4 -->
          <div class="col-lg-3 col-md-6 d-flex align-items-start gap-3">
            <div class="feature-icon-circle bg-orange-light">
              <i class="fas fa-chart-line text-orange"></i>
            </div>
            <div>
              <h5 class="feature-title">{{ __('Scale Your Business') }}</h5>
              <p class="feature-desc">{{ __('Flexible plans that grow with your business.') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
