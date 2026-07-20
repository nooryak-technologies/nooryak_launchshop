<!DOCTYPE html>
<html lang="en" @if ($rtl == 1) dir="rtl" @endif>

<head>
  <!--====== Required meta tags ======-->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="@yield('meta-description')">
  <meta name="keywords" content="@yield('meta-keywords')">


  @yield('og-meta')

  <!-- Title -->
  <title>{{ $bs->website_title }} @yield('pagename')</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/x-icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
  <!-- Fontawesome Icon CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/fonts/fontawesome/css/all.min.css') }}">
  <!-- Kreativ Icon -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/font-gigo.css') }}">
  <!-- Magnific Popup CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/magnific-popup.min.css') }}">
  <!-- Swiper Slider -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}">
  <!-- AOS Animation CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/aos.min.css') }}">
  <!-- toastr css -->
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/common/toastr.min.css') }}">
  <!-- Meanmenu CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/meanmenu.min.css') }}">
  <!-- Nice Select -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/nice-select.css') }}">
  <!-- CountDown -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/odometer.min.css') }}">
  {{-- floating-whatsapp --}}
  <link rel="stylesheet" href="{{ asset('assets/front/css/floating-whatsapp.css') }}">
  <!-- Main Style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/style.css?v=1.0.4') }}">
  <link rel="stylesheet" href="{{ asset('assets/front/css/launchshop-custom-v2.css?v=' . time()) }}">
  <link rel="stylesheet" href="{{ asset('assets/user-front/css/tinymce-content.css') }}">

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  @yield('styles')

  @if ($bs->is_whatsapp == 0 && $bs->is_tawkto == 0)
    <style>
      .back-to-top {
        left: auto;
        right: 30px;
      }
    </style>
  @endif


  @php
    $primaryColor = $bs->base_color;
    function checkColorCode($color)
    {
        return preg_match('/^#[a-f0-9]{6}/i', $color);
    }

    // if, primary color value does not contain '#', then add '#' before color value
    if (isset($primaryColor) && checkColorCode($primaryColor) == 0) {
        $primaryColor = '#' . $primaryColor;
    }

    // change decimal point into hex value for opacity
    if (!function_exists('rgb')) {
        function rgb($color = null)
        {
            if (!$color) {
                echo '';
            }

            $hex = htmlspecialchars($color);
            [$r, $g, $b] = sscanf($hex, '#%02x%02x%02x');
            echo "$r, $g, $b";
        }
    }

  @endphp
  <style>
    :root {
      --color-primary: #{{ $bs->base_color }};
      --color-primary2: #{{ $bs->base_color_2 }};
      --color-primary-rgb: {{ rgb(htmlspecialchars($primaryColor)) }};
    }
    body {
      user-select: none !important;
      -webkit-user-select: none !important;
      -moz-user-select: none !important;
      -ms-user-select: none !important;
    }
    img {
      -webkit-user-drag: none !important;
      user-drag: none !important;
    }
  </style>

  <script>
    if (top.location != location) {
      top.location.replace(location);
    }
  </script>
  <!-- ===/External Code=== -->
</head>

