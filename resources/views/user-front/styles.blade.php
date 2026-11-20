<!--====== Favicon Icon ======-->
<link rel="shortcut icon" href="{{ !empty($userBs->favicon) ? asset('assets/front/img/user/' . $userBs->favicon) : '' }}"
  type="img/png" />


<link rel="stylesheet" href="{{ asset('assets/user-front/css/plugins.css') }}">
<link rel="stylesheet" href="{{ asset('assets/user-front/css/aos.min.css') }}">


<link rel="stylesheet" href="{{ asset('assets/user-front/fonts/fontawesome/css/all.min.css') }}">
<!-- Main Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/user-front/css/common/style.css?v=' . time()) }}">
<link rel="stylesheet" href="{{ asset('assets/user-front/css/common/header-1.css?v=' . time()) }}">
<link rel="stylesheet" href="{{ asset('assets/user-front/css/common/zoom-fix.css?v=' . time()) }}">
<link rel="stylesheet" href="{{ asset('assets/user-front/css/tinymce-content.css?v=' . time()) }}">

@if ($userBs->theme == 'vegetables' || $userBs->theme == 'grocery')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/grocery/home-1.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/grocery/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'furniture')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/furniture/home-2.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/furniture/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'fashion')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/fashion/home-3.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/fashion/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'electronics')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/electronics/home-4.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/electronics/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'kids')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/kids/home-5.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/kids/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'manti')
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/manti/home-6.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/manti/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'pet')
  <style>
    :root {
      --font-family-base: "Nunito", sans-serif !important;
      --font-family-body: 'Nunito', sans-serif !important;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/pet/home-7.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/pet/custom-styles.css') }}">
@elseif ($userBs->theme == 'skinflow')
  <style>
    :root {
      --font-family-base: "Jost", sans-serif;
      --font-family-body: "Jost", sans-serif;
    }

    /* Skinflow Mobile View Layout & Announcement Slider Fixes */
    @media (max-width: 991.98px) {
      .home-hero-9 {
        max-height: none !important;
        height: auto !important;
        overflow: hidden !important;
        margin-bottom: 20px !important;
        padding-bottom: 0 !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
        box-sizing: border-box !important;
        width: 100% !important;
      }

      .home-hero-9 .home-hero-area,
      .home-hero-9 .slider-area,
      .home-hero-9 .hero-center-slider,
      .home-hero-9 .slick-list {
        overflow: hidden !important;
        width: 100% !important;
        position: relative !important;
        padding: 0 !important;
      }

      /* Force Slick Track to stay strictly HORIZONTAL and NEVER wrap slides vertically */
      .home-hero-9 .hero-center-slider .slick-track {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: stretch !important;
        width: 100% !important;
      }

      .home-hero-9 .hero-center-slider .slick-slide {
        flex: 0 0 100% !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        height: auto !important;
        float: none !important;
        box-sizing: border-box !important;
      }

      .home-hero-9 .hero-center-slider .slick-slide > div {
        width: 100% !important;
        height: 100% !important;
      }

      /* Slide Card Inner Styling with Equal Padding */
      .home-hero-9 .slide-item {
        height: 100% !important;
        max-height: none !important;
        min-height: auto !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 24px 20px 24px 20px !important;
        margin: 0 !important;
        width: 100% !important;
        border-radius: 20px !important;
        background: linear-gradient(180deg, #fbf7f4 0%, #f5ece5 100%) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
        box-sizing: border-box !important;
      }

      .home-hero-9 .slide-item .hero-content {
        width: 100% !important;
        max-width: 100% !important;
        text-align: center !important;
        margin: 0 auto 12px auto !important;
        display: block !important;
      }

      .home-hero-9 .slide-item .hero-content .title {
        font-size: 20px !important;
        line-height: 1.3 !important;
        font-weight: 700 !important;
        margin-bottom: 8px !important;
        color: #2c221e !important;
      }

      .home-hero-9 .slide-item .hero-content .description {
        font-size: 13.5px !important;
        line-height: 1.4 !important;
        margin-bottom: 14px !important;
        color: #6e5e57 !important;
      }

      .home-hero-9 .slide-item .hero-content .btn {
        display: inline-block !important;
        padding: 9px 24px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        border-radius: 30px !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12) !important;
      }

      .home-hero-9 .slide-item .hero-image {
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        margin-top: 12px !important;
        margin-bottom: 0 !important;
      }

      .home-hero-9 .slide-item img {
        display: block !important;
        max-height: 175px !important;
        height: auto !important;
        width: auto !important;
        max-width: 100% !important;
        object-fit: contain !important;
        filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.08)) !important;
      }

      .home-hero-9 .slider-arrow .slider-prev {
        left: 4px !important;
        top: 50% !important;
      }

      .home-hero-9 .slider-arrow .slider-next {
        right: 4px !important;
        top: 50% !important;
      }

      /* Below Slider (Announcement Bar) Mobile Styling - DISPLAY 1 ITEM PER ROW */
      .announcement-area {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: 5 !important;
        width: 100% !important;
        margin-top: 20px !important;
        margin-bottom: 25px !important;
        padding: 12px 0 !important;
        background: linear-gradient(135deg, #fcf8f5 0%, #f4eae3 100%) !important;
        border-top: 1px solid #ebdcd3 !important;
        border-bottom: 1px solid #ebdcd3 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02) !important;
        overflow: hidden !important;
      }

      .announcement-slider {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
      }

      .announcement-slider .slick-list {
        width: 100% !important;
        overflow: hidden !important;
      }

      .announcement-slider .slick-track {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
      }

      .announcement-slider .slick-slide {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        box-sizing: border-box !important;
        float: none !important;
      }

      .announcement-slider .slider-item {
        width: auto !important;
        max-width: 90% !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        padding: 10px 24px !important;
        margin: 0 auto !important;
        background: rgba(255, 255, 255, 0.92) !important;
        border-radius: 30px !important;
        border: 1px solid rgba(220, 195, 180, 0.5) !important;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04) !important;
        white-space: nowrap !important;
      }

      .announcement-slider .slider-item h5 {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #382c28 !important;
        margin: 0 !important;
        letter-spacing: 0.2px !important;
      }

      .announcement-slider .slider-item i {
        font-size: 16px !important;
        color: var(--color-primary, #d9826c) !important;
        margin-left: 6px !important;
      }
    }

    @media (max-width: 575.98px) {
      .home-hero-9 {
        padding-left: 12px !important;
        padding-right: 12px !important;
      }

      .home-hero-9 .slide-item {
        padding: 20px 14px 16px 14px !important;
      }

      .home-hero-9 .slide-item .hero-content .title {
        font-size: 20px !important;
      }

      .home-hero-9 .slide-item img {
        max-height: 185px !important;
      }

      .announcement-area {
        margin-top: 18px !important;
        margin-bottom: 22px !important;
      }
    }

    /* Task 3: Skinflow Product Card Redesign (Matching Reference Image 2) */
    .product-default-tab-card {
      position: relative !important;
      z-index: 2 !important;
      background: #ffffff !important;
      border-radius: 16px !important;
      border: 1px solid #f0e6e0 !important;
      overflow: hidden !important;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03) !important;
      transition: all 0.3s ease !important;
      margin-bottom: 24px !important;
      display: flex !important;
      flex-direction: column !important;
      height: 100% !important;
    }

    .product-default-tab-card:hover {
      transform: translateY(-4px) !important;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .product-default-tab-card .product-img {
      position: relative !important;
      overflow: hidden !important;
      border-radius: 16px 16px 0 0 !important;
      background: #f8f4f0 !important;
      margin-bottom: 0 !important;
      width: 100% !important;
    }

    .product-default-tab-card .product-img img {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover !important;
      transition: transform 0.4s ease !important;
    }

    .product-default-tab-card:hover .product-img img {
      transform: scale(1.05) !important;
    }

    .skinflow-discount-badge {
      position: absolute !important;
      top: 10px !important;
      left: 10px !important;
      width: 42px !important;
      height: 42px !important;
      border-radius: 50% !important;
      background: #e54848 !important;
      color: #ffffff !important;
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      justify-content: center !important;
      z-index: 10 !important;
      box-shadow: 0 4px 10px rgba(229, 72, 72, 0.35) !important;
      line-height: 1.1 !important;
      text-align: center !important;
    }

    .skinflow-discount-badge .percent {
      font-size: 11px !important;
      font-weight: 800 !important;
    }

    .skinflow-discount-badge .text {
      font-size: 8px !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
    }

    .skinflow-card-actions {
      position: absolute !important;
      bottom: 10px !important;
      left: 10px !important;
      display: flex !important;
      align-items: center !important;
      gap: 5px !important;
      z-index: 10 !important;
      margin: 0 !important;
    }

    .skinflow-card-actions .btn-icon {
      width: 32px !important;
      height: 32px !important;
      min-width: 32px !important;
      border-radius: 50% !important;
      background: #ffffff !important;
      border: 1px solid #e2dad2 !important;
      color: #444444 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 12px !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
      transition: all 0.2s ease !important;
      padding: 0 !important;
    }

    .skinflow-card-actions .btn-icon i {
      font-size: 12px !important;
      margin: 0 !important;
    }

    .skinflow-card-actions .btn-icon:hover {
      background: #2c221e !important;
      color: #ffffff !important;
      border-color: #2c221e !important;
    }

    .skinflow-card-actions .btn-icon.cart-link {
      background: #e54848 !important;
      color: #ffffff !important;
      border-color: #e54848 !important;
    }

    .skinflow-card-actions .btn-icon.cart-link:hover {
      background: #c83636 !important;
      border-color: #c83636 !important;
    }

    .product-default-tab-card .product-details {
      position: relative !important;
      z-index: 2 !important;
      padding: 12px 14px 14px 14px !important;
      background: #ffffff !important;
      text-align: left !important;
      width: 100% !important;
      top: auto !important;
      left: auto !important;
      bottom: auto !important;
      margin-top: auto !important;
    }

    .product-default-tab-card .product-details::after {
      display: none !important;
    }

    .product-default-tab-card .product-title {
      font-size: 14.5px !important;
      font-weight: 600 !important;
      color: #222222 !important;
      line-height: 1.3 !important;
      margin-bottom: 4px !important;
      text-align: left !important;
    }

    .product-default-tab-card .product-title a {
      color: #222222 !important;
      text-decoration: none !important;
    }

    .product-default-tab-card .product-title a:hover {
      color: #e54848 !important;
    }

    .product-default-tab-card .product-price {
      display: flex !important;
      align-items: center !important;
      gap: 8px !important;
      justify-content: flex-start !important;
      margin-top: 2px !important;
    }

    .product-default-tab-card .product-price .new-price {
      font-size: 15px !important;
      font-weight: 700 !important;
      color: #e54848 !important;
    }

    .product-default-tab-card .product-price .old-price {
      font-size: 13px !important;
      font-weight: 500 !important;
      color: #888888 !important;
      text-decoration: line-through !important;
    }

    @media (max-width: 575.98px) {
      .products-tab-8 .row > [class*="col-"] {
        padding-left: 6px !important;
        padding-right: 6px !important;
      }

      .product-default-tab-card {
        border-radius: 12px !important;
        margin-bottom: 12px !important;
      }

      .product-default-tab-card .product-img {
        border-radius: 12px 12px 0 0 !important;
      }

      .skinflow-discount-badge {
        width: 34px !important;
        height: 34px !important;
        top: 6px !important;
        left: 6px !important;
      }

      .skinflow-discount-badge .percent {
        font-size: 10px !important;
      }

      .skinflow-discount-badge .text {
        font-size: 7px !important;
      }

      .skinflow-card-actions {
        bottom: 6px !important;
        left: 6px !important;
        gap: 3px !important;
      }

      .skinflow-card-actions .btn-icon {
        width: 25px !important;
        height: 25px !important;
        min-width: 25px !important;
        font-size: 9px !important;
      }

      .skinflow-card-actions .btn-icon i {
        font-size: 9px !important;
      }

      .product-default-tab-card .product-details {
        padding: 8px 8px 10px 8px !important;
      }

      .product-default-tab-card .product-title {
        font-size: 12.5px !important;
        margin-bottom: 2px !important;
      }

      .product-default-tab-card .product-price .new-price {
        font-size: 13.5px !important;
      }

      .product-default-tab-card .product-price .old-price {
        font-size: 11px !important;
      }
    }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/skinflow/home-8.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/skinflow/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'jewellery')

  <style>
    :root {
      --font-family-base: "Merriweather", serif !important;
      --font-family-body: "Jost", sans-serif !important;
    }

    /* =====================================================
       JEWELLERY THEME — MOBILE HORIZONTAL SCROLL FIX
       Inline so it cannot be cached. Only loads for jewellery.
       ===================================================== */

    /* Prevent horizontal scroll at page level */
    html, body {
      overflow-x: hidden !important;
      max-width: 100% !important;
    }

    @media (max-width: 767.98px) {
      .main-panel, .wrapper, .footer-area {
        overflow-x: hidden !important;
        width: 100% !important;
        position: relative !important;
      }
      body {
        position: relative !important;
      }
    }

    /* Clip all major jewellery sections */
    .home-hero-8,
    .featured-8,
    .category-8,
    .products-section-v8,
    .flash-sale-section,
    .banner-section {
      overflow-x: hidden !important;
      max-width: 100% !important;
    }

    @media (max-width: 767.98px) {
      /* Disable all AOS animations on mobile for jewellery theme */
      [data-aos] {
        opacity: 1 !important;
        transform: translate3d(0, 0, 0) !important;
        transition: none !important;
        animation: none !important;
      }

      /* Disable hover "shine" effect on banners (mobile touch/scroll triggers hover) */
      .banner-md:hover::after, .banner-xl:hover::after {
        animation: none !important;
        display: none !important;
      }

      /* Fix hero background-attachment:fixed — collapses on iOS/Android */
      .home-hero-8 {
        background-attachment: scroll !important;
        background-size: cover !important;
        background-position: center center !important;
        padding: 60px 15px !important;
        min-height: 340px;
      }

      .home-hero-8 .hero-card-wrapper {
        max-width: 100% !important;
        width: 100%;
        padding: 16px;
      }

      /* Fix fluid-left and fluid-right negative calc causing huge overflow */
      .fluid-left, .fluid-right {
        padding-inline-start: 0 !important;
        padding-inline-end: 0 !important;
      }

      /* Force category row to wrap on mobile instead of staying nowrap */
      .category-8 .row.flex-nowrap {
        flex-wrap: wrap !important;
      }

      /* Hide the vertical rotated title (squishes layout on narrow screens) */
      .category-8 .vertical-title {
        display: none !important;
      }

      /* Make category slider take full row width */
      .category-8 .col-auto {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
      }

      /* Fix featured item huge padding causing overflow */
      .featured-8 .featured-item {
        padding: 0 16px !important;
      }

      /* Fix row negative margins inside featured wrap pushing width > 100vw */
      .featured-8 .featured-item-wrap.row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
      }
    }

    @media (max-width: 575.98px) {
      .home-hero-8 {
        padding: 40px 10px !important;
        min-height: 300px;
      }

      .featured-8 .featured-item {
        padding: 0 10px !important;
      }
    }
  </style>
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/jewellery/jewellery.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/jewellery/custom-styles.css?v=' . time()) }}">
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
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/clothing/clothing.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/clothing/custom-styles.css?v=' . time()) }}">
@elseif ($userBs->theme == 'grocery2')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/grocery2/styles.css?v=' . time()) }}">
  <style>
    /* Grocery2 only: restore banner inner padding (slick-slide must not zero it) */
    .theme-grocery2 .g2-hero-slider.slick-slider .slick-list {
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }
    .theme-grocery2 .g2-hero-slider .g2-slider-item,
    .theme-grocery2 .g2-hero-slider .slick-slide.g2-slider-item {
      padding: 48px 48px 48px 56px !important;
    }
    .theme-grocery2 .g2-slider-content {
      text-align: left !important;
      padding-left: 4px;
    }
    .theme-grocery2 .g2-side-promo {
      padding: 28px 24px 28px 40px !important;
    }
    .theme-grocery2 .g2-side-promo-content {
      text-align: left;
      padding-left: 4px;
    }
    .theme-grocery2 .container {
      max-width: 1450px !important;
      padding-left: 25px !important;
      padding-right: 25px !important;
    }
    @media (min-width: 1200px) {
      .g2-hero-slider {
        max-width: 940px !important;
      }
    }
    @media (max-width: 767.98px) {
      /* Hero banner spacing fixes: eliminate unwanted top clearance and gaps */
      .theme-grocery2 .g2-hero-section,
      .theme-grocery2 .g2-hero-section.pt-3,
      .theme-grocery2 .g2-hero-section.pt-lg-3 {
        padding-top: 0 !important;
        margin-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .theme-grocery2 .g2-hero-section > .container,
      .theme-grocery2 .g2-hero-section .container {
        padding-left: 0 !important;
        padding-right: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
      }
      .theme-grocery2 .g2-hero-section .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
      .theme-grocery2 .g2-hero-section .row.g-4,
      .theme-grocery2 .g2-hero-section .row.g-lg-4 {
        --bs-gutter-y: 0 !important;
        row-gap: 0 !important;
      }
      .theme-grocery2 .g2-hero-section .row > [class*="col-"] {
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .theme-grocery2 .g2-hero-section .col-xl-8.col-lg-12.mb-4,
      .theme-grocery2 .g2-hero-section .col-xl-8.col-lg-12.mb-lg-4 {
        margin-bottom: 6px !important;
      }
      .theme-grocery2 .g2-hero-section .col-xl-4.col-lg-12.mb-4,
      .theme-grocery2 .g2-hero-section .col-xl-4.col-lg-12.mb-lg-4 {
        margin-top: 0 !important;
        padding-top: 0 !important;
        margin-bottom: 12px !important;
      }
      /* FOUC prevention before slick initializes */
      .theme-grocery2 #g2-main-slider:not(.slick-initialized) .g2-slider-item:not(:first-child),
      .theme-grocery2 #g2-promo-stack-slider:not(.slick-initialized) .g2-side-promo:not(:first-child) {
        display: none !important;
      }

      /* Slick track position reset (undo plugin.css left: 7px) */
      .theme-grocery2 .g2-hero-slider .slick-track,
      .theme-grocery2 .g2-promo-stack .slick-track,
      .theme-grocery2 #g2-main-slider .slick-track,
      .theme-grocery2 #g2-promo-stack-slider .slick-track {
        left: 0 !important;
      }

      /* Hero Slider: balanced left & right gap */
      .theme-grocery2 #g2-main-slider,
      .theme-grocery2 .g2-hero-slider {
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-left: 12px !important;
        padding-right: 12px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 #g2-main-slider.slick-slider .slick-list,
      .theme-grocery2 #g2-main-slider .slick-list,
      .theme-grocery2 .g2-hero-slider.slick-slider .slick-list,
      .theme-grocery2 .g2-hero-slider .slick-list {
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        box-sizing: border-box !important;
        border-radius: 16px !important;
        overflow: hidden !important;
      }
      .theme-grocery2 #g2-main-slider .g2-slider-item,
      .theme-grocery2 #g2-main-slider .slick-slide.g2-slider-item,
      .theme-grocery2 .g2-hero-slider .g2-slider-item,
      .theme-grocery2 .g2-hero-slider .slick-slide.g2-slider-item {
        display: block !important;
        float: left !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box !important;
        height: auto !important;
      }
      .theme-grocery2 .g2-slider-mobile-img {
        width: 100% !important;
        margin-top: 10px !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        display: block !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 .g2-slider-mobile-img img {
        width: 100% !important;
        height: 220px !important;
        object-fit: cover !important;
        border-radius: 16px !important;
        display: block !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 #g2-main-slider .slick-dots {
        position: static !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 6px !important;
        margin-top: 8px !important;
        margin-bottom: 8px !important;
        padding: 0 !important;
        list-style: none !important;
        width: 100% !important;
      }

      /* Promo Stack: balanced left & right space and zero top space */
      .theme-grocery2 #g2-promo-stack-slider,
      .theme-grocery2 .g2-promo-stack,
      .theme-grocery2 .g2-promo-stack.slick-initialized,
      .theme-grocery2 .g2-promo-stack.slick-initialized.slick-slider {
        margin-top: 0 !important;
        padding-top: 0 !important;
        padding-left: 12px !important;
        padding-right: 12px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        box-sizing: border-box !important;
        width: 100% !important;
        max-width: 100% !important;
      }
      .theme-grocery2 #g2-promo-stack-slider.slick-slider .slick-list,
      .theme-grocery2 #g2-promo-stack-slider .slick-list,
      .theme-grocery2 .g2-promo-stack.slick-slider .slick-list,
      .theme-grocery2 .g2-promo-stack.slick-initialized .slick-list,
      .theme-grocery2 .g2-promo-stack .slick-list {
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding: 0 !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        width: 100% !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 #g2-promo-stack-slider .g2-side-promo,
      .theme-grocery2 #g2-promo-stack-slider .slick-slide.g2-side-promo,
      .theme-grocery2 .g2-promo-stack .g2-side-promo,
      .theme-grocery2 .g2-promo-stack.slick-initialized .g2-side-promo {
        margin: 0 !important;
        padding-left: 20px !important;
        padding-right: 20px !important;
        width: 100% !important;
        height: 200px !important;
        min-height: 200px !important;
        border-radius: 16px !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
      }
      .theme-grocery2 .g2-promo-stack.slick-initialized .slick-dots {
        display: none !important;
      }
      .theme-grocery2 .g2-hero-slider .g2-slider-item,
      .theme-grocery2 .g2-hero-slider .slick-slide.g2-slider-item {
        display: block !important;
        float: left !important;
        padding: 8px 12px 4px 12px !important;
        box-sizing: border-box !important;
        height: auto !important;
      }
      .theme-grocery2 .g2-hero-slider .g2-slider-content {
        background: rgba(255, 255, 255, 0.20) !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        padding: 16px 12px !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        border-radius: 14px !important;
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
        box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.06) !important;
      }
      .theme-grocery2 .g2-hero-slider .g2-title {
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.7) !important;
      }
      .theme-grocery2 .g2-hero-slider .g2-slider-btns {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 8px !important;
        width: 100% !important;
      }
      .theme-grocery2 .g2-hero-slider .g2-slider-btns .btn,
      .theme-grocery2 .g2-hero-slider .g2-slider-btns .g2-btn-primary {
        flex: 0 0 auto !important;
        width: auto !important;
        white-space: nowrap !important;
        text-align: center !important;
        padding: 10px 24px !important;
        font-size: 13px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 0 !important;
      }
      .theme-grocery2 .g2-hero-slider .g2-slider-btns .g2-btn-secondary {
        display: none !important;
      }
      .theme-grocery2 .g2-side-promo {
        padding: 24px 20px 24px 24px !important;
      }
    }
    @media (max-width: 991.98px) {
      /* Hero banner spacing fixes: eliminate unwanted top clearance and gaps (< 992px) */
      .theme-grocery2 .g2-hero-section,
      .theme-grocery2 .g2-hero-section.pt-3,
      .theme-grocery2 .g2-hero-section.pt-lg-3 {
        padding-top: 0 !important;
        margin-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .theme-grocery2 .g2-hero-section > .container,
      .theme-grocery2 .g2-hero-section .container {
        padding-left: 0 !important;
        padding-right: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
      }
      .theme-grocery2 .g2-hero-section .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
      .theme-grocery2 .g2-hero-section .row.g-4,
      .theme-grocery2 .g2-hero-section .row.g-lg-4 {
        --bs-gutter-y: 0 !important;
        row-gap: 0 !important;
      }
      .theme-grocery2 .g2-hero-section .row > [class*="col-"] {
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .theme-grocery2 .g2-hero-section .col-xl-8.col-lg-12.mb-4,
      .theme-grocery2 .g2-hero-section .col-xl-8.col-lg-12.mb-lg-4 {
        margin-bottom: 6px !important;
      }
      .theme-grocery2 .g2-hero-section .col-xl-4.col-lg-12.mb-4,
      .theme-grocery2 .g2-hero-section .col-xl-4.col-lg-12.mb-lg-4 {
        margin-top: 0 !important;
        padding-top: 0 !important;
        margin-bottom: 12px !important;
      }

      /* FOUC prevention before slick initializes (< 992px) */
      .theme-grocery2 #g2-main-slider:not(.slick-initialized) .g2-slider-item:not(:first-child),
      .theme-grocery2 #g2-promo-stack-slider:not(.slick-initialized) .g2-side-promo:not(:first-child) {
        display: none !important;
      }

      /* Slick track position reset (undo plugin.css left: 7px) */
      .theme-grocery2 .g2-hero-slider .slick-track,
      .theme-grocery2 .g2-promo-stack .slick-track,
      .theme-grocery2 #g2-main-slider .slick-track,
      .theme-grocery2 #g2-promo-stack-slider .slick-track {
        left: 0 !important;
      }

      /* Hero Slider: balanced left & right gap (< 992px) */
      .theme-grocery2 #g2-main-slider,
      .theme-grocery2 .g2-hero-slider {
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-left: 12px !important;
        padding-right: 12px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 #g2-main-slider.slick-slider .slick-list,
      .theme-grocery2 #g2-main-slider .slick-list,
      .theme-grocery2 .g2-hero-slider.slick-slider .slick-list,
      .theme-grocery2 .g2-hero-slider .slick-list {
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        box-sizing: border-box !important;
        border-radius: 16px !important;
        overflow: hidden !important;
      }
      .theme-grocery2 #g2-main-slider .g2-slider-item,
      .theme-grocery2 #g2-main-slider .slick-slide.g2-slider-item,
      .theme-grocery2 .g2-hero-slider .g2-slider-item,
      .theme-grocery2 .g2-hero-slider .slick-slide.g2-slider-item {
        display: block !important;
        float: left !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box !important;
        height: auto !important;
      }
      .theme-grocery2 .g2-slider-mobile-img {
        width: 100% !important;
        margin-top: 10px !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        display: block !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 .g2-slider-mobile-img img {
        width: 100% !important;
        height: 220px !important;
        object-fit: cover !important;
        border-radius: 16px !important;
        display: block !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 #g2-main-slider .slick-dots {
        position: static !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 6px !important;
        margin-top: 8px !important;
        margin-bottom: 8px !important;
        padding: 0 !important;
        list-style: none !important;
        width: 100% !important;
      }

      /* Promo Stack: balanced left & right space and zero top space (< 992px) */
      .theme-grocery2 #g2-promo-stack-slider,
      .theme-grocery2 .g2-promo-stack,
      .theme-grocery2 .g2-promo-stack.slick-initialized,
      .theme-grocery2 .g2-promo-stack.slick-initialized.slick-slider {
        margin-top: 0 !important;
        padding-top: 0 !important;
        padding-left: 12px !important;
        padding-right: 12px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        box-sizing: border-box !important;
        width: 100% !important;
        max-width: 100% !important;
      }
      .theme-grocery2 #g2-promo-stack-slider.slick-slider .slick-list,
      .theme-grocery2 #g2-promo-stack-slider .slick-list,
      .theme-grocery2 .g2-promo-stack.slick-slider .slick-list,
      .theme-grocery2 .g2-promo-stack.slick-initialized .slick-list,
      .theme-grocery2 .g2-promo-stack .slick-list {
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding: 0 !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        width: 100% !important;
        box-sizing: border-box !important;
      }
      .theme-grocery2 #g2-promo-stack-slider .g2-side-promo,
      .theme-grocery2 #g2-promo-stack-slider .slick-slide.g2-side-promo,
      .theme-grocery2 .g2-promo-stack .g2-side-promo,
      .theme-grocery2 .g2-promo-stack.slick-initialized .g2-side-promo {
        margin: 0 !important;
        padding-left: 20px !important;
        padding-right: 20px !important;
        width: 100% !important;
        height: 200px !important;
        min-height: 200px !important;
        border-radius: 16px !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
      }
      .theme-grocery2 .g2-promo-stack.slick-initialized .slick-dots {
        display: none !important;
      }

      /* Task 3: Arrow buttons beside Featured Categories on mobile view */
      .theme-grocery2 .g2-categories-section .g2-section-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-direction: row !important;
      }
      .theme-grocery2 .g2-categories-section .g2-arrow-nav {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
      }
      .theme-grocery2 .g2-category-bottom-arrows {
        display: none !important;
      }

      /* Mobile View: Full-width product card images without left/right gaps */
      .theme-grocery2 .g2-product-card {
        padding: 8px !important;
      }
      .theme-grocery2 .g2-product-image {
        width: 100% !important;
        height: 145px !important;
        margin-bottom: 6px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
        border-radius: 8px !important;
        background: #fbfbfb !important;
      }
      .theme-grocery2 .g2-img-link {
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
      }
      .theme-grocery2 .g2-product-image img,
      .theme-grocery2 .g2-img-link .primary-img,
      .theme-grocery2 .g2-img-link .secondary-img {
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: cover !important;
        object-position: center !important;
        display: block !important;
        border-radius: 8px !important;
      }
      .theme-grocery2 .g2-badge-tag {
        top: 6px !important;
        left: 6px !important;
        font-size: 10px !important;
        padding: 3px 8px !important;
        border-radius: 4px !important;
        white-space: nowrap !important;
        z-index: 6 !important;
      }
    }

    /* Mobile View: Newsletter input & button stacking to prevent button text cut off */
    @media (max-width: 575.98px) {
      .theme-grocery2 .g2-news-form {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
        gap: 10px !important;
        width: 100% !important;
      }
      .theme-grocery2 .g2-news-input {
        background: #ffffff !important;
        border-radius: 8px !important;
        padding: 12px 16px !important;
        width: 100% !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important;
        font-size: 14px !important;
      }
      .theme-grocery2 .g2-news-btn {
        width: 100% !important;
        padding: 12px 20px !important;
        border-radius: 8px !important;
        text-align: center !important;
        white-space: normal !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(71, 102, 145, 0.3) !important;
      }
    }
  </style>
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

@if ($userBs->theme == 'manti' || $userBs->theme == 'vegetables' || $userBs->theme == 'grocery' || $userBs->theme == 'kids' || $userBs->theme == 'fashion' || $userBs->theme == 'electronics')
<style>
  .header-bottom {
    margin-top: 1rem !important;
  }
</style>
@endif

<style>
/* ==========================================================================
   MOBILE & LAYOUT ALIGNMENT FIXES (All Templates)
   ========================================================================== */

/* --- Global Horizontal (Bottom) Scroll Prevention for All Themes --- */
html {
  overflow-x: hidden !important;
}

body {
  overflow-x: hidden !important;
  max-width: 100% !important;
  width: 100% !important;
  position: relative !important;
}

.wrapper,
.main-panel,
.content,
.page-inner,
.header-area,
.footer-area,
.main-wrapper,
.body-wrapper,
.page-wrapper,
section,
header,
footer {
  overflow-x: clip !important;
  max-width: 100% !important;
}

/* --- Global: Hide horizontal scrolling bar/indicator across all themes while preserving scrolling --- */
.shop-category-pills,
.g2-product-filters,
.g2-product-filters ul,
.g2-product-filters .nav,
.nav-tabs,
.nav-pills,
.category-filter-tabs,
.product-filters,
.filter-tabs,
.horizontal-scroll,
.tabs-navigation,
[class*="filter-tabs"],
[class*="-pills"],
[class*="product-filters"] {
  overflow-x: auto !important;
  scrollbar-width: none !important;
  -ms-overflow-style: none !important;
}

.shop-category-pills::-webkit-scrollbar,
.g2-product-filters::-webkit-scrollbar,
.g2-product-filters ul::-webkit-scrollbar,
.g2-product-filters .nav::-webkit-scrollbar,
.nav-tabs::-webkit-scrollbar,
.nav-pills::-webkit-scrollbar,
.category-filter-tabs::-webkit-scrollbar,
.product-filters::-webkit-scrollbar,
.filter-tabs::-webkit-scrollbar,
.horizontal-scroll::-webkit-scrollbar,
.tabs-navigation::-webkit-scrollbar,
[class*="filter-tabs"]::-webkit-scrollbar,
[class*="-pills"]::-webkit-scrollbar,
[class*="product-filters"]::-webkit-scrollbar {
  display: none !important;
  width: 0 !important;
  height: 0 !important;
}

/* --- Task 2: Page Title Area (About/Inner Headers) Spacing Fix --- */
@if ($userBs->theme == 'fashion' || $userBs->theme == 'furniture' || $userBs->theme == 'clothing' || $userBs->theme == 'jewellery' || $userBs->theme == 'skinflow' || $userBs->theme == 'pet')
/* For templates with fixed headers, we need top padding to prevent header overlap */
.page-title-area {
  padding-top: 100px !important;
  padding-bottom: 30px !important;
}

@media only screen and (max-width: 991.98px) {
  .page-title-area {
    padding-top: 80px !important;
    padding-bottom: 25px !important;
  }
}
@else
/* For other templates, use the compact spacing */
.page-title-area {
  padding-top: 0px !important;
  padding-bottom: 0px !important;
}

@media only screen and (max-width: 991.98px) {
  .page-title-area {
    padding-top: 15px !important;
    padding-bottom: 23px !important;
  }
}
@endif

/* Reduce page title font size on desktop only */
@media only screen and (min-width: 992px) {
  @if ($userBs->theme == 'fashion' || $userBs->theme == 'furniture' || $userBs->theme == 'clothing' || $userBs->theme == 'jewellery' || $userBs->theme == 'skinflow' || $userBs->theme == 'pet')
  /* Keep compact padding for fixed header templates on desktop */
  .page-title-area {
    padding-top: 100px !important;
    padding-bottom: 30px !important;
  }
  @else
  .page-title-area {
    padding-top: 30px !important;
    padding-bottom: 30px !important;
  }
  @endif

  .page-title-area h1,
  .page-title-area h2,
  .page-title-area h3,
  .page-title-area .content h2 {
    font-size: 28px !important;
  }

  .product-single {
    padding-top: 40px !important;
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
        /* flex-wrap: wrap !important; */
        white-space: nowrap !important;
        gap: 4px !important;
        align-items: center !important;
        width: 100% !important;
        justify-content: center;
        margin-bottom: 2px;
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
    /* margin: 0 auto !important; */
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

/* --- Task 3: Cart Popup Padding & Styling Fix (All Templates) --- */
.cart-dropdown,
#cart-dropdown-header,
#cart-dropdown-mobile {
  padding: 20px 24px 24px 24px !important;
  box-sizing: border-box !important;
  border-radius: 8px !important;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
  border: 1px solid rgba(0, 0, 0, 0.08) !important;
}

.cart-dropdown-list {
  padding: 0 !important;
  margin: 0 0 15px 0 !important;
  list-style: none !important;
}

.cart-dropdown-list-item {
  position: relative !important;
  padding: 15px 0 !important;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
  display: flex !important;
  align-items: flex-start !important;
  width: 100% !important;
  box-sizing: border-box !important;
}

.cart-dropdown-list-item:last-child {
  border-bottom: none !important;
}

.cart-dropdown-list-item .cart-img {
  width: 70px !important;
  height: 70px !important;
  margin-right: 15px !important;
  flex-shrink: 0 !important;
  border-radius: 6px !important;
  border: 1px solid rgba(0, 0, 0, 0.08) !important;
  overflow: hidden !important;
}

.cart-dropdown-list-item .cart-img img {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
}

.cart-dropdown-list-item .cart-title {
  flex-grow: 1 !important;
  min-width: 0 !important;
  padding-right: 10px !important;
}

.cart-dropdown-list-item .cart-title .product-title {
  margin-top: 0 !important;
  margin-bottom: 6px !important;
  font-size: 14px !important;
  font-weight: 600 !important;
  line-height: 1.3 !important;
}

.cart-dropdown-list-item .cart-title .product-title a {
  color: #111 !important;
  text-decoration: none !important;
}

.cart-dropdown-list-item .cart-delete {
  position: static !important;
  margin-left: auto !important;
  flex-shrink: 0 !important;
  align-self: flex-start !important;
  right: auto !important;
  top: auto !important;
  transform: none !important;
}

.cart-dropdown-list-item .cart-delete .btn-remove {
  width: 24px !important;
  height: 24px !important;
  line-height: 24px !important;
  font-size: 12px !important;
  border-radius: 50% !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  background: rgba(0, 0, 0, 0.05) !important;
  color: #666 !important;
  transition: all 0.2s ease !important;
}

.cart-dropdown-list-item .cart-delete .btn-remove:hover {
  background: #ff3f5c !important;
  color: #fff !important;
}

/* Variation table overrides inside cart items */
.cart-dropdown-list-item .variation-table {
  width: 100% !important;
  margin: 4px 0 !important;
  border-collapse: collapse !important;
  border: none !important;
}

.cart-dropdown-list-item .variation-table tr {
  display: flex !important;
  justify-content: space-between !important;
  align-items: flex-start !important;
  width: 100% !important;
  margin-bottom: 2px !important;
}

.cart-dropdown-list-item .variation-table td {
  padding: 0 !important;
  border: none !important;
  font-size: 12px !important;
  background: transparent !important;
}

.cart-dropdown-list-item .variation-table td:first-child {
  font-weight: 500 !important;
  color: #666 !important;
  padding-right: 10px !important;
}

.cart-dropdown-list-item .variation-table td:last-child {
  text-align: right !important;
  font-weight: 600 !important;
  color: #111 !important;
}

.cart-footer {
  padding-top: 15px !important;
  border-top: 1px solid rgba(0, 0, 0, 0.08) !important;
}

/* Empty cart spacing */
.cart-dropdown h4.text-center,
#cart-dropdown-header h4.text-center,
#cart-dropdown-mobile h4.text-center {
  padding: 30px 10px !important;
  margin: 0 !important;
  font-size: 16px !important;
  font-weight: 500 !important;
  color: #6c757d !important;
}

/* --- Global Cart Sidebar Drawer & Overlay Backdrop --- */
.cart-sidebar-overlay {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  background: rgba(0, 0, 0, 0.4) !important;
  z-index: 999999 !important;
  opacity: 0 !important;
  visibility: hidden !important;
  transition: all 0.3s ease !important;
}

.cart-sidebar-overlay.active {
  opacity: 1 !important;
  visibility: visible !important;
}

#cart-dropdown-mobile {
  position: fixed !important;
  top: 0 !important;
  bottom: 0 !important;
  right: -420px !important;
  left: auto !important;
  width: 420px !important;
  max-width: 100% !important;
  height: auto !important;
  max-height: 100vh !important;
  max-height: 100dvh !important;
  overflow: hidden !important;
  background: #ffffff !important;
  border-left: 1px solid #e5e1db !important;
  border-right: none !important;
  box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15) !important;
  margin-top: 0 !important;
  z-index: 1000000 !important;
  border-radius: 0 !important;
  padding: 18px 20px calc(20px + env(safe-area-inset-bottom, 0px)) 20px !important;
  opacity: 1 !important;
  visibility: visible !important;
  transform: none !important;
  transition: right 0.4s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
  display: flex !important;
  flex-direction: column !important;
}

