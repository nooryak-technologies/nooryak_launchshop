@extends('front.layout')

@section('pagename')
  - {{ __('Home') }}
@endsection

@section('styles')
<style>
  /* Give longer thumbnail preview */
  .card-image-wrap {
      height: 380px !important;
  }
  .template-card-modern:hover .scrolling-img {
      transform: translateY(calc(-100% + 380px)) !important;
  }
  /* Shorten the card preview container for the 4-column duplicated section on Home */
  #templates-duplicate .card-image-wrap {
      height: 280px !important;
  }
  #templates-duplicate .template-card-modern:hover .scrolling-img {
      transform: translateY(calc(-100% + 280px)) !important;
  }
  .btn-template-action.admin-btn {
      background: #0e1b3d;
      color: #ffffff;
      border: 1px solid #0e1b3d;
  }
  .btn-template-action.admin-btn:hover {
      background: #1e293b;
      border-color: #1e293b;
      color: #ffffff;
  }
  .btn-template-action {
      padding: 8px 4px !important;
      font-size: 13px !important;
      white-space: nowrap !important;
  }
  .card-action-row {
      display: flex !important;
      flex-direction: column !important;
      gap: 8px !important;
  }
  /* Steps & Stats Section Styles */
  .steps-stats-section {
    background: #ffffff;
    padding: 80px 0;
    font-family: 'Outfit', 'Inter', sans-serif;
  }
  .rocket-visual-wrap {
    position: relative;
    display: inline-block;
  }
  .rocket-main-img {
    max-width: 100%;
    height: auto;
    animation: floatRocket 4s ease-in-out infinite;
  }
  @keyframes floatRocket {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
  .steps-badge {
    background: #fff5f2;
    color: #ff5a2c;
    font-size: 14px;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 50px;
    border: 1px solid rgba(255, 90, 44, 0.1);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
  }
  .steps-main-title {
    font-size: 38px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.25;
  }
  .step-item-custom {
    gap: 16px;
  }
  .step-icon-container {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }
  .step-icon-orange {
    background: #fff5f2;
    color: #ff5a2c;
    border: 1px solid rgba(255, 90, 44, 0.15);
  }
  .step-icon-pink {
    background: #fdf2f8;
    color: #db2777;
    border: 1px solid rgba(219, 39, 119, 0.15);
  }
  .step-icon-green {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid rgba(22, 163, 74, 0.15);
  }
  .step-icon-blue {
    background: #f0f9ff;
    color: #2563eb;
    border: 1px solid rgba(37, 99, 235, 0.15);
  }
  .step-text-container {
    display: flex;
    flex-direction: column;
    text-align: left;
  }
  .step-item-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 4px;
  }
  .step-item-desc {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    line-height: 1.45;
  }
  .btn-start-journey {
    background: #ff5a2c;
    color: #ffffff !important;
    font-size: 15px;
    font-weight: 700;
    padding: 14px 28px;
    border-radius: 50px;
    border: none;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 14px rgba(255, 90, 44, 0.3);
    transition: all 0.3s ease;
    text-decoration: none !important;
  }
  .btn-start-journey:hover {
    background: #e0481d;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 90, 44, 0.4);
  }
  .stats-bar-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 24px 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
  }
  .stat-item-wrap {
    gap: 16px;
  }
  .stat-bar-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
  }
  .stat-icon-orange {
    background: #fff5f2;
    color: #ff5a2c;
  }
  .stat-icon-pink {
    background: #fdf2f8;
    color: #db2777;
  }
  .stat-icon-blue {
    background: #eff6ff;
    color: #3b82f6;
  }
  .stat-icon-green {
    background: #f0fdf4;
    color: #16a34a;
  }
  .stat-bar-info {
    display: flex;
    flex-direction: column;
    text-align: left;
  }
  .stat-bar-val {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    line-height: 1.1;
  }
  .stat-bar-lbl {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
  }
  @media (max-width: 575px) {
    .steps-stats-section .stats-bar-card {
      padding: 16px 10px !important;
    }
    .steps-stats-section .stat-item-wrap {
      gap: 6px !important;
      justify-content: flex-start;
    }
    .steps-stats-section .stat-bar-icon-box {
      width: 32px !important;
      height: 32px !important;
      font-size: 14px !important;
      border-radius: 8px !important;
    }
    .steps-stats-section .stat-bar-val {
      font-size: 16px !important;
    }
    .steps-stats-section .stat-bar-lbl {
      font-size: 10px !important;
    }
  }
