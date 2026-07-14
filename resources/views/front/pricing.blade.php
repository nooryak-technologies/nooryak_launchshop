@extends('front.layout')

@section('pagename')
  - {{ $pageHeading ?? __('Pricing') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->pricing_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->pricing_meta_keywords : '')

@section('styles')
<style>
  /* Hide breadcrumb */
  .page-title-area { display: none !important; }

  /* ── Pricing page wrapper ── */
  .pricing-v2-section {
    padding: 20px 0 60px;
    position: relative;
  }

  /* ── Header Title Centered ── */
  .pricing-centered-header {
    text-align: center;
    margin-bottom: 40px;
  }
  .pricing-tagline {
    font-size: 13px;
    font-weight: 700;
    color: #FF5A2C;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 12px;
    display: block;
  }
  .pricing-main-title {
    font-size: 42px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 12px;
  }
  .pricing-main-title span {
    color: #FF5A2C;
  }
  .pricing-sub-title {
    font-size: 16px;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
  }

  /* Switcher tabs styling */
  .pricing-toggle-wrap {
    text-align: center;
    margin-bottom: 32px;
  }
  .pricing-pill-tabs {
    display: inline-flex;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 50px;
    padding: 4px;
    gap: 2px;
    list-style: none;
    margin: 0 auto;
  }
  .pricing-pill-tabs .nav-item { margin: 0; }
  .pricing-pill-tabs .nav-link {
    border: none;
    border-radius: 50px;
    padding: 10px 28px;
    font-size: 15px;
    font-weight: 700;
    color: #475569;
    background: transparent;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .pricing-pill-tabs .nav-link.active {
    background: #FF5A2C;
    color: #fff !important;
  }
  .pricing-save-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #DCFCE7;
    color: #15803D;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 20px;
    margin-bottom: 14px;
  }
  .pricing-save-badge-pill i {
    font-size: 13px;
  }
  .pricing-yearly-include-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 13px;
    color: #475569;
    margin-top: 14px;
    font-weight: 500;
  }
  .pricing-yearly-include-badge i {
    color: #f97316;
  }

  /* ── Monthly Only Billing note card positioned on the left ── */
  .monthly-only-note-wrapper {
    position: absolute;
    left: -230px;
    top: -50px;
    width: 210px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    z-index: 100;
  }
  .monthly-only-note-card {
    background: #FFF5F2;
    border: 1px solid #FFD3C4;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    gap: 10px;
    text-align: left;
    box-shadow: 0 4px 12px rgba(255,90,44,0.06);
  }
  .monthly-only-note-card i {
    color: #FF5A2C;
    font-size: 18px;
    margin-top: 2px;
    flex-shrink: 0;
  }
  .monthly-only-note-card strong {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2px;
  }
  .monthly-only-note-card span {
    font-size: 11px;
    color: #475569;
    line-height: 1.35;
    display: block;
  }
  .dotted-arrow-svg {
    margin-top: -6px;
    margin-right: 24px;
  }
  @media (max-width: 1200px) {
    .monthly-only-note-wrapper {
      display: none;
    }
  }

  /* ── Cards grid ── */
  .pricing-cards-row {
    display: flex;
    gap: 20px;
    align-items: stretch;
    flex-wrap: wrap;
    justify-content: center;
    position: relative;
  }

  .pricing-card-v2 {
    flex: 1 1 250px;
    max-width: 280px;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 32px 24px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    color: #1e293b;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
  }
  .pricing-card-v2:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.06);
  }

  /* Standard Card recommended */
  .pricing-card-v2.card-recommended {
    border-color: #FF5A2C;
    box-shadow: 0 10px 25px rgba(255,90,44,0.08);
  }
  /* Premium Card best value */
  .pricing-card-v2.card-best-value {
    border-color: #ff9100;
    box-shadow: 0 10px 25px rgba(255,145,0,0.08);
  }

  /* Top badge */
  .plan-top-badge {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    font-size: 10px;
    font-weight: 800;
    padding: 4px 14px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    color: #fff;
  }
  .badge-recommended { background: #FF5A2C; }
  .badge-best-value   { background: #ff9100; }

  /* Plan Icon Circle */
  .plan-icon-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #FFF5F2;
    color: #FF5A2C;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin: 0 auto 16px;
  }

  /* Plan title */
  .plan-v2-title {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 4px;
    color: #0f172a;
    text-align: center;
  }
  .plan-v2-subtitle {
    font-size: 13px;
    color: #64748b;
    text-align: center;
    margin-bottom: 20px;
    height: 38px;
    overflow: hidden;
  }

  /* Price block */
  .plan-v2-price-block {
    text-align: center;
    margin-bottom: 4px;
    display: flex;
    align-items: baseline;
    justify-content: center;
  }
  .plan-v2-currency { font-size: 20px; font-weight: 700; color: #0f172a; margin-right: 4px; }
  .plan-v2-amount   { font-size: 38px; font-weight: 800; color: #0f172a; }
  .plan-v2-period   { font-size: 14px; font-weight: 500; color: #64748b; margin-left: 2px; }

  .plan-v2-billing-note {
    font-size: 11px;
    color: #94a3b8;
    text-align: center;
    margin-bottom: 20px;
  }
  .plan-v2-custom-billing-badge {
    display: inline-block;
    background: #FFF5F2;
    color: #FF5A2C;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 12px;
    margin: 4px auto 0;
  }

  /* Feature list */
  .plan-v2-features {
    list-style: none;
    padding: 0;
    margin: 0 0 16px;
    flex: 1;
  }
  .plan-v2-features li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    padding: 6px 0;
    color: #475569;
  }
  .plan-v2-features li i.fi-check {
    color: #FF5A2C;
    font-size: 13px;
    margin-top: 3px;
  }
  .plan-v2-features li i.fi-times {
    color: #94a3b8;
    font-size: 13px;
    margin-top: 3px;
    opacity: 0.5;
  }
  .plan-v2-features li.feat-disabled > span {
    color: #94a3b8;
  }

  /* See more toggle */
  .plan-v2-see-more {
    background: none;
    border: none;
    padding: 6px 0;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: opacity 0.2s;
    color: #FF5A2C;
    margin-bottom: 14px;
    margin-left: auto;
    margin-right: auto;
  }
  .plan-v2-extra-features {
    display: none;
    overflow: hidden;
  }
  .plan-v2-extra-features.open {
    display: block;
  }

  /* CTA button */
  .plan-v2-btn {
    display: block;
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1.5px solid transparent;
    margin-top: auto;
  }
  .btn-v2-outline {
    background: transparent;
    border-color: #FF5A2C;
    color: #FF5A2C !important;
  }
  .btn-v2-outline:hover {
    background: #FF5A2C;
    color: #fff !important;
  }
  .btn-v2-solid {
    background: #FF5A2C;
    border-color: #FF5A2C;
    color: #fff !important;
  }
  .btn-v2-solid:hover {
    background: #e04d24;
    border-color: #e04d24;
  }
  .btn-v2-outline-dark {
    background: transparent;
    border-color: #cbd5e1;
    color: #475569 !important;
  }
  .btn-v2-outline-dark:hover {
    background: #f8fafc;
    border-color: #94a3b8;
  }

  .plan-v2-wa-btn {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #25D366;
    color: #fff !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: background-color 0.2s;
    flex-shrink: 0;
    text-decoration: none !important;
    border: none;
  }
  .plan-v2-wa-btn:hover {
    background: #20ba58;
  }

  .plan-v2-divider {
    border: none;
    border-top: 1px solid #f1f5f9;
    margin: 16px 0;
  }

  /* Bottom Trust Factors Highlight */
  .pricing-v2-trust-row {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 50px;
    flex-wrap: wrap;
    background: #f8fafc;
    border-radius: 16px;
    padding: 24px;
  }
  .trust-item {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1 1 250px;
    max-width: 320px;
  }
  .trust-icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
  }
  .trust-icon-wrapper.green-circle { background: #DCFCE7; color: #15803D; }
  .trust-icon-wrapper.orange-circle { background: #FFEBE5; color: #FF5A2C; }
  .trust-icon-wrapper.violet-circle { background: #F3E8FF; color: #7E22CE; }
  
  .trust-text-wrapper strong {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
  }
  .trust-text-wrapper span {
    font-size: 11px;
    color: #64748b;
  }

  /* Highlight columns and table cells */
  .compare-table .highlight-column {
    background-color: rgba(255,90,44,0.02) !important;
  }
  .compare-table .highlight-column-header {
    background-color: rgba(255,90,44,0.03) !important;
    border-top: 2px solid #FF5A2C !important;
  }

  /* Responsive */
  @media(max-width:768px) {
    .pricing-card-v2 { max-width: 100%; flex: 1 1 300px; }
    .pricing-cards-row { flex-direction: column; align-items: center; }
  }
</style>
@endsection

@section('content')
@php
  $selectedTemplate = request()->query('template');
  if (\Schema::hasTable('package_features')) {
      $allFeatures = \App\Models\PackageFeature::orderBy('serial_number', 'asc')->get();
  } else {
      $allFeatures = collect();
  }
@endphp

  <!-- Modern Pricing Page wrapper -->
  <div class="modern-pricing-page-wrapper pt-40 pb-120">
    <div class="container">

      <!-- Centered Hero Header Section -->
      <div class="pricing-centered-header" data-aos="fade-up">
        <span class="pricing-tagline">{{ __('Simple, Transparent Pricing') }}</span>
        <h1 class="pricing-main-title">
          Choose the <span>perfect plan</span> for your business
        </h1>
        <p class="pricing-sub-title">
          Launch your store in minutes and scale as your business grows.
        </p>
      </div>

      <!-- ─── PRICING V2 SECTION ─── -->
      <div class="pricing-v2-section" data-aos="fade-up">

        <!-- Toggle Switcher -->
        <div class="pricing-toggle-wrap">
          <div style="position: relative; display: inline-block;">
            @if(in_array('yearly', array_map('strtolower', (array)$terms)))
              <div class="pricing-save-badge-pill">
                <i class="fas fa-tag"></i>
                <span>Save up to 67% with yearly billing!</span>
              </div>
            @endif
            <br>
            <ul class="pricing-pill-tabs nav" id="pricing-tabs" role="tablist">
              @foreach ($terms as $term)
                <li class="nav-item" role="presentation">
                  <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                          id="{{ strtolower($term) }}-tab"
                          data-bs-toggle="pill"
                          data-bs-target="#tab-{{ strtolower($term) }}"
                          type="button"
                          role="tab"
                          aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ __($term) }}
                  </button>
                </li>
              @endforeach
            </ul>
            @if(in_array('yearly', array_map('strtolower', (array)$terms)))
              <div class="pricing-yearly-include-badge">
                <i class="fas fa-gift"></i>
                <span>All yearly plans include a FREE custom domain for 1 year</span>
              </div>
            @endif
          </div>
        </div>

        <!-- Cards -->
        <div class="tab-content" id="pricing-tabs-content">
          @foreach ($terms as $term)
            @php
              $packages = \App\Models\Package::where('status', '1')->where('term', strtolower($term))->orderBy('price', 'asc')->get();
              $isMonthlyTab = (strtolower($term) == 'monthly');
              
              if ($isMonthlyTab) {
                  $newPackages = collect();
                  
                  // 1. Basic (monthly)
                  $basicMonthly = $packages->first(function($p) {
                      return strtolower($p->title) == 'basic';
                  });
                  if ($basicMonthly) {
                      $newPackages->push($basicMonthly);
                  } else {
                      $anyBasic = \App\Models\Package::where('status', '1')->where('title', 'Basic')->first();
                      if ($anyBasic) $newPackages->push($anyBasic);
                  }
                  
                  // 2. Standard (yearly)
                  $stdYearly = \App\Models\Package::where('status', '1')->where('term', 'yearly')->where('title', 'Standard')->first();
                  if ($stdYearly) {
                      $newPackages->push($stdYearly);
                  } else {
                      $stdMonthly = $packages->first(function($p) {
                          return strtolower($p->title) == 'standard';
                      });
                      if ($stdMonthly) $newPackages->push($stdMonthly);
                  }
                  
                  // 3. Premium (yearly)
                  $premYearly = \App\Models\Package::where('status', '1')->where('term', 'yearly')->where('title', 'Premium')->first();
                  if ($premYearly) {
                      $newPackages->push($premYearly);
                  } else {
                      $premMonthly = $packages->first(function($p) {
                          return strtolower($p->title) == 'premium';
                      });
                      if ($premMonthly) $newPackages->push($premMonthly);
                  }
                  
                  $packages = $newPackages;
              }
            @endphp
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                 id="tab-{{ strtolower($term) }}"
                 role="tabpanel"
                 style="position: relative;">

              @if($isMonthlyTab)
                <!-- Dotted Arrow Annotation Popup for Monthly Billing -->
                <div class="monthly-only-note-wrapper">
                  <div class="monthly-only-note-card">
                    <i class="far fa-calendar-alt"></i>
                    <div>
                      <strong>Monthly Billing</strong>
                      <span>Only Basic plan is available with monthly billing.</span>
                    </div>
                  </div>
                  <svg class="dotted-arrow-svg" width="80" height="60" viewBox="0 0 80 60">
                    <path d="M 70 10 Q 35 15 15 50" fill="none" stroke="#FF5A2C" stroke-width="1.5" stroke-dasharray="4" marker-end="url(#arrow)" />
                    <defs>
                      <marker id="arrow" viewBox="0 0 10 10" refX="5" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                        <path d="M 0 0 L 10 5 L 0 10 z" fill="#FF5A2C" />
                      </marker>
                    </defs>
                  </svg>
                </div>
              @endif

              <div class="pricing-cards-row">

                @foreach ($packages as $index => $package)
                  @php
                    $titleKey    = strtolower($package->title);

                    $isRecommended = ($titleKey == 'standard');
                    $isBestValue   = ($titleKey == 'premium');
                    $cardClass     = $isRecommended ? 'card-recommended' : ($isBestValue ? 'card-best-value' : '');

                    // Icon class based on plan title
                    $iconClass = 'fas fa-paper-plane';
                    if ($titleKey == 'standard') {
                        $iconClass = 'fas fa-rocket';
                    } elseif ($titleKey == 'premium') {
                        $iconClass = 'fas fa-crown';
                    }

                    // Subtitle
                    $subtitles = ['basic'=>'Perfect for getting started','standard'=>'Grow your business','premium'=>'For scaling stores'];
                    $planSubtitle = $subtitles[$titleKey] ?? ucfirst($titleKey).' plan';

                    $periodLabel = strtolower($package->term) == 'lifetime' ? 'one-time' : (strtolower($package->term) == 'yearly' ? 'year' : 'month');
                    
                    // Features
                    $pFeatures = json_decode($package->features, true) ?: [];
                    $packageFormattedFeatures = [];
                    
                    if ($allFeatures->isEmpty()) {
                        $packageFormattedFeatures = [];
                        
                        $limitVal = $package->categories_limit ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => '10 Categories', 'has' => true];
                        }
                        $limitVal = $package->product_limit ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => ($limitVal==999999?'Unlimited':$limitVal).' Products', 'has' => true];
                        }
                        $limitVal = $package->order_limit ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => 'Unlimited Orders', 'has' => true];
                        }
                        
                        $fallbackPills = [
                            'Custom Domain' => 'Free Domain (1 Year)',
                            'Subdomain' => 'Subdomain Store',
                            'Google Login' => 'Google Login',
                            'Google Analytics' => 'Google Analytics',
                            'Google Recaptcha' => 'Google Recaptcha',
                        ];
                        foreach ($fallbackPills as $k => $name) {
                            if (in_array($k, $pFeatures)) {
                                $packageFormattedFeatures[] = ['text' => $name, 'has' => true];
                            }
                        }
                    } else {
                        foreach ($allFeatures as $feature) {
                            if ($feature->keyword === 'AI Content & Image Generator' || $feature->name === 'AI Content & Image Generator') {
                                continue;
                            }
                            $has = false;
                            $text = $feature->name;
                            
                            if ($feature->type === 'limit') {
                                $limitVal = $package->{$feature->limit_key} ?? 0;
                                $formattedVal = ($limitVal == 999999) ? __('Unlimited') : $limitVal;
                                if ($feature->limit_key === 'order_limit' && $limitVal != 999999) {
                                    $formattedVal .= '/' . ($package->term == 'monthly' ? 'm' : 'yr');
                                }
                                $text = str_replace('{limit}', $formattedVal, $text);
                                $has = ($limitVal > 0 || $limitVal == 999999);
                            } elseif ($feature->type === 'standard') {
                                $has = in_array($feature->keyword, $pFeatures);
                                if ($has && !empty($feature->limit_key)) {
                                    $limitVal = $package->{$feature->limit_key} ?? 0;
                                    $formattedVal = ($limitVal == 999999) ? __('Unlimited') : $limitVal;
                                    $text = str_replace('{limit}', $formattedVal, $text);
                                } elseif (!empty($feature->limit_key)) {
                                    $limitVal = $package->{$feature->limit_key} ?? 0;
                                    $formattedVal = ($limitVal == 999999) ? __('Unlimited') : $limitVal;
                                    $text = str_replace('{limit}', $formattedVal, $text);
                                }
                            } elseif ($feature->type === 'custom') {
                                $has = in_array($feature->name, $pFeatures);
                            }
                            
                            // Align text names to reference image
                            if (strtolower($text) == 'custom domain' || strtolower($text) == 'free domain') {
                                $text = 'Free Domain (1 Year)';
                            } elseif (stripos($text, 'product') !== false) {
                                $text = ($package->product_limit == 999999 ? 'Unlimited' : $package->product_limit).' Products';
                            } elseif (stripos($text, 'category') !== false) {
                                $text = ($package->categories_limit == 999999 ? 'Unlimited' : $package->categories_limit).' Categories';
                            } elseif (stripos($text, 'order') !== false) {
                                $text = 'Unlimited Orders';
                            }
                            
                            $packageFormattedFeatures[] = ['text' => $text, 'has' => $has];
                        }
                    }

                    // Let's filter to only show positive features (has == true) for clean layout
                    $positiveFeatures = array_filter($packageFormattedFeatures, function($f) {
                        return $f['has'];
                    });

                    // CTA href
                    $ctaHref = $selectedTemplate
                      ? route('front.register.view', ['status'=>'regular','id'=>$package->id]).'?template='.urlencode($selectedTemplate)
                      : route('front.select.template', ['status'=>'regular','id'=>$package->id]);
                  @endphp

                  <div class="pricing-card-v2 {{ $cardClass }}">

                    {{-- Top badge --}}
                    @if($isRecommended)
                      <span class="plan-top-badge badge-recommended">RECOMMENDED</span>
                    @elseif($isBestValue)
                      <span class="plan-top-badge badge-best-value">BEST VALUE</span>
                    @endif

                    {{-- Icon Circle --}}
                    <div class="plan-icon-circle">
                      <i class="{{ $iconClass }}"></i>
                    </div>

                    {{-- Title --}}
                    <h3 class="plan-v2-title">{{ __($package->title) }}</h3>
                    <p class="plan-v2-subtitle">{{ __($planSubtitle) }}</p>

                    {{-- Price --}}
                    <div class="plan-v2-price-block">
                      @if($package->price == 0)
                        <span class="plan-v2-amount">{{ __('Free') }}</span>
                      @else
                        <span class="plan-v2-currency">{{ $be->base_currency_symbol }}</span>
                        <span class="plan-v2-amount">{{ number_format($package->price, 0) }}</span>
                        <span class="plan-v2-period">/ {{ $periodLabel }}</span>
                      @endif
                    </div>
                    
                    <div style="height: 36px; display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
                      @if($titleKey == 'basic' && strtolower($package->term) == 'monthly')
                        <span class="plan-v2-custom-billing-badge">Monthly billing only</span>
                      @endif
                    </div>

                    <hr class="plan-v2-divider">

                    {{-- Features --}}
                    <ul class="plan-v2-features">
                      @foreach($positiveFeatures as $feat)
                        @php
                          $isDomain = (stripos($feat['text'], 'Domain') !== false);
                        @endphp
                        <li>
                          @if($isDomain)
                            <i class="fas fa-globe text-success fi-check"></i>
                            <span style="color: #15803D; font-weight: 700;">{{ __($feat['text']) }}</span>
                          @else
                            <i class="fas fa-check fi-check"></i>
                            <span>{{ __($feat['text']) }}</span>
                          @endif
                        </li>
                      @endforeach
                    </ul>

                    {{-- CTA --}}
                    <a href="{{ $ctaHref }}" class="plan-v2-btn {{ ($isRecommended || $isBestValue) ? 'btn-v2-solid' : 'btn-v2-outline' }}">
                      {{ __('Select') }} {{ __($package->title) }}
                    </a>

                  </div><!-- /.pricing-card-v2 -->
                @endforeach

                @if(!$isMonthlyTab)
                  {{-- Enterprise card --}}
                  <div class="pricing-card-v2 card-enterprise">
                    {{-- Icon Circle --}}
                    <div class="plan-icon-circle">
                      <i class="fas fa-building"></i>
                    </div>

                    <h3 class="plan-v2-title">Enterprise</h3>
                    <p class="plan-v2-subtitle">For large &amp; global brands</p>
                    
                    <div class="plan-v2-price-block">
                      <span class="plan-v2-amount" style="font-size:38px;">Custom</span>
                    </div>
                    
                    <div style="height: 36px; display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
                      <span class="plan-v2-billing-note" style="margin-bottom:0;">Tailored to your needs</span>
                    </div>

                    <hr class="plan-v2-divider">
                    <ul class="plan-v2-features">
                      <li><i class="fas fa-check fi-check"></i><span>Everything in Premium</span></li>
                      <li><i class="fas fa-check fi-check"></i><span>Unlimited Staff Accounts</span></li>
                      <li><i class="fas fa-check fi-check"></i><span>Dedicated Account Manager</span></li>
                      <li><i class="fas fa-check fi-check"></i><span>Custom Integrations</span></li>
                      <li><i class="fas fa-check fi-check"></i><span>SLA &amp; Uptime Guarantee</span></li>
                      <li><i class="fas fa-check fi-check"></i><span>Priority 24/7 Support</span></li>
                    </ul>
                    <div style="display:flex;gap:8px;margin-top:auto;width:100%;">
                      <a href="{{ route('front.contact') }}" class="plan-v2-btn btn-v2-outline-dark" style="flex:1;margin-top:0;">Talk to Sales</a>
                      <a href="https://wa.me/6374913298?text=Hi%2C%20I%20want%20to%20enquire%20about%20the%20Enterprise%20Plan%20for%20LaunchShop." target="_blank" class="plan-v2-wa-btn">
                        <i class="fab fa-whatsapp"></i>
                      </a>
                    </div>
                  </div>
                @endif

              </div><!-- /.pricing-cards-row -->

              <!-- Trust row -->
              <div class="pricing-v2-trust-row">
                <div class="trust-item">
                  <div class="trust-icon-wrapper green-circle"><i class="fas fa-shield-alt"></i></div>
                  <div class="trust-text-wrapper">
                    <strong>14-Day Money Back Guarantee</strong>
                    <span>Risk-free, no questions asked</span>
                  </div>
                </div>
                <div class="trust-item">
                  <div class="trust-icon-wrapper orange-circle"><i class="fas fa-times"></i></div>
                  <div class="trust-text-wrapper">
                    <strong>Cancel Anytime</strong>
                    <span>No lock-in contracts</span>
                  </div>
                </div>
                <div class="trust-item">
                  <div class="trust-icon-wrapper violet-circle"><i class="fas fa-lock"></i></div>
                  <div class="trust-text-wrapper">
                    <strong>Secure Checkout</strong>
                    <span>Your data is 100% safe</span>
                  </div>
                </div>
              </div>

            </div><!-- /.tab-pane -->
          @endforeach
        </div><!-- /.tab-content -->

      </div><!-- /.pricing-v2-section -->

      <!-- Explore Store Designs Banner -->
      <div class="text-center mt-5 mb-5" data-aos="fade-up">
        <div style="display:inline-block; background:linear-gradient(135deg,#fff5f2 0%,#fff9f7 100%); border:2px solid #ff5a2c; border-radius:14px; padding:20px 36px; max-width:560px; box-shadow:0 4px 20px rgba(255,90,44,0.10);">
          <p style="font-size:15px; font-weight:600; color:#4a5568; margin-bottom:10px;">
            {{ __('Looking for a specific store style?') }}
          </p>
          <a href="{{ route('front.templates.view') }}" style="display:inline-flex; align-items:center; gap:8px; background:#ff5a2c; color:#fff; font-size:16px; font-weight:700; padding:12px 28px; border-radius:10px; text-decoration:none; transition:all 0.2s ease; box-shadow:0 4px 14px rgba(255,90,44,0.25);" onmouseover="this.style.background='#e04d24';this.style.boxShadow='0 6px 20px rgba(255,90,44,0.35)';" onmouseout="this.style.background='#ff5a2c';this.style.boxShadow='0 4px 14px rgba(255,90,44,0.25)';">
            <i class="fas fa-palette"></i> {{ __('Explore Store Themes') }} <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Detailed compare plans section -->
      @php
        $comparePackages = \App\Models\Package::where('status', '1')
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('title', 'Basic')->where('term', 'monthly');
                })->orWhere(function($q) {
                    $q->where('title', 'Basic')->where('term', 'yearly');
                })->orWhere(function($q) {
                    $q->where('title', 'Standard')->where('term', 'yearly');
                })->orWhere(function($q) {
                    $q->where('title', 'Premium')->where('term', 'yearly');
                });
            })
            ->orderByRaw("FIELD(title, 'Basic', 'Standard', 'Premium')")
            ->orderByRaw("FIELD(term, 'monthly', 'yearly')")
            ->get();

        if ($comparePackages->isEmpty()) {
            $firstTerm = count($terms) > 0 ? strtolower($terms[0]) : 'monthly';
            $comparePackages = \App\Models\Package::where('status', '1')
                ->where('term', $firstTerm)
                ->orderBy('price', 'asc')
                ->get();
        }

        // Build comparison rows
        $compareRows = [];

        if ($allFeatures->isEmpty()) {
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
            foreach ($allPfeatures as $f) {
                if ($f !== 'Posts Limit') {
                    $compareRows[] = [
                        'type' => 'flag',
                        'label' => $f,
                        'keyword' => $f,
                        'ent_val' => true
                    ];
                }
            }
        } else {
            foreach ($allFeatures as $feature) {
                if ($feature->type === 'limit') {
                    $compareRows[] = [
                        'type' => 'limit',
                        'label' => str_replace('{limit} ', '', $feature->name),
                        'key' => $feature->limit_key,
                        'ent_val' => 'Unlimited'
                    ];
                } else {
                    $compareRows[] = [
                        'type' => 'flag',
                        'label' => $feature->name,
                        'keyword' => $feature->keyword ?: $feature->name,
                        'ent_val' => true
                    ];
                }
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
                <th style="width: 40%;">Features</th>
                @foreach ($comparePackages as $pkg)
                  <th style="text-align: center;" class="{{ $pkg->recommended == '1' ? 'highlight-column-header' : '' }}">
                    <div style="font-size: 15px; font-weight: 700; color: #1e293b;">
                      {{ __($pkg->title) }}
                    </div>
                    <div style="font-size: 11px; font-weight: 600; color: #FF5A2C; text-transform: capitalize; margin-top: 2px;">
                      ({{ __($pkg->term) }})
                    </div>
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @foreach ($visibleCompareRows as $row)
                <tr>
                  <td>{{ __($row['label']) }}</td>
                  @foreach ($comparePackages as $pkg)
                    <td class="text-center {{ $pkg->recommended == '1' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                      @if ($row['type'] == 'limit')
                        @php
                          $val = $pkg->{$row['key']};
                        @endphp
                        {{ $val == 999999 ? __('Unlimited') : ($val ?: '0') }}
                      @else
                        @php
                          $pkgFeats = json_decode($pkg->features, true) ?: [];
                          $hasFeat = in_array($row['keyword'], $pkgFeats);
                        @endphp
                        @if ($hasFeat)
                          <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        @else
                          <span class="feat-check-circle times"><i class="fas fa-times"></i></span>
                        @endif
                      @endif
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
            
            @if (count($hiddenCompareRows) > 0)
              <tbody id="compare-features-hidden-rows" class="compare-rows-hidden">
                @foreach ($hiddenCompareRows as $row)
                  <tr>
                    <td>{{ __($row['label']) }}</td>
                    @foreach ($comparePackages as $pkg)
                      <td class="text-center {{ $pkg->recommended == '1' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                        @if ($row['type'] == 'limit')
                          @php
                            $val = $pkg->{$row['key']};
                          @endphp
                          {{ $val == 999999 ? __('Unlimited') : ($val ?: '0') }}
                        @else
                          @php
                            $pkgFeats = json_decode($pkg->features, true) ?: [];
                            $hasFeat = in_array($row['keyword'], $pkgFeats);
                          @endphp
                          @if ($hasFeat)
                            <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                          @else
                            <span class="feat-check-circle times"><i class="fas fa-times"></i></span>
                          @endif
                        @endif
                      </td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
            @endif
          </table>
        </div>

        @if (count($hiddenCompareRows) > 0)
          <div class="text-center mt-4">
            <button class="btn btn-orange-outline px-4 py-2" type="button" id="btn-toggle-compare-rows" style="font-size:16px; font-weight:700; padding:14px 32px !important; border-radius:10px;">
              View More Features <i class="fas fa-chevron-down ms-2"></i>
            </button>
          </div>
        @endif
      </div>

      @if (count($faqs) > 0)
        <!-- FAQ Section collapse grid -->
        <div class="pricing-faq-section " data-aos="fade-up">
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
      <div class="pricing-footer-cta-card " data-aos="fade-up">
        <div class="row align-items-center">
          <div class="col-lg-7 d-flex align-items-center  mb-lg-0">
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

@endsection

@section('scripts')
<script>
  // ── New V2: See More Features toggle per card ──
  function togglePlanFeatures(pkgId, btn) {
    var $extra = document.getElementById('extra-' + pkgId);
    var $txt   = btn.querySelector('.see-more-txt');
    var $icon  = btn.querySelector('.see-more-icon');
    if (!$extra) return;
    if ($extra.classList.contains('open')) {
      $extra.classList.remove('open');
      $txt.textContent  = 'See More Features';
      $icon.className   = 'fas fa-arrow-right see-more-icon';
      $icon.style.fontSize = '11px';
    } else {
      $extra.classList.add('open');
      $txt.textContent  = 'See Less Features';
      $icon.className   = 'fas fa-arrow-up see-more-icon';
      $icon.style.fontSize = '11px';
    }
  }

  $(document).ready(function() {

    // ── Compare table "View More Features" button ──
    var $tbody     = $('#compare-features-hidden-rows');
    var $toggleBtn = $('#btn-toggle-compare-rows');

    if ($tbody.length && $toggleBtn.length) {
      $tbody.hide();
      $toggleBtn.on('click', function(e) {
        e.preventDefault();
        if ($tbody.is(':visible')) {
          $tbody.find('tr').fadeOut(200);
          setTimeout(function() {
            $tbody.hide();
            $tbody.find('tr').css('display', '');
          }, 220);
          $toggleBtn.html('View More Features <i class="fas fa-chevron-down ms-2"></i>');
        } else {
          $tbody.css('display', 'table-row-group');
          $tbody.find('tr').hide().each(function(i, row) {
            $(row).delay(i * 35).fadeIn(280);
          });
          $toggleBtn.html('Show Less Features <i class="fas fa-chevron-up ms-2"></i>');
        }
      });
    }

  });
</script>
@endsection