#cart-dropdown-mobile.active {
  right: 0 !important;
  left: auto !important;
}

/* Close button and list item styling overrides for sidebar drawer */
.cart-dropdown .cart-header {
  display: flex !important;
  flex-shrink: 0 !important;
}

#cart-dropdown-mobile .cart-dropdown-list {
  flex: 1 1 auto !important;
  min-height: 0 !important;
  max-height: none !important;
  overflow-y: auto !important;
  -webkit-overflow-scrolling: touch !important;
  margin-bottom: 12px !important;
}

#cart-dropdown-mobile .cart-footer {
  flex-shrink: 0 !important;
  margin-top: auto !important;
  padding-top: 12px !important;
  background: #ffffff !important;
}


/* ── Ensure header-top is a single line on desktop screens (min-width: 1600px) ── */
@media (min-width: 1600px) {
  .header-top .row {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
  }
  /* Hide the empty middle column */
  .header-top .row > div:nth-child(2) {
    display: none !important;
  }
  /* Expand left and right columns to fill available space */
  .header-top .row > div:first-child {
    flex: 1 1 auto !important;
    width: auto !important;
  }
  .header-top .row > div:last-child {
    flex: 1 1 auto !important;
    max-width: 50% !important;
    width: auto !important;
    display: flex !important;
    justify-content: flex-end !important;
    align-items: center !important;
  }
  /* Force right menu items to stay inline */
  .header-top .header-right ul.menu {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
    margin: 0 !important;
    padding: 0 !important;
    gap: 15px !important;
  }
  .header-top .header-right ul.menu > li {
    white-space: nowrap !important;
    display: inline-flex !important;
    align-items: center !important;
  }
}