</style>
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
        <div class="row ">
          <div class="col-lg-5 col-xl-5 order-2 order-lg-1">
            <div class="hero-content" data-aos="fade-right">
              <div class="hero-badge">
                <i class="fas fa-bolt" style="margin-right: 8px;"></i> {{ __('Your Platform, Your Success Icon') }}
              </div>
              
              <h1 class="hero-title">Launch Your  <br><span>Online Store In</span> Just 2 minutes</h1>
              
              <p class="hero-text">{{ __('Manage products, payments, and sales effortlessly. Everything you need to grow your business is just a click away. Start today and simplify your e-commerce journey.') }}</p>
              
              <div class="d-flex align-items-center gap-3 hero-btns">
                <a href="{{ route('front.pricing') }}" class="btn-ls-primary">{{ __('Get Started Now') }} <i class="fas fa-arrow-right ms-2"></i></a>

                <a href="{{ route('front.contact') }}" class="btn-ls-outline">
                  <span class="btn-play-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="12" cy="12" r="12" fill="#0F172A"/>
                      <path d="M10 8L16 12L10 16V8Z" fill="white"/>
                    </svg>
                  </span>
                  {{ __('Book a Demo') }}
                </a>
              </div>

              <div class="hero-features d-flex align-items-center">
                <div class="hero-feature-item">
                  <div class="feat-icon-box icon-orange">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M12 22C12 22 20 18 20 12V5L12 2L4 5V12C4 18 12 22 12 22Z" stroke="#FF5A2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9 11L11 13L15 9" stroke="#FF5A2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <div class="feat-content">
                    <div class="feat-title">{{ __('10-Days Money') }}</div>
                    <div class="feat-sub">{{ __('Back Guarantee') }}</div>
                  </div>
                </div>
                <div class="feat-divider"></div>
                <div class="hero-feature-item">
                  <div class="feat-icon-box icon-green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M17.887 6.113c-.933-.933-2.903-1.157-5.111-.643l-4.148 4.148c-.689.69-.747 1.776-.174 2.507l-2.617 2.617a1 1 0 000 1.414l1.414 1.414a1 1 0 001.414 0l2.617-2.617c.731.573 1.817.515 2.507-.174l4.148-4.148c.514-2.208.29-4.178-.643-5.111z" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8.5 15.5L4.5 19.5M15.5 8.5l.01-.01" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <div class="feat-content">
                    <div class="feat-title">{{ __('Launch') }}</div>
                    <div class="feat-sub">{{ __('Instantly') }}</div>
                  </div>
                </div>
                <div class="feat-divider"></div>
                <div class="hero-feature-item">
                  <div class="feat-icon-box icon-blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M3 18V11C3 6.02944 7.02944 2 12 2C16.9706 2 21 6.02944 21 11V18" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M21 19C21 20.1 20.1 21 19 21H17C15.9 21 15 20.1 15 19V15C15 13.9 15.9 13 17 13H21V19Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M3 19C3 20.1 3.9 21 5 21H7C8.1 21 9 20.1 9 15V11C9 9.9 8.1 9 7 9H3V19Z" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <div class="feat-content">
                    <div class="feat-title">{{ __('24/7 Expert') }}</div>
                    <div class="feat-sub">{{ __('Support') }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-xl-7 order-1 order-lg-2 position-relative">
            <div class="hero-mockup-wrapper text-center" data-aos="fade-left">
              <img class="img-fluid lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                data-src="{{ asset('images/hero-section.png') }}" 
                alt="Storefront Mockup" style="width: 100%; height: auto; max-width: 100%; display: block; margin: 0 auto;">

              {{-- ===== Rocket Animation ===== --}}
              <div class="hero-rocket-container" id="heroRocketAnim">
                <div class="rocket-body">
                  {{-- SVG Rocket --}}
                  <svg class="rocket-svg" viewBox="0 0 90 160" xmlns="http://www.w3.org/2000/svg">
                    {{-- Body --}}
                    <ellipse cx="45" cy="85" rx="22" ry="48" fill="#ffffff" stroke="#e2e8f0" stroke-width="2"/>
                    {{-- Nose Cone --}}
                    <path d="M45 10 Q65 35 65 65 Q45 52 25 65 Q25 35 45 10Z" fill="#FF5A2C"/>
                    {{-- Window --}}
                    <circle cx="45" cy="72" r="10" fill="#dbeafe" stroke="#93c5fd" stroke-width="2"/>
                    <circle cx="45" cy="72" r="5" fill="#bfdbfe"/>
                    {{-- Window shine --}}
                    <circle cx="42" cy="69" r="2" fill="rgba(255,255,255,0.7)"/>
                    {{-- Left Fin --}}
                    <path d="M23 108 Q6 125 12 140 L23 125Z" fill="#FF5A2C"/>
                    {{-- Right Fin --}}
                    <path d="M67 108 Q84 125 78 140 L67 125Z" fill="#FF5A2C"/>
                    {{-- Nozzle --}}
                    <rect x="37" y="128" width="16" height="14" rx="4" fill="#94a3b8"/>
                    {{-- Nozzle shine --}}
                    <rect x="39" y="130" width="5" height="10" rx="2" fill="rgba(255,255,255,0.3)"/>
                    {{-- Body stripe --}}
                    <rect x="35" y="92" width="20" height="4" rx="2" fill="#FF5A2C" opacity="0.4"/>
                  </svg>

                  {{-- Fire / Exhaust --}}
                  <div class="rocket-exhaust">
                    <div class="exhaust-flame flame-outer"></div>
                    <div class="exhaust-flame flame-mid"></div>
                    <div class="exhaust-flame flame-inner"></div>
                    <div class="exhaust-spark spark-1"></div>
                    <div class="exhaust-spark spark-2"></div>
                    <div class="exhaust-spark spark-3"></div>
                  </div>
                </div>
              </div>
              {{-- ===== End Rocket ===== --}}
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- Hero Section End -->
  @endif

  @if ($bs->process_section == 1)
    <!-- How It Works Start -->
    <section class="how-it-works-v2" id="how-it-works">
      <div class="container">

        <!-- Stats Banner Row -->
        <div class="hiw-stats-row" data-aos="fade-up">
          <!-- Stat 1 -->
          <div class="hiw-stat-card">
            <div class="hiw-stat-icon hiw-icon-orange">
              <i class="fas fa-store"></i>
            </div>
            <div class="hiw-stat-info">
              <div class="hiw-stat-value"><span class="odometer" data-count="250">0</span>+</div>
              <div class="hiw-stat-label">{{ __('Stores Launched') }}</div>
            </div>
          </div>
          <!-- Divider -->
          <div class="hiw-stat-divider"></div>
          <!-- Stat 2 -->
          <div class="hiw-stat-card">
            <div class="hiw-stat-icon hiw-icon-purple">
              <i class="fas fa-gem"></i>
            </div>
            <div class="hiw-stat-info">
              <div class="hiw-stat-value"><span class="odometer" data-count="15">0</span>+</div>
              <div class="hiw-stat-label">{{ __('Premium Themes') }}</div>
            </div>
          </div>
          <!-- Divider -->
          <div class="hiw-stat-divider"></div>
          <!-- Stat 3 -->
          <div class="hiw-stat-card">
            <div class="hiw-stat-icon hiw-icon-green">
              <i class="fas fa-shield-alt"></i>
            </div>
            <div class="hiw-stat-info">
              <div class="hiw-stat-value"><span class="odometer" data-count="99">0</span>.99%</div>
              <div class="hiw-stat-label">{{ __('Uptime Guarantee') }}</div>
            </div>
          </div>
          <!-- Divider -->
          <div class="hiw-stat-divider"></div>
          <!-- Stat 4 -->
          <div class="hiw-stat-card">
            <div class="hiw-stat-icon hiw-icon-yellow">
              <i class="fas fa-user-friends"></i>
            </div>
            <div class="hiw-stat-info">
              <div class="hiw-stat-value"><span class="odometer" data-count="500">0</span>+</div>
              <div class="hiw-stat-label">{{ __('Happy Merchants') }}</div>
            </div>
          </div>
        </div>

        <!-- Section Title -->
        <div class="hiw-title-wrap" data-aos="fade-up">
          <span class="hiw-decor-dot left"></span>
          <h2 class="hiw-section-title">{{ __('How Launchshop Works') }}</h2>
          <span class="hiw-decor-dot right"></span>
        </div>

        <!-- 5 Steps Row -->
        <div class="hiw-steps-row" data-aos="fade-up">

          <!-- Step 1 -->
          <div class="hiw-step-item">
            <div class="hiw-step-icon-wrap">
              <div class="hiw-step-circle hiw-circle-orange">
                <i class="fas fa-paint-roller"></i>
              </div>
              <div class="hiw-step-badge">1</div>
            </div>
            <h4 class="hiw-step-title">{{ __('Choose a Theme') }}</h4>
            <p class="hiw-step-desc">{{ __('Pick a professional theme that matches your brand.') }}</p>
          </div>

          <!-- Step 2 -->
          <div class="hiw-step-item">
            <div class="hiw-step-icon-wrap">
              <div class="hiw-step-circle hiw-circle-purple">
                <i class="fas fa-cog"></i>
              </div>
              <div class="hiw-step-badge">2</div>
            </div>
            <h4 class="hiw-step-title">{{ __('Customize Your Store') }}</h4>
            <p class="hiw-step-desc">{{ __('Edit colors, fonts, layout and content easily.') }}</p>
          </div>

          <!-- Step 3 -->
          <div class="hiw-step-item">
            <div class="hiw-step-icon-wrap">
              <div class="hiw-step-circle hiw-circle-blue">
                <i class="fas fa-box-open"></i>
              </div>
              <div class="hiw-step-badge">3</div>
            </div>
            <h4 class="hiw-step-title">{{ __('Add Products') }}</h4>
            <p class="hiw-step-desc">{{ __('Upload products, set prices and manage inventory.') }}</p>
          </div>

          <!-- Step 4 -->
          <div class="hiw-step-item">
            <div class="hiw-step-icon-wrap">
              <div class="hiw-step-circle hiw-circle-green">
                <i class="fas fa-credit-card"></i>
              </div>
              <div class="hiw-step-badge">4</div>
            </div>
            <h4 class="hiw-step-title">{{ __('Accept Payments') }}</h4>
            <p class="hiw-step-desc">{{ __('Enable secure payments and shipping options.') }}</p>
          </div>

          <!-- Step 5 -->
          <div class="hiw-step-item">
            <div class="hiw-step-icon-wrap">
              <div class="hiw-step-circle hiw-circle-orange">
                <i class="fas fa-rocket"></i>
              </div>
              <div class="hiw-step-badge">5</div>
            </div>
            <h4 class="hiw-step-title">{{ __('Start Selling') }}</h4>
            <p class="hiw-step-desc">{{ __('Publish your store and start growing your business.') }}</p>
          </div>

        </div>
        <!-- /5 Steps Row -->

      </div>
    </section>
    <!-- How It Works End -->
  @endif

  @if ($bs->templates_section == 1)
    <!-- Templates Section Start -->
    <section class="templates-section" id="templates">
      <div class="container">
        <div class="row align-items-center mb-50">
          <div class="col-12 text-center">
            <div class="templates-badge-wrap" data-aos="fade-up">
              <span class="templates-badge">
                <i class="fas fa-palette me-2"></i>{{ __('50+ Premium Themes') }}
              </span>
            </div>
            <h2 class="section-title mb-3" data-aos="fade-up" style="font-size: 38px; font-weight: 800; color: #1E2335;">{{ __('Professional Themes for Every Industry') }}</h2>
            <p class="section-subtitle-text" data-aos="fade-up" style="font-size: 16px; color: #718096; max-width: 600px; margin: 0 auto 30px;">{{ __('Choose from 50+ premium themes designed for maximum conversions and beautiful user experience.') }}</p>
          </div>
        </div>

        <!-- Filter Buttons -->
        <div class="row mb-50" data-aos="fade-up">
          <div class="col-12 theme-filter-scroll-wrapper d-flex justify-content-center align-items-center gap-2 flex-wrap">
            <button class="theme-filter-btn active" data-category="all">
              <i class="fas fa-th-large me-2"></i>{{ __('All Themes') }}
            </button>
            <button class="theme-filter-btn" data-category="fashion">
              <i class="fas fa-tshirt me-2"></i>{{ __('Fashion') }}
            </button>
            <button class="theme-filter-btn" data-category="electronics">
              <i class="fas fa-laptop me-2"></i>{{ __('Electronics') }}
            </button>
            <button class="theme-filter-btn" data-category="furniture">
              <i class="fas fa-couch me-2"></i>{{ __('Furniture') }}
            </button>
            <button class="theme-filter-btn" data-category="grocery">
              <i class="fas fa-shopping-cart me-2"></i>{{ __('Grocery') }}
            </button>
            <button class="theme-filter-btn" data-category="lifestyle">
              <i class="fas fa-shopping-bag me-2"></i>{{ __('Lifestyle') }}
            </button>
            <button class="theme-filter-btn" data-category="beauty">
              <i class="fas fa-magic me-2"></i>{{ __('Beauty') }}
            </button>
            <div class="dropdown d-inline-block">
              <button class="theme-filter-btn dropdown-toggle" type="button" id="moreCategoriesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                {{ __('More') }} <i class="fas fa-chevron-down ms-1" style="font-size: 10px;"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="moreCategoriesDropdown">
                <li><a class="dropdown-item theme-filter-dropdown-item" href="#" data-category="kids">{{ __('Kids') }}</a></li>
                <li><a class="dropdown-item theme-filter-dropdown-item" href="#" data-category="pet">{{ __('Pet') }}</a></li>
                <li><a class="dropdown-item theme-filter-dropdown-item" href="#" data-category="jewellery">{{ __('Jewellery') }}</a></li>
              </ul>
            </div>
          </div>
        </div>

        @php
          $defaultPackage = \App\Models\Package::where('status', '1')->where('featured', '1')->first();
          $defaultPackageId = $defaultPackage ? $defaultPackage->id : 1;
        @endphp
        <div class="row theme-grid-row">
          @foreach ($templates as $template)
            @php
              $themeName = App\Models\User\BasicSetting::where('user_id', $template->id)->pluck('theme')->first();
              
              // Map display name and custom mock names to match reference screenshot perfectly
              $themeTitle = '';
              $themeCat = '';
              
              if ($themeName == 'fashion') {
                  $themeTitle = __('Urban Style');
                  $themeCat = __('Fashion');
              } elseif ($themeName == 'vegetables') {
                  $themeTitle = __('FreshMart');
                  $themeCat = __('Grocery');
              } elseif ($themeName == 'electronics') {
                  $themeTitle = __('TechHub');
                  $themeCat = __('Electronics');
              } elseif ($themeName == 'beauty' || $themeName == 'cosmetics') {
                  $themeTitle = __('Glow Studio');
                  $themeCat = __('Beauty');
              } elseif ($themeName == 'furniture') {
                  $themeTitle = __('FurniCasa');
                  $themeCat = __('Furniture');
              } else {
                  $themeTitle = __(ucfirst($themeName));
                  $themeCat = __(ucfirst($themeName));
              }
              
              // Normalize category for jQuery filtering
              $filterCat = strtolower($themeName == 'vegetables' ? 'grocery' : ($themeName == 'cosmetics' ? 'beauty' : $themeName));
            @endphp
            <div class="col-lg-3 col-md-6 col-sm-12 theme-item-col mb-4" data-category="{{ $filterCat }}" data-aos="fade-up">
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
                <div class="theme-card-body d-flex justify-content-between align-items-center">
                  <div class="theme-card-info">
                    <h3 class="theme-card-title mb-1">{{ $themeTitle }}</h3>
                    <span class="theme-card-category">{{ $themeCat }}</span>
                  </div>
                  <span class="theme-card-premium-badge">{{ __('Premium') }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- View All Themes Button Wrap -->
        <div class="view-all-themes-btn-wrap d-none" data-aos="fade-up" style="display: flex; justify-content: center; margin-top: 0px;">
          <button id="view-all-themes-btn" class="btn-view-all-themes">
            {{ __('View All Themes') }} <i class="fas fa-arrow-right ms-2"></i>
          </button>
        </div>

        <!-- Bottom Highlights Bar -->
        <div class="row mt-50" data-aos="fade-up">
          <div class="col-12">
            <div class="templates-highlights-bar d-none d-md-flex align-items-center justify-content-center gap-4">
              <div class="highlight-item">
                <i class="fas fa-ribbon me-2"></i> {{ __('Premium Quality') }}
              </div>
              <div class="highlight-divider"></div>
              <div class="highlight-item">
                <i class="fas fa-sync me-2"></i> {{ __('Regular Updates') }}
              </div>
              <div class="highlight-divider"></div>
              <div class="highlight-item">
                <i class="fas fa-headset me-2"></i> {{ __('Lifetime Support') }}
              </div>
              <div class="highlight-divider"></div>
              <div class="highlight-item">
                <i class="fas fa-shield-alt me-2"></i> {{ __('Money-Back Guarantee') }}
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- Templates Section End -->
  @endif

  @if ($bs->templates_section == 1)
    <!-- Duplicated Templates Section Start -->
    <section class="templates-section mt-80" id="templates-duplicate" style="background: #f8fafc; padding: 80px 0;">
      <div class="container">
        <div class="row align-items-center mb-50">
          <div class="col-12 text-center">
            <div class="templates-badge-wrap" data-aos="fade-up">
              <span class="templates-badge">
                <i class="fas fa-palette me-2"></i>{{ __('50+ Premium Themes') }}
              </span>
            </div>
            <h2 class="section-title mb-3 text-center" data-aos="fade-up" style="font-size: 38px; font-weight: 800; color: #1E2335;">{{ __('Professional Themes for Every Industry') }}</h2>
            <p class="section-subtitle-text" data-aos="fade-up" style="font-size: 16px; color: #718096; max-width: 600px; margin: 0 auto 30px;">{{ __('Explore our optimized scrolling templates built for speed, responsiveness, and conversions.') }}</p>
          </div>
        </div>

        <!-- Filter Buttons for the second grid -->
        <div class="row mb-50 templates-filter-section" data-aos="fade-up" data-aos-delay="100">
          <div class="col-12 theme-filter-scroll-wrapper d-flex justify-content-center align-items-center gap-2 flex-wrap">
            <button class="theme-filter-btn theme-filter-btn-duplicate active" data-filter="all">
              <i class="fas fa-th-large me-2"></i>{{ __('All Themes') }}
            </button>
            <button class="theme-filter-btn theme-filter-btn-duplicate" data-filter="fashion">
              <i class="fas fa-tshirt me-2"></i>{{ __('Fashion') }}
            </button>
            <button class="theme-filter-btn theme-filter-btn-duplicate" data-filter="clothing">
              <i class="fas fa-tshirt me-2"></i>{{ __('Clothing') }}
            </button>
            <button class="theme-filter-btn theme-filter-btn-duplicate" data-filter="grocery">
              <i class="fas fa-shopping-cart me-2"></i>{{ __('Grocery') }}
            </button>
            <button class="theme-filter-btn theme-filter-btn-duplicate" data-filter="electronics">
              <i class="fas fa-laptop me-2"></i>{{ __('Electronics') }}
            </button>
            <button class="theme-filter-btn theme-filter-btn-duplicate" data-filter="beauty">
              <i class="fas fa-magic me-2"></i>{{ __('Beauty') }}
            </button>
            <button class="theme-filter-btn theme-filter-btn-duplicate" data-filter="multipurpose">
              <i class="fas fa-shopping-bag me-2"></i>{{ __('Multipurpose') }}
            </button>
            <button class="theme-filter-btn theme-filter-btn-duplicate" data-filter="others">
              <i class="fas fa-folder me-2"></i>{{ __('Others') }}
            </button>
          </div>
        </div>

        <!-- Templates Grid Section -->
        <div class="templates-grid-wrapper">
          <div class="row g-4 justify-content-start" id="templatesGrid">
            @foreach ($templates as $template)
              @php
                $themeName = App\Models\User\BasicSetting::where('user_id', $template->id)->pluck('theme')->first();
                $category = 'others';
                $displayName = __('Theme');
                $badgeClass = 'bg-secondary';
                
                if ($themeName == 'vegetables' || $themeName == 'grocery') {
                    $category = 'grocery';
                    $displayName = __('Grocery & Supermarket');
                    $badgeClass = 'badge-grocery';
                } elseif ($themeName == 'manti' || $themeName == 'multipurpose') {
                    $category = 'multipurpose';
                    $displayName = __('Multipurpose');
                    $badgeClass = 'badge-multi';
                } elseif ($themeName == 'fashion' || $themeName == 'apparel' || $themeName == 'jewellery' || $themeName == 'kids' || $themeName == 'clothing') {
                    $category = ($themeName == 'clothing') ? 'clothing' : 'fashion';
                    $displayName = match($themeName) {
                        'jewellery' => __('Jewellery & Accessories'),
                        'kids' => __('Kids Fashion'),
                        'clothing' => __('Clothing & Apparel'),
                        default => __('Fashion & Apparel'),
                    };
                    $badgeClass = 'badge-fashion';
                } elseif ($themeName == 'electronics' || $themeName == 'gadgets') {
                    $category = 'electronics';
                    $displayName = __('Electronics & Gadgets');
                    $badgeClass = 'badge-electronics';
                } elseif ($themeName == 'beauty' || $themeName == 'cosmetics' || $themeName == 'skinflow') {
                    $category = 'beauty';
                    $displayName = match($themeName) {
                        'skinflow' => __('Skin & Beauty Care'),
                        default => __('Beauty & Cosmetics'),
                    };
                    $badgeClass = 'badge-beauty';
                } else {
                    $category = 'others';
                    $displayName = ucfirst($themeName ?? 'Default');
                    $badgeClass = 'badge-others';
                }
                
                $previewUrl = detailsUrl($template);
                $purchaseUrl = route('front.pricing') . '?template=' . urlencode($template->username);
              @endphp
              
              <div class="col-lg-3 col-md-6 col-sm-12 template-card-item mb-4" data-category="{{ $category }}" data-search="{{ strtolower(trim($displayName . ' ' . ($template->shop_name ?? '') . ' ' . $template->username . ' ' . ($themeName ?? '') . ' ' . $category)) }}">
                <div class="template-card-modern">
                  <!-- Image Wrapper with scroll hover effect -->
                  <div class="card-image-wrap" style="height: 280px !important; overflow: hidden; position: relative;">
                    <span class="category-badge {{ $badgeClass }}">{{ $displayName }}</span>
                    <a href="{{ $previewUrl }}" target="_blank" class="image-viewport" style="display: block; height: 100%; overflow: hidden;">
                      @if (!empty($template->template_img))
                        <img class="lazyload scrolling-img" src="{{ asset('assets/front/images/placeholder.png') }}"
                          data-src="{{ asset('assets/front/img/template-previews/' . $template->template_img) }}"
                          alt="{{ $displayName }} Theme" style="width: 100%; transition: transform 2.5s ease-in-out;" />
                      @else
                        <img class="lazyload scrolling-img" src="{{ asset('assets/front/images/placeholder.png') }}"
                          data-src="{{ asset('assets/front/img/template-previews/placeholder.png') }}"
                          alt="Placeholder Theme" style="width: 100%; transition: transform 2.5s ease-in-out;" />
                      @endif
                    </a>
                  </div>
                  
                  <!-- Card Body -->
                  <div class="card-body-wrap" style="padding: 24px; background: #ffffff;">
                    <h3 class="card-theme-title" style="font-size: 18px; font-weight: 700; color: #1e2335; margin-bottom: 12px;">{{ $displayName }} {{ __('Theme') }}</h3>
                    
                    <hr class="card-divider" style="border-top: 1px solid #e2e8f0; margin: 15px 0;">
                    
                    <div class="card-action-row" style="display: flex; flex-direction: column; gap: 8px;">
                      <div class="d-flex gap-2" style="width: 100%;">
                        <a href="{{ $previewUrl }}" target="_blank" class="btn-template-action outline-btn" style="flex: 1; justify-content: center; display: inline-flex; align-items: center; border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 10px; font-size: 14px; font-weight: 600; color: #4a5568; text-decoration: none;">
                          <i class="fas fa-eye me-2"></i> {{ __('Live Preview') }}
                        </a>
                        <a href="{{ route('front.templates.autologin', $template->username) }}" target="_blank" class="btn-template-action admin-btn" style="flex: 1; justify-content: center; display: inline-flex; align-items: center; border: 1.5px solid #0e1b3d; background: #0e1b3d; color: #ffffff; border-radius: 8px; padding: 10px; font-size: 14px; font-weight: 600; text-decoration: none;">
                          <i class="fas fa-user-cog me-2"></i> {{ __('Admin') }}
                        </a>
                      </div>
                      <a href="{{ $purchaseUrl }}" class="btn-template-action primary-btn" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; border: 1.5px solid #ff5a2c; background: #ff5a2c; color: #ffffff; border-radius: 8px; padding: 10px; font-size: 14px; font-weight: 600; text-decoration: none;">
                        <i class="fas fa-shopping-cart me-2"></i> {{ __('Purchase') }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- View All Themes Button Wrap for Duplicate Grid -->
        <div class="view-all-themes-btn-wrap-duplicate d-none" data-aos="fade-up" style="display: flex; justify-content: center; margin-top: 30px;">
          <button id="view-all-themes-btn-duplicate" class="btn-view-all-themes">
            {{ __('View All Themes') }} <i class="fas fa-arrow-right ms-2"></i>
          </button>
        </div>

      </div>
    </section>
    <!-- Duplicated Templates Section End -->
  @endif

  <!-- Steps & Stats section -->
  <section class="steps-stats-section py-80" data-aos="fade-up" style="background:#fff; border-top:1px solid #f1f5f9; padding-top:60px;">
    <div class="container">
      <div class="row align-items-center mb-60">
        <!-- Left Column: Rocket Image -->
        <div class="col-lg-6 col-md-12 text-center position-relative mb-5 mb-lg-0">
          <div class="rocket-visual-wrap">
            <img src="{{ asset('images/rocket_leftside.png') }}" alt="Rocket Launch" class="img-fluid rocket-main-img" style="max-width: 85%;">
          </div>
        </div>
        
        <!-- Right Column: 4 Simple Steps -->
        <div class="col-lg-6 col-md-12">
          <div class="steps-content-wrap ps-lg-4 text-start">
            <span class="steps-badge d-inline-block">{{ __('Simple Steps. Big Results.') }}</span>
            <h2 class="steps-main-title mb-4" style="font-weight: 800; font-size: 34px; color: #1e293b;">{{ __('Launch your dream store in four simple steps.') }}</h2>
            
            <div class="steps-list mt-30">
              <!-- Step 1 -->
              <div class="step-item-custom d-flex align-items-start mb-4" style="gap: 16px;">
                <div class="step-icon-container step-icon-orange">
                  <i class="fas fa-store"></i>
                </div>
                <div class="step-text-container">
                  <h4 class="step-item-title">{{ __('1. Choose Your Theme') }}</h4>
                  <p class="step-item-desc">{{ __('Pick a professional theme that matches your brand.') }}</p>
                </div>
              </div>
              
              <!-- Step 2 -->
              <div class="step-item-custom d-flex align-items-start mb-4" style="gap: 16px;">
                <div class="step-icon-container step-icon-pink">
                  <i class="fas fa-cog"></i>
                </div>
                <div class="step-text-container">
                  <h4 class="step-item-title">{{ __('2. Customize & Setup') }}</h4>
                  <p class="step-item-desc">{{ __('Add your products, customize design & settings.') }}</p>
                </div>
              </div>
              
              <!-- Step 3 -->
              <div class="step-item-custom d-flex align-items-start mb-4" style="gap: 16px;">
                <div class="step-icon-container step-icon-green">
                  <i class="fas fa-credit-card"></i>
                </div>
                <div class="step-text-container">
                  <h4 class="step-item-title">{{ __('3. Configure Payments') }}</h4>
                  <p class="step-item-desc">{{ __('Set up payment methods and shipping options.') }}</p>
                </div>
              </div>
              
              <!-- Step 4 -->
              <div class="step-item-custom d-flex align-items-start mb-4" style="gap: 16px;">
                <div class="step-icon-container step-icon-blue">
                  <i class="fas fa-rocket"></i>
                </div>
                <div class="step-text-container">
                  <h4 class="step-item-title">{{ __('4. Launch Your Store') }}</h4>
                  <p class="step-item-desc">{{ __('Your store is live! Start selling and growing.') }}</p>
                </div>
              </div>
            </div>
            
            @php
              $defaultPackage = \App\Models\Package::where('status', '1')->where('featured', '1')->first();
              $defaultPackageId = $defaultPackage ? $defaultPackage->id : 1;
            @endphp
            <div class="mt-4" style="text-align: left;">
              <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $defaultPackageId]) }}" class="btn-start-journey">
                {{ __('Start Your Journey') }} <i class="fas fa-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Stats Bar at the Bottom -->
      <div class="stats-bar-card mt-5 mb-5" style="border: 1px solid #f1f5f9; border-radius: 16px; padding: 24px 30px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); background: #ffffff;">
        <div class="row align-items-center justify-content-between g-4">
          <!-- Stat Item 1 -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start justify-content-lg-center">
            <div class="stat-item-wrap d-flex align-items-center" style="gap: 16px;">
              <div class="stat-bar-icon-box stat-icon-orange">
                <i class="fas fa-store"></i>
              </div>
              <div class="stat-bar-info">
                <h3 class="stat-bar-val">250+</h3>
                <p class="stat-bar-lbl">{{ __('Live Stores') }}</p>
              </div>
            </div>
          </div>
          
          <!-- Stat Item 2 -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start justify-content-lg-center">
            <div class="stat-item-wrap d-flex align-items-center" style="gap: 16px;">
              <div class="stat-bar-icon-box stat-icon-pink">
                <i class="fas fa-users"></i>
              </div>
              <div class="stat-bar-info">
                <h3 class="stat-bar-val">5,000+</h3>
                <p class="stat-bar-lbl">{{ __('Happy Merchants') }}</p>
              </div>
            </div>
          </div>
          
          <!-- Stat Item 3 -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start justify-content-lg-center">
            <div class="stat-item-wrap d-flex align-items-center" style="gap: 16px;">
              <div class="stat-bar-icon-box stat-icon-blue">
                <i class="fas fa-gem"></i>
              </div>
              <div class="stat-bar-info">
                <h3 class="stat-bar-val">15+</h3>
                <p class="stat-bar-lbl">{{ __('Premium Themes') }}</p>
              </div>
            </div>
          </div>
          
          <!-- Stat Item 4 -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start justify-content-lg-center">
            <div class="stat-item-wrap d-flex align-items-center" style="gap: 16px;">
              <div class="stat-bar-icon-box stat-icon-green">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="stat-bar-info">
                <h3 class="stat-bar-val">98%</h3>
                <p class="stat-bar-lbl">{{ __('Customer Satisfaction') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Dashboard Showcase Section Start -->
  <section class="dashboard-section py-80" id="dashboard-showcase">
    <div class="container-fluid px-lg-5">
      <div class="row align-items-center">
        
        <!-- Left Text Column -->
        <div class="col-lg-3 col-md-12 mb-5 mb-lg-0" data-aos="fade-right">
          <div class="dashboard-text-wrap">
            <span class="dashboard-subtitle mb-2 d-block">{{ __('Everything Under One Roof') }}</span>
            <h2 class="dashboard-title mb-3">{{ __('Powerful Dashboard Built for Growth') }}</h2>
            <p class="dashboard-desc mb-4">{{ __('From analytics to orders, products to customers, manage every part of your business from one smart dashboard.') }}</p>
            
            <ul class="dashboard-bullets-list list-unstyled mb-4">
              <li class="mb-3 d-flex align-items-center gap-2">
                <span class="bullet-check-icon"><i class="fas fa-check"></i></span>
                <span class="bullet-txt">{{ __('Real-time sales & analytics') }}</span>
              </li>
              <li class="mb-3 d-flex align-items-center gap-2">
                <span class="bullet-check-icon"><i class="fas fa-check"></i></span>
                <span class="bullet-txt">{{ __('Manage products & inventory') }}</span>
              </li>
              <li class="mb-3 d-flex align-items-center gap-2">
                <span class="bullet-check-icon"><i class="fas fa-check"></i></span>
                <span class="bullet-txt">{{ __('Track orders, payments & shipping') }}</span>
              </li>
              <li class="mb-3 d-flex align-items-center gap-2">
                <span class="bullet-check-icon"><i class="fas fa-check"></i></span>
                <span class="bullet-txt">{{ __('Customers, coupons & reports') }}</span>
              </li>
            </ul>
            
            @php
              $defaultPackage = \App\Models\Package::where('status', '1')->where('featured', '1')->first();
              $defaultPackageId = $defaultPackage ? $defaultPackage->id : 1;
            @endphp
            <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $defaultPackageId]) }}" class="btn-dashboard-explore px-4 py-3 d-inline-flex align-items-center gap-2">
              {{ __('Explore Dashboard') }} <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>

        <!-- Center Dashboard Column -->
        <div class="col-lg-6 col-md-12 mb-5 mb-lg-0" data-aos="fade-up">
          <div class="simulated-dashboard-card">
            <img src="{{ asset('images/user_dashboard.png') }}" alt="User Dashboard" style="width: 100%; height: auto; display: block; object-fit: cover;">
          </div>
        </div>

        <!-- Right Features Column -->
        <div class="col-lg-3 col-md-12" data-aos="fade-left">
          <div class="dashboard-side-features d-flex flex-column gap-3">
            
            <!-- Feature 1 -->
            <div class="dash-side-feat-card d-flex align-items-center">
              <div class="side-feat-icon-box purple">
                <i class="fas fa-chart-pie"></i>
              </div>
              <div class="side-feat-info">
                <h4 class="side-feat-title mb-1">{{ __('Analytics & Reports') }}</h4>
                <p class="side-feat-desc mb-0">{{ __('Make data-driven decisions') }}</p>
              </div>
            </div>

            <!-- Feature 2 -->
            <div class="dash-side-feat-card d-flex align-items-center">
              <div class="side-feat-icon-box orange">
                <i class="fas fa-boxes"></i>
              </div>
              <div class="side-feat-info">
                <h4 class="side-feat-title mb-1">{{ __('Inventory Management') }}</h4>
                <p class="side-feat-desc mb-0">{{ __('Never run out of stock') }}</p>
              </div>
            </div>

            <!-- Feature 3 -->
            <div class="dash-side-feat-card d-flex align-items-center">
              <div class="side-feat-icon-box green">
                <i class="fas fa-shield-alt"></i>
              </div>
              <div class="side-feat-info">
                <h4 class="side-feat-title mb-1">{{ __('Secure Payments') }}</h4>
                <p class="side-feat-desc mb-0">{{ __('Track all transactions in one place') }}</p>
              </div>
            </div>

            <!-- Feature 4 -->
            <div class="dash-side-feat-card d-flex align-items-center">
              <div class="side-feat-icon-box pink">
                <i class="fas fa-user-friends"></i>
              </div>
              <div class="side-feat-info">
                <h4 class="side-feat-title mb-1">{{ __('Customer Insights') }}</h4>
                <p class="side-feat-desc mb-0">{{ __('Understand your customers better') }}</p>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- Dashboard Showcase Section End -->

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
                          <span class="period">/ {{ strtolower($term) == 'lifetime' ? 'one-time' : (strtolower($term) == 'yearly' ? 'year' : 'month') }}</span>
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
                        // if (!empty($package->subcategories_limit)) {
                        //     $limitFeatures[] = ['label' => 'Subcategories Limit : ' . ($package->subcategories_limit == 999999 ? 'Unlimited' : $package->subcategories_limit), 'active' => true];
                        // }
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
                            <span class="show-more-label">See More Features <i class="fas fa-chevron-down" style="font-size:10px;"></i></span>
                            <span class="show-less-label d-none">See Less Features <i class="fas fa-chevron-up" style="font-size:10px;"></i></span>
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
                            $hrefPurchase = $selectedTemplate 
                              ? route('front.register.view', ['status' => 'regular', 'id' => $package->id]) . '?template=' . urlencode($selectedTemplate)
                              : route('front.select.template', ['status' => 'regular', 'id' => $package->id]);
                          @endphp
                          <a href="{{ $hrefPurchase }}" 
                             class="btn-pricing-action btn-orange-filled d-block mt-2">
                            Purchase Plan <i class="fas fa-shopping-cart ms-2" style="font-size: 11px;"></i>
                          </a>
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
                          No credit card required
                        </p>
                      </div>
                    </div>
                  </div>
                @endforeach
                
                @if (strtolower($term) != 'monthly')
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
                        <a href="https://wa.me/916374913298?text=Interested%20with%20CUSTOM%20Plan" target="_blank" class="btn-whatsapp-sales" title="WhatsApp Sales">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      </div>
                      <p class="trial-label text-center mt-2">Schedule a demo</p>
                    </div>
                  </div>
                @endif
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


  {{-- features-grid section removed --}}



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

        <div class="testimonials-slider-wrapper position-relative" data-aos="fade-up">
          <div class="swiper testimonials-slider pb-40">
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
                    <p class="testi-text">
                      <span class="testi-quote">“</span>{{ $testimonial->comment }}”
                    </p>
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

          <!-- Navigation Arrow Buttons flanking the carousel -->
          <div class="swiper-button-prev testimonials-prev-btn">
            <i class="fas fa-chevron-left"></i>
          </div>
          <div class="swiper-button-next testimonials-next-btn">
            <i class="fas fa-chevron-right"></i>
          </div>

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

  {{-- brands-banner section removed --}}


  <!-- Bottom CTA Start -->
  <section class="bottom-cta-revamp py-80">
    <div class="container position-relative">
      
      <!-- Dot grid decorators -->
      <div class="cta-decor-dots cta-decor-left"></div>
      <div class="cta-decor-dots cta-decor-right"></div>
      
      <!-- Main Blue Card -->
      <div class="cta-blue-card mb-4" data-aos="fade-up">
        <div class="row align-items-center g-0">
          
          <!-- Left Column (Text & Buttons) -->
          <div class="col-lg-6 col-md-12 p-4 p-sm-5 text-center text-lg-start">
            <h2 class="cta-revamp-title mb-3">{{ __('Ready to Launch Your Dream Store?') }}</h2>
            <p class="cta-revamp-desc mb-4">{{ __('Join thousands of entrepreneurs and start selling online with Launchshop in just minutes.') }}</p>
            
            <div class="cta-revamp-btns d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
              @php
                $defaultPackage = \App\Models\Package::where('status', '1')->where('featured', '1')->first();
                $defaultPackageId = $defaultPackage ? $defaultPackage->id : 1;
              @endphp
              <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $defaultPackageId]) }}" class="btn-cta-launch px-4 py-3 d-inline-flex align-items-center gap-2">
                {{ __('Launch Your Store') }} <i class="fas fa-arrow-right"></i>
              </a>
              <a href="#dashboard-showcase" class="btn-cta-check px-4 py-3 d-inline-flex align-items-center">
                {{ __('Check Stores Launched') }}
              </a>
            </div>
          </div>

          <!-- Right Column (Footer Right Image) -->
          <div class="col-lg-6 col-md-12 text-center d-flex align-items-end justify-content-center h-100 position-relative cta-right-col">
            <img src="{{ asset('images/footer_right.png') }}" class="img-fluid cta-right-img" alt="Ready to Launch">
          </div>

        </div>
      </div>

      <!-- Trust Badges Banner -->
      <div class="cta-trust-banner py-4 px-3" data-aos="fade-up">
        <div class="row g-3 justify-content-between align-items-center text-center">
          
          <div class="col-6 col-md-4">
            <div class="trust-badge-item d-flex align-items-center justify-content-center gap-2">
              <span class="trust-icon"><i class="fas fa-rocket"></i></span>
              <span class="trust-txt">{{ __('Launch Instantly') }}</span>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <div class="trust-badge-item d-flex align-items-center justify-content-center gap-2">
              <span class="trust-icon"><i class="fas fa-shield-alt"></i></span>
              <span class="trust-txt">{{ __('14-Days Money Back Guarantee') }}</span>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="trust-badge-item d-flex align-items-center justify-content-center gap-2">
              <span class="trust-icon"><i class="fas fa-headset"></i></span>
              <span class="trust-txt">{{ __('24/7 Expert Support') }}</span>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
  <!-- Bottom CTA End -->