<body>

  @if ($bs->preloader_status == 1)
    <!--====== Start Preloader ======-->

    <!--====== Start Preloader ======-->
    <!--<div class="preloader" id="preLoader">
      <div class="lds-ellipsis loader">
        <img class="lazy" data-src="{{ asset('assets/front/img/' . $bs->preloader) }}" alt="">
      </div>
    </div>--> <!--====== End Preloader ======-->
    <!--====== End Preloader ======-->
  @endif

  @includeIf('front.partials.header')

  @if (!request()->routeIs('front.index'))
    <!-- Page Title Start-->
    <div class="page-title-area" style="background-image:url('{{ asset('assets/front/img/' . $bs->breadcrumb) }} ')">
      <div class="container">
        <div class="row">
          <div class="col-lg-10">
            <div class="content">
              <h2>@yield('breadcrumb-title')</h1>
                <!-- <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-start">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb-link') </li>
                  </ol>
                </nav> -->
            </div>
          </div>

        </div>

      </div>
    </div>
    <!-- Page Title End-->
  @endif

  @yield('content')

  {{-- footer section --}}
  @includeIf('front.partials.footer')
  @if ($be->cookie_alert_status == 1)
    <div class="cookie">
      @include('cookie-consent::index')
    </div>
  @endif

  {{-- Popups start --}}
  @includeIf('front.partials.popups')
  {{-- Popups end --}}

  {{-- WhatsApp Chat Button (dynamic custom widget) --}}
  @php
    $defaultPackage = \App\Models\Package::where('status', '1')->where('featured', '1')->first();
    $defaultPackageId = $defaultPackage ? $defaultPackage->id : 1;
  @endphp
  <div id="WAButton" class="custom-wa-widget">
    <!-- WhatsApp Float Button (the circle button) -->
    <button type="button" class="wa-float-btn" aria-label="Open Chat">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#fff">
        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
      </svg>
      <span class="wa-pulse"></span>
    </button>

    <!-- WhatsApp Chat Popup -->
    <div class="wa-chat-popup">
      <!-- Header -->
      <div class="wa-chat-header">
        <div class="wa-header-info">
          <div class="wa-avatar">
            <img src="{{ asset('assets/front/img/' . $bs->logo) }}" alt="Logo">
          </div>
          <div class="wa-status-text">
            <span class="wa-chat-name">{{ $bs->whatsapp_header_title ?: $bs->website_title . ' Support' }}</span>
            <span class="wa-online-status">
              <span class="wa-dot"></span> Online
            </span>
          </div>
        </div>
        <button type="button" class="wa-close-btn" aria-label="Close Chat">&times;</button>
      </div>

      <!-- Body -->
      <div class="wa-chat-body">
        <!-- Message Bubble -->
        <div class="wa-msg-bubble">
          <div class="wa-msg-text">
            {!! !empty($bs->whatsapp_popup_message) ? $bs->whatsapp_popup_message : '👋 Welcome to ' . $bs->website_title . '! How can we help you today?' !!}
          </div>
          <div class="wa-msg-time">Just now</div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="wa-quick-actions">
          <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $defaultPackageId]) }}" class="wa-action-btn">
            Start My Online Store
          </a>
          <a href="https://api.whatsapp.com/send?phone=6374913298&text=Hi%2C%20I%20want%20to%20talk%20to%20an%20expert%20to%20help%20me%20get%20started." target="_blank" class="wa-action-btn wa-talk-expert">
            Talk to Expert
          </a>
          <a href="{{ route('front.pricing') }}" class="wa-action-btn">
            Pricing & Plans
          </a>
        </div>
      </div>

      <!-- Input Footer -->
      <div class="wa-chat-footer">
        <input type="text" class="wa-chat-input" placeholder="Type your message...">
        <button type="button" class="wa-send-btn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#fff">
            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- {{-- AI Chat Button — always visible, above WhatsApp --}}
  <button type="button"
          class="fab-btn fab-ai-chat"
          title="AI Assistant"
          aria-label="Chat with AI"
          onclick="window.dispatchEvent(new CustomEvent('open-ai-chat'))">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 2a8 8 0 0 1 8 8c0 3-1.6 5.6-4 7.1V20l-4-2-4 2v-2.9A8 8 0 0 1 4 10a8 8 0 0 1 8-8z"/>
      <circle cx="9" cy="10" r="1" fill="#fff" stroke="none"/>
      <circle cx="12" cy="10" r="1" fill="#fff" stroke="none"/>
      <circle cx="15" cy="10" r="1" fill="#fff" stroke="none"/>
    </svg>
    <span class="fab-ai-pulse"></span>
  </button> -->

  <style>
    /* ── Shared FAB base ── */
    .fab-btn {
      position: fixed;
      left: 18px;
      width: 56px;
      height: 56px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      cursor: pointer;
      text-decoration: none !important;
      z-index: 9999;
      transition: transform 0.22s ease, box-shadow 0.22s ease;
    }
    .fab-btn:hover {
      transform: scale(1.1) translateY(-2px);
    }

    /* ── WhatsApp ── */
    .fab-whatsapp {
      bottom: 22px;
      background: #25D366;
      box-shadow: 0 4px 16px rgba(37,211,102,0.45);
      color: #fff !important;
    }
    .fab-whatsapp:hover {
      background: #20ba58;
      box-shadow: 0 6px 20px rgba(37,211,102,0.6);
      color: #fff !important;
    }

    /* ── AI Chat ── */
    .fab-ai-chat {
      bottom: 90px;           /* 22px + 56px + 12px gap */
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
      box-shadow: 0 4px 16px rgba(99,102,241,0.45);
      position: fixed;
      padding: 0;
    }
    .fab-ai-chat:hover {
      box-shadow: 0 6px 20px rgba(99,102,241,0.6);
    }

    /* Animated pulse ring on AI button */
    .fab-ai-pulse {
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      border: 2px solid rgba(139,92,246,0.5);
      animation: fab-pulse 2s ease-out infinite;
      pointer-events: none;
    }
    @keyframes fab-pulse {
      0%   { transform: scale(1);   opacity: 0.7; }
      70%  { transform: scale(1.5); opacity: 0;   }
      100% { transform: scale(1.5); opacity: 0;   }
    }

    /* ── Scroll-to-top — bottom-RIGHT at same level as WhatsApp ── */
    .go-top {
      left: auto !important;
      right: 18px !important;
      bottom: 22px !important;
      border-radius: 12px !important;
    }
  </style>

  <!-- Go to Top -->
  <div class="go-top"><i class="fal fa-angle-up"></i></div>
  <!-- Go to Top -->

  <!-- Jquery JS -->
  <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
  <!-- Popper JS -->
  <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
  <!-- Nice Select JS -->
  <script src="{{ asset('assets/front/js/jquery.nice-select.min.js') }}"></script>
  <!-- Magnific Popup JS -->
  <script src="{{ asset('assets/front/js/jquery.magnific-popup.min.js') }}"></script>
  {{-- lazyload js --}}
  <script src="{{ asset('assets/front/js/vanilla-lazyload.min.js') }}"></script>
  {{-- syotimer --}}
  <script src="{{ asset('assets/front/js/jquery-syotimer.min.js') }}"></script>
  <!-- Swiper Slider JS -->
  <script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>
  <!-- Lazysizes -->
  <script src="{{ asset('assets/front/js/lazysizes.min.js') }}"></script>
  <script src="{{ asset('assets/user-front/js/toastr.min.js') }}"></script>
  <!-- Meanmenu JS -->
  <script src="{{ asset('assets/front/js/jquery.meanmenu.min.js') }}"></script>
  {{-- floatingWhatsApp --}}
  <script src="{{ asset('assets/front/js/floating-whatsapp.js') }}"></script>
  <!-- AOS JS -->
  <script src="{{ asset('assets/front/js/aos.min.js') }}"></script>

  <!-- CountDown -->
  <script src="{{ asset('assets/front/js/appear.min.js') }}"></script>
  <script src="{{ asset('assets/front/js/odometer.min.js') }}"></script>

  <script>
    "use strict";
    var rtl = {{ $rtl }};
    var mainurl = "{{ url('/') }}";
    var vapid_public_key = "{{ env('VAPID_PUBLIC_KEY') }}";
    var show_more = "{{ __('Show More') }}";
    var show_less = "{{ __('Show Less') }}";
  </script>

  <!-- Lenis Smooth Scroll -->
  <script src="{{ asset('assets/front/js/lenis.min.js') }}"></script>

  <!-- Main script JS -->
  <script src="{{ asset('assets/front/js/script.js') }}"></script>

  {{-- push notification js --}}
  <script src="{{ asset('assets/front/js/push-notification.js') }}"></script>

  <!-- LaunchShop Slider Engine -->
  <script src="{{ asset('assets/front/js/ls-slider.js') }}"></script>

  @yield('scripts')

  @yield('vuescripts')


  @if (session()->has('success'))
    <script>
      "use strict";
      toastr['success']("{{ __(session('success')) }}");
    </script>
  @endif

  @if (session()->has('error'))
    <script>
      "use strict";
      toastr['error']("{{ __(session('error')) }}");
    </script>
  @endif

  @if (session()->has('warning'))
    <script>
      "use strict";
      toastr['warning']("{{ __(session('warning')) }}");
    </script>
  @endif
  <script>
    "use strict";

    function handleSelect(elm) {
      window.location.href = "{{ route('changeLanguage', '') }}" + "/" + elm.value;
    }
  </script>

  {{-- whatsapp init code --}}
  <script type="text/javascript">
    $(function() {
      var $widget = $('.custom-wa-widget');
      var $floatBtn = $widget.find('.wa-float-btn');
      var $popup = $widget.find('.wa-chat-popup');
      var $closeBtn = $widget.find('.wa-close-btn');
      var $sendBtn = $widget.find('.wa-send-btn');
      var $input = $widget.find('.wa-chat-input');

      // Toggle popup
      $floatBtn.on('click', function(e) {
        e.stopPropagation();
        $popup.toggleClass('show');
        if ($popup.hasClass('show')) {
          $input.focus();
        }
      });

      // Close popup
      $closeBtn.on('click', function(e) {
        e.stopPropagation();
        $popup.removeClass('show');
      });

      // Close popup when clicking outside the widget
      $(document).on('click', function(e) {
        if (!$(e.target).closest('.custom-wa-widget').length) {
          $popup.removeClass('show');
        }
      });

      // Send function
      function sendMessage() {
        var text = $.trim($input.val());
        var phone = "6374913298";
        var defaultMsg = "Hi, I want to enquire about the LaunchShop. Please help me get started.";
        var message = text ? text : defaultMsg;
        
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        var url = (isMobile ? 'https://api.whatsapp.com/send' : 'https://web.whatsapp.com/send') 
                  + '?phone=' + phone + '&text=' + encodeURIComponent(message);
        
        window.open(url, '_blank');
        $input.val('');
        $popup.removeClass('show');
      }

      // Send on click
      $sendBtn.on('click', function(e) {
        e.preventDefault();
        sendMessage();
      });

      // Send on Enter
      $input.on('keypress', function(e) {
        if (e.which === 13) {
          e.preventDefault();
          sendMessage();
        }
      });
    });
  </script>

  @if ($bs->is_tawkto == 1)
    {{-- Force Tawk.to to left side via CSS on its injected containers --}}
    <style>
      /* Tawk.to widget pinned to bottom-LEFT */
      #tawkchat-status-container,
      .tawk-min-container,
      [id^="tawk-bubble"],
      div[class*="tawk-min"],
      div[id*="tawkchat"] {
        left: 20px !important;
        right: auto !important;
      }
    </style>
    <script type="text/javascript">
      var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();

      // Move Tawk.to widget to LEFT side via the official API
      Tawk_API.onLoad = function() {
        try {
          Tawk_API.customStyle({
            visibility: {
              desktop: { position: 'bl', xOffset: '20', yOffset: '20' },
              mobile:  { position: 'bl', xOffset: '15', yOffset: '15' }
            }
          });
        } catch(e) {}

        // Also inject CSS directly into Tawk iframe for reliable positioning
        try {
          var frames = document.querySelectorAll('iframe[src*="tawk.to"], iframe[title*="chat"]');
          frames.forEach(function(f) {
            var p = f.parentElement;
            if (p) {
              p.style.setProperty('left', '20px', 'important');
              p.style.setProperty('right', 'auto', 'important');
            }
          });
        } catch(e) {}
      };

      (function() {
        var s1 = document.createElement("script"),
          s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/{{ $bs->tak_to_property_id }}/{{ $bs->tak_to_widget_id }}';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
      })();
    </script>
  @endif
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const lazyBgElements = document.querySelectorAll('.lazy[data-bg]');

      lazyBgElements.forEach(el => {
        const bg = el.getAttribute('data-bg');
        if (bg) {
          el.style.backgroundImage = `url('${bg}')`;
        }
      });

      // ─────────────────────────────────────────────────────────
      // LENIS SMOOTH SCROLL — initialised here after all scripts
      // ─────────────────────────────────────────────────────────
      if (typeof Lenis !== 'undefined') {
        var lenis = new Lenis({
          duration: 1.2,
          easing: function(t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
          smooth: true,
          smoothTouch: false,
          autoRaf: true,
        });

        // Sticky header scroll shadow driven by Lenis
        var header = document.querySelector('.header-area');
        if (header) {
          lenis.on('scroll', function(e) {
            if (e.scroll > 10) {
              header.classList.add('scrolled');
            } else {
              header.classList.remove('scrolled');
            }
          });
        }

        // Keep AOS in sync with Lenis
        lenis.on('scroll', function() {
          if (typeof AOS !== 'undefined') { AOS.refresh(); }
        });
      } else {
        // Fallback: native scroll for header shadow if Lenis failed to load
        var header = document.querySelector('.header-area');
        if (header) {
          window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
              header.classList.add('scrolled');
            } else {
              header.classList.remove('scrolled');
            }
          }, { passive: true });
        }
      }

      // Close mobile menu when clicking outside (on the overlay)
      $(document).on('click', '.mean-container', function(e) {
        if ($(e.target).closest('.mean-nav, .meanmenu-reveal').length === 0) {
          $('a.meanmenu-reveal.meanclose').click();
        }
      });

      // ─────────────────────────────────────────────────────────
      // FORCE: WhatsApp LEFT + scroll-to-top RIGHT
      // ─────────────────────────────────────────────────────────
      function forcePositions() {
        // 1. Floating WhatsApp (#WAButton / .floating-wpp)
        var waBtn = document.getElementById('WAButton');
        if (waBtn) {
          waBtn.style.setProperty('left', '15px', 'important');
          waBtn.style.setProperty('right', 'auto', 'important');
          waBtn.style.setProperty('position', 'fixed', 'important');
          waBtn.style.setProperty('bottom', '15px', 'important');
          var wpp = waBtn.querySelector('.floating-wpp');
          if (wpp) {
            wpp.style.setProperty('left', '15px', 'important');
            wpp.style.setProperty('right', 'auto', 'important');
          }
        }

        // 2. Scroll-to-top stays RIGHT
        var goTop = document.querySelector('.go-top');
        if (goTop) {
          goTop.style.cssText += ';right:20px!important;left:auto!important;';
        }

        // 3. Tawk.to — target its injected container divs and iframes
        var tawkSelectors = [
          '#tawkchat-status-container',
          '#tawkchat-container',
          '.tawk-min-container',
          '[class*="tawk-min"]',
          '[id*="tawkchat"]',
          '[id^="tawk-bubble"]',
          'iframe[src*="tawk.to"]',
          'iframe[title*="chat"]'
        ];
        tawkSelectors.forEach(function(sel) {
          document.querySelectorAll(sel).forEach(function(el) {
            var target = el.tagName === 'IFRAME' ? el.parentElement : el;
            if (target) {
              target.style.setProperty('left', '20px', 'important');
              target.style.setProperty('right', 'auto', 'important');
            }
          });
        });
        // Also catch any div containing a tawk iframe
        document.querySelectorAll('iframe[src*="tawk.to"]').forEach(function(iframe) {
          var p = iframe.parentElement;
          while (p && p !== document.body) {
            if (p.style && (p.style.bottom || p.style.right || getComputedStyle(p).position === 'fixed')) {
              p.style.setProperty('left', '20px', 'important');
              p.style.setProperty('right', 'auto', 'important');
              break;
            }
            p = p.parentElement;
          }
        });
      }

      // Run once after page load
      setTimeout(forcePositions, 500);
      setTimeout(forcePositions, 2000);
      setTimeout(forcePositions, 5000);

      // Watch for dynamically injected Tawk.to widgets
      if (window.MutationObserver) {
        var posObserver = new MutationObserver(function(mutations) {
          mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
              mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) {
                  var id = (node.id || '').toLowerCase();
                  var cls = (typeof node.className === 'string' ? node.className : '').toLowerCase();
                  if (id.indexOf('tawk') !== -1 || cls.indexOf('tawk') !== -1) {
                    node.style.setProperty('left', '20px', 'important');
                    node.style.setProperty('right', 'auto', 'important');
                  }
                  // Also handle iframes inside injected containers
                  var iframes = node.querySelectorAll ? node.querySelectorAll('iframe[src*="tawk.to"]') : [];
                  if (iframes.length) {
                    node.style.setProperty('left', '20px', 'important');
                    node.style.setProperty('right', 'auto', 'important');
                  }
                }
              });
            }
          });
        });
        posObserver.observe(document.body, { childList: true, subtree: true });
      }
    });
  </script>

  <!-- Prevent Code & Theme Cloning (Anti-DevTools & Inspect Element & Anti-Copy) -->
  <script>
    (function() {
      // Developer bypass checks:
      // 1. Auto-allow on localhost / local IP
      const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
      // 2. Auto-allow if Laravel is in local environment or APP_DEBUG is true
      const isLaravelDev = {{ config('app.env') === 'local' || config('app.debug') ? 'true' : 'false' }};
      // 3. Secret URL debug query parameter override (?debug=true to enable, ?debug=false to disable)
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('debug') === 'true') {
        localStorage.setItem('allow_inspect', 'true');
      } else if (urlParams.get('debug') === 'false') {
        localStorage.removeItem('allow_inspect');
      }

      // If any developer mode is active, completely skip all code & copy protection
      if (isLocalhost || isLaravelDev || localStorage.getItem('allow_inspect') === 'true') {
        return;
      }

      function blockDevTools() {
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(e) {
          e.preventDefault();
        });
        
        // Disable keyboard shortcuts (F12, Ctrl+Shift+I/J/C, Ctrl+U, Ctrl+S)
        document.addEventListener('keydown', function(e) {
          if (e.keyCode === 123 || 
              (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) || 
              (e.ctrlKey && e.keyCode === 85) || 
              (e.ctrlKey && e.keyCode === 83)) {
            e.preventDefault();
            return false;
          }
        });

        // Disable text copying (copy and cut)
        document.addEventListener('copy', function(e) {
          e.preventDefault();
        });
        document.addEventListener('cut', function(e) {
          e.preventDefault();
        });
        
        // Disable selection triggers
        document.addEventListener('selectstart', function(e) {
          e.preventDefault();
        });

        // Disable dragging of images
        document.addEventListener('dragstart', function(e) {
          if (e.target.tagName === 'IMG') {
            e.preventDefault();
          }
        });

        // Infinite debugger statements to freeze DevTools console & element inspector
        setInterval(function() {
          (function() {}["constructor"]("debugger")());
        }, 100);

        // Detect open/docked DevTools by window dimension differences
        const threshold = 160;
        setInterval(function() {
          const widthThreshold = window.outerWidth - window.innerWidth > threshold;
          const heightThreshold = window.outerHeight - window.innerHeight > threshold;
          if (widthThreshold || heightThreshold) {
            document.body.innerHTML = `
              <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;background:#0f172a;color:#ffffff;font-family:sans-serif;text-align:center;padding:20px;z-index:999999;position:fixed;top:0;left:0;width:100%;">
                <h1 style="font-size:28px;margin-bottom:10px;">Developer Tools Detected</h1>
                <p style="color:#94a3b8;font-size:16px;">To protect proprietary templates, themes, and system code, inspecting this platform is not permitted.</p>
              </div>
            `;
          }
        }, 500);
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', blockDevTools);
      } else {
        blockDevTools();
      }
    })();
  </script>

</body>

</html>