/* Ensure all modals and backdrops are rendered above any headers */
.modal {
  z-index: 999999 !important;
}
.modal-backdrop {
  z-index: 999998 !important;
}

/* Prevent gallery slider and thumbnail overlap on laptop/desktop views */
@media (min-width: 992px) {
  .product-single-default .product-single-gallery {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    align-items: start !important;
    gap: 0 !important;
  }
  .product-single-default .slider-thumbnails,
  .product-single-default .slider-thumbnails2 {
    width: 80px !important;
    flex: 0 0 80px !important;
    max-width: 80px !important;
    margin-right: 20px !important;
  }
  .product-single-default .product-single-slider,
  .product-single-default .product-single-slider2 {
    width: calc(100% - 100px) !important;
    flex: 0 0 calc(100% - 100px) !important;
    max-width: calc(100% - 100px) !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
}

/* Ensure elevateZoom container doesn't block layout or capture pointer clicks when not active */
.zoomContainer {
  pointer-events: none !important;
}
.zoomContainer .zoomWindowContainer,
.zoomContainer .zoomWindow {
  pointer-events: auto !important;
}

/* --- Global Header Logo Size Enhancements (All Themes) --- */
.mobile-navbar .logo img,
.mobile-navbar-inner .logo img,
.header-area .logo img,
.header-navigation .logo img {
  max-height: 55px !important;
  max-width: 230px !important;
  width: auto !important;
  height: auto !important;
  object-fit: contain !important;
}

@media (min-width: 992px) {
  .brand-logo img,
  .header-middle .brand-logo img,
  .header-area .brand-logo img,
  .navbar-brand img,
  .site-logo img {
    max-height: 75px !important;
    max-width: 280px !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
  }
}

/* --- Global Footer Logo Display & Visibility Fix (All Themes & Breakpoints) --- */
.footer-widget .navbar-brand,
.footer-area .navbar-brand,
.footer-logo {
  display: inline-block !important;
  max-width: 100% !important;
}

.footer-widget .navbar-brand a,
.footer-area .navbar-brand a,
.footer-logo a {
  display: inline-block !important;
}

.footer-widget .navbar-brand img,
.footer-area .navbar-brand img,
.footer-widget .footer-logo img,
.footer-area .footer-logo img,
.footer-logo img {
  display: block !important;
  visibility: visible !important;
  opacity: 1 !important;
  max-height: 65px !important;
  max-width: 240px !important;
  width: auto !important;
  height: auto !important;
  object-fit: contain !important;
}

/* --- Global Mobile Copyright Display & Bottom Clearance Fix (All Themes) --- */
@media only screen and (max-width: 991.98px) {
  footer, .footer-area, .copy-right-area, .copy-right-content, .footer-bottom {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
  }
  footer, .footer-area {
    padding-bottom: 5px !important;
  }
  .copy-right-area, .footer-bottom {
    padding-top: 15px !important;
    /* padding-bottom: 85px !important; */
    margin-bottom: 0 !important;
    text-align: center !important;
    display: block !important;
    position: relative !important;
    z-index: 10 !important;
  }
  .copy-right-content span, .copy-right-area p, .copy-right-area span, .footer-bottom span, .footer-bottom p {
    display: inline-block !important;
    color: inherit !important;
    font-size: 13px !important;
    line-height: 1.5 !important;
  }
}

@media only screen and (max-width: 767.98px) {
  .footer-area .footer-widget {
    margin-bottom: 22px;
  }
  .footer-area .footer-widget h3 {
    font-size: 16px;
    margin-bottom: 14px;
  }
  .footer-area .footer-widget .footer-links li {
    font-size: 13px;
    line-height: 1.45;
    margin-bottom: 10px;
  }
  .footer-area .footer-widget .footer-links li,
  .footer-area .footer-widget .footer-links li a,
  .footer-area .footer-widget .footer-links li span,
  .footer-area .footer-widget-email,
  .footer-area .footer-widget-number,
  .footer-area .footer-widget-address {
    min-width: 0;
    overflow-wrap: anywhere;
    word-break: break-word;
  }
}

/* --- Global Order Success Page Clearances & Alignment Fix (All Themes) --- */
.purchase-message {
  padding-top: 240px !important;
  padding-bottom: 90px !important;
  position: relative !important;
  z-index: 1 !important;
}

@media only screen and (max-width: 1199.98px) {
  .purchase-message {
    padding-top: 140px !important;
    padding-bottom: 70px !important;
  }
}

@media only screen and (max-width: 767.98px) {
  .purchase-message {
    padding-top: 110px !important;
    padding-bottom: 50px !important;
  }
}

/* For themes with in-flow sticky headers such as Grocery2 */
.theme-grocery2 .purchase-message {
  padding-top: 60px !important;
  padding-bottom: 70px !important;
}

@media only screen and (max-width: 767.98px) {
  .theme-grocery2 .purchase-message {
    padding-top: 40px !important;
    padding-bottom: 40px !important;
  }
}

.purchase-success {
  max-width: 520px !important;
  margin-left: auto !important;
  margin-right: auto !important;
  text-align: center !important;
}

.success-icon-area {
  max-width: 250px !important;
  margin: 0 auto 25px auto !important;
}

.success-icon-area svg {
  width: 100% !important;
  height: auto !important;
  max-height: 240px !important;
  object-fit: contain !important;
  display: block !important;
  margin: 0 auto !important;
}

/* --- Global Footer Contact Us Clean Single-Line Phone & Email Formatting --- */
.footer-widget-number {
  display: flex !important;
  flex-wrap: wrap !important;
  align-items: center !important;
  gap: 4px !important;
}

.footer-widget-number .phone-item {
  display: inline-flex !important;
  align-items: center !important;
  white-space: nowrap !important;
}

.footer-widget-number a {
  display: inline-block !important;
  white-space: nowrap !important;
}

.footer-widget-email a {
  display: block !important;
  word-break: break-all !important;
}

/* =========================================================
   UNIVERSAL PIXEL-PERFECT QUICK VIEW MODAL (ALL THEMES)
   ========================================================= */

.quick-view-modal .modal-dialog,
#quickViewModal .modal-dialog {
    max-width: 900px !important;
    margin: 30px auto !important;
}

