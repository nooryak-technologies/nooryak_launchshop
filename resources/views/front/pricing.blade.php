@extends('front.layout')

@section('pagename')
  - {{ $pageHeading ?? __('Pricing') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->pricing_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->pricing_meta_keywords : '')

@section('styles')
<style>
  /* Completely hide the default grey parallax breadcrumb header */
  .page-title-area {
      display: none !important;
  }

  /* Strikeout and make red the text of disabled features, with a black line */
  .disabled-feature span:not(.feat-check-circle) {
      text-decoration: line-through !important;
      text-decoration-color: #000000 !important;
      color: #ef4444 !important;
      opacity: 0.65;
  }
</style>
@endsection

@section('content')
@php
  $selectedTemplate = request()->query('template');
@endphp

  <!-- Modern Pricing Page wrapper -->
  <div class="modern-pricing-page-wrapper pt-40 pb-120">
    <div class="container">
      
      <!-- Subtle top breadcrumb navigation -->
      <!-- <nav aria-label="breadcrumb" class="custom-pricing-breadcrumb mb-4" data-aos="fade-down">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $pageHeading ?? __('Pricing') }}</li>
        </ol>
      </nav> -->

      <!-- Hero Header Section -->
      <div class="row align-items-center mb-80 pricing-hero-row">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="pricing-hero-content" data-aos="fade-right">
            <span class="pricing-plan-badge">{{ __('PRICING PLANS') }}</span>
            <h1 class="pricing-hero-title">
              Simple Pricing for <br><span>Every Stage</span> of Growth
            </h1>
            <p class="pricing-hero-desc">
              Launch your store in minutes, pick a beautiful theme, get a free subdomain, and scale with confidence.
            </p>
            <div class="pricing-trust-pills">
              <span class="trust-pill"><i class="fas fa-check-circle"></i> {{ __('No credit card required') }}</span>
              <span class="trust-pill"><i class="fas fa-check-circle"></i> {{ __('14-day free trial') }}</span>
              <span class="trust-pill"><i class="fas fa-check-circle"></i> {{ __('Cancel anytime') }}</span>
            </div>
          </div>
        </div>
        
        <div class="col-lg-6">
          <div class="pricing-dashboard-mockup-wrapper" data-aos="fade-left">
            <!-- Dotted Background Grid glow -->
            <div class="mockup-bg-glow"></div>
            
            <!-- Live CSS Dashboard Card Mockup -->
            <div class="pricing-dashboard-mockup">
              <!-- Left Sidebar -->
              <div class="mockup-sidebar">
                <div class="mockup-sidebar-header">
                  <i class="fas fa-shopping-bag"></i>
                </div>
                <ul class="mockup-sidebar-menu">
                  <li class="active"><i class="fas fa-th-large"></i> <span>Overview</span></li>
                  <li><i class="fas fa-shopping-cart"></i> <span>Orders</span></li>
                  <li><i class="fas fa-box"></i> <span>Products</span></li>
                  <li><i class="fas fa-users"></i> <span>Customers</span></li>
                  <li><i class="fas fa-chart-bar"></i> <span>Analytics</span></li>
                  <li><i class="fas fa-bullhorn"></i> <span>Marketing</span></li>
                  <li><i class="fas fa-cog"></i> <span>Settings</span></li>
                </ul>
              </div>
              
              <!-- Main Content Area -->
              <div class="mockup-main">
                <!-- Stat widgets row -->
                <div class="mockup-stats-row">
                  <div class="stat-card">
                    <span class="stat-label">Total Sales</span>
                    <span class="stat-value">₹1,24,560</span>
                    <span class="stat-growth success"><i class="fas fa-arrow-up"></i> +24.8%</span>
                  </div>
                  <div class="stat-card">
                    <span class="stat-label">Orders</span>
                    <span class="stat-value">2,345</span>
                    <span class="stat-growth success"><i class="fas fa-arrow-up"></i> +7.2%</span>
                  </div>
                  <div class="stat-card">
                    <span class="stat-label">Visitors</span>
                    <span class="stat-value">12,845</span>
                    <span class="stat-growth success"><i class="fas fa-arrow-up"></i> +12.4%</span>
                  </div>
                </div>
                
                <!-- Chart widgets box -->
                <div class="mockup-chart-card">
                  <div class="chart-header">
                    <span class="chart-title">Sales Overview</span>
                    <span class="chart-filter">This Month <i class="fas fa-chevron-down"></i></span>
                  </div>
                  <div class="chart-body">
                    <svg viewBox="0 0 400 120" class="chart-svg">
                      <!-- Grid lines -->
                      <line x1="0" y1="20" x2="400" y2="20" stroke="#f1f5f9" stroke-dasharray="4" />
                      <line x1="0" y1="50" x2="400" y2="50" stroke="#f1f5f9" stroke-dasharray="4" />
                      <line x1="0" y1="80" x2="400" y2="80" stroke="#f1f5f9" stroke-dasharray="4" />
                      <line x1="0" y1="110" x2="400" y2="110" stroke="#e2e8f0" />
                      <!-- Orange wavy trend line -->
                      <path d="M 0 100 Q 50 60 100 80 T 200 40 T 300 90 T 400 30" fill="none" stroke="#ff5a2c" stroke-width="3" stroke-linecap="round" />
                      <!-- Area gradient under trend line -->
                      <path d="M 0 100 Q 50 60 100 80 T 200 40 T 300 90 T 400 30 L 400 110 L 0 110 Z" fill="url(#pricing-chart-grad)" opacity="0.1" />
                      <defs>
                        <linearGradient id="pricing-chart-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                          <stop offset="0%" stop-color="#ff5a2c" />
                          <stop offset="100%" stop-color="#ffffff" />
                        </linearGradient>
                      </defs>
                    </svg>
                    <div class="chart-months">
                      <span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Store Growth floating widget -->
              <div class="mockup-floating-growth">
                <div class="growth-icon-circle">
                  <i class="fas fa-chart-line"></i>
                </div>
                <div class="growth-info">
                  <span class="growth-title">Store Growth</span>
                  <span class="growth-pct">+42%</span>
                  <span class="growth-sub">vs last month</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Toggle Tabs Section -->
      <div class="pricing-toggle-area text-center mb-50">
        <div class="toggle-container" data-aos="fade-up">
          <ul class="nav nav-pills justify-content-center" id="pricing-tabs" role="tablist">
            @foreach ($terms as $term)
              <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                        id="{{ strtolower($term) }}-tab" 
                        data-bs-toggle="pill" 
                        data-bs-target="#tab-{{ strtolower($term) }}" 
                        type="button" 
                        role="tab" 
                        aria-controls="tab-{{ strtolower($term) }}" 
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                  {{ __("$term") }}
                  @if (strtolower($term) == 'yearly')
                    <span class="badge-best-value">{{ __('Best Value') }}</span>
                  @endif
                </button>
              </li>
            @endforeach
          </ul>
        </div>
        <p class="toggle-subtext" data-aos="fade-up" data-aos-delay="100">Save up to 30% with yearly billing</p>
      </div>

      <!-- Pricing Cards content tabs -->
      <div class="tab-content" id="pricing-tabs-content" data-aos="fade-up">
        @foreach ($terms as $term)
          @php
            $packages = \App\Models\Package::where('status', '1')->where('term', strtolower($term))->orderBy('price', 'asc')->get();
          @endphp
          <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
               id="tab-{{ strtolower($term) }}" 
               role="tabpanel" 
               aria-labelledby="{{ strtolower($term) }}-tab">
            <div class="row g-4 justify-content-center">
              @foreach ($packages as $index => $package)
                @php
                  // Plan icon & subtitle based on price order
                  $planTitle    = __($package->title);
                  $planSubtitle = $package->term ? ucfirst(strtolower($package->term)) . ' plan' : '';
                  $planIcon     = 'fas fa-paper-plane';
                  $iconClass    = 'starter';

                  if ($index == 0) {
                      $planSubtitle = 'Perfect for getting started';
                      $planIcon     = 'fas fa-paper-plane';
                      $iconClass    = 'starter';
                  } elseif ($index == 1) {
                      $planSubtitle = 'Grow your business';
                      $planIcon     = 'fas fa-rocket';
                      $iconClass    = 'growth';
                  } elseif ($index == 2) {
                      $planSubtitle = 'For scaling stores';
                      $planIcon     = 'fas fa-crown';
                      $iconClass    = 'scale';
                  } else {
                      $planSubtitle = 'Advanced plan';
                      $planIcon     = 'fas fa-gem';
                      $iconClass    = 'scale';
                  }
                @endphp
                <div class="col-sm-12 col-md-6 col-lg-3">
                  <div class="pricing-card-modern {{ $package->recommended == '1' ? 'popular' : '' }}">
                    @if ($package->recommended == '1')
                      <span class="card-ribbon-badge">{{ __('MOST POPULAR') }}</span>
                    @endif
                    
                    <div class="card-header-block">
                      <div class="icon-circle {{ $iconClass }}">
                        <i class="{{ $planIcon }}"></i>
                      </div>
                      <div class="title-info">
                        <h3>{{ $planTitle }}</h3>
                        <p class="subtitle">{{ $planSubtitle }}</p>
                      </div>
                    </div>
                    
                    <div class="price-section">
                      @if ($be->base_currency_symbol_position == 'left')
                        <span class="currency-symbol">{{ $be->base_currency_symbol }}</span>
                      @endif
                      <span class="price-value">{{ $package->price == 0 ? __('Free') : number_format($package->price, 0) }}</span>
                      @if ($be->base_currency_symbol_position == 'right')
                        <span class="currency-symbol">{{ $be->base_currency_symbol }}</span>
                      @endif
                      @if ($package->price != 0)
                        <span class="period">/ {{ strtolower($term) == 'lifetime' ? 'one-time' : 'month' }}</span>
                      @endif
                    </div>
                    
                    <p class="billing-subtext">
                      @if (strtolower($term) == 'yearly')
                        Billed yearly at {{ $be->base_currency_symbol }}{{ number_format($package->price * 12, 0) }}
                      @elseif (strtolower($term) == 'monthly')
                        Billed monthly
                      @else
                        One-time access fee
                      @endif
                    </p>
                    
                    <!-- Feature lists - ALL from admin -->
                    @php
                      // Build the full list of limit-based features from DB fields
                      $limitFeatures = [];

                      if (!empty($package->categories_limit)) {
                          $limitFeatures[] = ['label' => 'Categories Limit : ' . ($package->categories_limit == 999999 ? 'Unlimited' : $package->categories_limit), 'active' => true];
                      }
                      if (!empty($package->subcategories_limit)) {
                          $limitFeatures[] = ['label' => 'Subcategories Limit : ' . ($package->subcategories_limit == 999999 ? 'Unlimited' : $package->subcategories_limit), 'active' => true];
                      }
                      $limitFeatures[] = ['label' => 'Products Limit : ' . ($package->product_limit == 999999 ? 'Unlimited' : $package->product_limit), 'active' => true];
                      if (!empty($package->order_limit)) {
                          $limitFeatures[] = ['label' => 'Orders Limit : ' . ($package->order_limit == 999999 ? 'Unlimited' : $package->order_limit), 'active' => true];
                      }
                      if (!empty($package->language_limit)) {
                          $limitFeatures[] = ['label' => 'Additional Languages : ' . ($package->language_limit == 999999 ? 'Unlimited' : $package->language_limit), 'active' => true];
                      }
                      if (!empty($package->post_limit)) {
                          $limitFeatures[] = ['label' => 'Posts Limit : ' . ($package->post_limit == 999999 ? 'Unlimited' : $package->post_limit), 'active' => true];
                      }
                      if (!empty($package->number_of_custom_page)) {
                          $limitFeatures[] = ['label' => 'Custom Pages Limit : ' . ($package->number_of_custom_page == 999999 ? 'Unlimited' : $package->number_of_custom_page), 'active' => true];
                      }

                      // All toggled features from the JSON array
                      $pFeatures = json_decode($package->features, true) ?: [];

                      // How many to show initially (first 6 limit features)
                      $visibleCount = 6;
                      $visibleLimits = array_slice($limitFeatures, 0, $visibleCount);
                      $extraLimits   = array_slice($limitFeatures, $visibleCount);

                      // Total extra = extra limits + all master features (except Posts Limit) + AI fields
                      $masterFeaturesToShow = collect($allPfeatures)->filter(function($f) {
                          return $f !== 'Posts Limit';
                      });
                      $aiCount = (!empty($package->ai_engine) && in_array('AI Content & Image Generator', $pFeatures) ? 1 : 0)
                               + (!empty($package->ai_token_limit) && in_array('AI Content & Image Generator', $pFeatures) ? 1 : 0)
                               + (!empty($package->ai_image_limit) && in_array('AI Content & Image Generator', $pFeatures) ? 1 : 0);
                      $totalExtra = count($extraLimits) + $masterFeaturesToShow->count() + $aiCount;
                    @endphp

                    <div class="features-list-block">
                      <ul>
                        @foreach ($visibleLimits as $lf)
                          <li>
                            <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                            <span>{{ $lf['label'] }}</span>
                          </li>
                        @endforeach
                      </ul>
                    </div>

                    @if ($totalExtra > 0)
                      <div class="pricing-feature-more">
                        <button type="button" class="pricing-feature-toggle" aria-expanded="false">
                          <span class="show-more-label">+ {{ $totalExtra }} more</span>
                          <span class="show-less-label d-none">Show less</span>
                        </button>

                        <div class="pricing-features-extra" aria-hidden="true">
                          <ul>
                            {{-- Extra limit-based features --}}
                            @foreach ($extraLimits as $lf)
                              <li>
                                <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                                <span>{{ $lf['label'] }}</span>
                              </li>
                            @endforeach

                            {{-- All JSON feature flags with ticks/crosses --}}
                            @foreach ($allPfeatures as $feature)
                              @if ($feature !== 'Posts Limit')
                                @php
                                  $hasFeature = is_array($pFeatures) && in_array($feature, $pFeatures);
                                @endphp
                                <li class="{{ !$hasFeature ? 'disabled-feature' : '' }}">
                                  @if ($hasFeature)
                                    <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                                  @else
                                    <span class="feat-check-circle times"><i class="fas fa-times"></i></span>
                                  @endif
                                  <span>{{ $feature }}</span>
                                </li>
                                @if ($feature === 'AI Content & Image Generator' && $hasFeature)
                                  @if (!empty($package->ai_engine))
                                    <li class="pricing-feature-detail">
                                      <span class="feat-check-circle detail"><i class="fas fa-microchip"></i></span>
                                      <span>AI Engine : {{ strtoupper($package->ai_engine) }}</span>
                                    </li>
                                  @endif
                                  @if (!empty($package->ai_token_limit))
                                    <li class="pricing-feature-detail">
                                      <span class="feat-check-circle detail"><i class="fas fa-coins"></i></span>
                                      <span>AI Token Limit : {{ number_format($package->ai_token_limit) }}</span>
                                    </li>
                                  @endif
                                  @if (!empty($package->ai_image_limit))
                                    <li class="pricing-feature-detail">
                                      <span class="feat-check-circle detail"><i class="fas fa-image"></i></span>
                                      <span>AI Image Limit : {{ $package->ai_image_limit }}</span>
                                    </li>
                                  @endif
                                @endif
                              @endif
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    @endif

                    
                    <!-- Call to action button -->
                    <div class="card-btn-action">
                      @if ($package->is_trial === '1' && $package->price != 0)
                        @php
                          $hrefTrial = $selectedTemplate 
                            ? route('front.register.view', ['status' => 'trial', 'id' => $package->id]) . '?template=' . urlencode($selectedTemplate)
                            : route('front.select.template', ['status' => 'trial', 'id' => $package->id]);
                          $hrefPurchase = $selectedTemplate 
                            ? route('front.register.view', ['status' => 'regular', 'id' => $package->id]) . '?template=' . urlencode($selectedTemplate)
                            : route('front.select.template', ['status' => 'regular', 'id' => $package->id]);
                        @endphp
                        <div class="d-flex gap-2 justify-content-between mt-2">
                          <a href="{{ $hrefTrial }}" 
                             class="btn-pricing-action btn-orange-filled" 
                             style="font-size: 10px; padding: 10px 4px; flex: 1 1 0% !important; width: auto !important; white-space: nowrap; display: inline-flex; align-items: center; justify-content: center;">
                            Start Free Trial <i class="fas fa-chevron-right ms-1" style="font-size: 8px;"></i>
                          </a>
                          <a href="{{ $hrefPurchase }}" 
                             class="btn-pricing-action btn-orange-outline" 
                             style="font-size: 10px; padding: 10px 4px; flex: 1 1 0% !important; width: auto !important; white-space: nowrap; display: inline-flex; align-items: center; justify-content: center;">
                            Purchase Plan <i class="fas fa-shopping-cart ms-1" style="font-size: 8px;"></i>
                          </a>
                        </div>
                      @elseif ($package->price == 0)
                        @php
                          $href = $selectedTemplate 
                            ? route('front.register.view', ['status' => 'regular', 'id' => $package->id]) . '?template=' . urlencode($selectedTemplate)
                            : route('front.select.template', ['status' => 'regular', 'id' => $package->id]);
                        @endphp
                        <a href="{{ $href }}" 
                           class="btn-pricing-action btn-orange-outline d-block">
                          Get Started Free <i class="fas fa-chevron-right ms-2" style="font-size:11px;"></i>
                        </a>
                      @else
                        @php
                          $href = $selectedTemplate 
                            ? route('front.register.view', ['status' => 'regular', 'id' => $package->id]) . '?template=' . urlencode($selectedTemplate)
                            : route('front.select.template', ['status' => 'regular', 'id' => $package->id]);
                        @endphp
                        <a href="{{ $href }}" 
                           class="btn-pricing-action btn-orange-filled d-block">
                          Get Started <i class="fas fa-chevron-right ms-2" style="font-size:11px;"></i>
                        </a>
                      @endif
                      <p class="trial-label mt-2">
                        @if ($package->is_trial === '1')
                          {{ $package->trial_days }}-day free trial
                        @else
                          No credit card required
                        @endif
                      </p>
                    </div>
                  </div>
                </div>
              @endforeach
              
              <!-- Static Enterprise Column Card -->
              <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="pricing-card-modern enterprise">
                  <div class="card-header-block">
                    <div class="icon-circle enterprise">
                      <i class="fas fa-building"></i>
                    </div>
                    <div class="title-info">
                      <h3>Enterprise</h3>
                      <p class="subtitle">For large & global brands</p>
                    </div>
                  </div>
                  
                  <div class="price-section custom-price">
                    <span class="price-value text-dark">Custom</span>
                  </div>
                  <p class="billing-subtext">Tailored to your needs</p>
                  
                  <div class="features-list-block">
                    <ul>
                      <li>
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        <span>Everything in Scale</span>
                      </li>
                      <li>
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        <span>Unlimited Staff Accounts</span>
                      </li>
                      <li>
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        <span>Dedicated Account Manager</span>
                      </li>
                      <li>
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        <span>Custom Integrations</span>
                      </li>
                      <li>
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        <span>SLA &amp; Uptime Guarantee</span>
                      </li>
                      <li>
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        <span>Priority 24/7 Support</span>
                      </li>
                    </ul>
                  </div>
                  
                  <div class="card-btn-action">
                    <a href="{{ route('front.contact') }}" class="btn-pricing-action btn-outline-dark">
                      Talk to Sales
                    </a>
                    <p class="trial-label">Schedule a demo</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Trust Factors Highlights row -->
      <div class="pricing-highlights-row mt-80" data-aos="fade-up">
        <div class="highlight-item">
          <div class="icon-box"><i class="far fa-calendar-check"></i></div>
          <div class="text-box">
            <strong>14-Day Free Trial</strong>
            <span>Full access. No limits.</span>
          </div>
        </div>
        <div class="highlight-item">
          <div class="icon-box"><i class="far fa-credit-card"></i></div>
          <div class="text-box">
            <strong>No Credit Card</strong>
            <span>Start instantly. No hassle.</span>
          </div>
        </div>
        <div class="highlight-item">
          <div class="icon-box"><i class="far fa-clock"></i></div>
          <div class="text-box">
            <strong>Cancel Anytime</strong>
            <span>No lock-ins. No questions.</span>
          </div>
        </div>
        <div class="highlight-item">
          <div class="icon-box"><i class="fas fa-bolt"></i></div>
          <div class="text-box">
            <strong>Instant Setup</strong>
            <span>Your store in minutes.</span>
          </div>
        </div>
        <div class="highlight-item">
          <div class="icon-box"><i class="far fa-shield-alt"></i></div>
          <div class="text-box">
            <strong>Secure & Reliable</strong>
            <span>99.9% uptime. Always.</span>
          </div>
        </div>
      </div>

      <!-- Detailed compare plans section -->
      @php
        $firstTerm = count($terms) > 0 ? strtolower($terms[0]) : 'monthly';
        $comparePackages = \App\Models\Package::where('status', '1')
            ->where('term', $firstTerm)
            ->orderBy('price', 'asc')
            ->get();

        // Build comparison rows
        $compareRows = [];

        // Limit rows
        $compareRows[] = [
            'type' => 'limit',
            'label' => 'Products Limit',
            'key' => 'product_limit',
            'ent_val' => 'Unlimited'
        ];
        $compareRows[] = [
            'type' => 'limit',
            'label' => 'Categories Limit',
            'key' => 'categories_limit',
            'ent_val' => 'Unlimited'
        ];
        $compareRows[] = [
            'type' => 'limit',
            'label' => 'Subcategories Limit',
            'key' => 'subcategories_limit',
            'ent_val' => 'Unlimited'
        ];
        $compareRows[] = [
            'type' => 'limit',
            'label' => 'Orders Limit',
            'key' => 'order_limit',
            'ent_val' => 'Unlimited'
        ];
        $compareRows[] = [
            'type' => 'limit',
            'label' => 'Additional Languages',
            'key' => 'language_limit',
            'ent_val' => 'Unlimited'
        ];
        $compareRows[] = [
            'type' => 'limit',
            'label' => 'Posts Limit',
            'key' => 'post_limit',
            'ent_val' => 'Unlimited'
        ];
        $compareRows[] = [
            'type' => 'limit',
            'label' => 'Custom Pages Limit',
            'key' => 'number_of_custom_page',
            'ent_val' => 'Unlimited'
        ];

        // Feature flags
        foreach ($allPfeatures as $f) {
            if ($f !== 'Posts Limit') {
                $compareRows[] = [
                    'type' => 'flag',
                    'label' => $f,
                    'ent_val' => true
                ];
            }
        }

        // Show first 6 rows initially, hide the rest
        $visibleCompareCount = 6;
        $visibleCompareRows = array_slice($compareRows, 0, $visibleCompareCount);
        $hiddenCompareRows = array_slice($compareRows, $visibleCompareCount);
      @endphp

      <div class="compare-features-section mt-100" data-aos="fade-up">
        <h2 class="section-title text-center mb-5">Compare Plan Features</h2>
        
        <div class="table-responsive">
          <table class="table compare-table">
            <thead>
              <tr>
                <th style="width: 28%;">Features</th>
                @foreach ($comparePackages as $pkg)
                  <th style="width: 18%; text-align: center;" class="{{ $pkg->recommended == '1' ? 'highlight-column-header' : '' }}">
                    @if ($pkg->recommended == '1')
                      <div class="highlight-wrapper">
                        <i class="fas fa-crown text-orange me-1"></i> {{ __($pkg->title) }}
                      </div>
                    @else
                      {{ __($pkg->title) }}
                    @endif
                  </th>
                @endforeach
                <th style="width: 18%; text-align: center;">Enterprise</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($visibleCompareRows as $row)
                <tr>
                  <td>{{ $row['label'] }}</td>
                  @foreach ($comparePackages as $pkg)
                    <td class="text-center {{ $pkg->recommended == '1' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                      @if ($row['type'] == 'limit')
                        @php
                          $val = $pkg->{$row['key']};
                        @endphp
                        {{ $val == 999999 ? 'Unlimited' : ($val ?: '0') }}
                      @else
                        @php
                          $pkgFeats = json_decode($pkg->features, true) ?: [];
                          $hasFeat = in_array($row['label'], $pkgFeats);
                        @endphp
                        @if ($hasFeat)
                          <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        @else
                          <span class="feat-check-circle times"><i class="fas fa-times"></i></span>
                        @endif
                      @endif
                    </td>
                  @endforeach
                  <td class="text-center">
                    @if ($row['type'] == 'limit')
                      {{ $row['ent_val'] }}
                    @else
                      <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
            
            @if (count($hiddenCompareRows) > 0)
              <tbody id="compare-features-hidden-rows" class="collapse">
                @foreach ($hiddenCompareRows as $row)
                  <tr>
                    <td>{{ $row['label'] }}</td>
                    @foreach ($comparePackages as $pkg)
                      <td class="text-center {{ $pkg->recommended == '1' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                        @if ($row['type'] == 'limit')
                          @php
                            $val = $pkg->{$row['key']};
                          @endphp
                          {{ $val == 999999 ? 'Unlimited' : ($val ?: '0') }}
                        @else
                          @php
                            $pkgFeats = json_decode($pkg->features, true) ?: [];
                            $hasFeat = in_array($row['label'], $pkgFeats);
                          @endphp
                          @if ($hasFeat)
                            <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                          @else
                            <span class="feat-check-circle times"><i class="fas fa-times"></i></span>
                          @endif
                        @endif
                      </td>
                    @endforeach
                    <td class="text-center">
                      @if ($row['type'] == 'limit')
                        {{ $row['ent_val'] }}
                      @else
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            @endif
          </table>
        </div>

        @if (count($hiddenCompareRows) > 0)
          <div class="text-center mt-4">
            <button class="btn btn-orange-outline px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#compare-features-hidden-rows" aria-expanded="false" aria-controls="compare-features-hidden-rows" id="btn-toggle-compare-rows">
              View More Features <i class="fas fa-chevron-down ms-2"></i>
            </button>
          </div>
        @endif
      </div>

      @if (count($faqs) > 0)
        <!-- FAQ Section collapse grid -->
        <div class="pricing-faq-section mt-100" data-aos="fade-up">
          <h2 class="section-title text-center mb-50">Frequently Asked Questions</h2>
          
          <div class="row">
            <!-- Left Column accordion -->
            <div class="col-md-6 mb-4 mb-md-0">
              <div class="accordion" id="faqAccordionLeft">
                @foreach ($faqs as $index => $faq)
                  @if ($index % 2 == 0)
                    <div class="accordion-item faq-item">
                      <h3 class="accordion-header" id="faqHL{{ $faq->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCL{{ $faq->id }}" aria-expanded="false" aria-controls="faqCL{{ $faq->id }}">
                          {{ $faq->question }}
                        </button>
                      </h3>
                      <div id="faqCL{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="faqHL{{ $faq->id }}" data-bs-parent="#faqAccordionLeft">
                        <div class="accordion-body">
                          {{ $faq->answer }}
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
            
            <!-- Right Column accordion -->
            <div class="col-md-6">
              <div class="accordion" id="faqAccordionRight">
                @foreach ($faqs as $index => $faq)
                  @if ($index % 2 != 0)
                    <div class="accordion-item faq-item">
                      <h3 class="accordion-header" id="faqHR{{ $faq->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCR{{ $faq->id }}" aria-expanded="false" aria-controls="faqCR{{ $faq->id }}">
                          {{ $faq->question }}
                        </button>
                      </h3>
                      <div id="faqCR{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="faqHR{{ $faq->id }}" data-bs-parent="#faqAccordionRight">
                        <div class="accordion-body">
                          {{ $faq->answer }}
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endif

      <!-- Bottom final CTA conversion card -->
      <div class="pricing-footer-cta-card mt-100" data-aos="fade-up">
        <div class="row align-items-center">
          <div class="col-lg-7 d-flex align-items-center mb-4 mb-lg-0">
            <div class="cta-store-icon me-4 d-none d-sm-block">
              <div class="roof-span"></div>
              <div class="window-span"></div>
            </div>
            <div class="cta-text">
              <h3>Ready to Launch Your Store?</h3>
              <p>Join thousands of successful entrepreneurs. Start your free trial today — no credit card required.</p>
            </div>
          </div>
          <div class="col-lg-5 text-lg-end">
            <div class="cta-buttons-wrapper d-flex justify-content-lg-end justify-content-center">
              <div class="cta-btn-block">
