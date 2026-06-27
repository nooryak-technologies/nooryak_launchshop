<!--====== Favicon Icon ======-->
<link rel="shortcut icon" href="{{ !empty($userBs->favicon) ? asset('assets/front/img/user/' . $userBs->favicon) : '' }}"
  type="img/png" />


<link rel="stylesheet" href="{{ asset('assets/user-front/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/user-front/css/aos.min.css') }}">


<link rel="stylesheet" href="{{ asset('assets/user-front/fonts/fontawesome/css/all.min.css') }}">
<!-- Main Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/user-front/css/common/style.css?v=1.0.2') }}">
<link rel="stylesheet" href="{{ asset('assets/user-front/css/common/header-1.css') }}">
<link rel="stylesheet" href="{{ asset('assets/user-front/css/tinymce-content.css') }}">

@if ($userBs->theme == 'vegetables')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/grocery/home-1.css') }}">
@elseif ($userBs->theme == 'furniture')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/furniture/home-2.css') }}">
@elseif ($userBs->theme == 'fashion')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/fashion/home-3.css') }}">
@elseif ($userBs->theme == 'electronics')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/electronics/home-4.css') }}">
@elseif ($userBs->theme == 'kids')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/kids/home-5.css') }}">
@elseif ($userBs->theme == 'manti')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/manti/home-6.css') }}">
@elseif ($userBs->theme == 'pet')
  <style>
    :root {
      --font-family-base: "Nunito", sans-serif !important;
      --font-family-body: 'Nunito', sans-serif !important;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/pet/home-7.css') }}">
@elseif ($userBs->theme == 'skinflow')
  <style>
    :root {
      --font-family-base: "Jost", sans-serif;
      --font-family-body: "Jost", sans-serif;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/skinflow/home-8.css') }}">
@elseif ($userBs->theme == 'jewellery')

  <style>
    :root {
      --font-family-base: "Merriweather", serif !important;
      --font-family-body: "Jost", sans-serif !important;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/jewellery/jewellery.css') }}">
@elseif ($userBs->theme == 'clothing')

  <style>
    :root {
      --font-family-base: "Jost", sans-serif;
      --font-family-body: "Jost", sans-serif;
      --font-family-heading: "Cormorant Garamond", serif;
    }
  </style>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/clothing/clothing.css') }}">
@endif
<!--====== Style css ======-->

<!--====== RTL css ======-->
@if ($userCurrentLang->rtl == 1)
  <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
@endif
@if ($userCurrentLang->rtl == 1 & ($userBs->theme == 'pet'))
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/pet/home-7-rtl.css') }}">
@endif
@if ($userCurrentLang->rtl == 1 & ($userBs->theme == 'skinflow'))
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/skinflow/home-8-rtl.css') }}">
@endif
@if ($userCurrentLang->rtl == 1 & ($userBs->theme == 'jewellery'))
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/jewellery/jewellery-rtl.css') }}">
@endif

<style>
/* ==========================================================================
   MOBILE & LAYOUT ALIGNMENT FIXES (All Templates)
   ========================================================================== */

/* --- Task 2: Page Title Area (About/Inner Headers) Spacing Fix --- */
.page-title-area {
  padding-top: 0px !important;
  padding-bottom: 60px !important;
}

@media only screen and (max-width: 991.98px) {
  .page-title-area {
    padding-top: 15px !important;
    padding-bottom: 10px !important;
  }
}

/* --- Task 4: Hero Slider Product Thumb Overlap Fix --- */
@media only screen and (max-width: 767.98px) {
  .home-slider .product-thumb {
    position: relative !important;
    left: 0 !important;
    margin-top: 30px !important;
    width: 100% !important;
    max-width: 100% !important;
    bottom: auto !important;
    padding: 0 15px !important;
    display: block !important;
  }
}

/* --- Task 1: Product Card Button Action Icons Group Mobile Fit --- */
@media only screen and (max-width: 575.98px) {
  /* Prevent action buttons from wrapping and keep on a single line */
  .btn-icon-group, 
  .btn-icon-group-area,
  .product-default .btn-icon-group,
  .product-default-2 .btn-icon-group,
  .product-default-3 .btn-icon-group,
  .product-default-7 .btn-icon-group,
  .product-default-8 .btn-icon-group,
  .product-default-9 .btn-icon-group,
  .product-default-tab-card .btn-icon-group {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    white-space: nowrap !important;
    gap: 4px !important;
    align-items: center !important;
    width: 100% !important;
  }

  .btn-icon-group.text-center,
  .btn-icon-group.justify-content-center,
  .product-center .btn-icon-group {
    justify-content: center !important;
  }

  .btn-icon-group.text-start,
  .btn-icon-group.justify-content-start {
    justify-content: flex-start !important;
  }

  .btn-icon-group.text-end,
  .btn-icon-group.justify-content-end {
    justify-content: flex-end !important;
  }

  /* Shrink button sizes inside the action group to fit card width */
  .btn-icon-group .btn-icon,
  .btn-icon-group a.btn,
  .btn-icon-group button.btn,
  .btn-icon-group a,
  .btn-icon-group button {
    --size: 26px !important;
    width: 26px !important;
    height: 26px !important;
    min-width: 26px !important;
    max-width: 26px !important;
    line-height: 24px !important;
    font-size: 10px !important;
    padding: 0 !important;
    margin: 0 1px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
  }

  .btn-icon-group .btn-icon i,
  .btn-icon-group a.btn i,
  .btn-icon-group button.btn i,
  .btn-icon-group a i,
  .btn-icon-group button i {
    font-size: 10px !important;
    margin: 0 !important;
    padding: 0 !important;
  }
}

/* --- Task 3: Single Product Gallery Alignment & Thumbnails --- */
@media only screen and (max-width: 575.98px) {
  .product-single-default .product-single-gallery {
    flex-direction: column !important;
    align-items: center !important;
    gap: 15px !important;
    width: 100% !important;
  }

  .product-single-default .slider-thumbnails,
  .product-single-default .slider-thumbnails2 {
    width: 100% !important;
    max-width: 100% !important;
    order: 2 !important;
    margin-top: 10px !important;
    display: block !important;
    height: auto !important;
  }

  .product-single-default .slider-thumbnails .slick-list,
  .product-single-default .slider-thumbnails2 .slick-list {
    height: auto !important;
  }

  .product-single-default .slider-thumbnails2 .slick-track,
  .product-single-default .slider-thumbnails .slick-track {
    height: auto !important;
  }

  .product-single-default .product-single-slider,
  .product-single-default .product-single-slider2 {
    width: 100% !important;
    max-width: 100% !important;
    order: 1 !important;
    margin-bottom: 0 !important;
  }

  /* Make thumbnail items nice squares on mobile */
  .product-single-default .slider-thumbnails2 .thumbnail-img,
  .product-single-default .slider-thumbnails .thumbnail-img {
    width: 65px !important;
    height: 65px !important;
    max-width: 65px !important;
    max-height: 65px !important;
    margin: 0 auto !important;
    border: 1px solid var(--border) !important;
    border-radius: 6px !important;
  }

  .product-single-default .slider-thumbnails2 .thumbnail-img img,
  .product-single-default .slider-thumbnails .thumbnail-img img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
  }
}

/* --- Task 4: Reduce font size for the third slider image/slide --- */
.third-slide-content .title, 
.third-slide-content h1 {
  font-size: clamp(1.5rem, 0.5rem + 2vw, 3rem) !important;
}
.third-slide-content .sub-title, 
.third-slide-content span {
  font-size: 14px !important;
}
.third-slide-content .text-lg, 
.third-slide-content p {
  font-size: 14px !important;
}

/* Custom class for product details page related products spacing */
.product-details-related-products {
  padding-top: 20px !important;
}
</style>

@yield('styles')