.quick-view-modal .modal-content,
#quickViewModal .modal-content {
    border-radius: 16px !important;
    padding: 28px !important;
    border: none !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
    background: #ffffff !important;
    position: relative !important;
}

/* Close Button (Top Right Red X) */
.quick-view-modal .close_modal_btn,
.quick-view-modal .btn-close,
#quickViewModal .close_modal_btn,
#quickViewModal .btn-close {
    position: absolute !important;
    top: 14px !important;
    right: 14px !important;
    width: 32px !important;
    height: 32px !important;
    background-color: #ff3f5c !important;
    color: #ffffff !important;
    border-radius: 6px !important;
    border: none !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 16px !important;
    opacity: 1 !important;
    cursor: pointer !important;
    z-index: 100 !important;
    transition: all 0.2s ease !important;
}

.quick-view-modal .close_modal_btn:hover,
.quick-view-modal .btn-close:hover,
#quickViewModal .close_modal_btn:hover,
#quickViewModal .btn-close:hover {
    background-color: #e02847 !important;
}

/* Gallery Container Layout */
.quick-view-modal .product-single-gallery,
#quickViewModal .product-single-gallery {
    display: flex !important;
    flex-direction: row !important;
    align-items: flex-start !important;
    gap: 15px !important;
    width: 100% !important;
}

