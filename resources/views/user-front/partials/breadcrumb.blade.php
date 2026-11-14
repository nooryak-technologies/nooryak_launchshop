@php
  $isUrbanTheme = (!empty($userBs) && $userBs->theme == 'clothing');
  $isFashionTheme = (!empty($userBs) && $userBs->theme == 'fashion');
  $isSkinflowTheme = (!empty($userBs) && $userBs->theme == 'skinflow');
  $isJewelleryTheme = (!empty($userBs) && $userBs->theme == 'jewellery');
  $isPetTheme = (!empty($userBs) && $userBs->theme == 'pet');

  if ($isUrbanTheme) {
    $breadcrumbBgImg = asset('assets/front/img/shop_banner_bg.png');
  } elseif ($isFashionTheme) {
    $breadcrumbBgImg = asset('assets/front/img/fashion_banner_bg.png');
  } else {
    $breadcrumbBgImg = (!is_null($userBe) && !empty($userBe->breadcrumb) && file_exists(public_path('assets/front/img/user/' . $userBe->breadcrumb)))
      ? asset('assets/front/img/user/' . $userBe->breadcrumb)
      : asset('assets/front/img/default_shop_banner.png');
  }
@endphp

<style>
  /* Theme-specific Breadcrumb Top Clearance for Laptop / Desktop (min-width: 992px) */
  @media (min-width: 992px) {
    .theme-pet .page-title-area.header-next {
      padding-top: 175px !important;
      padding-bottom: 50px !important;
    }
    .theme-fashion .page-title-area.header-next {
      padding-top: 175px !important;
      padding-bottom: 55px !important;
    }
    .theme-furniture .page-title-area.header-next {
      padding-top: 145px !important;
      padding-bottom: 45px !important;
    }
    .theme-clothing .page-title-area.header-next {
      padding-top: 145px !important;
      padding-bottom: 45px !important;
    }
    .theme-jewellery .page-title-area.header-next,
    .theme-skinflow .page-title-area.header-next {
      padding-top: 135px !important;
      padding-bottom: 45px !important;
    }
    .theme-grocery .page-title-area.header-next,
    .theme-grocery2 .page-title-area.header-next,
    .theme-vegetables .page-title-area.header-next,
    .theme-manti .page-title-area.header-next,
    .theme-electronics .page-title-area.header-next,
    .theme-kids .page-title-area.header-next {
      padding-top: 50px !important;
      padding-bottom: 40px !important;
    }
  }

  /* Theme-specific Breadcrumb Top Clearance for Mobile & Tablet (max-width: 991px) */
  @media (max-width: 991px) {
    .theme-pet .page-title-area.header-next {
      padding-top: 115px !important;
      padding-bottom: 25px !important;
    }
    .theme-fashion .page-title-area.header-next {
      padding-top: 115px !important;
      padding-bottom: 25px !important;
    }
    .theme-furniture .page-title-area.header-next {
      padding-top: 105px !important;
      padding-bottom: 25px !important;
    }
    .theme-clothing .page-title-area.header-next {
      padding-top: 105px !important;
      padding-bottom: 25px !important;
    }
    .theme-jewellery .page-title-area.header-next,
    .theme-skinflow .page-title-area.header-next {
      padding-top: 100px !important;
      padding-bottom: 25px !important;
    }
    .theme-grocery .page-title-area.header-next,
    .theme-grocery2 .page-title-area.header-next,
    .theme-vegetables .page-title-area.header-next,
    .theme-manti .page-title-area.header-next,
    .theme-electronics .page-title-area.header-next,
    .theme-kids .page-title-area.header-next {
      padding-top: 30px !important;
      padding-bottom: 25px !important;
    }
  }
</style>

<div class="page-title-area header-next" style="background-image: url('{{ $breadcrumbBgImg }}'); background-size: cover; background-position: center center; position: relative;">
  @if($isUrbanTheme)
    <div class="page-title-overlay" style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(248, 245, 240, 0.65) 100%); pointer-events: none;"></div>
  @elseif($isFashionTheme)
    <div class="page-title-overlay" style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255, 255, 255, 0.5) 0%, rgba(250, 247, 242, 0.7) 100%); pointer-events: none;"></div>
  @endif
  <img class="bg-img" src="{{ $breadcrumbBgImg }}" data-src="{{ $breadcrumbBgImg }}" alt="Banner" style="display:none;">
  <div class="container position-relative" style="z-index: 2;">
    <div class="row align-items-center justify-content-between">
      <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
        <div class="content text-start">
          <h2 style="{{ $isUrbanTheme || $isFashionTheme ? 'font-weight: 600; color: #1a1a1a; letter-spacing: -0.3px;' : '' }}">@yield('breadcrumb_title')</h2>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start mb-0" style="background: transparent; padding: 0;">
              <li class="breadcrumb-item"><a
                  href="{{ route('front.user.detail.view', getParam()) }}" style="{{ $isUrbanTheme || $isFashionTheme ? 'color: #666; text-decoration: none;' : '' }}">{{ $keywords['Home'] ?? __('Home') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page" style="{{ $isUrbanTheme || $isFashionTheme ? 'color: #a87d52; font-weight: 500;' : '' }}">
                @if (
                    !request()->routeIs('customer.itemcheckout.offline.success') &&
                        !request()->routeIs('customer.success.page') &&
                        !request()->routeIs('front.user.productDetails') &&
                        !request()->routeIs('user-front.blog_details'))
                  @yield('breadcrumb_title')
                @else
                  @yield('breadcrumb_second_title')
                @endif
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
        @yield('breadcrumb_right')
      </div>
    </div>
  </div>
</div>
