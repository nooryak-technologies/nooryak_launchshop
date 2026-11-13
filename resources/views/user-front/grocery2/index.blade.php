@extends('user-front.layout')
@section('meta-description', !empty($seo) ? $seo->home_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->home_meta_keywords : '')
@section('page-title', $keywords['Home'] ?? __('Home'))
@section('og-meta')
  <meta property="og:title" content="{{ $user->username }}">
  <meta property="og:image" content="{{ !empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : '' }}">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1024">
  <meta property="og:image:height" content="1024">
@endsection

@php
  $additional_section_status = json_decode($userBs->additional_section_status, true) ?? [];
@endphp

@section('content')
  <!-- ==================== HERO SLIDER AREA ==================== -->
  <section class="g2-hero-section pt-3">
    <div class="container">
      <div class="row g-4">
        <!-- Main Hero Slider -->
        <div class="col-xl-8 col-lg-12 mb-4">
          <div class="g2-hero-slider" id="g2-main-slider">
            @if (count($sliders) > 0)
              @foreach ($sliders as $slider)
                <div class="g2-slider-item" style="background-image: url('{{ asset('assets/front/img/hero_slider/' . $slider->img) }}');">
                  <div class="g2-slider-content">
                    <span class="g2-badge">{{ !empty($slider->subtitle) ? html_entity_decode($slider->subtitle, ENT_QUOTES, 'UTF-8') : __('Organic fruits provider') }}</span>
                    <h1 class="g2-title">{{ html_entity_decode($slider->title ?? $slider->subtitle ?? '', ENT_QUOTES, 'UTF-8') }}</h1>
                    <p class="g2-text">{{ html_entity_decode($slider->text ?? '', ENT_QUOTES, 'UTF-8') }}</p>
                    <div class="g2-slider-btns">
                      @if ($slider->btn_url && $slider->btn_name)
                        <a href="{{ $slider->btn_url }}" class="btn g2-btn-primary">{{ $slider->btn_name }}</a>
                      @else
                        <a href="{{ route('front.user.shop', getParam()) }}" class="btn g2-btn-primary">{{ __('Shop Now') }}</a>
                      @endif
                    </div>
                  </div>
                  <div class="g2-slider-mobile-img d-block d-lg-none">
                    <img src="{{ asset('assets/front/img/hero_slider/' . $slider->img) }}" alt="{{ $slider->title ?? 'Hero Banner' }}" onerror="this.onerror=null;this.src='{{ asset('assets/front/img/hero_slider/ecom_grocery_banner_clean.png') }}';">
                  </div>
                </div>
              @endforeach
            @else
              <div class="g2-slider-item" style="background-image: url('{{ asset('assets/front/img/hero_slider/ecom_grocery_banner_clean.png') }}');">
                <div class="g2-slider-content">
                  <span class="g2-badge">{{ __('Organic fruits provider') }}</span>
                  <h1 class="g2-title">{{ $user->shop_name ?? 'Welcome to Our Store' }}</h1>
                  <p class="g2-text">{{ __('Shop the latest deals and products') }}</p>
                  <div class="g2-slider-btns">
                    <a href="{{ route('front.user.shop', getParam()) }}" class="btn g2-btn-primary">{{ __('Order Now') }}</a>
                  </div>
                </div>
                <div class="g2-slider-mobile-img d-block d-lg-none">
                  <img src="{{ asset('assets/front/img/hero_slider/ecom_grocery_banner_clean.png') }}" alt="Hero Banner">
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Right Side Promo Stack -->
        @php
          $topBanners = isset($banners) ? $banners->whereIn('position', ['right', 'top_right']) : collect();
          if ($topBanners->isEmpty() && isset($banners)) {
              $topBanners = $banners->take(2);
          }
        @endphp
        @if(isset($topBanners) && count($topBanners) > 0)
          <div class="col-xl-4 col-lg-12 mb-4">
            <div class="g2-promo-stack" id="g2-promo-stack-slider">
              @foreach($topBanners->take(2) as $b)
                <div class="g2-side-promo" style="background-image: url('{{ asset('assets/front/img/user/banners/' . $b->banner_img) }}');">
                  <div class="g2-side-promo-content">
                    @if(!empty($b->title)) <h3>{{ $b->title }}</h3> @endif
                    <a href="{{ $b->banner_url ?? $b->url ?? route('front.user.shop', getParam()) }}" class="g2-link-btn">{{ !empty($b->button_text) ? $b->button_text : __('Shop Now') }} <i class="far fa-long-arrow-right"></i></a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>
 
  <!-- ==================== FEATURED CATEGORIES ==================== -->
  @if ($ubs->category_section == 1)
    <section class="g2-categories-section py-4">
      <div class="container">
        <!-- Laptop View Header (Single Row on Laptop View Only) -->
        <div class="g2-section-header d-flex justify-content-between align-items-center mb-4">
          <h2 class="g2-section-title mb-0">Featured Categories</h2>
          <div class="g2-arrow-nav d-none d-lg-flex gap-2">
            <button class="g2-arrow-btn cat-prev"><i class="fal fa-chevron-left"></i></button>
            <button class="g2-arrow-btn cat-next"><i class="fal fa-chevron-right"></i></button>
          </div>
        </div>
        
        <div class="g2-categories-slider" id="g2-categories-carousel">
          @if (count($item_categories) > 0)
            @foreach ($item_categories as $category)
              <div class="g2-category-card-wrapper">
                <a href="{{ route('front.user.shop', [getParam(), 'category' => $category->slug]) }}" class="g2-category-card">
                  <div class="g2-category-img-circle">
                    @if($category->image)
                      <img src="{{ asset('assets/front/img/user/items/categories/' . $category->image) }}" alt="{{ $category->name }}">
                    @else
                      <img src="{{ asset('assets/front/images/placeholder.png') }}" alt="{{ $category->name }}">
                    @endif
                  </div>
                  <h3>{{ $category->name }}</h3>
                  @php
                    $item_count = ProductCountByCategory($uLang, $category->id);
                  @endphp
                  <span class="count">{{ $item_count }} {{ $item_count == 1 ? 'Item' : 'Items' }}</span>
                </a>
              </div>
            @endforeach
          @else
            <div class="col-12 text-center py-4">
              <p class="text-muted">{{ __('No categories found') }}</p>
            </div>
          @endif
        </div>

        <!-- Mobile View Navigation Arrows (Below Category Slider on Mobile View Only) -->
        <div class="g2-category-bottom-arrows d-flex d-lg-none justify-content-center gap-2 mt-3">
          <button class="g2-arrow-btn cat-prev"><i class="fal fa-chevron-left"></i></button>
          <button class="g2-arrow-btn cat-next"><i class="fal fa-chevron-right"></i></button>
        </div>
      </div>
    </section>
  @endif

  <!-- ==================== POPULAR PRODUCTS ==================== -->
  <section class="g2-popular-products py-4">
    <div class="container">
      <div class="g2-section-header align-items-center">
        <h2 class="g2-section-title mb-0">Popular Products</h2>
        <!-- Filters list -->
        <div class="g2-product-filters">
          <ul class="nav nav-tabs border-0" id="g2ProductTabs" role="tablist">
            <li class="nav-item">
              <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#tab-all" type="button" role="tab">All</button>
            </li>
            @php $count = 0; @endphp
            @foreach($categories->take(5) as $cat)
              <li class="nav-item">
                <button class="nav-link" id="cat-{{ $cat->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab-cat-{{ $cat->id }}" type="button" role="tab">{{ $cat->name }}</button>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <!-- Tab Contents -->
      <div class="tab-content mt-4" id="g2ProductTabsContent">
        <!-- ALL TAB -->
        <div class="tab-pane fade show active" id="tab-all" role="tabpanel">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-3">
            @php
              $all_items = (isset($latest_items) && count($latest_items) > 0) ? $latest_items : [];
            @endphp
            @if(count($all_items) > 0)
              @foreach($all_items->take(12) as $item)
                @include('user-front.grocery2.partials.product-card', ['item' => $item])
              @endforeach
            @else
              <div class="col-12 text-center py-4">
                <p class="text-muted">{{ __('No products found') }}</p>
              </div>
            @endif
          </div>
        </div>

        <!-- CATEGORIES TABS -->
        @foreach($categories->take(5) as $cat)
          <div class="tab-pane fade" id="tab-cat-{{ $cat->id }}" role="tabpanel">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-3">
              @php
                $cat_items = App\Models\User\UserItem::join('user_item_contents', 'user_items.id', '=', 'user_item_contents.item_id')
                  ->where('user_items.user_id', $user->id)
                  ->where('user_item_contents.language_id', $uLang)
                  ->where('user_item_contents.category_id', $cat->id)
                  ->select('user_items.*', 'user_item_contents.title', 'user_item_contents.slug', 'user_item_contents.summary', 'user_item_contents.description')
                  ->orderBy('user_items.id', 'desc')
                  ->get();
              @endphp
              @if(count($cat_items) > 0)
                @foreach($cat_items->take(12) as $item)
                  @include('user-front.grocery2.partials.product-card', ['item' => $item])
                @endforeach
              @else
                <div class="col-12 text-center py-4">
                  <p class="text-muted">{{ __('No products found in this category') }}</p>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ==================== MIDDLE PROMO CARDS (4 Column Grid) ==================== -->
  @php
    $midBanners = isset($banners) ? $banners->where('position', 'middle') : collect();
    if ($midBanners->isEmpty() && isset($banners) && count($banners) >= 3) {
        $midBanners = $banners->slice(2, 4);
    }
  @endphp
  @if(count($midBanners) > 0)
    <section class="g2-middle-banners py-4">
      <div class="container">
        <div class="row g-3">
          @php
            $bgClasses = ['bg-cream-light', 'bg-blue-light', 'bg-green-light', 'bg-pink-light'];
            $i = 0;
          @endphp
          @foreach($midBanners as $b)
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="g2-mid-card {{ $bgClasses[$i % 4] }}">
                <div class="g2-mid-card-img">
                  <img src="{{ asset('assets/front/img/user/banners/' . $b->banner_img) }}" alt="Banner">
                </div>
                <div class="g2-mid-card-text">
                  <h3>{{ $b->title }}</h3>
                  <a href="{{ $b->banner_url ?? $b->url ?? route('front.user.shop', getParam()) }}" class="g2-supplier-link">{{ !empty($b->button_text) ? $b->button_text : __('Go To Supplier') }} <i class="fas fa-caret-right"></i></a>
                </div>
              </div>
            </div>
            @php $i++; @endphp
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- ==================== SIDEBAR BANNER + POPULAR ITEMS GRID SECTION ==================== -->
  <section class="g2-sidebar-grid py-4">
    <div class="container">
      <div class="row">
        <!-- Left vertical banner (Loaded dynamically from $banners) -->
        @php
          $vertBanner = isset($banners) ? ($banners->whereIn('position', ['vertical', 'left', 'bottom_left'])->first()
            ?? ($banners->count() >= 7 ? $banners->get(6) : ($banners->count() >= 3 ? $banners->last() : null))) : null;
        @endphp
        @if($vertBanner)
          <div class="col-xl-3 col-lg-4 mb-4">
            <div class="g2-vertical-juice-card">
              <div class="g2-vert-content">
                <h3>{{ $vertBanner->title }}</h3>
                <a href="{{ $vertBanner->banner_url ?? $vertBanner->url ?? route('front.user.shop', getParam()) }}" class="btn g2-btn-orange">{{ !empty($vertBanner->button_text) ? $vertBanner->button_text : __('Shop Now') }} <i class="fas fa-caret-right"></i></a>
              </div>
              <div class="g2-vert-img">
                <img src="{{ asset('assets/front/img/user/banners/' . $vertBanner->banner_img) }}" alt="Vertical Promo">
              </div>
            </div>
          </div>
        @else
          <div class="col-xl-3 col-lg-4 mb-4">
            <div class="g2-vertical-juice-card">
              <div class="g2-vert-content">
                <h3>Everyday Fresh Clean with Our Products</h3>
                <a href="{{ route('front.user.shop', getParam()) }}" class="btn g2-btn-orange">Shop Now <i class="fas fa-caret-right"></i></a>
              </div>
              <div class="g2-vert-img">
                <img src="{{ asset('assets/front/img/user/banners/redesign_ecom_vertical_juice_promo.png') }}" alt="Juice Promo">
              </div>
            </div>
          </div>
        @endif

        <!-- Right Products Grid -->
        <div class="col-xl-9 col-lg-8">
          <div class="g2-section-header align-items-center mb-3">
            <div class="d-flex align-items-center gap-3">
              <!-- Desktop Arrows on Laptop View Only -->
              <div class="g2-arrow-nav d-none d-lg-flex me-2">
                <button class="g2-arrow-btn grid-prev"><i class="fal fa-chevron-left"></i></button>
                <button class="g2-arrow-btn grid-next"><i class="fal fa-chevron-right"></i></button>
              </div>
              <h2 class="g2-section-title mb-0">Popular Items</h2>
            </div>

            <!-- Filters list -->
            <div class="g2-product-filters d-none d-md-block">
              <ul class="nav nav-tabs border-0" id="g2PopularItemTabs" role="tablist">
                <li class="nav-item">
                  <button class="nav-link active" id="pop-all-tab" data-bs-toggle="tab" data-bs-target="#pop-tab-all" type="button" role="tab">All</button>
                </li>
                @foreach($categories->take(5) as $cat)
                  <li class="nav-item">
                    <button class="nav-link" id="pop-cat-{{ $cat->id }}-tab" data-bs-toggle="tab" data-bs-target="#pop-tab-cat-{{ $cat->id }}" type="button" role="tab">{{ $cat->name }}</button>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>

          <div class="tab-content" id="g2PopularItemTabsContent">
            <!-- ALL TAB — Single row with pagination -->
            <div class="tab-pane fade show active" id="pop-tab-all" role="tabpanel">
              @if(count($all_items) > 0)
                <div class="g2-pop-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                  @foreach($all_items as $item)
                    @include('user-front.grocery2.partials.product-card', ['item' => $item])
                  @endforeach
                </div>
                <div class="g2-pagination-nav d-flex justify-content-center align-items-center mt-4"></div>
              @else
                <div class="col-12 text-center py-4">
                  <p class="text-muted">{{ __('No products found') }}</p>
                </div>
              @endif
            </div>

            <!-- CATEGORIES TABS — Single row with pagination -->
            @foreach($categories->take(5) as $cat)
              <div class="tab-pane fade" id="pop-tab-cat-{{ $cat->id }}" role="tabpanel">
                @php
                  $cat_items2 = App\Models\User\UserItem::where('user_items.user_id', $user->id)
                    ->where('user_items.status', 1)
                    ->whereHas('itemContents', function ($q) use ($cat, $uLang) {
                        $q->where('category_id', $cat->id)->where('language_id', $uLang);
                    })
                    ->with(['itemContents' => function ($q) use ($uLang) {
                        $q->where('language_id', $uLang);
                    }, 'sliders'])
                    ->orderBy('id', 'desc')
                    ->get();

                  if ($cat_items2->isEmpty()) {
                    $cat_items2 = App\Models\User\UserItem::where('user_items.user_id', $user->id)
                      ->where('user_items.status', 1)
                      ->whereHas('itemContents', function ($q) use ($cat) {
                          $q->where('category_id', $cat->id);
                      })
                      ->with(['itemContents', 'sliders'])
                      ->orderBy('id', 'desc')
                      ->get();
                  }
                @endphp
                @if(count($cat_items2) > 0)
                  <div class="g2-pop-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                    @foreach($cat_items2 as $item)
                      @include('user-front.grocery2.partials.product-card', ['item' => $item])
                    @endforeach
                  </div>
                  <div class="g2-pagination-nav d-flex justify-content-center align-items-center mt-4"></div>
                @else
                  <div class="col-12 text-center py-4">
                    <p class="text-muted">{{ __('No products found in this category') }}</p>
                  </div>
                @endif
              </div>
            @endforeach
          </div>

          <!-- Mobile View Navigation Arrows (Below Popular Items on Mobile View Only) -->
          <div class="g2-popular-bottom-arrows d-flex d-lg-none justify-content-center gap-2 mt-3">
            <button class="g2-arrow-btn grid-prev"><i class="fal fa-chevron-left"></i></button>
            <button class="g2-arrow-btn grid-next"><i class="fal fa-chevron-right"></i></button>
          </div>
        </div>
      </div>
    </div>
  </section>



  {{-- Variation Modal & Quick View Modal --}}
  @include('user-front.partials.variation-modal')
  <div class="modal custom-modal quick-view-modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content radius-sm">
        <button type="button" class="close_modal_btn" data-bs-dismiss="modal" aria-label="Close"><i class="fal fa-times"></i></button>
        <div class="modal-body">
          <div class="product-single-default">
            <div class="row gx-0" id="quickViewModalContent"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ==================== NEWSLETTER BANNER SECTION ==================== -->
  @php
    $ctaTitle = !empty($userSec->call_to_action_section_title) ? $userSec->call_to_action_section_title : (!empty($callToAction->title) ? $callToAction->title : 'Stay home & get your daily needs from our shop');
    $ctaSubtitle = !empty($userSec->call_to_action_section_text) ? $userSec->call_to_action_section_text : (!empty($callToAction->text) ? $callToAction->text : 'Start Your Daily Shopping with Ecom Mart');
    $ctaBtnText = !empty($userSec->call_to_action_section_button_text) ? $userSec->call_to_action_section_button_text : (!empty($callToAction->button_text) ? $callToAction->button_text : 'Sign up');

    $rawSideImg = !empty($userSec->action_section_side_image) ? $userSec->action_section_side_image : (!empty($callToAction->side_image) ? $callToAction->side_image : null);
    $rawBgImg = !empty($userSec->action_section_background_image) ? $userSec->action_section_background_image : (!empty($callToAction->background_image) ? $callToAction->background_image : null);

    $defaultCtaSideImg = asset('assets/front/img/user/banners/redesign_ecom_grocery_banner_clean.png');

    $resolveCtaAsset = function ($filename) {
      if (empty($filename)) {
        return null;
      }
      foreach (['assets/front/img/cta/', 'assets/front/img/user/cta/', 'assets/front/img/user/banners/'] as $dir) {
        if (file_exists(public_path($dir . $filename))) {
          return asset($dir . $filename);
        }
      }
      return null;
    };

    $ctaSideImg = $resolveCtaAsset($rawSideImg);
    $ctaBgImg = $resolveCtaAsset($rawBgImg);

    // Fallback to the bundled grocery banner image whenever no valid side or background image exists on disk
    if (empty($ctaBgImg) && empty($ctaSideImg)) {
        $ctaSideImg = $defaultCtaSideImg;
    }
  @endphp
  <section class="g2-newsletter-section py-4">
    <div class="container">
      <div class="g2-newsletter-card" @if($ctaBgImg) style="background-image: url('{{ $ctaBgImg }}'); background-size: cover; background-position: center;" @endif>
        <div class="row align-items-center g-0">
          <div class="{{ !empty($ctaSideImg) ? 'col-lg-6 col-md-12' : 'col-lg-8 col-md-12' }} g2-news-left-content">
            <h2 class="g2-news-title">{{ html_entity_decode($ctaTitle, ENT_QUOTES, 'UTF-8') }}</h2>
            <p class="g2-news-subtitle">{{ html_entity_decode($ctaSubtitle, ENT_QUOTES, 'UTF-8') }}</p>
            <form action="{{ route('front.user.subscribe', getParam()) }}" method="POST" class="g2-news-form">
              @csrf
              <input type="email" name="email" class="g2-news-input" placeholder="{{ __('Your email address') }}" required>
              <button type="submit" class="btn g2-news-btn">{{ $ctaBtnText }}</button>
            </form>
          </div>
          @if(!empty($ctaSideImg))
            <div class="col-lg-6 col-md-12 d-none d-lg-block g2-news-right-col">
              <img src="{{ $ctaSideImg }}" onerror="this.onerror=null;this.src='{{ $defaultCtaSideImg }}';" alt="Newsletter Banner" class="g2-news-banner-img">
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    // All Category Dropdown Selection Handler
    $(document).on('click', '.cat-item-link', function(e) {
      e.preventDefault();
      var slug = $(this).data('slug');
      var text = $(this).text().trim();
      $('#selectedCategoryInput').val(slug);
      $('#selectedCategoryText').text(text);
      $('.grocery2-cat-dropdown-menu a').removeClass('active');
      $(this).addClass('active');
      $(this).closest('form').submit();
    });

    // Preloader auto-hide fallback
    $('.preloader').addClass('hidden').fadeOut(300);
    $(window).on('load', function() {
      $('.preloader').addClass('hidden').fadeOut(300);
    });
    setTimeout(function() {
      $('.preloader').addClass('hidden').fadeOut(300);
    }, 1200);

    // Main Hero Slider Carousel
    // On mobile (<768px): use slide mode (no fade) + adaptiveHeight so height auto works correctly with stacked layout
    // On desktop: use fade mode for smooth transitions
    if ($('#g2-main-slider').length > 0) {
      var isMobile = $(window).width() < 768;
      $('#g2-main-slider').slick({
        dots: true,
        arrows: !isMobile,
        prevArrow: '<button type="button" class="slick-prev g2-slider-arrow"><i class="fal fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next g2-slider-arrow"><i class="fal fa-chevron-right"></i></button>',
        autoplay: true,
        autoplaySpeed: 3500,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        pauseOnHover: false,
        fade: !isMobile,
        adaptiveHeight: isMobile,
        cssEase: 'ease-in-out',
        rtl: $('html').attr('dir') === 'rtl'
      });
    }

    // Categories Carousel (Auto Smooth Scroll)
    if ($('#g2-categories-carousel').length > 0) {
      var catSlider = $('#g2-categories-carousel').slick({
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2500,
        speed: 800,
        cssEase: 'cubic-bezier(0.25, 1, 0.5, 1)',
        slidesToShow: 7,
        slidesToScroll: 1,
        infinite: true,
        responsive: [
          { breakpoint: 1200, settings: { slidesToShow: 5 } },
          { breakpoint: 992, settings: { slidesToShow: 4 } },
          { breakpoint: 768, settings: { slidesToShow: 3 } },
          { breakpoint: 576, settings: { slidesToShow: 2 } }
        ],
        rtl: $('html').attr('dir') === 'rtl'
      });

      $('.cat-prev').on('click', function() {
        catSlider.slick('slickPrev');
      });
      $('.cat-next').on('click', function() {
        catSlider.slick('slickNext');
      });
    }

    // Popular Items Single-Row Pagination (4 items on desktop, 2 on mobile -> exactly 1 single row)
    function initPopularPagination() {
      var pageSize = $(window).width() < 768 ? 2 : 4;

      $('#g2PopularItemTabsContent .tab-pane').each(function() {
        var $pane = $(this);
        var $grid = $pane.find('.g2-pop-grid');
        if ($grid.length === 0) return;

        var $items = $grid.children('.col');
        var totalItems = $items.length;

        var $nav = $pane.find('.g2-pagination-nav');
        if ($nav.length === 0) {
          $nav = $('<div class="g2-pagination-nav d-flex justify-content-center align-items-center mt-4"></div>');
          $grid.after($nav);
        }

        if (totalItems <= pageSize) {
          $items.show();
          $nav.empty();
          $pane.data('currentPage', 1);
          $pane.data('totalPages', 1);
          updateHeaderArrows();
          return;
        }

        var totalPages = Math.ceil(totalItems / pageSize);
        var currentPage = $pane.data('currentPage') || 1;
        if (currentPage > totalPages) currentPage = 1;

        function renderPage(page) {
          currentPage = page;
          $pane.data('currentPage', currentPage);
          $pane.data('totalPages', totalPages);

          $items.hide();
          var start = (page - 1) * pageSize;
          var end = start + pageSize;
          $items.slice(start, end).fadeIn(150);

          var html = '<ul class="pagination g2-pagination mb-0">';
          
          // Prev button
          html += '<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '">';
          html += '<a class="page-link g2-page-prev" href="javascript:void(0)" aria-label="Previous"><i class="fal fa-chevron-left"></i></a>';
          html += '</li>';

          for (var p = 1; p <= totalPages; p++) {
            html += '<li class="page-item ' + (p === currentPage ? 'active' : '') + '">';
            html += '<a class="page-link g2-page-num" href="javascript:void(0)" data-page="' + p + '">' + p + '</a>';
            html += '</li>';
          }

          // Next button
          html += '<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '">';
          html += '<a class="page-link g2-page-next" href="javascript:void(0)" aria-label="Next"><i class="fal fa-chevron-right"></i></a>';
          html += '</li>';

          html += '</ul>';
          $nav.html(html);

          updateHeaderArrows();
        }

        renderPage(currentPage);
        $pane.data('renderPage', renderPage);
      });
    }

    function updateHeaderArrows() {
      var $activePane = $('#g2PopularItemTabsContent .tab-pane.active');
      var cur = $activePane.data('currentPage') || 1;
      var total = $activePane.data('totalPages') || 1;

      if (total <= 1) {
        $('.grid-prev, .grid-next').prop('disabled', true).css('opacity', '0.4');
      } else {
        $('.grid-prev').prop('disabled', cur === 1).css('opacity', cur === 1 ? '0.4' : '1');
        $('.grid-next').prop('disabled', cur === total).css('opacity', cur === total ? '0.4' : '1');
      }
    }

    $(document).on('click', '.g2-page-num', function(e) {
      e.preventDefault();
      var page = parseInt($(this).data('page'));
      var $pane = $(this).closest('.tab-pane');
      var renderPage = $pane.data('renderPage');
      if (typeof renderPage === 'function') {
        renderPage(page);
      }
    });

    $(document).on('click', '.g2-page-prev', function(e) {
      e.preventDefault();
      var $pane = $(this).closest('.tab-pane');
      var cur = $pane.data('currentPage') || 1;
      var renderPage = $pane.data('renderPage');
      if (cur > 1 && typeof renderPage === 'function') {
        renderPage(cur - 1);
      }
    });

    $(document).on('click', '.g2-page-next', function(e) {
      e.preventDefault();
      var $pane = $(this).closest('.tab-pane');
      var cur = $pane.data('currentPage') || 1;
      var total = $pane.data('totalPages') || 1;
      var renderPage = $pane.data('renderPage');
      if (cur < total && typeof renderPage === 'function') {
        renderPage(cur + 1);
      }
    });

    $(document).on('click', '.grid-prev', function(e) {
      e.preventDefault();
      var $activePane = $('#g2PopularItemTabsContent .tab-pane.active');
      var cur = $activePane.data('currentPage') || 1;
      var renderPage = $activePane.data('renderPage');
      if (cur > 1 && typeof renderPage === 'function') {
        renderPage(cur - 1);
      }
    });

    $(document).on('click', '.grid-next', function(e) {
      e.preventDefault();
      var $activePane = $('#g2PopularItemTabsContent .tab-pane.active');
      var cur = $activePane.data('currentPage') || 1;
      var total = $activePane.data('totalPages') || 1;
      var renderPage = $activePane.data('renderPage');
      if (cur < total && typeof renderPage === 'function') {
        renderPage(cur + 1);
      }
    });

    $('#g2PopularItemTabs [data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
      var target = $(this).attr('data-bs-target') || $(this).attr('href');
      if (target) {
        var $pane = $(target);
        var renderPage = $pane.data('renderPage');
        if (typeof renderPage === 'function') {
          renderPage(1);
        } else {
          initPopularPagination();
        }
      }
      updateHeaderArrows();
    });

    initPopularPagination();

    var resizeTimer;
    $(window).on('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        initPopularPagination();
      }, 250);
    });

    // Promo Stack Mobile Slider Only (< 992px)
    function initPromoMobileSlider() {
      if ($(window).width() < 992) {
        if ($('#g2-promo-stack-slider').length > 0 && !$('#g2-promo-stack-slider').hasClass('slick-initialized')) {
          $('#g2-promo-stack-slider').slick({
            dots: false,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 3000,
            speed: 600,
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            rtl: $('html').attr('dir') === 'rtl'
          });
        }
      } else {
        if ($('#g2-promo-stack-slider').length > 0 && $('#g2-promo-stack-slider').hasClass('slick-initialized')) {
          $('#g2-promo-stack-slider').slick('unslick');
        }
      }
    }

    initPromoMobileSlider();
    $(window).on('resize', function() {
      initPromoMobileSlider();
    });
  });
</script>
@endsection