#quickViewModal .slider-thumbnails,
.quick-view-modal .slider-thumbnails {
    width: 75px !important;
    min-width: 75px !important;
    max-width: 75px !important;
    flex-shrink: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
}

#quickViewModal .slider-thumbnails .thumbnail-img,
.quick-view-modal .slider-thumbnails .thumbnail-img {
    width: 75px !important;
    height: 75px !important;
    box-shadow: none !important;
    outline: none !important;
    margin-bottom: 8px !important;
    border-radius: 8px !important;
    border: 1px solid #e2e8f0 !important;
    overflow: hidden !important;
    background: #ffffff !important;
    cursor: pointer !important;
}

#quickViewModal .slider-thumbnails .thumbnail-img img,
.quick-view-modal .slider-thumbnails .thumbnail-img img {
    border: none !important;
    border-radius: 6px !important;
    object-fit: cover !important;
    display: block !important;
    width: 100% !important;
    height: 100% !important;
}

#quickViewModal .product-single-slider,
.quick-view-modal .product-single-slider {
    flex: 1 !important;
    width: calc(100% - 90px) !important;
    min-width: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
}

#quickViewModal .product-single-slider img,
.quick-view-modal .product-single-slider img {
    max-width: 100% !important;
    max-height: 380px !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    margin: 0 auto !important;
    display: block !important;
    border-radius: 10px !important;
}

@media (min-width: 768px) {
    #quickViewModal .qv-cart-action-row .qv-add-to-cart-wrap,
    .quick-view-modal .qv-cart-action-row .qv-add-to-cart-wrap {
        flex: 0 0 100% !important;
        width: 100% !important;
        margin-top: 8px !important;
    }
}

/* Mobile View Quick View Responsive Layout (< 768px) */
@media (max-width: 767.98px) {
    #quickViewModal .modal-dialog,
    .quick-view-modal .modal-dialog {
        width: calc(100% - 16px) !important;
        max-width: calc(100% - 16px) !important;
        margin: 12px auto !important;
    }

    #quickViewModal .modal-content,
    .quick-view-modal .modal-content {
        padding: 16px 14px !important;
    }

    #quickViewModal .modal-body,
    .quick-view-modal .modal-body {
        padding: 0 !important;
    }

    #quickViewModal #quickViewModalContent,
    #quickViewModal .modal-body > .row,
    .quick-view-modal .modal-body > .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        --bs-gutter-x: 0 !important;
    }

    #quickViewModal #quickViewModalContent > [class*="col-"],
    .quick-view-modal .modal-body > .row > [class*="col-"] {
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important;
    }

    #quickViewModal .product-single-default,
    .quick-view-modal .product-single-default {
        margin-bottom: 12px !important;
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #quickViewModal .product-single-gallery,
    .quick-view-modal .product-single-gallery {
        flex-direction: column !important;
        align-items: center !important;
        width: 100% !important;
        gap: 10px !important;
        margin-bottom: 0 !important;
    }

    #quickViewModal .product-single-slider,
    .quick-view-modal .product-single-slider {
        order: 1 !important;
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
        margin-bottom: 0 !important;
    }

    #quickViewModal .product-single-slider .slick-slide figure,
    .quick-view-modal .product-single-slider .slick-slide figure {
        margin: 0 !important;
        width: 100% !important;
    }

    #quickViewModal .product-single-slider img,
    .quick-view-modal .product-single-slider img {
        max-height: 260px !important;
        width: auto !important;
        max-width: 100% !important;
        height: auto !important;
        object-fit: contain !important;
        display: block !important;
        margin: 0 auto !important;
    }

    #quickViewModal .slider-thumbnails,
    .quick-view-modal .slider-thumbnails {
        order: 2 !important;
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
        display: flex !important;
        flex-direction: row !important;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        position: relative !important;
        z-index: 10 !important;
    }

    #quickViewModal .slider-thumbnails .slick-list,
    .quick-view-modal .slider-thumbnails .slick-list {
        width: 100% !important;
        height: auto !important;
        min-height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    #quickViewModal .slider-thumbnails .slick-track,
    .quick-view-modal .slider-thumbnails .slick-track {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
        width: 100% !important;
        height: auto !important;
        transform: none !important;
    }

    #quickViewModal .slider-thumbnails .slick-slide,
    .quick-view-modal .slider-thumbnails .slick-slide {
        width: 55px !important;
        height: 55px !important;
        margin: 0 !important;
        border: none !important;
    }

    #quickViewModal .slider-thumbnails .thumbnail-img,
    .quick-view-modal .slider-thumbnails .thumbnail-img {
        width: 55px !important;
        height: 55px !important;
        min-width: 55px !important;
        max-width: 55px !important;
        margin: 0 !important;
        margin-bottom: 0 !important;
    }

    #quickViewModal .product-single-details,
    .quick-view-modal .product-single-details {
        margin-top: 12px !important;
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        position: relative !important;
        z-index: 1 !important;
        clear: both !important;
        display: block !important;
        width: 100% !important;
        text-align: left !important;
    }

    #quickViewModal .product-single-details > ul,
    .quick-view-modal .product-single-details > ul {
        padding-left: 0 !important;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        list-style: none !important;
    }

    /* SKU + Flash Countdown Timer on a single row on mobile only */
    #quickViewModal .qv-sku-timer-row.has-timer,
    .quick-view-modal .qv-sku-timer-row.has-timer {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-wrap: nowrap !important;
        gap: 8px !important;
        width: 100% !important;
        margin-bottom: 12px !important;
    }

    #quickViewModal .qv-sku-timer-row.has-timer .sku-code,
    .quick-view-modal .qv-sku-timer-row.has-timer .sku-code {
        margin: 0 !important;
        font-size: 12px !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
    }

    #quickViewModal .qv-sku-timer-row .product-countdown,
    .quick-view-modal .qv-sku-timer-row .product-countdown {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        flex-wrap: nowrap !important;
        gap: 4px !important;
        margin: 0 !important;
        min-width: 0 !important;
    }

    #quickViewModal .qv-sku-timer-row .product-countdown .count,
    .quick-view-modal .qv-sku-timer-row .product-countdown .count {
        width: 34px !important;
        min-width: 34px !important;
        height: 34px !important;
        margin: 0 !important;
        padding: 2px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 1.05 !important;
    }

    #quickViewModal .qv-sku-timer-row .product-countdown .count span:first-child,
    .quick-view-modal .qv-sku-timer-row .product-countdown .count span:first-child {
        font-size: 11px !important;
        font-weight: 700 !important;
        margin-bottom: 1px !important;
    }

    #quickViewModal .qv-sku-timer-row .product-countdown .count .count-period,
    .quick-view-modal .qv-sku-timer-row .product-countdown .count .count-period {
        font-size: 8.5px !important;
    }

    #quickViewModal .qv-sku-timer-row .product-countdown .details-label-discount-percentage,
    .quick-view-modal .qv-sku-timer-row .product-countdown .details-label-discount-percentage {
        --size: 28px !important;
        width: 28px !important;
        height: 28px !important;
        line-height: 28px !important;
        margin-inline-start: 4px !important;
        top: 0 !important;
    }

    #quickViewModal .qv-sku-timer-row .product-countdown .details-label-discount-percentage .percentage-text,
    .quick-view-modal .qv-sku-timer-row .product-countdown .details-label-discount-percentage .percentage-text {
        width: 100% !important;
        height: 100% !important;
        left: 0 !important;
        top: 0 !important;
        font-size: 8.5px !important;
    }

    #quickViewModal .qv-sku-timer-row .product-countdown .details-label-discount-percentage .percentage-text svg,
    .quick-view-modal .qv-sku-timer-row .product-countdown .details-label-discount-percentage .percentage-text svg {
        width: 11px !important;
        height: 11px !important;
    }

    /* Quantity + Compare/Wishlist Icons + Add To Cart in a single row on mobile */
    #quickViewModal .qv-cart-action-row,
    .quick-view-modal .qv-cart-action-row {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 6px !important;
        width: 100% !important;
        margin-bottom: 16px !important;
    }

    #quickViewModal .modal-content,
    .quick-view-modal .modal-content {
        overflow-x: hidden !important;
    }

    #quickViewModal .qv-cart-action-row,
    .quick-view-modal .qv-cart-action-row {
        gap: 6px !important;
        max-width: 100% !important;
        flex-wrap: nowrap !important;
    }

    #quickViewModal .qv-cart-action-row .item_quantity,
    #quickViewModal .qv-cart-action-row .quantity-input,
    .quick-view-modal .qv-cart-action-row .item_quantity,
    .quick-view-modal .qv-cart-action-row .quantity-input {
        width: auto !important;
        min-width: 0 !important;
        max-width: fit-content !important;
        flex: 0 0 auto !important;
        height: 38px !important;
        margin: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    #quickViewModal .qv-cart-action-row .qv-add-to-cart-wrap,
    .quick-view-modal .qv-cart-action-row .qv-add-to-cart-wrap {
        flex: 1 1 0% !important;
        min-width: 0 !important;
    }

    #quickViewModal .qv-cart-action-row .qv-add-to-cart-btn,
    .quick-view-modal .qv-cart-action-row .qv-add-to-cart-btn {
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        padding: 0 8px !important;
        white-space: nowrap !important;
    }

    #quickViewModal .qv-cart-action-row .item_quantity .quantity-btn,
    .quick-view-modal .qv-cart-action-row .item_quantity .quantity-btn {
        width: 28px !important;
        height: 38px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 11px !important;
    }

    #quickViewModal .qv-cart-action-row .item_quantity .quantity_field,
    #quickViewModal .qv-cart-action-row .quantity-input .quantity_field,
    .quick-view-modal .qv-cart-action-row .item_quantity .quantity_field,
    .quick-view-modal .qv-cart-action-row .quantity-input .quantity_field {
        width: 30px !important;
        min-width: 30px !important;
        max-width: 30px !important;
        flex: 0 0 30px !important;
        box-sizing: border-box !important;
        height: 38px !important;
        padding: 0 !important;
        text-align: center !important;
        font-size: 13px !important;
    }

    #quickViewModal .qv-cart-action-row .btn-icon-group,
    .quick-view-modal .qv-cart-action-row .btn-icon-group {
        width: auto !important;
        flex: 0 0 auto !important;
        display: inline-flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        margin: 0 !important;
    }

    #quickViewModal .qv-cart-action-row .btn-icon-group .btn.btn-icon,
    .quick-view-modal .qv-cart-action-row .btn-icon-group .btn.btn-icon {
        --size: 34px !important;
        width: 34px !important;
        min-width: 34px !important;
        max-width: 34px !important;
        height: 34px !important;
        line-height: 34px !important;
        margin: 0 !important;
        padding: 0 !important;
        font-size: 13px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    #quickViewModal .qv-cart-action-row .btn-icon-group .btn.btn-icon i,
    .quick-view-modal .qv-cart-action-row .btn-icon-group .btn.btn-icon i {
        font-size: 13px !important;
    }

    #quickViewModal .qv-cart-action-row .qv-add-to-cart-wrap,
    .quick-view-modal .qv-cart-action-row .qv-add-to-cart-wrap {
        flex: 1 1 auto !important;
        min-width: 0 !important;
        margin: 0 !important;
    }

    #quickViewModal .qv-cart-action-row .qv-add-to-cart-btn,
    .quick-view-modal .qv-cart-action-row .qv-add-to-cart-btn {
        width: 100% !important;
        height: 38px !important;
        padding: 0 10px !important;
        font-size: 12.5px !important;
        white-space: nowrap !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        border-radius: 8px !important;
    }
}

/* =========================================================================
   Unified, Even Section Spacing (Multipurpose, Electronics & All Themes)
   ========================================================================= */
/* Electronics Theme Spacing */
.category.pb-100,
.electronics-category-section {
    padding-top: 25px !important;
    padding-bottom: 25px !important;
    margin-bottom: 0 !important;
}

/* Universal Preloader styling across all themes */
.preloader {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background: #ffffff !important;
    z-index: 9999999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: opacity 0.4s ease, visibility 0.4s ease !important;
}

.preloader.hidden {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

.preloader .preloader-wrapper {
    position: relative !important;
    width: 110px !important;
    height: 110px !important;
    max-width: 80vw !important;
    max-height: 80vh !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    left: auto !important;
    top: auto !important;
    transform: none !important;
}

.preloader .preloader-wrapper::before,
.preloader .preloader-wrapper::after {
    display: none !important;
}

.preloader .preloader-wrapper img {
    display: block !important;
    max-width: 100% !important;
    max-height: 100% !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
}

.category-slider:not(.slick-initialized) {
    display: flex !important;
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    justify-content: center !important;
    gap: 15px !important;
    width: 100% !important;
}

.category-slider:not(.slick-initialized) > * {
    flex: 0 0 auto !important;
    max-width: 165px !important;
}

.category-slider .slick-track {
    display: flex !important;
    align-items: center !important;
}

.category-slider .slick-slide {
    display: block !important;
    float: none !important;
    height: auto !important;
}

.category .category-item {
    margin-bottom: 12px !important;
}

.category .text-center.mt-20 {
    margin-top: 10px !important;
    margin-bottom: 10px !important;
}

.product-with-border.actual-content {
    margin-top: 24px !important;
    padding-top: 16px !important;
    padding-bottom: 50px !important;
}

.product-with-border.actual-content .product-inner {
    margin-top: 10px !important;
}

section.products.actual-content {
    margin-top: 24px !important;
    padding-top: 16px !important;
    padding-bottom: 50px !important;
}

/* Multipurpose (Manti) Theme Spacing */
.theme-manti section.category.category-6,
section.category.category-6 {
    padding-top: 25px !important;
    padding-bottom: 25px !important;
    margin-bottom: 0 !important;
}

.theme-manti .category-6 .category-item .category-img,
.category-6 .category-item .category-img {
    margin-bottom: 14px !important;
}

.theme-manti section.section.actual-content,
.theme-manti section.product-area.actual-content,
.theme-manti section.rated-area.actual-content {
    padding-top: 16px !important;
    padding-bottom: 45px !important;
    margin-top: 16px !important;
}

/* Mobile Spacing Fixes (< 992px) */
@media only screen and (max-width: 991.98px) {
    section.featured.featured-2.pb-70 {
        padding-bottom: 15px !important;
    }

    .category.pb-100,
    .electronics-category-section {
        padding-top: 15px !important;
        padding-bottom: 12px !important;
        margin-bottom: 0 !important;
    }

    .category .section-title.title-center {
        margin-bottom: 16px !important;
    }

    .category .section-title.title-center .title {
        margin-bottom: 6px !important;
        font-size: 22px !important;
    }

    .category .category-slider {
        margin-bottom: 6px !important;
    }

    .category .category-item {
        margin-bottom: 6px !important;
    }

    .category .text-center.mt-20 {
        margin-top: 6px !important;
        margin-bottom: 0 !important;
    }

    .product-with-border.actual-content,
    .product-with-border.lazy {
        margin-top: 20px !important;
        padding-top: 0 !important;
        padding-bottom: 25px !important;
    }

    .product-with-border .product-inner,
    .product-with-border.actual-content .product-inner {
        margin-top: 0 !important;
        padding: 45px 15px 20px !important;
    }

    section.products.actual-content,
    section.products.lazy {
        margin-top: 14px !important;
        padding-top: 10px !important;
        padding-bottom: 30px !important;
    }

    .theme-manti section.category.category-6,
    section.category.category-6 {
        padding-top: 18px !important;
        padding-bottom: 18px !important;
    }

    .theme-manti section.section.actual-content,
    .theme-manti section.product-area.actual-content,
    .theme-manti section.rated-area.actual-content {
        padding-top: 10px !important;
        padding-bottom: 28px !important;
        margin-top: 12px !important;
    }
}

/* =========================================================================
   Ultra-Smooth 60FPS Slick Slider Acceleration (All Themes)
   ========================================================================= */
.slick-slider {
    -webkit-tap-highlight-color: transparent;
}

.slick-track {
    will-change: transform;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-perspective: 1000px;
    perspective: 1000px;
}

.slick-slide {
    outline: none !important;
}

.slick-slide a,
.slick-slide a:focus,
.slick-slide:focus {
    outline: none !important;
}

.slick-slide img,
.category-slider img,
.animated-slider img {
    -webkit-user-drag: none;
    -khtml-user-drag: none;
    -moz-user-drag: none;
    -o-user-drag: none;
    user-drag: none;
}

/* Specific Spacing for Kids Theme - Favorite Categories & Sections */
section.category-5 {
    padding-top: 70px !important;
    padding-bottom: 40px !important;
    margin-top: 25px !important;
}

.quick-view-modal .lazy-container,
#quickViewModal .lazy-container {
    background-color: transparent !important;
}

.quick-view-modal .lazy-container::after,
#quickViewModal .lazy-container::after {
    display: none !important;
}

#quickViewModal .zoomContainer,
#quickViewModal .zoomWindowContainer,
.quick-view-modal .zoomContainer,
.quick-view-modal .zoomWindowContainer {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

#quickViewModal .product-single-slider .slick-slide a,
.quick-view-modal .product-single-slider .slick-slide a {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
}

/* Right Details Column Alignments */
.quick-view-modal .product-single-details,
#quickViewModal .product-single-details {
    padding-left: 10px !important;
}

.quick-view-modal .product-title,
#quickViewModal .product-title {
    font-size: 21px !important;
    font-weight: 700 !important;
    line-height: 1.35 !important;
    color: #1e293b !important;
    margin-bottom: 10px !important;
}

.quick-view-modal .rating-wrapper,
#quickViewModal .rating-wrapper {
    font-size: 13px !important;
    color: #64748b !important;
}

