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
  <link rel="stylesheet" href="{{ asset('assets/front/css/launchshop-custom-v2.css?v=2.1.2') }}">
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

  {{-- WhatsApp Chat Button (dynamic via plugin when is_whatsapp=1) --}}
  <div id="WAButton" style="position:fixed;left:18px;right:auto;bottom:22px;z-index:999;"></div>

  {{-- ═══════════════════════════════════════════════════
       LEFT SIDE FLOATING STACK  (bottom → top)
       [WhatsApp]  bottom: 22px
       [AI Chat]   bottom: 90px  (22 + 56 + 12 gap)
       ═══════════════════════════════════════════════════ --}}

  {{-- Static WhatsApp — shows when is_whatsapp plugin is OFF but number exists --}}
  @if (!empty($bs->whatsapp_number) && $bs->is_whatsapp != 1)
    <a href="https://wa.me/6374913298?text=Hi%2C%20I%20want%20to%20enquire%20about%20the%20LaunchShop.%20Please%20help%20me%20get%20started."
       target="_blank" rel="noopener noreferrer"
       class="fab-btn fab-whatsapp"
       title="Chat on WhatsApp"
       aria-label="Chat on WhatsApp">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="26" height="26" fill="#fff">
        <path d="M24 4C13 4 4 13 4 24c0 3.6.97 7 2.66 9.9L4 44l10.37-2.63A19.9 19.9 0 0 0 24 44c11 0 20-9 20-20S35 4 24 4zm0 36a16 16 0 0 1-8.18-2.26l-.58-.35-6.16 1.56 1.6-5.98-.38-.6A16 16 0 1 1 24 40zm8.77-11.9c-.48-.24-2.83-1.4-3.27-1.56-.44-.16-.76-.24-1.08.24-.32.48-1.24 1.56-1.52 1.88-.28.32-.56.36-1.04.12-.48-.24-2.02-.74-3.85-2.36-1.42-1.26-2.38-2.82-2.66-3.3-.28-.48-.03-.74.21-.98.22-.22.48-.56.72-.84.24-.28.32-.48.48-.8.16-.32.08-.6-.04-.84-.12-.24-1.08-2.6-1.48-3.56-.38-.93-.78-.8-1.08-.82h-.92c-.32 0-.84.12-1.28.6-.44.48-1.68 1.64-1.68 4s1.72 4.64 1.96 4.96c.24.32 3.38 5.16 8.2 7.24 1.14.5 2.04.8 2.74 1.02 1.15.36 2.2.31 3.03.19.92-.14 2.83-1.16 3.23-2.28.4-1.12.4-2.08.28-2.28-.12-.2-.44-.32-.92-.56z"/>
      </svg>
    </a>
  @endif

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
  @if ($bs->is_whatsapp == 1)
    <script type="text/javascript">
      "use strict";
      var whatsapp_popup = {{ $bs->whatsapp_popup }};
      var whatsapp_number = "6374913298";
      var whatsapp_prefill = "Hi%2C%20I%20want%20to%20enquire%20about%20the%20LaunchShop.%20Please%20help%20me%20get%20started.";
      var whatsapp_header_title = "{{ $bs->whatsapp_header_title }}";
      var popup_message = `{!! $bs->whatsapp_popup_message !!}`;
      var whatsappImg = "{{ asset('assets/front/images/whatsapp.svg') }}";
      $(function() {
        $('#WAButton').floatingWhatsApp({
          phone: whatsapp_number,
          headerTitle: whatsapp_header_title,
          popupMessage: popup_message,
          message: "Hi, I want to enquire about the LaunchShop. Please help me get started.",
          showPopup: whatsapp_popup == 1 ? true : false,
          buttonImage: '<img src="' + whatsappImg + '" />',
          position: "left"
        });
      });
    </script>
  @endif

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

  <!-- Prevent Code & Theme Cloning (Anti-DevTools & Inspect Element) -->
  <script>
    (function() {
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
