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
    padding: 60px 0 100px;
  }

  /* ── Toggle pill tabs ── */
  .pricing-toggle-wrap {
    text-align: center;
    margin-bottom: 48px;
  }
  .pricing-save-badge {
    display: inline-block;
    background: linear-gradient(135deg, #ff5a2c, #ff8c00);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 16px;
    letter-spacing: 0.5px;
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
    background: linear-gradient(135deg, #ff5a2c, #ff8c00);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(255,90,44,0.3);
  }

  /* ── Discount Tooltip ── */
  .yearly-save-tooltip {
    background: #10b981;
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    padding: 6px 14px;
    border-radius: 30px;
    position: absolute;
    top: -42px;
    right: -10px;
    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    z-index: 10;
    animation: floatTooltip 3s ease-in-out infinite;
  }
  .yearly-save-tooltip::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 75%;
    transform: translateX(-50%);
    border-width: 6px 6px 0;
    border-style: solid;
    border-color: #10b981 transparent transparent;
  }
  @keyframes floatTooltip {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
  }

  /* ── Cards grid ── */
  .pricing-cards-row {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    flex-wrap: wrap;
    justify-content: center;
  }

  .pricing-card-v2 {
    flex: 1 1 220px;
    max-width: 270px;
    background: #ffffff;
   border: 2px solid #252627;
    border-radius: 20px;
    padding: 28px 22px 24px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    color: #1e293b;
  }
  .pricing-card-v2:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
  }

  /* Recommended (Standard) → golden gradient card */
  .pricing-card-v2.card-recommended {
    background: linear-gradient(160deg, #b8600a 0%, #d4860f 100%);
    border: 2px solid #ff5a2c;
    box-shadow: 0 12px 40px rgba(212,134,15,0.25);
    color: #fff;
  }
  /* Best Value (Premium) → orange gradient card */
  .pricing-card-v2.card-best-value {
    background: linear-gradient(160deg, #ff5a2c 0%, #ff8c00 100%);
    border: 2px solid #d4860f;
    box-shadow: 0 12px 40px rgba(255,90,44,0.25);
    color: #fff;
  }
  /* Enterprise white card */
  .pricing-card-v2.card-enterprise {
    background: #ffffff;
  }
  .plan-v2-wa-btn {
    width: 50px;
    height: 48px;
    border-radius: 12px;
    background: #25D366;
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
    background: #20ba58;
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
  .badge-recommended { background: linear-gradient(135deg, #ff5a2c, #ff8c00); color: #fff; }
  .badge-best-value   { background: linear-gradient(135deg, #b8600a, #d4860f); color: #fff; }


  /* Plan title */
  .plan-v2-title {
    font-size: 22px;
    font-weight: 800;
    margin: 12px 0 4px;
    color: #0f172a;
    text-align: center;
  }
  .card-recommended .plan-v2-title,
  .card-best-value  .plan-v2-title {
    color: #ffffff;
  }
  .plan-v2-subtitle {
    font-size: 12px;
    color: #64748b;
    text-align: center;
    margin-bottom: 14px;
  }
  .card-recommended .plan-v2-subtitle,
  .card-best-value  .plan-v2-subtitle {
    color: rgba(255,255,255,0.85);
  }

  /* Price block */
  .plan-v2-price-block {
    text-align: center;
    margin-bottom: 6px;
  }
  .plan-v2-currency { font-size: 18px; font-weight: 700; vertical-align: top; margin-top: 6px; display: inline-block; color: #475569; }
  .plan-v2-amount   { font-size: 44px; font-weight: 900; line-height: 1; color: #0f172a; }
  .plan-v2-period   { font-size: 13px; font-weight: 500; color: #475569; }
  .card-recommended .plan-v2-currency,
  .card-recommended .plan-v2-amount,
  .card-recommended .plan-v2-period,
  .card-best-value .plan-v2-currency,
  .card-best-value .plan-v2-amount,
  .card-best-value .plan-v2-period {
    color: #ffffff;
  }

  .plan-v2-billing-note {
    font-size: 11px;
    color: #64748b;
    text-align: center;
    margin-bottom: 18px;
  }
  .card-recommended .plan-v2-billing-note,
  .card-best-value  .plan-v2-billing-note {
    color: rgba(255,255,255,0.8);
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
  .card-recommended .plan-v2-features li,
  .card-best-value  .plan-v2-features li {
    color: #ffffff;
  }

  /* Check/Cross icons */
  .plan-v2-features li .fi-check {
    background: #ff5a2c;
    color: #fff;
    border-radius: 50%;
    padding: 3px;
    font-size: 8px;
    width: 16px;
    height: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
  }
  .card-recommended .plan-v2-features li .fi-check,
  .card-best-value  .plan-v2-features li .fi-check {
    background: transparent;
    color: #ffffff;
    padding: 0;
    width: auto;
    height: auto;
    font-size: 13px;
  }
  .plan-v2-features li .fi-times {
    background: #f1f5f9;
    color: #ef4444;
    border-radius: 50%;
    padding: 3px;
    font-size: 8px;
    width: 16px;
    height: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
  }
  .card-recommended .plan-v2-features li .fi-times,
  .card-best-value  .plan-v2-features li .fi-times {
    background: transparent;
    color: rgba(255,255,255,0.6);
    padding: 0;
    width: auto;
    height: auto;
    font-size: 13px;
  }
  .plan-v2-features li.feat-disabled > span:last-child {
    text-decoration: line-through;
    opacity: 0.6;
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
    color: #ff5a2c;
    margin-bottom: 14px;
  }
  .card-recommended .plan-v2-see-more,
  .card-best-value  .plan-v2-see-more { color: #fff; }
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
  }
  .btn-v2-outline {
    background: transparent;
    border-color: #ff5a2c;
    color: #ff5a2c;
  }
  .btn-v2-outline:hover { background: #ff5a2c; color: #fff; }
  
  .card-recommended .plan-v2-btn {
    background: #fff;
    color: #b8600a;
    border-color: #fff;
  }
  .card-recommended .plan-v2-btn:hover { background: #fef3c7; }
  
  .card-best-value .plan-v2-btn {
    background: #fff;
    color: #ff5a2c;
    border-color: #fff;
  }
  .card-best-value .plan-v2-btn:hover { background: #ffe8e0; }

  .card-enterprise .plan-v2-btn {
    background: #ff5a2c;
    color: #fff;
    border-color: #ff5a2c;
  }
  .card-enterprise .plan-v2-btn:hover { background: #e04d24; border-color: #e04d24; }

  /* Divider line above features */
  .plan-v2-divider {
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 14px 0 14px;
  }
  .card-recommended .plan-v2-divider,
  .card-best-value .plan-v2-divider {
    border-top-color: rgba(255,255,255,0.12);
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
    gap: 20px;
    flex-wrap: wrap;
  }

  .pricing-v2-trust span { display:flex; align-items:center; gap:6px; }
  .pricing-v2-trust i { color: #22c55e; }

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

      <!-- Hero Header Section -->
      <div class="row align-items-center mb-60 pricing-hero-row">
        <div class="col-lg-6 mb-lg-0">
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
      </div>

      <!-- ─── PRICING V2 SECTION ─── -->
      <div class="pricing-v2-section" data-aos="fade-up">

        <!-- Toggle -->
        <div class="pricing-toggle-wrap" style="text-align: center; margin-bottom: 48px; width: 100%;">
          <div style="position: relative; display: inline-block;">
            @if(in_array('yearly', array_map('strtolower', (array)$terms)))
              <div class="yearly-save-tooltip">Save up to 67% yearly!</div>
            @endif
            <ul class="pricing-pill-tabs nav" id="pricing-tabs" role="tablist" style="margin: 0 auto;">
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
          </div>
        </div>


        <!-- Cards -->
        <div class="tab-content" id="pricing-tabs-content">
          @foreach ($terms as $term)
            @php
              $packages = \App\Models\Package::where('status', '1')->where('term', strtolower($term))->orderBy('price', 'asc')->get();
            @endphp
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                 id="tab-{{ strtolower($term) }}"
                 role="tabpanel">
              <div class="pricing-cards-row">

                @foreach ($packages as $index => $package)
                  @php
                    if (strtolower($term) == 'monthly' && (strtolower($package->title) == 'standard' || strtolower($package->title) == 'premium')) {
                        $package = \App\Models\Package::where('status', '1')
                            ->where('term', 'yearly')
                            ->where('title', $package->title)
                            ->first() ?: $package;
                    }
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
                        $limitFeatures = [];
                        if (!empty($package->categories_limit)) $limitFeatures[] = ['text' => 'Categories Limit : '.($package->categories_limit==999999?'Unlimited':$package->categories_limit), 'has' => true];
                        $limitFeatures[] = ['text' => 'Products Limit : '.($package->product_limit==999999?'Unlimited':$package->product_limit), 'has' => true];
                        if (!empty($package->order_limit)) $limitFeatures[] = ['text' => 'Orders Limit : '.($package->order_limit==999999?'Unlimited':$package->order_limit), 'has' => true];
                        if (!empty($package->language_limit)) $limitFeatures[] = ['text' => 'Additional Languages : '.($package->language_limit==999999?'Unlimited':$package->language_limit), 'has' => true];
                        if (!empty($package->post_limit)) $limitFeatures[] = ['text' => 'Posts Limit : '.($package->post_limit==999999?'Unlimited':$package->post_limit), 'has' => true];
                        if (!empty($package->number_of_custom_page)) $limitFeatures[] = ['text' => 'Custom Pages : '.($package->number_of_custom_page==999999?'Unlimited':$package->number_of_custom_page), 'has' => true];
                        
                        $packageFormattedFeatures = $limitFeatures;
                        
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
                            if ($k !== 'Blog' && $k !== 'Custom Page') {
                                $has = in_array($k, $pFeatures);
                                $packageFormattedFeatures[] = ['text' => $name, 'has' => $has];
                            }
                        }
                    } else {
                        foreach ($allFeatures as $feature) {
                            $has = false;
                            $text = $feature->name;
                            
                            if ($feature->type === 'limit') {
                                $limitVal = $package->{$feature->limit_key} ?? 0;
                                if ($limitVal > 0 || $limitVal == 999999) {
                                    $has = true;
                                    $formattedVal = ($limitVal == 999999) ? __('Unlimited') : $limitVal;
                                    if ($feature->limit_key === 'order_limit' && $limitVal != 999999) {
                                        $formattedVal .= '/' . ($package->term == 'monthly' ? 'm' : 'yr');
                                    }
                                    $text = str_replace('{limit}', $formattedVal, $text);
                                } else {
                                    $text = str_replace('{limit}', '0', $text);
                                }
                            } elseif ($feature->type === 'standard') {
                                $has = in_array($feature->keyword, $pFeatures);
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

                    {{-- Top badge --}}
                    @if($isRecommended)
                      <span class="plan-top-badge badge-recommended">RECOMMENDED</span>
                    @elseif($isBestValue)
                      <span class="plan-top-badge badge-best-value">BEST VALUE</span>
                    @endif

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
                    <p class="plan-v2-billing-note">
                      @if(strtolower($package->term)=='yearly')
                        Billed yearly at {{ $be->base_currency_symbol }}{{ number_format($package->price * 12, 0) }}
                      @elseif(strtolower($package->term)=='monthly')
                        Billed monthly
                      @else
                        One-time access fee
                      @endif
                    </p>


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

                    {{-- CTA --}}
                    <a href="{{ $ctaHref }}" class="plan-v2-btn btn-v2-outline">
                      {{ __('Get') }} {{ __($package->title) }}
                    </a>

                  </div><!-- /.pricing-card-v2 -->
                @endforeach

                @if(strtolower($term) != 'monthly')
                  {{-- Enterprise card --}}
                  <div class="pricing-card-v2 card-enterprise">
                    <h3 class="plan-v2-title">Enterprise</h3>
                    <p class="plan-v2-subtitle">For large &amp; global brands</p>
                    <div class="plan-v2-price-block">
                      <span class="plan-v2-amount" style="font-size:34px;">Custom</span>
                    </div>
                    <p class="plan-v2-billing-note">Tailored to your needs</p>
                    <hr class="plan-v2-divider">
                    <ul class="plan-v2-features">
                      <li><i class="fas fa-check fi-check"></i><span>Everything in Scale</span></li>
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
              <div class="pricing-v2-trust">
                <span><i class="fas fa-shield-alt"></i> 14-day money-back guarantee</span>
                <span><i class="fas fa-times-circle"></i> Cancel anytime</span>
                <span><i class="fas fa-lock"></i> Secure checkout</span>
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
                    @if ($pkg->recommended == '1')
                      <div class="highlight-wrapper">
                        <i class="fas fa-crown text-orange me-1"></i> {{ __($pkg->title) }}
                      </div>
                    @else
                      {{ __($pkg->title) }}
                    @endif
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