.quick-view-modal .stock-status .badge.bg-success,
#quickViewModal .stock-status .badge.bg-success {
    background-color: #dcfce7 !important;
    color: #15803d !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    padding: 4px 10px !important;
    border-radius: 6px !important;
}

.quick-view-modal .product-price,
#quickViewModal .product-price {
    display: flex !important;
    align-items: baseline !important;
    gap: 10px !important;
    margin-top: 12px !important;
    margin-bottom: 12px !important;
}

.quick-view-modal .new-price-area .new-price,
#quickViewModal .new-price-area .new-price {
    font-size: 24px !important;
    font-weight: 700 !important;
    color: #0f5b3f !important;
}

.quick-view-modal .old-price-area .old-price,
#quickViewModal .old-price-area .old-price {
    font-size: 16px !important;
    color: #94a3b8 !important;
    text-decoration: line-through !important;
}

.quick-view-modal .discountoff,
#quickViewModal .discountoff {
    font-size: 14px !important;
    font-weight: 700 !important;
    color: #f97316 !important;
}

.quick-view-modal .btn-primary,
#quickViewModal .btn-primary {
    background-color: #0f5b3f !important;
    border-color: #0f5b3f !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    border-radius: 8px !important;
    padding: 10px 24px !important;
}

.quick-view-modal .social-link a,
#quickViewModal .social-link a {
    width: 32px !important;
    height: 32px !important;
    border-radius: 50% !important;
    background-color: #0f5b3f !important;
    color: #ffffff !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* QuickView Variations & Alignment */
#quickViewModal .product-list-group,
.quick-view-modal .product-list-group {
    display: flex !important;
    flex-direction: column !important;
    gap: 14px !important;
    margin: 16px 0 !important;
    padding: 0 !important;
    list-style: none !important;
}

#quickViewModal .product-list-group .list-item,
.quick-view-modal .product-list-group .list-item {
    display: flex !important;
    flex-direction: column !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
}

#quickViewModal .list-item-title,
.quick-view-modal .list-item-title {
    font-size: 13.5px !important;
    font-weight: 600 !important;
    color: #1e293b !important;
    margin-bottom: 6px !important;
    display: block !important;
}

#quickViewModal .variantUL,
.quick-view-modal .variantUL {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 0 !important;
    margin: 0 !important;
    list-style: none !important;
}

#quickViewModal .variantUL li,
.quick-view-modal .variantUL li {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
    display: inline-flex !important;
}

#quickViewModal .variantUL .input-radio,
.quick-view-modal .variantUL .input-radio {
    display: none !important;
    position: absolute !important;
    opacity: 0 !important;
}

#quickViewModal .variantUL .form-radio-label,
.quick-view-modal .variantUL .form-radio-label {
    cursor: pointer !important;
    padding: 6px 14px !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 8px !important;
    background: #ffffff !important;
    color: #334155 !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    line-height: 1.3 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    transition: all 0.2s ease !important;
    margin: 0 !important;
}

#quickViewModal .variantUL .form-radio-label::before,
#quickViewModal .variantUL .form-radio-label::after,
.quick-view-modal .variantUL .form-radio-label::before,
.quick-view-modal .variantUL .form-radio-label::after {
    display: none !important;
}

#quickViewModal .variantUL input[type="radio"]:checked + .form-radio-label,
.quick-view-modal .variantUL input[type="radio"]:checked + .form-radio-label {
    border-color: #0f5b3f !important;
    background-color: rgba(15, 91, 63, 0.08) !important;
    color: #0f5b3f !important;
    font-weight: 600 !important;
    box-shadow: 0 0 0 1px #0f5b3f !important;
}

#quickViewModal .variantUL .form-radio-label:hover,
.quick-view-modal .variantUL .form-radio-label:hover {
    border-color: #94a3b8 !important;
    background-color: #f8fafc !important;
}

/* RTL Alignment across themes */
html[dir="rtl"] #quickViewModal .product-single-details,
html[dir="rtl"] .quick-view-modal .product-single-details {
    padding-left: 0 !important;
    padding-right: 10px !important;
    text-align: right !important;
}

html[dir="rtl"] #quickViewModal .product-price,
html[dir="rtl"] .quick-view-modal .product-price {
    flex-direction: row-reverse !important;
    justify-content: flex-end !important;
}

html[dir="rtl"] .header-top .header-right,
html[dir="rtl"] .header-middle .header-right {
    margin-left: 0 !important;
    margin-right: auto !important;
}

/* =========================================================================
   MODERN SOFT OFF-WHITE MOBILE SIDEBAR (UI/UX Overhaul — All Themes)
   ========================================================================= */
.mobile-menu-overlay {
    background-color: rgba(15, 23, 42, 0.45) !important;
    backdrop-filter: blur(3px) !important;
    -webkit-backdrop-filter: blur(3px) !important;
}

.mobile-menu,
.mobile-menu.mobile-menu-v10 {
    background: linear-gradient(180deg, #f5f7fa 0%, #eef2f6 100%) !important;
    color: #1e293b !important;
    max-width: 310px !important;
    width: 85% !important;
    box-shadow: 0 12px 40px rgba(15, 23, 42, 0.18) !important;
    border-right: 1px solid rgba(15, 23, 42, 0.08) !important;
    border-radius: 0 20px 20px 0 !important;
}

html[dir="rtl"] .mobile-menu,
html[dir="rtl"] .mobile-menu.mobile-menu-v10 {
    border-right: none !important;
    border-left: 1px solid rgba(15, 23, 42, 0.08) !important;
    border-radius: 20px 0 0 20px !important;
}

.mobile-menu .mobile-menu-wrapper {
    background: transparent !important;
}

/* Sidebar Top Header (Logo + Close Button Alignment) */
.mobile-menu .mobile-menu-top,
.mobile-menu.mobile-menu-v10 .mobile-menu-top {
    background: #ebeff5 !important;
    padding: 15px 18px !important;
    min-height: 70px !important;
    border-bottom: 1px solid #dbe3ec !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px !important;
    cursor: default !important;
}

.mobile-menu .mobile-menu-top .logo,
.mobile-menu.mobile-menu-v10 .mobile-menu-top .logo {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    flex: 1 1 auto !important;
    min-width: 0 !important;
    max-width: calc(100% - 48px) !important;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden !important;
}

.mobile-menu .mobile-menu-top .logo a,
.mobile-menu.mobile-menu-v10 .mobile-menu-top .logo a {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
    text-decoration: none !important;
    color: #0f172a !important;
}

.mobile-menu .mobile-menu-top .logo img,
.mobile-menu.mobile-menu-v10 .mobile-menu-top .logo img {
    max-width: 160px !important;
    max-height: 44px !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    object-position: left center !important;
    display: block !important;
}

html[dir="rtl"] .mobile-menu .mobile-menu-top .logo img {
    object-position: right center !important;
}

/* Close Button */
.mobile-menu .mobile-menu-top .mobile-menu-close,
.mobile-menu.mobile-menu-v10 .mobile-menu-top .mobile-menu-close {
    flex: 0 0 36px !important;
    width: 36px !important;
    height: 36px !important;
    min-width: 36px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50% !important;
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #334155 !important;
    font-size: 16px !important;
    line-height: 1 !important;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08) !important;
    transition: all 0.2s ease !important;
    cursor: pointer !important;
    margin: 0 !important;
    padding: 0 !important;
}