@section('scripts')
<script>
  $(document).ready(function() {
    // ===== Duplicated Templates Grid Filtering and Limit Logic =====
    var activeFilterThemes = 'all';
    var itemsLimitThemes = 4;
    var showAllThemes = false;

    function filterTemplates() {
        // Get all template items in the duplicated section
        var filteredItems = $('.template-card-item');
        if (activeFilterThemes !== 'all') {
            if (activeFilterThemes === 'clothing') {
                filteredItems = $('.template-card-item').filter(function() {
                    var cat = $(this).attr('data-category');
                    return cat === 'clothing' || cat === 'fashion' || cat === 'kids';
                });
            } else {
                filteredItems = $('.template-card-item[data-category="' + activeFilterThemes + '"]');
            }
        }

        // Hide all items first
        $('.template-card-item').addClass('d-none');

        if (showAllThemes) {
            filteredItems.removeClass('d-none');
            $('.view-all-themes-btn-wrap-duplicate').addClass('d-none');
        } else {
            filteredItems.slice(0, itemsLimitThemes).removeClass('d-none');
            if (filteredItems.length > itemsLimitThemes) {
                $('.view-all-themes-btn-wrap-duplicate').removeClass('d-none');
            } else {
                $('.view-all-themes-btn-wrap-duplicate').addClass('d-none');
            }
        }
    }

    $('.theme-filter-btn-duplicate').on('click', function(e) {
        e.preventDefault();
        $('.theme-filter-btn-duplicate').removeClass('active');
        $(this).addClass('active');
        activeFilterThemes = $(this).data('filter').toLowerCase().trim();
        showAllThemes = false;
        filterTemplates();
    });

    $('#view-all-themes-btn-duplicate').on('click', function(e) {
        e.preventDefault();
        showAllThemes = true;
        filterTemplates();
    });

    // Run initially
    filterTemplates();
    // 1. Template filter and show balance logic
    let itemsLimit = 4;
    let activeCategory = 'all';
    let showAll = false;

    function applyFilterAndLimit() {
      // Get all items in active category
      let filteredItems = $('.theme-item-col');
      if (activeCategory !== 'all') {
        filteredItems = $('.theme-item-col[data-category="' + activeCategory + '"]');
      }

      // Hide all items first
      $('.theme-item-col').addClass('d-none');

      if (showAll) {
        // Show all filtered items
        filteredItems.removeClass('d-none');
        // Hide the button
        $('.view-all-themes-btn-wrap').addClass('d-none');
      } else {
        // Show first 4 filtered items
        filteredItems.slice(0, itemsLimit).removeClass('d-none');
        
        // Show button only if there are more than itemsLimit items
        if (filteredItems.length > itemsLimit) {
          $('.view-all-themes-btn-wrap').removeClass('d-none');
        } else {
          $('.view-all-themes-btn-wrap').addClass('d-none');
        }
      }
    }

    // Category button click
    $('#templates .theme-filter-btn, #templates .theme-filter-dropdown-item').on('click', function(e) {
      e.preventDefault();
      
      // Remove active classes
      $('#templates .theme-filter-btn').removeClass('active');
      
      // If it is a dropdown item, add active to the dropdown toggle button
      if ($(this).hasClass('theme-filter-dropdown-item')) {
        $('#templates #moreCategoriesDropdown').addClass('active');
      } else {
        $(this).addClass('active');
      }

      activeCategory = $(this).data('category').toLowerCase().trim();
      showAll = false; // Reset to show only first 4 on category switch
      applyFilterAndLimit();
    });

    // "View All Themes" button click -> reveal all balance themes
    $('#view-all-themes-btn').on('click', function(e) {
      e.preventDefault();
      showAll = true;
      applyFilterAndLimit();
    });

    // Initialize on page load
    applyFilterAndLimit();

    // Shop animation loop — restart CSS animations every 6.5s
    (function loopShopAnim() {
      var svg = document.getElementById('shopAnim');
      if (!svg) return;
      function restart() {
        // Force a DOM reflow to restart CSS animations
        svg.style.display = 'none';
        void svg.offsetWidth; // trigger reflow
        svg.style.display = 'block';
        setTimeout(restart, 6500);
      }
      // Start first loop after initial animation completes
      setTimeout(restart, 6500);
    })();

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
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.testimonials-next-btn',
        prevEl: '.testimonials-prev-btn',
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
        768: {
          slidesPerView: 2,
          spaceBetween: 20
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 30
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

  // ===== Rocket Launch Animation (Looping & Slow Launch) =====
  (function() {
    var rocketEl = document.getElementById('heroRocketAnim');
    if (!rocketEl) return;

    function startCycle() {
      rocketEl.classList.remove('rocket-launching');
      rocketEl.classList.remove('rocket-hidden');
      rocketEl.classList.remove('rocket-fade-in');
      
      // Let the rocket float/idle for 4 seconds before launch
      setTimeout(function() {
        launch();
      }, 4000);
    }

    function launch() {
      rocketEl.classList.add('rocket-launching');
      
      // Slow launch animation takes 3.0s to fly away and fade out
      setTimeout(function() {
        hideAndReset();
      }, 3000);
    }

    function hideAndReset() {
      rocketEl.classList.remove('rocket-launching');
      rocketEl.classList.add('rocket-hidden');
      
      // Keep completely hidden/reset for 2 seconds
      setTimeout(function() {
        fadeIn();
      }, 2000);
    }

    function fadeIn() {
      rocketEl.classList.remove('rocket-hidden');
      rocketEl.classList.add('rocket-fade-in');
      
      // Wait for the 1s fade-in animation to complete
      setTimeout(function() {
        startCycle();
      }, 1000);
    }

    // Initialize cycle
    startCycle();
  })();
</script>
@endsection

@endsection
