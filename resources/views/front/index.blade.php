@extends('front.layout')

@section('pagename')
  - {{ __('Home') }}
@endsection
@php
  $additional_section_status = json_decode($bs->additional_section_status, true);
@endphp
@section('meta-description', !empty($seo) ? $seo->home_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->home_meta_keywords : '')

@section('content')

  @if ($bs->feature_section == 1)
    <!-- Hero Section Start-->
    <section id="home" class="hero-wrapper">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 col-xl-5 order-2 order-lg-1">
            <div class="hero-content" data-aos="fade-right">
              @if (@$homeSec->hero_section_title)
                <div class="hero-badge">
                  <i class="fas fa-bolt" style="margin-right: 8px;"></i> {{ @$homeSec->hero_section_title }}
                </div>
              @endif
              
              <h1 class="hero-title">Launch Your  <br><span>Online Store</span> In minutes</h1>
              
              <p class="hero-text">{{ @$homeSec->hero_section_desc ?: 'Launch a professional online store in minutes. Choose a theme, pick a plan, get your subdomain and start selling – all without coding.' }}</p>
              
              <div class="d-flex align-items-center gap-3 hero-btns">
                @if (@$homeSec->hero_section_button_url)
                  <a href="{{ @$homeSec->hero_section_button_url }}" class="btn-ls-primary">
                    {{ @$homeSec->hero_section_button_text ?: 'Start Free Trial' }}
                  </a>
                @else
                  <a href="{{ route('front.pricing') }}" class="btn-ls-primary">Start Free Trial <i class="fas fa-arrow-right ms-2"></i></a>
                @endif

                @if (@$homeSec->hero_section_video_url)
                  <a href="{{ @$homeSec->hero_section_video_url }}" class="btn-ls-outline youtube-popup">
                    <i class="fas fa-play-circle me-2"></i> Book a Demo
                  </a>
                @else
                  <a href="{{ route('front.contact') }}" class="btn-ls-outline">
                    <i class="fas fa-play-circle me-2"></i> Book a Demo
                  </a>
                @endif
              </div>

              <div class="hero-features d-none d-md-flex">
                <span><i class="fas fa-check-circle"></i> No Credit Card Required</span>
                <span><i class="fas fa-times-circle" style="color:var(--ls-gray)"></i> Cancel Anytime</span>
                <span><i class="fas fa-calendar-alt"></i> 14-Day Free Trial</span>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-xl-7 order-1 order-lg-2">
            <div class="hero-mockup-wrapper text-center" data-aos="fade-left">
              <img class="img-fluid lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                data-src="{{ asset('images/hero-section.png') }}" 
                alt="Storefront Mockup" style="width: 100%; height: auto; max-width: 100%; display: block; margin: 0 auto;">
            </div>
          </div>
        </div>
        
        <!-- Stats Banner -->
        <div class="row">
          <div class="col-12">
            <div class="hero-stats-banner" data-aos="fade-up">
              <div class="row hero-stats-row justify-content-center">
                <div class="hero-stat-col">
                  <div class="hero-stat-item">
                    <div class="hero-stat-icon icon-stores"><i class="fas fa-shopping-bag"></i></div>
                    <div class="hero-stat-value">10,000+</div>
                    <div class="hero-stat-label">Stores Launched</div>
                  </div>
                </div>
                <div class="hero-stat-col">
                  <div class="hero-stat-item">
                    <div class="hero-stat-icon icon-themes"><i class="fas fa-palette"></i></div>
                    <div class="hero-stat-value">150+</div>
                    <div class="hero-stat-label">Premium Themes</div>
                  </div>
                </div>
                <div class="hero-stat-col">
                  <div class="hero-stat-item">
                    <div class="hero-stat-icon icon-uptime"><i class="fas fa-shield-check"></i></div>
                    <div class="hero-stat-value">99.99%</div>
                    <div class="hero-stat-label">Uptime Guarantee</div>
                  </div>
                </div>
                <div class="hero-stat-col">
                  <div class="hero-stat-item">
                    <div class="hero-stat-icon icon-merchants"><i class="fas fa-users"></i></div>
                    <div class="hero-stat-value">50,000+</div>
                    <div class="hero-stat-label">Happy Merchants</div>
                  </div>
                </div>
                <div class="hero-stat-col">
                  <div class="hero-stat-item">
                    <div class="hero-stat-icon icon-support"><i class="fas fa-heartbeat"></i></div>
                    <div class="hero-stat-value">24/7</div>
                    <div class="hero-stat-label">Expert Support</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Hero Section End -->
  @endif

  @if (count($after_hero) > 0)
    @foreach ($after_hero as $cusHero)
      @if (isset($additional_section_status[$cusHero->id]) && $additional_section_status[$cusHero->id] == 1)
        @php
          $cusHeroContent = App\Models\AdditionalSectionContent::where([
              ['language_id', $lang_id],
              ['addition_section_id', $cusHero->id],
          ])->first();
        @endphp
        @includeIf('front.additional-section', ['data' => $cusHeroContent, 'possition' => $cusHero->possition])
      @endif
    @endforeach
  @endif


  @if ($bs->templates_section == 1)
    <!-- Templates Section Start -->
    <section class="templates-section" id="templates">
      <div class="container">
        <div class="row align-items-center mb-50">
          <div class="col-12 text-center">
            <div class="section-subtitle" data-aos="fade-up">{{ @$homeSec->template_section_title ?: 'Stunning. Modern. Conversion-Focused.' }}</div>
            <h2 class="section-title mb-0" data-aos="fade-up">{!! preg_replace('/(Ecom Store)/i', '<span>$1</span>', e(@$homeSec->template_section_subtitle ?: 'Choose a Theme You Love')) !!}</h2>
          </div>
          <!-- <div class="col-lg-7 text-lg-end mt-4 mt-lg-0" data-aos="fade-up">
            <div class="theme-filters mb-3 mb-lg-0 d-inline-flex">
              <button class="theme-filter-btn active">All</button>
              <button class="theme-filter-btn">Fashion</button>
              <button class="theme-filter-btn">Grocery</button>
              <button class="theme-filter-btn">Electronics</button>
              <button class="theme-filter-btn">Beauty</button>
              <button class="theme-filter-btn">Kids</button>
              <button class="theme-filter-btn">Furniture</button>
              <button class="theme-filter-btn">Pet</button>
              <button class="theme-filter-btn">Jewellery</button>
            </div>
            <a href="#" class="btn-ls-outline ms-lg-3">View All Themes <i class="fas fa-arrow-right ms-2"></i></a>
          </div> -->
        </div>

        @php
          $defaultPackage = \App\Models\Package::where('status', '1')->where('featured', '1')->first();
          $defaultPackageId = $defaultPackage ? $defaultPackage->id : 1;
        @endphp
        <div class="row">
          @foreach ($templates as $template)
            @php
              $themeName = App\Models\User\BasicSetting::where('user_id', $template->id)->pluck('theme')->first();
              
              // Map display name and custom mock names to match reference screenshot perfectly
              $themeTitle = '';
              $themeCat = '';
              $themeBadgeColor = '';
              
              if ($themeName == 'fashion') {
                  $themeTitle = __('Urban Chic');
                  $themeCat = __('Fashion Store');
                  $themeBadgeColor = 'badge-fashion';
              } elseif ($themeName == 'vegetables') {
                  $themeTitle = __('FreshMart');
                  $themeCat = __('Grocery Store');
                  $themeBadgeColor = 'badge-grocery';
              } elseif ($themeName == 'electronics') {
                  $themeTitle = __('TechWave');
                  $themeCat = __('Electronics');
                  $themeBadgeColor = 'badge-electronics';
              } elseif ($themeName == 'beauty' || $themeName == 'cosmetics') {
                  $themeTitle = __('Glow Studio');
                  $themeCat = __('Beauty & Cosmetics');
                  $themeBadgeColor = 'badge-beauty';
              } else {
                  $themeTitle = __(ucfirst($themeName));
                  $themeCat = __(ucfirst($themeName)) . ' ' . __('Store');
                  $themeBadgeColor = 'badge-default';
              }
              
              // Normalize category for jQuery filtering
              $filterCat = strtolower($themeName == 'vegetables' ? 'grocery' : $themeName);
            @endphp
            <div class="col-lg-4 col-md-6 theme-item-col" data-category="{{ $filterCat }}" data-aos="fade-up" data-aos-delay="100">
              <div class="theme-card">
                <div class="theme-card-img-wrap">
                  <img class="theme-card-img lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                    data-src="{{ asset('assets/front/img/template-previews/' . $template->template_img) }}" alt="Theme Image">
                  <div class="theme-card-overlay">
                    <a href="{{ detailsUrl($template) }}" target="_blank" class="btn-overlay-preview">
                      <i class="fas fa-eye me-1"></i> Live Preview
                    </a>
                    <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $defaultPackageId]) }}?template={{ urlencode($template->username) }}" class="btn-overlay-purchase">
                      <i class="fas fa-shopping-cart me-1"></i> Purchase
                    </a>
                  </div>
                </div>
                <div class="theme-card-body">
                  <div>
                    <h3 class="theme-card-title">{{ $themeTitle }}</h3>
                    <span class="theme-card-cat-badge {{ $themeBadgeColor }}">{{ $themeCat }}</span>
                  </div>
                  <div class="theme-card-badge">Premium</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <!-- Templates Section End -->
  @endif

  @if (count($after_template) > 0)
    @foreach ($after_template as $cusTemplate)
      @if (isset($additional_section_status[$cusTemplate->id]) && $additional_section_status[$cusTemplate->id] == 1)
        @php
          $cusTemplateContent = App\Models\AdditionalSectionContent::where([
              ['language_id', $lang_id],
              ['addition_section_id', $cusTemplate->id],
          ])->first();
        @endphp
        @includeIf('front.additional-section', ['data' => $cusTemplateContent, 'possition' => $cusTemplate->possition])
      @endif
    @endforeach
  @endif


  @if ($bs->process_section == 1)
    <!-- How It Works Start -->
    <section class="how-it-works">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div class="section-subtitle" data-aos="fade-up">Simple Steps. Big Results.</div>
            <h2 class="section-title" data-aos="fade-up">{{ @$homeSec->work_process_section_title ?: 'How Launchshop.in Works' }}</h2>
          </div>
        </div>
        <div class="steps-container">
          <div class="steps-line">
            <div class="steps-line-fill"></div>
          </div>
          @foreach ($processes as $index => $process)
            <div class="step-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
              <div class="step-icon-wrap" style="border-color: #{{ $process->color }};">
                <i class="{{ $process->icon }}" style="color: #{{ $process->color }};"></i>
              </div>
              <div class="step-number d-none d-lg-block">{{ $index + 1 }}</div>
              <h3 class="step-title"><span class="d-inline d-lg-none">{{ $index + 1 }}. </span>{{ $process->title }}</h3>
              <p class="step-desc">{{ $process->text }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <!-- How It Works End -->
  @endif

  @if (count($after_work_process) > 0)
    @foreach ($after_work_process as $cusWorkProcess)
      @if (isset($additional_section_status[$cusWorkProcess->id]) && $additional_section_status[$cusWorkProcess->id] == 1)
        @php
          $cusWorkProcessContent = App\Models\AdditionalSectionContent::where([
              ['language_id', $lang_id],
              ['addition_section_id', $cusWorkProcess->id],
          ])->first();
        @endphp
        @includeIf('front.additional-section', ['data' => $cusWorkProcessContent, 'possition' => $cusWorkProcess->possition])
      @endif
    @endforeach
  @endif


  @if ($bs->pricing_section == 1)
    <!-- Pricing Section Start -->
    <section class="pricing-section pb-120">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div class="section-subtitle" data-aos="fade-up">{{ @$homeSec->pricing_section_title ?: 'Simple. Transparent. Scalable.' }}</div>
            <h2 class="section-title" data-aos="fade-up">{{ @$homeSec->pricing_section_subtitle ?: 'Choose the Plan That Grows With You' }}</h2>
          </div>
        </div>

        @php
          $selectedTemplate = request()->query('template');
        @endphp

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
              $packages = \App\Models\Package::where('status', '1')
                  ->where('featured', '1')
                  ->where('term', strtolower($term))
                  ->orderBy('price', 'asc')
                  ->get();
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
                                  <li>
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
                    
                    <div class="card-btn-action d-flex align-items-center gap-2">
                      <a href="{{ route('front.contact') }}" class="btn-pricing-action btn-outline-dark flex-grow-1" style="margin-bottom:0;">
                        Talk to Sales
                      </a>
                      <a href="https://wa.me/{{ $bs->whatsapp_number }}?text=Interested%20with%20CUSTOM%20Plan" target="_blank" class="btn-whatsapp-sales" title="WhatsApp Sales">
                        <i class="fab fa-whatsapp"></i>
                      </a>
                    </div>
                    <p class="trial-label text-center mt-2">Schedule a demo</p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <!-- Pricing Section End -->
  @endif

  @if (count($after_pricing) > 0)
    @foreach ($after_pricing as $cusPricing)
      @if (isset($additional_section_status[$cusPricing->id]) && $additional_section_status[$cusPricing->id] == 1)
        @php
          $cusPricingContent = App\Models\AdditionalSectionContent::where([
              ['language_id', $lang_id],
              ['addition_section_id', $cusPricing->id],
          ])->first();
        @endphp
        @includeIf('front.additional-section', ['data' => $cusPricingContent, 'possition' => $cusPricing->possition])
      @endif
    @endforeach
  @endif


  @if ($bs->intro_section == 1)
    <!-- Features Grid Start -->
    <section class="features-grid">
      <div class="container">
        <div class="row mb-50 text-center">
          <div class="col-12">
            <h2 class="section-title mb-0" data-aos="fade-up">{{ @$homeSec->features_section_subtitle ?: 'Everything You Need. Built-In.' }}</h2>
          </div>
        </div>
        <div class="row">
          @foreach ($features as $feature)
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4" data-aos="fade-up">
              <div class="feature-box h-100 mb-0">
                <div class="feature-icon">
                  @if($feature->icon)
                    <!-- Assuming $feature->icon holds the fontawesome class in DB, else use image -->
                    @if(str_contains($feature->icon, 'fa-') || str_contains($feature->icon, 'flaticon-'))
                      <i class="{{ $feature->icon }}"></i>
                    @else
                      <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}" data-src="{{ asset('assets/front/img/feature/' . $feature->icon) }}" style="width:32px; height:32px; object-fit:contain;" alt="">
                    @endif
                  @else
                    <i class="fas fa-cube"></i>
                  @endif
                </div>
                <h3 class="feature-title">{{ $feature->title }}</h3>
                <p class="feature-desc">{{ $feature->text }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <!-- Features Grid End -->
  @endif

  @if (count($after_features) > 0)
    @foreach ($after_features as $cusFeatures)
      @if (isset($additional_section_status[$cusFeatures->id]) && $additional_section_status[$cusFeatures->id] == 1)
        @php
          $cusFeaturesContent = App\Models\AdditionalSectionContent::where([
              ['language_id', $lang_id],
              ['addition_section_id', $cusFeatures->id],
          ])->first();
        @endphp
        @includeIf('front.additional-section', ['data' => $cusFeaturesContent, 'possition' => $cusFeatures->possition])
      @endif
    @endforeach
  @endif


  <!-- Claim Subdomain Banner -->
  <section class="subdomain-banner">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="subdomain-inner flex-column flex-lg-row text-center text-lg-start" data-aos="fade-up">
            <div class="d-flex align-items-center mb-4 mb-lg-0">
              <div class="subdomain-title-icon" style="width: 50px; height: 50px; border-radius: 50%; background: #ffffff; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                <i class="fas fa-globe" style="font-size: 24px; color: #ff5a2c;"></i>
              </div>
              <div>
                <h3 class="subdomain-title">Claim Your Branded Subdomain</h3>
                <p class="text-white-50 mb-0">Get a professional identity for your store in seconds.</p>
              </div>
            </div>
            <div class="subdomain-check-container mt-3 mt-lg-0">
              <div class="subdomain-input-group" style="max-width: 100%;">
                <span class="domain-prefix">https://</span>
                <input type="text" id="subdomain-input" placeholder="mystore" value="mystore">
                <span class="domain-ext">.launchshop.in</span>
                <button type="button" id="btn-check-availability">
                  <span class="d-none d-md-inline">Check Availability</span>
                  <span class="d-inline d-md-none">Check</span>
                </button>
              </div>
              <div id="subdomain-status" class="subdomain-status-msg text-start mt-2" style="display: none;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Claim Subdomain Banner End -->


  @if ($bs->testimonial_section == 1)
    <!-- Testimonials Start -->
    <section class="testimonials-section">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <h2 class="section-title" data-aos="fade-up">{{ @$homeSec->testimonial_section_title ?: 'Loved by Entrepreneurs. Trusted by Thousands.' }}</h2>
          </div>
        </div>
        <div class="swiper testimonials-slider pb-40" data-aos="fade-up">
          <div class="swiper-wrapper">
            @foreach ($testimonials as $testimonial)
              <div class="swiper-slide">
                <div class="testimonial-card h-100 mb-0">
                  <div class="testi-header">
                    <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                      data-src="{{ $testimonial->image ? asset('assets/front/img/testimonials/' . $testimonial->image) : asset('assets/front/img/thumb-1.jpg') }}"
                      alt="User">
                    <div>
                      <h4 class="testi-name">{{ $testimonial->name }}</h4>
                      <span class="testi-designation">{{ $testimonial->designation }}</span>
                    </div>
                  </div>
                  <p class="testi-text">"{{ $testimonial->comment }}"</p>
                  <div class="testi-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <!-- Pagination -->
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>
    <!-- Testimonials End -->
  @endif

  @if (count($after_testimonial) > 0)
    @foreach ($after_testimonial as $cusTestimonial)
      @if (isset($additional_section_status[$cusTestimonial->id]) && $additional_section_status[$cusTestimonial->id] == 1)
        @php
          $cusTestimonialContent = App\Models\AdditionalSectionContent::where([
              ['language_id', $lang_id],
              ['addition_section_id', $cusTestimonial->id],
          ])->first();
        @endphp
        @includeIf('front.additional-section', ['data' => $cusTestimonialContent, 'possition' => $cusTestimonial->possition])
      @endif
    @endforeach
  @endif

  @if ($bs->partners_section == 1)
    <!-- Brands Banner Start -->
    <section class="brands-banner bg-white">
      <div class="container">
        <h4 class="brands-title">Trusted by 10,000+ amazing brands</h4>
        <div class="brands-marquee">
          <div class="brands-marquee-inner">
            @php
            $svgBrands = [
              /* Amazon */
              ['name'=>'Amazon','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 38"><text x="4" y="28" font-family="Arial Black,Arial" font-weight="900" font-size="26" fill="#232F3E">amazon</text><path d="M8 33 Q34 42 60 33" stroke="#FF9900" stroke-width="3" fill="none" stroke-linecap="round"/><path d="M57 30 L63 33 L57 36" fill="#FF9900"/></svg>'],
              /* Flipkart */
              ['name'=>'Flipkart','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 38"><rect x="0" y="4" width="30" height="30" rx="5" fill="#2874F0"/><text x="3" y="26" font-family="Arial Black" font-weight="900" font-size="20" fill="#fff">F</text><text x="35" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="20" fill="#2874F0">flipkart</text></svg>'],
              /* Shopify */
              ['name'=>'Shopify','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 38"><g transform="translate(2,3)"><path d="M26 6c-.1-.7-.7-1.1-1.2-1.1s-3.9-.3-3.9-.3S19 2.8 18.6 2.4c0 0-.1-.1-.2-.1L17 32l9.9 2.4S26.1 6.7 26 6z" fill="#95BF47"/><path d="M18.6 2.4c-.1-.1-.2-.1-.2-.1l-1.2 29.8 4.2 1c.4-1.1 1.7-5 1.7-5L18.6 2.4z" fill="#5E8E3E"/><path d="M15.1 12.5l-.5-1.5c0 0-1.1.3-2.2 1-.1-1.4.4-2.4 1.5-2.5.4 0 .8.1 1.1.2V7.9c-.3-.1-.7-.1-1.1-.1C10.6 7.8 8.4 10 8.4 13c0 1.9.8 3.3 2.2 4.2L15.1 12.5z" fill="#fff"/></g><text x="32" y="26" font-family="Arial Black,Arial" font-weight="900" font-size="18" fill="#96BF48">shopify</text></svg>'],
              /* Nike */
              ['name'=>'Nike','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 38"><path d="M5 26 Q30 8 65 14 Q80 17 85 12 Q90 8 72 22 Q50 36 5 26z" fill="#111"/></svg>'],
              /* Apple */
              ['name'=>'Apple','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 40"><path d="M31 8c-3.5 0-6 2-7.5 2-1.6 0-4-2-6.8-2C12 8 7 12 7 19c0 8.5 7.5 20 12 20 2 0 3.5-1.5 6-1.5s3.8 1.5 6 1.5c4.8 0 8-5.5 10-11-3-.5-7-3-7-8 0-4.5 3.5-7 5.5-7.5C37.5 9.5 34 8 31 8z" fill="#555"/><path d="M29 4c0 0 3.5-0.5 5 3-1.5 1-5 1-5-3z" fill="#555"/><text x="48" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="18" fill="#111">apple</text></svg>'],
              /* Samsung */
              ['name'=>'Samsung','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 38"><text x="4" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="22" letter-spacing="-1" fill="#1428A0">SAMSUNG</text></svg>'],
              /* Adidas */
              ['name'=>'Adidas','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 38"><polygon points="20,32 36,8 52,32" fill="none" stroke="#000" stroke-width="3.5"/><line x1="16" y1="32" x2="55" y2="32" stroke="#000" stroke-width="3"/><text x="60" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="17" fill="#000">adidas</text></svg>'],
              /* Zara */
              ['name'=>'Zara','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 38"><text x="4" y="28" font-family="Times New Roman,serif" font-weight="700" font-size="28" letter-spacing="4" fill="#111">ZARA</text></svg>'],
              /* H&M */
              ['name'=>'H&amp;M','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 38"><text x="4" y="28" font-family="Arial Black,Arial" font-weight="900" font-size="26" fill="#E50010">H&amp;M</text></svg>'],
              /* Nykaa */
              ['name'=>'Nykaa','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 38"><circle cx="14" cy="19" r="10" fill="#FC2779"/><circle cx="14" cy="19" r="5" fill="#fff"/><text x="30" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="20" fill="#FC2779">nykaa</text></svg>'],
              /* IKEA */
              ['name'=>'IKEA','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 38"><rect x="2" y="4" width="86" height="30" rx="4" fill="#0058A3"/><text x="10" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="22" fill="#FFCC02" letter-spacing="3">IKEA</text></svg>'],
              /* Puma */
              ['name'=>'Puma','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 38"><path d="M8 30 C8 14 18 6 26 10 C30 12 28 18 24 20 C20 22 14 18 18 14 C22 10 28 14 30 20 L35 30" fill="none" stroke="#111" stroke-width="2.5" stroke-linecap="round"/><text x="38" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="20" fill="#111">PUMA</text></svg>'],
              /* Decathlon */
              ['name'=>'Decathlon','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130 38"><rect x="2" y="6" width="26" height="26" rx="4" fill="#0082C9"/><text x="5" y="25" font-family="Arial Black" font-weight="900" font-size="18" fill="#fff">D</text><text x="33" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="17" fill="#0082C9">decathlon</text></svg>'],
              /* Myntra */
              ['name'=>'Myntra','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 38"><path d="M10 28 L10 10 L19 22 L28 10 L28 28" fill="none" stroke="#FF3F6C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><text x="36" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="18" fill="#FF3F6C">myntra</text></svg>'],
              /* Meesho */
              ['name'=>'Meesho','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 38"><text x="4" y="27" font-family="Arial Black,Arial" font-weight="900" font-size="20" fill="#9B4DCA">meesho</text></svg>'],
              /* WooCommerce */
              ['name'=>'WooCommerce','svg'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130 38"><rect x="2" y="4" width="30" height="30" rx="6" fill="#7F54B3"/><text x="6" y="26" font-family="Arial Black" font-weight="900" font-size="18" fill="#fff">W</text><text x="37" y="26" font-family="Arial Black,Arial" font-weight="700" font-size="14" fill="#7F54B3">WooCommerce</text></svg>'],
            ];
            @endphp

            {{-- First copy --}}
            <div class="marquee-content">
              @foreach ($partners as $partner)
                <a href="{{ $partner->url }}" target="_blank" class="brand-item">
                  <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                       data-src="{{ asset('assets/front/img/partners/' . $partner->image) }}" alt="Partner">
                </a>
              @endforeach
              @foreach($svgBrands as $brand)
                <div class="brand-item brand-item-svg" title="{{ $brand['name'] }}">
                  {!! $brand['svg'] !!}
                </div>
              @endforeach
            </div>
            {{-- Duplicate for infinite scroll --}}
            <div class="marquee-content" aria-hidden="true">
              @foreach ($partners as $partner)
                <a href="{{ $partner->url }}" target="_blank" class="brand-item">
                  <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                       data-src="{{ asset('assets/front/img/partners/' . $partner->image) }}" alt="Partner">
                </a>
              @endforeach
              @foreach($svgBrands as $brand)
                <div class="brand-item brand-item-svg" title="{{ $brand['name'] }}">
                  {!! $brand['svg'] !!}
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Brands Banner End -->
  @endif
  
  @if (count($after_partner) > 0)
    @foreach ($after_partner as $cusPartner)
      @if (isset($additional_section_status[$cusPartner->id]) && $additional_section_status[$cusPartner->id] == 1)
        @php
          $cusPartnerContent = App\Models\AdditionalSectionContent::where([
              ['language_id', $lang_id],
              ['addition_section_id', $cusPartner->id],
          ])->first();
        @endphp
        @includeIf('front.additional-section', ['data' => $cusPartnerContent, 'possition' => $cusPartner->possition])
      @endif
    @endforeach
  @endif


  <!-- Bottom CTA Start -->
  <section class="bottom-cta">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8 text-center text-lg-start" data-aos="fade-right">
          <h2 class="cta-title">Ready to Launch Your Dream Store?</h2>
          <p class="cta-text">Join thousands of entrepreneurs who trust Launchshop.in. Start your 14-day free trial today. No credit card required.</p>
          <div class="cta-btns d-flex gap-3 justify-content-center justify-content-lg-start">
            <a href="{{ route('front.pricing') }}" class="btn-ls-primary" style="background:#fff !important; color:var(--ls-primary) !important;">Start Free Trial <i class="fas fa-arrow-right ms-2"></i></a>
            <a href="{{ route('front.contact') }}" class="btn-ls-outline">Book a Demo</a>
          </div>
        </div>
        <div class="col-lg-4 text-center mt-4 mt-lg-0" data-aos="fade-left">
          <img src="https://cdn.pixabay.com/animation/2023/06/13/15/12/15-12-30-710_512.gif" alt="Online Payment" style="width: 100%; max-width: 220px; height: auto; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); border: 2px solid rgba(255,255,255,0.1);">
        </div>
      </div>
    </div>
  </section>
  <!-- Bottom CTA End -->

@section('scripts')
<script>
  $(document).ready(function() {
    // 1. Template filter logic
    $('.theme-filter-btn').on('click', function(e) {
      e.preventDefault();
      $('.theme-filter-btn').removeClass('active');
      $(this).addClass('active');

      let category = $(this).text().toLowerCase().trim();
      if (category === 'all') {
        $('.theme-item-col').fadeIn(300);
      } else {
        $('.theme-item-col').hide();
        $('.theme-item-col[data-category="' + category + '"]').fadeIn(300);
      }
    });

    // 2. Subdomain check availability logic
    function checkSubdomain() {
      let inputVal = $('#subdomain-input').val().trim().toLowerCase();
      // Keep only alphanumeric characters
      inputVal = inputVal.replace(/[^a-z0-9]/g, '');
      $('#subdomain-input').val(inputVal);

      if (inputVal.length === 0) {
        $('#subdomain-status')
          .removeClass('text-success text-danger text-info')
          .addClass('text-warning')
          .html('<i class="fas fa-exclamation-triangle me-1"></i> Please enter a subdomain name.')
          .fadeIn(200);
        return;
      }

      // Show checking loader
      $('#subdomain-status')
        .removeClass('text-success text-danger text-warning text-info')
        .addClass('text-info')
        .html('<i class="fas fa-spinner fa-spin me-1"></i> Checking availability...')
        .fadeIn(200);

      $.get("{{ url('/') }}/check/" + inputVal + '/username', function(isTaken) {
        if (isTaken == true) {
          // Username is already taken
          $('#subdomain-status')
            .removeClass('text-success text-info text-warning')
            .addClass('text-danger')
            .html('<i class="fas fa-times-circle me-1" style="color: #ef4444;"></i> ' + inputVal + '.launchshop.in is already taken!')
            .fadeIn(200);
        } else {
          // Username is available
          $('#subdomain-status')
            .removeClass('text-danger text-info text-warning')
            .addClass('text-success')
            .html('<i class="fas fa-check-circle me-1" style="color: #22c55e;"></i> ' + inputVal + '.launchshop.in is available!')
            .fadeIn(200);
        }
      }).fail(function() {
        $('#subdomain-status')
          .removeClass('text-success text-info')
          .addClass('text-danger')
          .html('<i class="fas fa-times-circle me-1"></i> Error checking availability. Please try again.')
          .fadeIn(200);
      });
    }

    // Trigger check on button click
    $('#btn-check-availability').on('click', function(e) {
      e.preventDefault();
      checkSubdomain();
    });

    // Trigger check on Enter key
    $('#subdomain-input').on('keypress', function(e) {
      if (e.which === 13) {
        e.preventDefault();
        checkSubdomain();
      }
    });

    // Run check availability on initial load if value is present
    if ($('#subdomain-input').val().length > 0) {
      checkSubdomain();
    }

    // 3. Testimonials swiper slider auto scroll
    new Swiper('.testimonials-slider', {
      slidesPerView: 5,
      spaceBetween: 25,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 15
        },
        576: {
          slidesPerView: 2,
          spaceBetween: 20
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 20
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 25
        },
        1200: {
          slidesPerView: 5,
          spaceBetween: 25
        }
      }
    });

    // 13. Smooth transition for pricing feature toggles
    $(document).on('click', '.pricing-feature-toggle', function (e) {
      e.preventDefault();
      var $btn = $(this);
      var $card = $btn.closest('.pricing-card-modern');
      var $extra = $card.find('.pricing-features-extra');
      var $moreLabel = $btn.find('.show-more-label');
      var $lessLabel = $btn.find('.show-less-label');
      
      var isExpanded = $card.hasClass('expanded');
      
      if (isExpanded) {
        $extra.slideUp(400, function() {
          $card.removeClass('expanded');
          $btn.attr('aria-expanded', 'false');
          $moreLabel.removeClass('d-none');
          $lessLabel.addClass('d-none');
        });
      } else {
        $card.addClass('expanded');
        $btn.attr('aria-expanded', 'true');
        $moreLabel.addClass('d-none');
        $lessLabel.removeClass('d-none');
        $extra.hide().slideDown(400);
      }
    });

    // How It Works Step Line Scroll Animation
    function updateStepLine() {
      const container = $('.steps-container');
      if (!container.length) return;

      const isMobile = window.innerWidth <= 991;
      const rect = container[0].getBoundingClientRect();
      const windowHeight = $(window).height();

      // Line starts growing when container's top enters 80% of screen height
      // and is fully filled when container's bottom reaches 20% of screen height
      const startPoint = windowHeight * 0.8;
      const endPoint = windowHeight * 0.2;
      const containerHeight = container.outerHeight();
      const totalDistance = containerHeight + (startPoint - endPoint);

      let progress = (startPoint - rect.top) / totalDistance;
      progress = Math.max(0, Math.min(1, progress));

      const lineFill = $('.steps-line-fill');
      if (lineFill.length) {
        $('.steps-line').css({
          opacity: progress > 0 ? 1 : 0,
          visibility: progress > 0 ? 'visible' : 'hidden'
        });
        if (isMobile) {
          lineFill.css({
            height: (progress * 100) + '%',
            width: '100%'
          });
        } else {
          lineFill.css({
            width: (progress * 100) + '%',
            height: '100%'
          });
        }
      }
    }

    $(window).on('scroll', updateStepLine);
    $(window).on('resize', updateStepLine);
    updateStepLine();
  });
</script>
@endsection

@endsection