@php
                  $trialPackage = \App\Models\Package::where('status','1')->where('is_trial','1')->orderBy('price','asc')->first();
                  $trialLink = $trialPackage
                    ? ($selectedTemplate 
                        ? route('front.register.view', ['status' => 'trial', 'id' => $trialPackage->id]) . '?template=' . urlencode($selectedTemplate)
                        : route('front.select.template', ['status' => 'trial', 'id' => $trialPackage->id]))
                    : route('front.pricing');
                @endphp
                <a href="{{ $trialLink }}" class="btn-pricing-action btn-orange-filled px-4">
                  Start Free Trial <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <span class="btn-subtext">{{ $trialPackage ? $trialPackage->trial_days.'-day free trial' : '14-day free trial' }}</span>
              </div>
              <div class="cta-btn-block ms-3">
                <a href="{{ route('front.templates.view') }}" class="btn-pricing-action btn-white-outline px-4">
                  Browse Themes
                </a>
                <span class="btn-subtext">Find your perfect look</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
    document.addEventListener('click', function (event) {
      const toggleButton = event.target.closest('.pricing-feature-toggle');

      if (!toggleButton) {
        return;
      }

      const card = toggleButton.closest('.pricing-card-modern');
      if (!card) {
        return;
      }

      const extraFeatures = card.querySelector('.pricing-features-extra');
      if (!extraFeatures) {
        return;
      }

      const isExpanded = card.classList.toggle('expanded');
      toggleButton.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');

      const moreLabel = toggleButton.querySelector('.show-more-label');
      const lessLabel = toggleButton.querySelector('.show-less-label');

      if (moreLabel && lessLabel) {
        moreLabel.classList.toggle('d-none', isExpanded);
        lessLabel.classList.toggle('d-none', !isExpanded);
      }

      extraFeatures.setAttribute('aria-hidden', isExpanded ? 'false' : 'true');
    });

    document.addEventListener('DOMContentLoaded', function () {
      const hiddenRows = document.getElementById('compare-features-hidden-rows');
      const toggleBtn = document.getElementById('btn-toggle-compare-rows');
      if (hiddenRows && toggleBtn) {
        hiddenRows.addEventListener('shown.bs.collapse', function () {
          toggleBtn.innerHTML = 'Show Less Features <i class="fas fa-chevron-up ms-2"></i>';
        });
        hiddenRows.addEventListener('hidden.bs.collapse', function () {
          toggleBtn.innerHTML = 'View More Features <i class="fas fa-chevron-down ms-2"></i>';
        });
      }
    });
  </script>

@endsection
