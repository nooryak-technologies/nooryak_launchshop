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

  /* ── Page wrapper ── */
  .modern-pricing-page-wrapper {
    background-color: #fafbfc !important;
  }
  .pricing-v2-section {
    padding: 60px 0 100px;
  }

  /* ── Centered hero header ── */
  .pricing-hero-center {
    text-align: center;
    padding: 56px 0 0;
  }
  .pricing-eyebrow-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #ff5a2c;
    margin-bottom: 14px;
  }
  .pricing-hero-center h1 {
    font-size: 40px;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.15;
    margin-bottom: 14px;
  }
  .pricing-hero-center h1 span {
    color: #ff5a2c;
  }
  .pricing-hero-center h1 strong {
    color: #ff5a2c;
    font-weight: 900;
  }
  .pricing-hero-center .subtitle {
    font-size: 16px;
    color: #64748b;
    margin-bottom: 20px;
  }
  .pricing-save-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #e6faf2;
    color: #059669;
    font-size: 13px;
    font-weight: 700;
    padding: 7px 18px;
    border-radius: 30px;
    margin-bottom: 36px;
    border: 1.5px solid #a7f3d0;
  }

  /* ── Toggle pill tabs ── */
  .pricing-toggle-wrap {
    text-align: center;
    margin-bottom: 48px;
  }
  .pricing-pill-tabs {
    display: inline-flex;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 50px;
    padding: 5px;
    gap: 4px;
    list-style: none;
    margin: 0 auto;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
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
    transition: all 0.25s ease;
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .pricing-pill-tabs .nav-link.active {
    background: #ff5a2c;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(255,90,44,0.25);
  }

  .yearly-free-domain-note {
    font-size: 13px;
    color: #64748b;
    text-align: center;
    margin-bottom: 32px;
  }
  .yearly-free-domain-note span { color: #ff5a2c; font-weight: 700; }

  /* ── Monthly Billing Callout ── */
  .monthly-billing-callout {
    position: absolute;
    left: -240px;
    top: -45px;
    width: 210px;
    background: #fff5f2;
    border: 1px solid #ffd5c8;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 4px 12px rgba(255,90,44,0.05);
    z-index: 10;
    text-align: left;
  }
  .callout-icon-wrap {
    background: #ff5a2c;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
  }
  .callout-title {
    font-size: 13px;
    font-weight: 700;
    margin: 0 0 4px 0;
    color: #0f172a;
  }
  .callout-desc {
    font-size: 11px;
    margin: 0;
    color: #475569;
    line-height: 1.4;
  }
  .callout-arrow {
    position: absolute;
    left: 20px;
    bottom: -45px;
    z-index: 2;
  }

  /* ── Cards grid ── */
  .pricing-cards-row {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    flex-wrap: wrap;
    justify-content: center;
    position: relative;
  }

  .pricing-card-v2 {
    flex: 1 1 210px;
    max-width: 260px;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 20px;
    padding: 28px 22px 24px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    color: #1e293b;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
  }
  .pricing-card-v2:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
  }

  /* Standard card → white bg, orange border (RECOMMENDED) */
  .pricing-card-v2.card-recommended {
    background: #ffffff;
    border: 2px solid #ff5a2c;
    box-shadow: 0 12px 40px rgba(255,90,44,0.12);
    color: #1e293b;
    transform: scale(1.02);
  }
  /* Premium card → white bg, gold border (BEST VALUE) */
  .pricing-card-v2.card-best-value {
    background: #ffffff;
    border: 2px solid #f59e0b;
    box-shadow: 0 12px 40px rgba(245,158,11,0.08);
    color: #1e293b;
  }
  /* Enterprise white card */
  .pricing-card-v2.card-enterprise {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
  }

  .plan-v2-wa-btn {
    width: 50px;
    height: 48px;
    border-radius: 12px;
    background: #22c55e;
    color: #fff !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    transition: transform 0.2s, background-color 0.2s;
    flex-shrink: 0;
    text-decoration: none !important;
    border: none;
    margin-top: auto;
  }
  .plan-v2-wa-btn:hover {
    background: #16a34a;
    transform: scale(1.05);
  }

  /* Top badge */
  .plan-top-badge {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 16px;
    border-radius: 20px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
  .badge-recommended { background: #ff5a2c; color: #fff; }
  .badge-best-value   { background: #f59e0b; color: #fff; }

  /* Plan icon area */
  .plan-v2-icon {
    text-align: center;
    margin: 0 auto 12px;
    width: 56px;
    height: 56px;
    background: #fff3f0;
    color: #ff5a2c;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }

  /* Plan title */
  .plan-v2-title {
    font-size: 22px;
    font-weight: 800;
    margin: 8px 0 4px;
    color: #0f172a;
    text-align: center;
  }
  .plan-v2-subtitle {
    font-size: 12px;
    color: #64748b;
    text-align: center;
    margin-bottom: 14px;
  }

  /* Price block */
  .plan-v2-price-block {
    text-align: center;
    margin-bottom: 4px;
  }
  .plan-v2-currency { font-size: 18px; font-weight: 700; vertical-align: top; margin-top: 8px; display: inline-block; color: #0f172a; }
  .plan-v2-amount   { font-size: 42px; font-weight: 900; line-height: 1; color: #0f172a; }
  .plan-v2-period   { font-size: 13px; font-weight: 500; color: #64748b; }

  .plan-v2-billing-note {
    font-size: 11px;
    color: #64748b;
    text-align: center;
    margin-bottom: 18px;
    padding: 3px 10px;
    border-radius: 20px;
  }
  /* Monthly billing badge on basic */
  .plan-monthly-badge {
    display: inline-block;
    background: #fff3f0;
    color: #ff5a2c;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
    border: 1px solid #ffd5c8;
    margin-bottom: 12px;
  }

  /* Feature list */
  .plan-v2-features {
    list-style: none;
    padding: 0;
    margin: 0 0 4px;
    flex: 1;
  }
  .plan-v2-features li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    padding: 4px 0;
    color: #334155;
  }

  /* Check icons */
  .plan-v2-features li .fi-check {
    color: #ff5a2c;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 1px;
  }
  /* Unavailable features: line-through text, muted X icon */
  .plan-v2-features li.feat-disabled {
    opacity: 0.55;
  }
  .plan-v2-features li.feat-disabled > span:last-child {
    text-decoration: line-through;
  }
  .plan-v2-features li .fi-times {
    color: #ef4444;
    font-size: 12px;
    flex-shrink: 0;
    margin-top: 1px;
  }

  /* Free domain highlight row */
  .plan-v2-features li.feat-free-domain {
    color: #059669;
    font-weight: 700;
  }

  /* See more toggle */
  .plan-v2-see-more {
    background: none;
    border: none;
    padding: 6px 0;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: opacity 0.2s;
    color: #ff5a2c;
    margin-bottom: 14px;
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
    padding: 13px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    margin-top: auto;
    cursor: pointer;
  }
  /* Basic & Enterprise outline button */
  .btn-v2-outline {
    background: transparent;
    border-color: #ff5a2c;
    color: #ff5a2c;
  }
  .btn-v2-outline:hover { background: #ff5a2c; color: #fff; }

  /* Standard & Premium solid orange button */
  .card-recommended .plan-v2-btn,
  .card-best-value .plan-v2-btn {
    background: #ff5a2c;
    color: #ffffff;
    border-color: #ff5a2c;
  }
  .card-recommended .plan-v2-btn:hover,
  .card-best-value .plan-v2-btn:hover {
    background: #e04d24;
    border-color: #e04d24;
    color: #ffffff;
  }

  /* Enterprise button */
  .card-enterprise .plan-v2-btn {
    background: transparent;
    border-color: #cbd5e1;
    color: #334155;
  }
  .card-enterprise .plan-v2-btn:hover { background: #cbd5e1; color: #334155; }

  /* Divider line above features */
  .plan-v2-divider {
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 14px 0 14px;
  }

  /* Trust row below cards */
  .pricing-v2-trust {
    text-align: center;
    margin-top: 28px;
    font-size: 13px;
    color: #64748b;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 36px;
    flex-wrap: wrap;
  }
  .pricing-v2-trust span { display:flex; align-items:center; gap:8px; font-weight: 600; }
  .pricing-v2-trust .trust-icon { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; }
  .trust-icon.green { background: #e6faf2; color: #059669; }
  .trust-icon.red   { background: #fee2e2; color: #ef4444; }
  .trust-icon.blue  { background: #eff6ff; color: #3b82f6; }

  /* Responsive */
  @media(max-width:1200px) {
    .monthly-billing-callout {
      position: relative;
      left: auto;
      top: auto;
      margin: 0 auto 24px;
      width: 100%;
      max-width: 280px;
    }
    .monthly-billing-callout .callout-arrow {
      display: none !important;
    }
  }
  @media(max-width:768px) {
    .pricing-card-v2 { max-width: 100%; flex: 1 1 300px; }
    .pricing-cards-row { flex-direction: column; align-items: center; }
    .pricing-hero-center h1 { font-size: 28px; }
    .card-recommended { transform: none; }
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

      <!-- Hero Header Section – centered to match reference -->
      <div class="pricing-hero-center" data-aos="fade-up">
        <div class="pricing-eyebrow-badge">SIMPLE, TRANSPARENT PRICING</div>
        <h1>Choose the <span>perfect plan</span> for your business</h1>
        <p class="subtitle">Launch your store in minutes and scale as your business grows.</p>
        @if(in_array('yearly', array_map('strtolower', (array)$terms)))
          <div class="pricing-save-pill">
            🏷️ Save up to 67% with yearly billing!
          </div>
        @endif
      </div>

      <!-- ─── PRICING V2 SECTION ─── -->
      <div class="pricing-v2-section" data-aos="fade-up">

        <!-- Toggle -->
        <div class="pricing-toggle-wrap">
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
                  {{ __(ucfirst(strtolower($term))) }}
                </button>
              </li>
            @endforeach
          </ul>
          @if(in_array('yearly', array_map('strtolower', (array)$terms)))
            <p class="yearly-free-domain-note mt-3">🎁 All yearly plans include a <span>FREE custom domain</span> for 1 year</p>
          @endif
        </div>


        <!-- Cards -->
        <div class="tab-content" id="pricing-tabs-content">
          @foreach ($terms as $term)
            @php
              $packages = \App\Models\Package::where('status', '1')->where('term', strtolower($term))->orderBy('price', 'asc')->get();
              if (strtolower($term) == 'monthly') {
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
                 role="tabpanel">
              <div class="pricing-cards-row">

                @foreach ($packages as $index => $package)
                  @php
                    $titleKey    = strtolower($package->title);

                    $isRecommended = ($titleKey == 'standard');
                    $isBestValue   = ($titleKey == 'premium');
                    $cardClass     = $isRecommended ? 'card-recommended' : ($isBestValue ? 'card-best-value' : '');

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
                            $packageFormattedFeatures[] = ['text' => 'Categories Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                        }
                        $limitVal = $package->product_limit ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => 'Products Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                        }
                        $limitVal = $package->order_limit ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => 'Orders Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                        }
                        $limitVal = $package->language_limit ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => 'Additional Languages : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                        }
                        $limitVal = $package->post_limit ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => 'Posts Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                        }
                        $limitVal = $package->number_of_custom_page ?? 0;
                        if ($limitVal > 0 || $limitVal == 999999) {
                            $packageFormattedFeatures[] = ['text' => 'Custom Pages : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                        }
                        
                        $fallbackPills = [
                            'Custom Domain' => 'Custom Domain',
                            'Subdomain' => 'Subdomain',
                            'QR Builder' => 'QR Builder',
                            'Blog' => 'Blog',
                            'Custom Page' => 'Custom Page',
                            'Google Login' => 'Google Login',
                            'Google Analytics' => 'Google Analytics',
                            'Facebook Pixel' => 'Facebook Pixel',
                            'Google Recaptcha' => 'Google Recaptcha',
                            'WhatsApp Chat Button' => 'WhatsApp Chat Button',
                            'Tawk to' => 'Tawk to',
                            'Disqus' => 'Disqus',
                            'AI Content & Image Generator' => 'AI Content & Image Generator'
                        ];
                        foreach ($fallbackPills as $k => $name) {
                            if ($k === 'AI Content & Image Generator') {
                                continue;
                            }
                            if ($k !== 'Blog' && $k !== 'Custom Page') {
                                if (in_array($k, $pFeatures)) {
                                    $packageFormattedFeatures[] = ['text' => $name, 'has' => true];
                                }
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
                            
                            $packageFormattedFeatures[] = ['text' => $text, 'has' => $has];
                        }
                    }

                    $visibleCount = 5;
                    $visibleFeats = array_slice($packageFormattedFeatures, 0, $visibleCount);
                    $extraFeats   = array_slice($packageFormattedFeatures, $visibleCount);

                    // CTA href
                    if ($package->is_trial === '1' && $package->price != 0) {
                      $ctaHref = $selectedTemplate
                        ? route('front.register.view', ['status'=>'regular','id'=>$package->id]).'?template='.urlencode($selectedTemplate)
                        : route('front.select.template', ['status'=>'regular','id'=>$package->id]);
                    } elseif ($package->price == 0) {
                      $ctaHref = $selectedTemplate
                        ? route('front.register.view', ['status'=>'regular','id'=>$package->id]).'?template='.urlencode($selectedTemplate)
                        : route('front.select.template', ['status'=>'regular','id'=>$package->id]);
                    } else {
                      $ctaHref = $selectedTemplate
                        ? route('front.register.view', ['status'=>'regular','id'=>$package->id]).'?template='.urlencode($selectedTemplate)
                        : route('front.select.template', ['status'=>'regular','id'=>$package->id]);
                    }
                  @endphp

                  <div class="pricing-card-v2 {{ $cardClass }}">
                    @if($titleKey == 'basic')
                      <!-- Monthly Billing Callout Box -->
                      <div class="monthly-billing-callout d-none d-lg-block">
                        <div class="d-flex align-items-start gap-2">
                          <div class="callout-icon-wrap">
                            <i class="far fa-calendar-alt"></i>
                          </div>
                          <div class="callout-text">
                            <h5 class="callout-title">Monthly Billing</h5>
                            <p class="callout-desc">Only Basic plan is available with monthly billing.</p>
                          </div>
                        </div>
                        <div class="callout-arrow">
                          <svg width="220" height="50" viewBox="0 0 220 50" fill="none">
                            <path d="M10,0 C10,35 150,45 205,45" stroke="#ff5a2c" stroke-dasharray="4,4" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M197,39 L207,45 L197,51" stroke="#ff5a2c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                          </svg>
                        </div>
                      </div>
                    @endif

                    {{-- Top badge --}}
                    @if($isRecommended)
                      <span class="plan-top-badge badge-recommended">RECOMMENDED</span>
                    @elseif($isBestValue)
                      <span class="plan-top-badge badge-best-value">BEST VALUE</span>
                    @endif

                    {{-- Icon --}}
                    <div class="plan-v2-icon">
                      @if($titleKey == 'basic') <i class="fas fa-paper-plane"></i>
                      @elseif($titleKey == 'standard') <i class="fas fa-rocket"></i>
                      @elseif($titleKey == 'premium') <i class="fas fa-crown"></i>
                      @else <i class="fas fa-building"></i>
                      @endif
                    </div>

                    {{-- Title --}}
                    <h3 class="plan-v2-title">{{ __($package->title) }}</h3>
                    <p class="plan-v2-subtitle">{{ $planSubtitle }}</p>

                    {{-- Price --}}
                    <div class="plan-v2-price-block">
                      @if($package->price == 0)
                        <span class="plan-v2-amount">{{ __('Free') }}</span>
                      @else
                        <span class="plan-v2-currency">{{ $be->base_currency_symbol }}</span><span class="plan-v2-amount">{{ number_format($package->price, 0) }}</span>
                        <span class="plan-v2-period"> / {{ $periodLabel }}</span>
                      @endif
                    </div>
                    @if(strtolower($package->term)=='monthly')
                      <div class="text-center mb-2">
                        <span class="plan-monthly-badge">Monthly billing only</span>
                      </div>
                    @else
                      <p class="plan-v2-billing-note">
                        @if(strtolower($package->term)=='yearly')
                          Billed yearly
                        @else
                          One-time access fee
                        @endif
                      </p>
                    @endif

                    <hr class="plan-v2-divider">

                    {{-- Visible features --}}
                    <ul class="plan-v2-features">
                      @foreach($visibleFeats as $feat)
                        <li class="{{ !$feat['has'] ? 'feat-disabled' : '' }}">
                          @if($feat['has'])
                            <i class="fas fa-check fi-check"></i>
                          @else
                            <i class="fas fa-times fi-times"></i>
                          @endif
                          <span>{{ __($feat['text']) }}</span>
                        </li>
                      @endforeach
                    </ul>

                    {{-- Extra features (collapsed) --}}
                    @php $hasExtra = (count($extraFeats) > 0); @endphp
                    @if($hasExtra)
                      <div class="plan-v2-extra-features" id="extra-{{ strtolower($term) }}-{{ $package->id }}">
                        <ul class="plan-v2-features" style="margin-bottom:8px;">
                          @foreach($extraFeats as $ef)
                            <li class="{{ !$ef['has'] ? 'feat-disabled' : '' }}">
                              @if($ef['has'])
                                <i class="fas fa-check fi-check"></i>
                              @else
                                <i class="fas fa-times fi-times"></i>
                              @endif
                              <span>{{ __($ef['text']) }}</span>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                      <button type="button" class="plan-v2-see-more"
                              onclick="togglePlanFeatures('{{ strtolower($term) }}-{{ $package->id }}', this)">
                        <span class="see-more-txt">See More Features</span>
                        <i class="fas fa-arrow-right see-more-icon" style="font-size:11px;"></i>
                      </button>
                    @endif

                    {{-- CTA Button with correct name --}}
                    <a href="{{ $ctaHref }}" class="plan-v2-btn {{ ($isRecommended || $isBestValue) ? '' : 'btn-v2-outline' }}">
                      Select {{ __($package->title) }}
                    </a>

                  </div><!-- /.pricing-card-v2 -->
                @endforeach

                @if(strtolower($term) != 'monthly')
                {{-- Enterprise card always shown --}}
                  <div class="pricing-card-v2 card-enterprise">
                    <div class="plan-v2-icon" style="color:#ff5a2c;"><i class="fas fa-building"></i></div>
                    <h3 class="plan-v2-title">Enterprise</h3>
                    <p class="plan-v2-subtitle">For large &amp; global brands</p>
                    <div class="plan-v2-price-block">
                      <span class="plan-v2-amount" style="font-size:34px;color:#0f172a;">Custom</span>
                    </div>
                    <p class="plan-v2-billing-note">Tailored to your needs</p>
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
                      <a href="{{ route('front.contact') }}" class="plan-v2-btn" style="flex:1;margin-top:0;">Talk to Sales</a>
                      <a href="https://wa.me/6374913298?text=Hi%2C%20I%20want%20to%20enquire%20about%20the%20Enterprise%20Plan%20for%20LaunchShop." target="_blank" class="plan-v2-wa-btn">
                        <i class="fab fa-whatsapp"></i>
                      </a>
                    </div>
                  </div>
                @endif

              </div><!-- /.pricing-cards-row -->

              <!-- Trust row -->
              <div class="pricing-v2-trust mt-4">
                <span>
                  <span class="trust-icon green"><i class="fas fa-shield-alt"></i></span>
                  <span><strong>14-Day Money Back Guarantee</strong><br><small>Risk-free, no questions asked</small></span>
                </span>
                <span>
                  <span class="trust-icon red"><i class="fas fa-times"></i></span>
                  <span><strong>Cancel Anytime</strong><br><small>No lock-in contracts</small></span>
                </span>
                <span>
                  <span class="trust-icon blue"><i class="fas fa-lock"></i></span>
                  <span><strong>Secure Checkout</strong><br><small>Your data is 100% safe</small></span>
                </span>
              </div>
              <p class="text-center mt-3" style="font-size:12px;color:#94a3b8;">Prices shown are exclusive of applicable taxes.</p>

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
        // Task 2: Show ALL plans – Basic (monthly) + Standard (yearly) + Premium (yearly)
        $comparePackages = collect();
        $basicPkg = \App\Models\Package::where('status','1')->where('title','Basic')->orderBy('price','asc')->first();
        if ($basicPkg) $comparePackages->push($basicPkg);
        $stdPkg = \App\Models\Package::where('status','1')->where('title','Standard')->where('term','yearly')->first();
        if (!$stdPkg) $stdPkg = \App\Models\Package::where('status','1')->where('title','Standard')->first();
        if ($stdPkg) $comparePackages->push($stdPkg);
        $premPkg = \App\Models\Package::where('status','1')->where('title','Premium')->where('term','yearly')->first();
        if (!$premPkg) $premPkg = \App\Models\Package::where('status','1')->where('title','Premium')->first();
        if ($premPkg) $comparePackages->push($premPkg);

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
                <th style="width: 35%;">Features</th>
                @foreach ($comparePackages as $pkg)
                  <th style="text-align: center;" class="{{ strtolower($pkg->title) == 'standard' ? 'highlight-column-header' : '' }}">
                    @if (strtolower($pkg->title) == 'standard')
                      <div class="highlight-wrapper">
                        <i class="fas fa-star text-orange me-1"></i> {{ __($pkg->title) }}
                      </div>
                    @else
                      {{ __($pkg->title) }}
                    @endif
                    <div style="font-size:11px;font-weight:600;color:#94a3b8;">{{ strtolower($pkg->term) == 'monthly' ? 'Monthly' : 'Yearly' }}</div>
                  </th>
                @endforeach
                <th style="text-align:center;">Enterprise</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($visibleCompareRows as $row)
                <tr>
                  <td>{{ __($row['label']) }}</td>
                  @foreach ($comparePackages as $pkg)
                    <td class="text-center {{ strtolower($pkg->title) == 'standard' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                      @if ($row['type'] == 'limit')
                        @php $val = $pkg->{$row['key']}; @endphp
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
                  {{-- Enterprise column: always ✓ for flag rows, Unlimited for limit rows --}}
                  <td class="text-center">
                    @if($row['type'] == 'limit')
                      Unlimited
                    @else
                      <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
            
            @if (count($hiddenCompareRows) > 0)
              <tbody id="compare-features-hidden-rows" class="compare-rows-hidden">
                  @foreach ($hiddenCompareRows as $row)
                  <tr>
                    <td>{{ __($row['label']) }}</td>
                    @foreach ($comparePackages as $pkg)
                      <td class="text-center {{ strtolower($pkg->title) == 'standard' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                        @if ($row['type'] == 'limit')
                          @php $val = $pkg->{$row['key']}; @endphp
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
                    {{-- Enterprise column --}}
                    <td class="text-center">
                      @if($row['type'] == 'limit')
                        Unlimited
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
