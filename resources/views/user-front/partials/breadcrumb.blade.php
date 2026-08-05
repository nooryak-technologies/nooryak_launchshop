@php
  $breadcrumbBgImg = (!is_null($userBe) && $userBe->breadcrumb)
    ? asset('assets/front/img/user/' . $userBe->breadcrumb)
    : asset('assets/front/img/shop_banner_bg.png');
@endphp
<div class="page-title-area header-next" style="background-image: url('{{ $breadcrumbBgImg }}'); background-size: cover; background-position: center bottom;">
  <img class="bg-img" src="{{ $breadcrumbBgImg }}" data-src="{{ $breadcrumbBgImg }}" alt="Banner" style="display:none;">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col-lg-4 col-md-5 col-sm-12">
        <div class="content text-start">
          <h2>@yield('breadcrumb_title') </h2>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start mb-0">
              <li class="breadcrumb-item"><a
                  href="{{ route('front.user.detail.view', getParam()) }}">{{ $keywords['Home'] ?? __('Home') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">
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
      <div class="col-lg-8 col-md-7 col-sm-12">
        @yield('breadcrumb_right')
      </div>
    </div>
  </div>
</div>