.mobile-menu .mobile-menu-top .mobile-menu-close:hover,
.mobile-menu.mobile-menu-v10 .mobile-menu-top .mobile-menu-close:hover {
    background: var(--color-primary, #2563eb) !important;
    border-color: var(--color-primary, #2563eb) !important;
    color: #ffffff !important;
}

/* Mobile Search Input Card */
.mobile-menu .mobile-search {
    padding: 0 !important;
}

.mobile-menu .header-search-form,
.mobile-menu.mobile-menu-v10 .header-search-form {
    background: #ffffff !important;
    border: 1.5px solid #d5dde7 !important;
    border-radius: 12px !important;
    width: calc(100% - 32px) !important;
    margin: 16px auto 12px !important;
    padding: 2px 6px 2px 4px !important;
    display: flex !important;
    align-items: center !important;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04) !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
}

.mobile-menu .header-search-form:focus-within {
    border-color: var(--color-primary, #2563eb) !important;
    box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb, 37, 99, 235), 0.12) !important;
}

body .mobile-menu .header-search-form .search-input input,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form .search-input input,
body .mobile-menu .header-search-form input[type="text"],
body .mobile-menu .header-search-form input[type="search"],
body .mobile-menu .mobile-search input {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    caret-color: var(--color-primary, #2563eb) !important;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 9px 12px !important;
    font-size: 14px !important;
    width: 100% !important;
}

body .mobile-menu .header-search-form .search-input input::placeholder,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form .search-input input::placeholder,
body .mobile-menu .header-search-form input::placeholder,
body .mobile-menu .mobile-search input::placeholder {
    color: #64748b !important;
    -webkit-text-fill-color: #64748b !important;
    opacity: 1 !important;
}

body .mobile-menu .header-search-form .btn,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form .btn,
body .mobile-menu .header-search-form .btn-icon,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form .btn-icon,
body .mobile-menu .header-search-form button,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form button {
    background: transparent !important;
    border: none !important;
    color: #475569 !important;
    width: 36px !important;
    height: 36px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 !important;
    position: static !important;
    flex-shrink: 0 !important;
}

body .mobile-menu .header-search-form .btn i,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form .btn i,
body .mobile-menu .header-search-form .btn-icon i,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form .btn-icon i,
body .mobile-menu .header-search-form button i,
body .mobile-menu:not(.mobile-menu-v10) .header-search-form button i {
    color: #475569 !important;
    font-size: 15px !important;
}

/* Main Navigation Links */
.mobile-menu .menu.mobile-nav,
.mobile-menu .mobile-nav {
    padding: 4px 14px 10px !important;
    margin: 0 !important;
}

.mobile-menu ul .nav-item {
    margin-bottom: 3px !important;
    border: none !important;
}

.mobile-menu ul .nav-item > a {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 11px 14px !important;
    border-radius: 10px !important;
    border-bottom: none !important;
    color: #1e293b !important;
    font-size: 14.5px !important;
    font-weight: 600 !important;
    background: transparent !important;
    transition: background-color 0.2s ease, color 0.2s ease !important;
}

.mobile-menu ul .nav-item > a:hover {
    background: rgba(15, 23, 42, 0.05) !important;
    color: var(--color-primary, #2563eb) !important;
}

.mobile-menu ul .nav-item > a.active,
.mobile-menu ul .nav-item.active > a {
    background: rgba(var(--color-primary-rgb, 37, 99, 235), 0.11) !important;
    color: var(--color-primary, #2563eb) !important;
    font-weight: 700 !important;
}

.mobile-menu ul .nav-item > a i {
    float: none !important;
    margin-left: auto !important;
    color: #64748b !important;
    font-size: 12.5px !important;
}

.mobile-menu ul .nav-item .submenu,
.mobile-menu ul .nav-item .mega-menu {
    background: rgba(255, 255, 255, 0.72) !important;
    border-radius: 10px !important;
    margin: 4px 0 6px 10px !important;
    padding: 6px !important;
    border-left: 2px solid var(--color-primary, #2563eb) !important;
    box-shadow: none !important;
    width: calc(100% - 10px) !important;
}

.mobile-menu ul .nav-item .submenu li a,
.mobile-menu ul .nav-item .mega-menu li a {
    color: #334155 !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    padding: 8px 12px !important;
    border-radius: 8px !important;
    border-bottom: none !important;
}

.mobile-menu ul .nav-item .submenu li a:hover {
    background: #eef2f6 !important;
    color: var(--color-primary, #2563eb) !important;
}

/* Action Items (Language, Currency, My Account) */
.mobile-menu .menu-action-item-area {
    padding: 14px 14px 28px !important;
    margin-top: 8px !important;
    border-top: 1px solid #dbe3ec !important;
}

.mobile-menu .menu-action-item-wrapper {
    gap: 8px !important;
    margin: 0 !important;
    padding: 0 !important;
}

.mobile-menu .menu-action-item-area .menu-action-item-wrapper .menu-action-item > a {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 10px 12px !important;
    border-radius: 11px !important;
    border: 1px solid rgba(15, 23, 42, 0.07) !important;
    background: rgba(255, 255, 255, 0.8) !important;
    color: #1e293b !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03) !important;
    transition: all 0.2s ease !important;
}

.mobile-menu .menu-action-item-area .menu-action-item-wrapper .menu-action-item > a:hover {
    background: #ffffff !important;
    border-color: rgba(var(--color-primary-rgb, 37, 99, 235), 0.3) !important;
    color: var(--color-primary, #2563eb) !important;
}

.mobile-menu .menu-action-item .icon {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.mobile-menu .menu-action-item .icon i,
.mobile-menu .menu-action-item .icon .currency-symbol {
    width: 28px !important;
    height: 28px !important;
    line-height: 28px !important;
    margin-right: 0 !important;
    padding: 0 !important;
    border-radius: 8px !important;
    background: rgba(var(--color-primary-rgb, 37, 99, 235), 0.12) !important;
    color: var(--color-primary, #2563eb) !important;
    font-size: 13px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.mobile-menu .menu-action-item .plus-icon {
    float: none !important;
    margin-left: auto !important;
    transform: none !important;
    color: #64748b !important;
    font-size: 12px !important;
    display: inline-flex !important;
    align-items: center !important;
}

.mobile-menu .menu-action-item-wrapper .setting-dropdown {
    margin: 6px 0 2px 10px !important;
    padding: 6px !important;
    background: #ffffff !important;
    border-radius: 10px !important;
    border: 1px solid #dbe3ec !important;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05) !important;
}

.mobile-menu .menu-action-item-wrapper .setting-dropdown li a {
    color: #334155 !important;
    border: none !important;
    border-bottom: none !important;
    background: transparent !important;
    padding: 8px 12px !important;
    border-radius: 8px !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    box-shadow: none !important;
}

.mobile-menu .menu-action-item-wrapper .setting-dropdown li a:hover {
    background: #eef2f6 !important;
    color: var(--color-primary, #2563eb) !important;
}

/* Variation Modal Single-Column Layout */
#variationModal #variants {
    display: flex !important;
    flex-direction: column !important;
}

#variationModal #variants .variation-group-col {
    width: 100% !important;
    max-width: 100% !important;
    flex: 0 0 100% !important;
}
</style>

@yield('styles')

<style>

/* --- Shop Category Pills Horizontal Alignment Fix for Laptop & Mobile --- */
.shop-category-pills {
  width: 100% !important;
  overflow-x: auto !important;
  overflow-y: hidden !important;
  scroll-behavior: smooth !important;
  -webkit-overflow-scrolling: touch !important;
  scrollbar-width: none !important;
  -ms-overflow-style: none !important;
}
.shop-category-pills::-webkit-scrollbar {
  display: none !important;
  width: 0 !important;
  height: 0 !important;
}
.shop-category-pills .pills-wrapper {
  display: flex !important;
  gap: 16px !important;
  align-items: flex-start !important;
  justify-content: flex-start !important;
  width: max-content !important;
  padding: 8px 4px !important;
  margin: 0 !important;
}
.shop-category-pills .pill-item {
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: flex-start !important;
  width: 78px !important;
  min-width: 78px !important;
  flex-shrink: 0 !important;
  text-align: center !important;
  text-decoration: none !important;
}
.shop-category-pills .pill-img-wrap {
  width: 72px !important;
  height: 72px !important;
  border-radius: 50% !important;
  flex-shrink: 0 !important;
  margin-bottom: 8px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  overflow: hidden !important;
}
.shop-category-pills .pill-img {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
}
.shop-category-pills .pill-icon {
  font-size: 24px !important;
}
.shop-category-pills .pill-name {
  font-size: 12px !important;
  font-weight: 600 !important;
  line-height: 1.25 !important;
  text-align: center !important;
  white-space: normal !important;
  word-break: break-word !important;
  max-width: 76px !important;
  min-height: 32px !important;
  display: -webkit-box !important;
  -webkit-line-clamp: 2 !important;
  -webkit-box-orient: vertical !important;
  overflow: hidden !important;
}

/* --- Mobile View Adjustments for Category Pills (< 992px) --- */
@media (max-width: 991px) {
  .page-title-area .row {
    flex-direction: column !important;
    text-align: center !important;
  }
  .page-title-area .content {
    text-align: center !important;
    margin-bottom: 12px !important;
  }
  .page-title-area .breadcrumb {
    justify-content: center !important;
  }
  .shop-category-pills {
    padding-bottom: 6px !important;
  }
  .shop-category-pills .pills-wrapper {
    gap: 12px !important;
    padding: 4px 2px !important;
  }
  .shop-category-pills .pill-item {
    width: 68px !important;
    min-width: 68px !important;
  }
  .shop-category-pills .pill-img-wrap {
    width: 60px !important;
    height: 60px !important;
    margin-bottom: 6px !important;
  }
  .shop-category-pills .pill-icon {
    font-size: 20px !important;
  }
  .shop-category-pills .pill-name {
    font-size: 11px !important;
    max-width: 68px !important;
    min-height: 28px !important;
    line-height: 1.2 !important;
  }
}

/* --- Theme-Specific Shop Category Pills Active & Hover States --- */
/* Pet theme */
.theme-pet .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-pet .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #ff5a5f !important;
  box-shadow: 0 4px 12px rgba(255, 90, 95, 0.25) !important;
  background: #fff !important;
}
.theme-pet .shop-category-pills .pill-item.active .pill-name,
.theme-pet .shop-category-pills .pill-item.active .pill-icon,
.theme-pet .shop-category-pills .pill-item:hover .pill-name {
  color: #ff5a5f !important;
}

/* Furniture theme */
.theme-furniture .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-furniture .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #e88d43 !important;
  box-shadow: 0 4px 12px rgba(232, 141, 67, 0.25) !important;
  background: #fff !important;
}
.theme-furniture .shop-category-pills .pill-item.active .pill-name,
.theme-furniture .shop-category-pills .pill-item.active .pill-icon,
.theme-furniture .shop-category-pills .pill-item:hover .pill-name {
  color: #e88d43 !important;
}

/* Fashion theme */
.theme-fashion .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-fashion .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #c19a6b !important;
  box-shadow: 0 4px 12px rgba(193, 154, 107, 0.25) !important;
  background: #fff !important;
}
.theme-fashion .shop-category-pills .pill-item.active .pill-name,
.theme-fashion .shop-category-pills .pill-item.active .pill-icon,
.theme-fashion .shop-category-pills .pill-item:hover .pill-name {
  color: #c19a6b !important;
}

/* Clothing (Urban) theme */
.theme-clothing .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-clothing .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #1a1a1a !important;
  box-shadow: 0 4px 12px rgba(26, 26, 26, 0.25) !important;
  background: #fff !important;
}
.theme-clothing .shop-category-pills .pill-item.active .pill-name,
.theme-clothing .shop-category-pills .pill-item.active .pill-icon,
.theme-clothing .shop-category-pills .pill-item:hover .pill-name {
  color: #1a1a1a !important;
}

/* Grocery & Vegetables */
.theme-grocery .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-grocery .shop-category-pills .pill-item:hover .pill-img-wrap,
.theme-vegetables .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-vegetables .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #10b981 !important;
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important;
  background: #fff !important;
}
.theme-grocery .shop-category-pills .pill-item.active .pill-name,
.theme-grocery .shop-category-pills .pill-item.active .pill-icon,
.theme-grocery .shop-category-pills .pill-item:hover .pill-name {
  color: #10b981 !important;
}

/* Grocery2 theme */
.theme-grocery2 .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-grocery2 .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #3bb77e !important;
  box-shadow: 0 4px 12px rgba(59, 183, 126, 0.25) !important;
  background: #fff !important;
}
.theme-grocery2 .shop-category-pills .pill-item.active .pill-name,
.theme-grocery2 .shop-category-pills .pill-item.active .pill-icon,
.theme-grocery2 .shop-category-pills .pill-item:hover .pill-name {
  color: #3bb77e !important;
}

/* Electronics theme */
.theme-electronics .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-electronics .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #2264d1 !important;
  box-shadow: 0 4px 12px rgba(34, 100, 209, 0.25) !important;
  background: #fff !important;
}
.theme-electronics .shop-category-pills .pill-item.active .pill-name,
.theme-electronics .shop-category-pills .pill-item.active .pill-icon,
.theme-electronics .shop-category-pills .pill-item:hover .pill-name {
  color: #2264d1 !important;
}

/* Manti theme */
.theme-manti .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-manti .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #2c742f !important;
  box-shadow: 0 4px 12px rgba(44, 116, 47, 0.25) !important;
  background: #fff !important;
}
.theme-manti .shop-category-pills .pill-item.active .pill-name,
.theme-manti .shop-category-pills .pill-item.active .pill-icon,
.theme-manti .shop-category-pills .pill-item:hover .pill-name {
  color: #2c742f !important;
}

