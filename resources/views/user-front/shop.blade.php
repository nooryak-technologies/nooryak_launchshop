@extends('user-front.layout')
@section('meta-description', !empty($seo) ? $seo->shop_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->shop_meta_keywords : '')
@section('breadcrumb_title', $pageHeading->shop_page ?? __('Shop'))
@section('page-title', $pageHeading->shop_page ?? __('Shop'))
@section('og-meta')
  <!--- For Social Media Share Thumbnail --->
  <meta property="og:title" content="{{ $pageHeading->shop_page ?? __('Shop') }} | {{ $user->username }}">
  <meta property="og:image" content="{{ !empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : '' }}">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1024">
  <meta property="og:image:height" content="1024">
  <!--- For Social Media Share Thumbnail --->
@endsection

@section('breadcrumb_right')
{{-- Category pills are shown inline in content below, not in breadcrumb for clothing theme --}}
@endsection

@section('content')
  <!-- Shop Start -->
  <div class="products pt-40 pb-70">
    <div class="container">

      {{-- ===== CATEGORY SLIDER ROW (matches manti reference) ===== --}}
      @if(count($categories) > 0)
      <div class="urban-cat-slider-row mb-30">
        <style>
          .urban-cat-slider-row {
            width: 100%;
            background: #faf7f2;
            border-radius: 14px;
            border: 1px solid #ede9e0;
            padding: 18px 24px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
          }
          .urban-cat-slider-row::-webkit-scrollbar { display: none; }
          .urban-cat-slider-inner {
            display: flex;
            align-items: flex-start;
            gap: 28px;
            width: max-content;
          }
          .urban-cat-pill {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none !important;
            cursor: pointer;
            min-width: 80px;
            transition: transform 0.2s ease;
          }
          .urban-cat-pill:hover { transform: translateY(-3px); }
          .urban-cat-pill-img {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 2.5px solid #ddd6c8;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
            margin-bottom: 8px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
          }
          .urban-cat-pill.active .urban-cat-pill-img,
          .urban-cat-pill:hover .urban-cat-pill-img {
            border-color: #8B5E34;
            box-shadow: 0 4px 16px rgba(139,94,52,0.18);
          }
          .urban-cat-pill-img img {
            width: 100%; height: 100%; object-fit: cover; display: block;
          }
          .urban-cat-pill-img .pill-icon-inner {
            font-size: 26px; color: #8B5E34;
          }
          .urban-cat-pill-name {
            font-size: 12.5px;
            font-weight: 700;
            color: #444;
            text-align: center;
            line-height: 1.3;
            max-width: 80px;
            transition: color 0.2s;
          }
          .urban-cat-pill.active .urban-cat-pill-name {
            color: #8B5E34;
          }
          @media(max-width: 575px) {
            .urban-cat-pill-img { width: 58px; height: 58px; }
            .urban-cat-pill-name { font-size: 11px; max-width: 65px; }
            .urban-cat-slider-inner { gap: 18px; }
          }
        </style>
        <div class="urban-cat-slider-inner">
          {{-- ALL pill --}}
          <a href="#" class="urban-cat-pill category {{ Route::current()->getName() == 'front.user.shop' && empty(request()->input('category')) ? 'active' : '' }}" data-category-slug-="all">
            <div class="urban-cat-pill-img">
              <span class="pill-icon-inner"><i class="fal fa-th-large"></i></span>
            </div>
            <span class="urban-cat-pill-name">{{ $keywords['All'] ?? __('All') }}</span>
          </a>
          {{-- Category pills --}}
          @foreach ($categories as $cat)
          <a href="#" class="urban-cat-pill category {{ request()->input('category') == $cat->slug ? 'active' : '' }}" data-slug="{{ $cat->slug }}">
            <div class="urban-cat-pill-img">
              @if(!empty($cat->image))
                <img src="{{ asset('assets/front/img/user/items/categories/' . $cat->image) }}" alt="{{ $cat->name }}">
              @else
                <span class="pill-icon-inner"><i class="fal fa-tags"></i></span>
              @endif
            </div>
            <span class="urban-cat-pill-name">{{ $cat->name }}</span>
          </a>
          @endforeach
        </div>
      </div>
      @endif
      {{-- ===== END CATEGORY SLIDER ROW ===== --}}

      <div class="row gx-xl-5">

        <div class="col-lg-4 col-xl-3">
          <div class="widget-offcanvas offcanvas-lg offcanvas-start" tabindex="-1" id="widgetOffcanvas"
            aria-labelledby="widgetOffcanvas">
            <div class="offcanvas-header px-20">
              <h4 class="offcanvas-title">{{ $keywords['Filters'] ?? __('Filters') }}</h4>
              <button type="button" class="widget-offcanvas-close" data-bs-dismiss="offcanvas"
                data-bs-target="#widgetOffcanvas" aria-label="Close"><i class="fal fa-times"></i></button>
            </div>

            <div class="offcanvas-body p-lg-0">
              <aside class="sidebar-widget-area radius-md">
                <div class="widget widget-categories mb-40">
                  <h3 class="title">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#categories"
                      aria-expanded="true" aria-controls="categories">
                      {{ $keywords['Categories'] ?? __('Categories') }}
                    </button>
                  </h3>
                  <div id="categories" class="collapse show">
                    <ul class="list-group toggle-list" data-toggle-list="amenitiesToggle" data-toggle-show="7">
                      <li
                        class="list-dropdown {{ Route::current()->getName() == 'front.user.shop' && empty(request()->input('category')) ? 'open' : '' }}">
                        <a class="category d-inline-flex align-items-center gap-2" href="#" data-category-slug-="all">
                          <span class="radio-circle {{ empty(request()->input('category')) ? 'active' : '' }}" style="width:14px;height:14px;border-radius:50%;border:2px solid #8B5E34;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                            @if(empty(request()->input('category')))
                              <span style="width:6px;height:6px;border-radius:50%;background:#8B5E34;"></span>
                            @endif
                          </span>
                          <span>{{ $keywords['All'] ?? __('All') }}</span>
                          <span class="qty">({{ $all_category_product_count }})</span>
                        </a>
                      </li>

                      @foreach ($categories as $category)
                        @php
                          $category_count = \App\Models\User\UserItemContent::join(
                              'user_items',
                              'user_items.id',
                              '=',
                              'user_item_contents.item_id'
                          )
                          ->where('user_items.status', 1)
                          ->where('user_items.user_id', $user->id)
                          ->where('user_item_contents.category_id', $category->id)
                          ->count();
                        @endphp
                        <li class="list-dropdown {{ request()->input('category') == $category->slug ? 'open' : '' }}">
                          <a class="category d-inline-flex align-items-center gap-2" href="#" data-slug="{{ $category->slug }}">
                            <span class="radio-circle {{ request()->input('category') == $category->slug ? 'active' : '' }}" style="width:14px;height:14px;border-radius:50%;border:2px solid #8B5E34;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                              @if(request()->input('category') == $category->slug)
                                <span style="width:6px;height:6px;border-radius:50%;background:#8B5E34;"></span>
                              @endif
                            </span>
                            @if(!empty($category->image))
                              <img src="{{ asset('assets/front/img/user/items/categories/' . $category->image) }}" alt="{{ $category->name }}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                            @endif
                            <span>{{ $category->name }}</span>
                            <span class="qty">({{ $category_count }})</span>
                          </a>

                          @php
                            $subcategories = $category->subcategories()->where('status', 1)->get();
                          @endphp
                          @if (count($subcategories) > 0)
                            <ul class="menu-collapse">
                              @foreach ($subcategories as $subcategory)
                                <li>
                                  <a id="{{ 'radio' . $subcategory->id }}" data-slug="{{ $subcategory->slug }}"
                                    class="subcategory">{{ $subcategory->name }} </span></a>
                                </li>
                              @endforeach
                            </ul>
                          @endif
                        </li>
                      @endforeach
                    </ul>
                    <span class="show-more mb-30"
                      data-toggle-btn="toggleListBtn">{{ $keywords['Show More'] ?? __('Show More') }} +</span>
                  </div>
                </div>
                <div id="show-variant" class="mb-40">
                  @include('user-front.variants', ['variants', $variants])
                </div>

                <div class="widget widget-price mb-40">
                  <h3 class="title">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#price"
                      aria-expanded="true" aria-controls="price">

                      {{ $keywords['Price'] ?? __('Price') }}
                    </button>
                  </h3>
                  <div id="price" class="collapse show">
                    <div class="price-item">
                      <div id="priceSlider"></div>
                      <div class="price-value">
                        <span>{{ $keywords['Price'] ?? __('Price') . ':' }} <span id="filter-price-range"></span></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="on_sale_div">
                  <div class="widget widget-color mb-40">
                    <h3 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#on_sale-filter" aria-expanded="true" aria-controls="on_sale-filter">
                        {{ $keywords['Offer_Status'] ?? __('Offer Status') }}
                      </button>
                    </h3>
                    <div id="on_sale-filter" class="collapse show">
                      <ul class="list-group custom-radio">
                        <li>
                          <input class="input-radio product_on_sale" type="radio" name="on_sale" id="all_sale"
                            value="" checked>
                          <label class="form-radio-label" for="all_sale">
                            {{ $keywords['All_off_sale_on_sale'] ?? __('All (Off Sale + On Sale)') }}
                            <span class="qty"></span>
                          </label>
                        </li>
                        <li>
                          <input class="input-radio product_on_sale" type="radio" name="on_sale" id="on_sale"
                            value="on_sale">
                          <label class="form-radio-label" for="on_sale">
                            {{ $keywords['On_Sale'] ?? __('On Sale') }}
                            <span class="qty"></span>
                          </label>
                        </li>
                        <li>
                          <input class="input-radio product_on_sale" type="radio" name="on_sale" id="flash_sale"
                            value="flash_sale" @checked(request()->input('on_sale') == 'flash_sale')>
                          <label class="form-radio-label" for="flash_sale">
                            {{ $keywords['flash_sale'] ?? __('Flash Sale') }}
                            <span class="qty"></span>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div id="rating_div">
                  <div class="widget widget-color">
                    <h3 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#ratings" aria-expanded="true" aria-controls="ratings">
                        {{ $keywords['Ratings'] ?? __('Ratings') }}
                      </button>
                    </h3>
                    <div id="ratings" class="collapse show">
                      <ul class="list-group custom-radio">
                        <li>
                          <input class="input-radio produt_ratings" type="radio" name="ratings" id="all_ratings"
                            value="" checked>
                          <label class="form-radio-label" for="all_ratings">
                            {{ $keywords['All'] ?? __('All') }}
                            <span class="qty"></span>
                          </label>
                        </li>

                        <li>
                          <input class="input-radio produt_ratings" type="radio" name="ratings"
                            id="five_star_ratings" value="5">
                          <label class="form-radio-label" for="five_star_ratings">
                            <span class="ms-1">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                            </span>
                            <span class="qty"></span>
                          </label>
                        </li>
                        <li>
                          <input class="input-radio produt_ratings" type="radio" name="ratings"
                            id="four_star_ratings" value="4">
                          <label class="form-radio-label" for="four_star_ratings">
                            <span class="ms-1">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                            </span>
                            <span class="qty">{{ $keywords['And Up'] ?? __('And Up') }}</span>
                          </label>
                        </li>
                        <li>
                          <input class="input-radio produt_ratings" type="radio" name="ratings"
                            id="three_star_ratings" value="3">
                          <label class="form-radio-label" for="three_star_ratings">
                            <span class="ms-1">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                            </span>
                            <span class="qty">{{ $keywords['And Up'] ?? __('And Up') }}</span>
                          </label>
                        </li>
                        <li>
                          <input class="input-radio produt_ratings" type="radio" name="ratings"
                            id="two_star_ratings" value="2">
                          <label class="form-radio-label" for="two_star_ratings">
                            <span class="ms-1">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                            </span>
                            <span class="qty">{{ $keywords['And Up'] ?? __('And Up') }}</span>
                          </label>
                        </li>
                        <li>
                          <input class="input-radio produt_ratings" type="radio" name="ratings"
                            id="one_star_ratings" value="1">
                          <label class="form-radio-label" for="one_star_ratings">
                            <span class="ms-1">
                              <i class="fas fa-star"></i>
                            </span>
                            <span class="qty">{{ $keywords['And Up'] ?? __('And Up') }}</span>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

              </aside>
            </div>
          </div>
        </div>


        <div class="col-lg-8 col-xl-9">

          <div class="product-sort-area mb-30">

            <ul class="product-sort-list">
              <li class="item">
                <div class="sort-item">
                  <input class="form-control serch-product" type="text" id="search-input"
                    placeholder="{{ $keywords['Search_Product'] ?? __('Search Product') }}"
                    value="{{ !empty(request()->input('keyword')) ? request()->input('keyword') : '' }}">
                </div>
              </li>
              <li class="item">
                <div class="sort-item">
                  <select name="type" id="sort-type">
                    <option selected disabled>{{ $keywords['Sort By'] ?? __('Sort By') }}</option>
                    <option {{ request()->input('sort') == 'new' ? 'selected' : '' }} value="new">
                      {{ $keywords['Newest'] ?? __('Newest') }}
                    </option>
                    <option {{ request()->input('sort') == 'old' ? 'selected' : '' }} value="old">
                      {{ $keywords['Oldest'] ?? __('Oldest') }}
                    </option>
                    <option {{ request()->input('sort') == 'ascending' ? 'selected' : '' }} value="ascending">
                      {{ $keywords['Price'] . ' :' ?? __('Price') . ' :' }}
                      {{ $keywords['Low_to_High'] ?? __('Low to High') }}
                    </option>
                    <option {{ request()->input('sort') == 'descending' ? 'selected' : '' }} value="descending">
                      {{ $keywords['Price'] . ' : ' ?? __('Price') . ':' }}
                      {{ $keywords['High to Low'] ?? __('High to Low') }}
                    </option>
                  </select>
                </div>
              </li>
            </ul>

            <div class="view-and-filter">
              <button class="btn btn-sm btn-outline icon-end radius-sm product_filter_btn" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#widgetOffcanvas" aria-controls="widgetOffcanvas">
                {{ $keywords['Filters'] ?? __('Filters') }} <i class="fal fa-filter"></i></button>
              <div class="view">
                <li class="item"><a href=""
                    class="btn-icon {{ Session::get('view_type') == 'grid' ? 'active' : '' }}{{ !Session::has('view_type') ? 'active' : '' }} view-type"
                    data-view-type="grid"><i class="fas fa-th"></i></a>
                </li>
                <li class="item"><a href="{{ route('front.user.shop.shop_type', ['type' => 'list', getParam()]) }}"
                    class="btn-icon {{ Session::get('view_type') == 'list' ? 'active' : '' }}  view-type"
                    data-view-type="list"><i class="fas fa-list"></i></a>
                </li>
              </div>
            </div>

          </div>
          <div class="row" id="show-products">
            @if (Session::get('view_type') == 'list')
              @include('user-front.shop-list')
            @else
              @include('user-front.shop-grid')
            @endif
          </div>
          @include('user-front.skeleton')
        </div>
      </div>
    </div>
  </div>
  <!-- Shop End -->





  <form id="filtersForm" class="d-none" action="{{ route('front.user.shop.search', getParam()) }}" method="GET">

    <input type="hidden" id="category" name="category"
      value="{{ !empty(request()->input('category')) ? request()->input('category') : '' }}">
    <input type="hidden" id="subcategory" name="subcategory"
      value="{{ !empty(request()->input('subcategory')) ? request()->input('subcategory') : '' }}">

    <input type="hidden" id="min-id" name="min"
      value="{{ !empty(request()->input('min')) ? request()->input('min') : '' }}">

    <input type="hidden" id="max-id" name="max"
      value="{{ !empty(request()->input('max')) ? request()->input('max') : '' }}">

    <input type="hidden" id="keyword-id" name="keyword"
      value="{{ !empty(request()->input('keyword')) ? request()->input('keyword') : '' }}">

    <input type="hidden" id="sort-id" name="sort"
      value="{{ !empty(request()->input('sort')) ? request()->input('sort') : '' }}">

    <input type="hidden" id="on-sale-id" name="on_sale"
      value="{{ !empty(request()->input('on_sale')) ? request()->input('on_sale') : '' }}">

    <input type="hidden" id="view-type" name="view_type" value="{{ Session::get('view-type') }}">
    <input type="hidden" id="selected-variants" name="variants" value="">
    <input type="hidden" id="selected-ratings" name="ratings" value="">


    @if ($selected_category)
      @foreach ($selected_category->variations as $variation)
        @php
          $option_name = json_decode($variation->option_name);
          $option_price = json_decode($variation->option_price);
        @endphp
        @if (!empty(request()->input('variations')))
          @foreach ($option_name as $key => $single_option)
            @if (in_array($single_option, request()->input('variations')))
              <input type="hidden" data-type="variation" data-v_name="{{ $variation->variant_name }}"
                name="variations[]" value="{{ $single_option }}">
            @endif
          @endforeach
        @endif
      @endforeach
    @endif

    @if ($selected_subcategory)
      @foreach ($selected_subcategory->variations as $variation)
        @php
          $option_name = json_decode($variation->option_name);
          $option_price = json_decode($variation->option_price);
        @endphp
        @if (!empty(request()->input('variations')))
          @foreach ($option_name as $key => $single_option)
            @if (in_array($single_option, request()->input('variations')))
              <input type="hidden" data-type="variation" data-v_name="{{ $variation->variant_name }}"
                name="variations[]" value="{{ $single_option }}">
            @endif
          @endforeach
        @endif
      @endforeach
    @endif

    <input type="hidden" name="page" id="page">
    <button type="submit" id="submitBtn"></button>
  </form>

  {{-- Variation Modal Starts --}}
  @includeIf('user-front.partials.variation-modal')

  <!-- Quick View Modal Start -->
  <div class="modal custom-modal quick-view-modal fade" id="quickViewModal"
    tabindex="-1"aria-labelledby="quickViewModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content radius-sm">
        <button type="button" class="close_modal_btn" data-bs-dismiss="modal" aria-label="Close"><i
            class="fal fa-times"></i></button>
        <div class="modal-body">
          <div class="product-single-default">
            <div class="row" id="quickViewModalContent">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Quick View Modal End -->

  <div class="mobile-menu-overlay"></div>
  <!-- Responsive Mobile Menu -->
  <div class="mobile-menu">
    <div class="mobile-menu-wrapper">
      <div class="mobile-menu-top">

        <div class="logo">
          <!-- logo -->
          <a href="{{ route('front.user.detail.view', getParam()) }}" class="logo">
            <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
              data-src="{{ asset('assets/front/img/user/' . $userBs->logo) }}" alt="logo">
          </a>
        </div>
        <span class="mobile-menu-close"><i class="fal fa-times"></i></span>

      </div>
    </div>
  </div>
  <!-- Responsive Mobile Menu -->


  <!-- Responsive Bottom Toolbar -->
  <div class="mobile-bottom-toolbar d-block d-lg-none">
    <div class="container">
      <nav class="toolbar" id="nav">
        <ul class="toolbar-nav">
          <li class="tolbar-item">
            <a class="{{ request()->routeIs('front.user.detail.view') ? 'active' : '' }}" href="{{ route('front.user.detail.view', getParam()) }}" target="_self">
              <i class="fal fa-home"></i>
              <span>{{ $keywords['Home'] ?? __('Home') }}</span>
            </a>
          </li>
          <li class="tolbar-item">
            <a class="{{ request()->routeIs('front.user.shop') ? 'active' : '' }}" href="{{ route('front.user.shop', getParam()) }}" target="_self">
              <i class="fal fa-shopping-cart"></i>
              <span>{{ $keywords['Shop'] ?? __('Shop') }}</span>
            </a>
          </li>
          <li class="tolbar-item">
            <a href="{{ route('front.user.cart', getParam()) }}" class="cart-sidebar-toggle" target="_self">
              <i class="fal fa-shopping-bag"></i>
              {{ $keywords['Cart'] ?? __('Cart') }}
              <span class="badge cart-dropdown-count">0</span>
            </a>
          </li>
          <li class="tolbar-item">
            <a href="{{ route('customer.wishlist', getParam()) }}" target="_self">
              <i class="fal fa-heart"></i>
              <span>{{ $keywords['Wishlist'] ?? __('Wishlist') }}</span>
              <span class="badge wishlist-count">0</span>
            </a>
          </li>
          <li class="tolbar-item">
            <a href="{{ route('customer.dashboard', getParam()) }}" target="_self">
              <i class="fal fa-user"></i>
              <span>{{ $keywords['Account'] ?? __('Account') }}</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    "use strict";
    let variation_search_url = "{{ route('front.user.shop.get_variation', getParam()) }}";
    let symbol = "{{ $symbol }}";
    let min_price = {!! !is_null(currency_converter($minPrice)) ? htmlspecialchars(currency_converter($minPrice)) : 0 !!};
    let max_price = {!! !is_null(currency_converter($maxPrice)) ? htmlspecialchars(currency_converter($maxPrice)) : 0 !!};
    let curr_min = {!! (!empty(request()->input('min'))
            ? htmlspecialchars(request()->input('min'))
            : !is_null(currency_converter($minPrice)))
        ? htmlspecialchars(currency_converter($minPrice))
        : 0 !!};
    let curr_max = {!! (!empty(request()->input('max'))
            ? htmlspecialchars(request()->input('max'))
            : !is_null(currency_converter($maxPrice)))
        ? htmlspecialchars(currency_converter($maxPrice))
        : 0 !!};
  </script>

  <script src="{{ asset('assets/user-front/js/product-search.js') }}"></script>
  <script>
    $(document).ready(function() {
      // When top urban slider pill is clicked — sync sidebar + trigger filter
      $('body').on('click', '.urban-cat-pill', function(e) {
        e.preventDefault();
        $('.urban-cat-pill').removeClass('active');
        $(this).addClass('active');
        var slug = $(this).data('slug');
        var allSlug = $(this).data('category-slug-');
        // Sync sidebar
        $('#categories .category').parent().removeClass('open');
        if (slug) {
          $('#categories .category[data-slug="' + slug + '"]').parent().addClass('open');
          $('#categories .category[data-slug="' + slug + '"]').trigger('click_from_pill');
        } else {
          $('#categories .category[data-category-slug-="all"]').trigger('click_from_pill');
        }
        // Trigger the actual category filter via the sidebar link
        if (slug) {
          var $sidebarLink = $('#categories .category[data-slug="' + slug + '"]');
          if ($sidebarLink.length) {
            $sidebarLink[0].click();
          }
        } else {
          var $allLink = $('#categories .category[data-category-slug-="all"]');
          if ($allLink.length) {
            $allLink[0].click();
          }
        }
      });

      // When sidebar category is clicked — sync top urban slider pills
      $('body').on('click', '#categories .category', function() {
        var slug = $(this).data('slug');
        $('.urban-cat-pill').removeClass('active');
        if (slug) {
          $('.urban-cat-pill[data-slug="' + slug + '"]').addClass('active');
        } else {
          $('.urban-cat-pill[data-category-slug-="all"]').addClass('active');
        }
      });
    });
  </script>

@endsection