/* Jewellery & Skinflow themes */
.theme-jewellery .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-jewellery .shop-category-pills .pill-item:hover .pill-img-wrap,
.theme-skinflow .shop-category-pills .pill-item.active .pill-img-wrap,
.theme-skinflow .shop-category-pills .pill-item:hover .pill-img-wrap {
  border-color: #c5a982 !important;
  box-shadow: 0 4px 12px rgba(197, 169, 130, 0.25) !important;
  background: #fff !important;
}
.theme-jewellery .shop-category-pills .pill-item.active .pill-name,
.theme-jewellery .shop-category-pills .pill-item.active .pill-icon,
.theme-skinflow .shop-category-pills .pill-item.active .pill-name,
.theme-skinflow .shop-category-pills .pill-item.active .pill-icon {
  color: #c5a982 !important;
}

/* =========================================================
   MODERN VARIANT STYLES: COLOR SWATCHES & SIZE PILLS
   ========================================================= */

/* Variant Containers: Force vertical stacking for variant groups (Size, Color, etc.) */
#variantListULDetails,
#variantListUL,
.product-single-default .product-single-details .product-action .product-list-group,
.product-action .product-list-group,
.variant-groups-container {
  display: flex !important;
  flex-direction: column !important;
  align-items: flex-start !important;
  width: 100% !important;
  gap: 16px !important;
  margin: 0 0 20px 0 !important;
  padding: 0 !important;
  list-style: none !important;
}

#variantListULDetails .list-item,
#variantListUL .list-item,
.product-single-default .product-single-details .product-action .product-list-group .list-item,
.variant-group-row {
  display: block !important;
  width: 100% !important;
  margin: 0 0 6px 0 !important;
}

#variantListULDetails .variantUL,
#variantListUL .variantUL,
.product-single-default .product-single-details .product-action .product-list-group .list-item .variantUL,
.variantUL {
  display: flex !important;
  flex-direction: row !important;
  flex-wrap: wrap !important;
  align-items: center !important;
  gap: 10px !important;
  margin: 6px 0 0 0 !important;
  padding: 0 !important;
  list-style: none !important;
}

.variant-item-wrap {
  position: relative !important;
  display: inline-flex !important;
  align-items: center !important;
  margin: 0 !important;
  padding: 0 !important;
  list-style: none !important;
}

/* Hide native radio inputs completely */
.custom-variant-radio,
.custom-variant-radio input,
input.custom-variant-radio {
  display: none !important;
  position: absolute !important;
  opacity: 0 !important;
  width: 0 !important;
  height: 0 !important;
  margin: 0 !important;
  pointer-events: none !important;
  visibility: hidden !important;
}

/* Eliminate ANY theme radio circle pseudo-elements */
.variantUL label::before,
.variantUL label::after,
.variantUL input:checked + label::before,
.variantUL input:checked + label::after,
.variantUL .form-radio-label::before,
.variantUL .form-radio-label::after,
.variant-item-wrap label::before,
.variant-item-wrap label::after,
.variant-item-wrap input:checked + label::before,
.variant-item-wrap input:checked + label::after,
.variant-pill-btn::before,
.variant-pill-btn::after,
.custom-variant-radio:checked + .variant-pill-btn::before,
.custom-variant-radio:checked + .variant-pill-btn::after,
.variant-color-swatch::before,
.variant-color-swatch::after,
.custom-variant-radio:checked + .variant-color-swatch::before,
.custom-variant-radio:checked + .variant-color-swatch::after {
  content: none !important;
  display: none !important;
  opacity: 0 !important;
  visibility: hidden !important;
  width: 0 !important;
  height: 0 !important;
  border: none !important;
  background: none !important;
}

/* Reset default label indent */
.variantUL label,
.variantUL .form-radio-label,
.variant-item-wrap label {
  margin: 0 !important;
  text-align: center !important;
}

/* Hide legacy price indicators next to variant options */
.details_view_variants_price,
.quick_view_variants_price,
.variants_price {
  display: none !important;
}

/* 1. COLOR SWATCHES (Circular, with active border ring) */
.variant-color-swatch {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  cursor: pointer !important;
  margin: 0 !important;
  width: 38px !important;
  height: 38px !important;
  min-width: 38px !important;
  border-radius: 50% !important;
  border: 2px solid transparent !important;
  padding: 2px !important;
  background: transparent !important;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
  box-sizing: border-box !important;
}

.variant-color-swatch .color-circle {
  display: block !important;
  width: 100% !important;
  height: 100% !important;
  border-radius: 50% !important;
  border: 1px solid rgba(0, 0, 0, 0.15) !important;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12) !important;
  transition: transform 0.2s ease !important;
}

.variant-color-swatch:hover {
  transform: scale(1.08) !important;
}

/* Selected Color Swatch (white gap + theme color ring - exact match to Reference Image) */
.custom-variant-radio:checked + .variant-color-swatch {
  border-color: transparent !important;
  box-shadow: 0 0 0 2px #ffffff, 0 0 0 4px var(--color-primary, #ec4899) !important;
  transform: scale(1.04) !important;
}

/* 2. PILL / BOX BUTTONS (Size, Pack, Age, etc.) */
.variant-pill-btn {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  cursor: pointer !important;
  margin: 0 !important;
  min-width: 64px !important;
  padding: 8px 18px !important;
  padding-left: 18px !important;
  padding-right: 18px !important;
  padding-inline-start: 18px !important;
  padding-inline-end: 18px !important;
  border-radius: 8px !important;
  border: 1.5px solid #d1d5db !important;
  background-color: #ffffff !important;
  color: #1f2937 !important;
  font-size: 14px !important;
  font-weight: 600 !important;
  line-height: 1.25 !important;
  text-align: center !important;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
  user-select: none !important;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
  box-sizing: border-box !important;
}

.variant-pill-btn:hover {
  border-color: #9ca3af !important;
  background-color: #f9fafb !important;
  color: #111827 !important;
}

/* Selected Pill Button (Solid Theme/Pink background with crisp white text) */
.custom-variant-radio:checked + .variant-pill-btn {
  background-color: var(--color-primary, #ec4899) !important;
  border-color: var(--color-primary, #ec4899) !important;
  color: #ffffff !important;
  font-weight: 700 !important;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15) !important;
}

.variant-pill-btn .variant-text {
  display: inline-block !important;
  text-align: center !important;
  width: 100% !important;
  margin: 0 auto !important;
  padding: 0 !important;
  line-height: 1.25 !important;
  letter-spacing: normal !important;
}

.custom-variant-radio:checked + .variant-pill-btn .variant-text {
  color: #ffffff !important;
}

/* Checkout Variations Area & Summary (always visible, no toggle) */
.variation-area,
.variation-summary {
  display: block !important;
}

.show-variation {
  display: none !important;
}

/* =========================================================
   GLOBAL IMAGE BORDER RADIUS (Sliders, Banners, Product Cards, Galleries)
   ========================================================= */

/* Hero Sliders & Banner Cards */
.home-slider .slider-item,
.animated-slider .slider-item,
#home-slider-4 .slider-item,
.home-slider .slider-item.ratio,
.banner-sm,
.banner-sm.ratio,
.banner-sm-style-2,
.banner-sm-style-3,
.banner-sm-style-4 {
  border-radius: 16px !important;
  overflow: hidden !important;
}

.home-slider .slider-item img.bg-img,
.animated-slider .slider-item img.bg-img,
#home-slider-4 .slider-item img.bg-img,
.banner-sm img.bg-img,
.home-slider-4 .banner-sm img.bg-img {
  border-radius: 16px !important;
}

/* Product Detail Main Gallery & Thumbnails */
.product-single-gallery .product-single-slider,
.product-single-gallery .product-single-slider2,
.product-single-gallery .product-single-single-item,
.product-single-gallery .product-zoom-figure,
.product-single-gallery figure,
.product-single-gallery .ratio {
  border-radius: 16px !important;
  overflow: hidden !important;
}

.product-single-gallery .product-zoom-img,
.product-single-gallery .product-single-single-item img,
.product-single-gallery figure img {
  border-radius: 16px !important;
  object-fit: cover !important;
}

.product-single-gallery .slider-thumbnails2 .thumbnail-img,
.product-single-gallery .slider-thumbnails .thumbnail-img {
  border-radius: 10px !important;
  overflow: hidden !important;
  border: 1.5px solid #e5e7eb !important;
}

.product-single-gallery .slider-thumbnails2 .thumbnail-img.slick-current,
.product-single-gallery .slider-thumbnails .thumbnail-img.slick-current {
  border-color: var(--color-primary, #000) !important;
}

.product-single-gallery .slider-thumbnails2 .thumbnail-img img,
.product-single-gallery .slider-thumbnails .thumbnail-img img {
  border-radius: 8px !important;
}

/* Product Cards in Shop, Home, Related, Flash Sale */
.product-default,
.product-card,
.product-item,
.card-product {
  border-radius: 14px !important;
  overflow: hidden !important;
}

.product-default .product-img,
.product-card .product-img,
.product-item .product-img {
  border-radius: 14px 14px 0 0 !important;
  overflow: hidden !important;
}

.product-default .product-img img,
.product-card .product-img img,
.product-item .product-img img {
  border-radius: 14px 14px 0 0 !important;
}

</style>
