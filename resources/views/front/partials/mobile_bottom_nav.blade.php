<!-- Mobile Bottom Navigation Bar -->
<div class="mobile-bottom-nav-bar">
  <div class="mobile-nav-items">
    <!-- 1. HOME -->
    <a href="{{ route('front.index') }}" class="mobile-nav-item {{ request()->routeIs('front.index') ? 'active' : '' }}">
      <div class="mobile-nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-6a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v6H4a1 1 0 0 1-1-1V9.5z"/>
        </svg>
      </div>
      <span class="mobile-nav-label">{{ __('HOME') }}</span>
    </a>

    <!-- 2. THEME -->
    <a href="{{ route('front.templates.view') }}" class="mobile-nav-item {{ request()->routeIs('front.templates.view') ? 'active' : '' }}">
      <div class="mobile-nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m18.37 2.63 3 3a2.12 2.12 0 0 1 0 3L11 19l-4 1 1-4L18.37 2.63z"/>
          <path d="M8 14s-1.5 2-4 2 2 3.5 4.5 3.5 3.5-1.5 3.5-3.5"/>
        </svg>
      </div>
      <span class="mobile-nav-label">{{ __('THEME') }}</span>
    </a>

    <!-- 3. PRICING -->
    <a href="{{ route('front.pricing') }}" class="mobile-nav-item {{ request()->routeIs('front.pricing') ? 'active' : '' }}">
      <div class="mobile-nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m20.59 13.41-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
          <line x1="7" y1="7" x2="7.01" y2="7"/>
        </svg>
      </div>
      <span class="mobile-nav-label">{{ __('PRICING') }}</span>
    </a>

    <!-- 4. ACCOUNT -->
    @auth
      <a href="{{ route('user-dashboard') }}" class="mobile-nav-item {{ request()->routeIs('user-dashboard') ? 'active' : '' }}">
    @else
      <a href="{{ route('user.login') }}" class="mobile-nav-item {{ (request()->routeIs('user.login') || request()->routeIs('user.register')) ? 'active' : '' }}">
    @endauth
      <div class="mobile-nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
      </div>
      <span class="mobile-nav-label">{{ __('ACCOUNT') }}</span>
    </a>

    <!-- 5. CONTACT -->
    <a href="{{ route('front.contact') }}" class="mobile-nav-item {{ request()->routeIs('front.contact') ? 'active' : '' }}">
      <div class="mobile-nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 18v-6a9 9 0 0 1 18 0v6"/>
          <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>
        </svg>
      </div>
      <span class="mobile-nav-label">{{ __('CONTACT') }}</span>
    </a>
  </div>

  <!-- iOS Home Indicator bar -->
  <div class="mobile-home-indicator"></div>
</div>

<style>
  /* Mobile Floating Bottom Navigation Bar Styles */
  .mobile-bottom-nav-bar {
    display: none;
  }

  @media (max-width: 991px) {
    /* Sleek Floating Dock Navigation Bar */
    .mobile-bottom-nav-bar {
      display: block !important;
      position: fixed !important;
      bottom: 12px !important;
      left: 14px !important;
      right: 14px !important;
      width: auto !important;
      z-index: 999999 !important;
      background: #0d121e !important;
      border-radius: 20px !important;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.65), 0 0 1px rgba(255, 255, 255, 0.15) !important;
      padding: 9px 8px 6px !important;
      user-select: none !important;
      -webkit-user-select: none !important;
      backdrop-filter: blur(12px) !important;
      -webkit-backdrop-filter: blur(12px) !important;
      overflow: hidden !important;
    }

    /* Top Multi-Color Gradient Glow Border Line */
    .mobile-bottom-nav-bar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3.5px;
      background: linear-gradient(90deg, #ff4500 0%, #e60067 22%, #9c27b0 45%, #0070f3 72%, #00f2fe 100%);
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
    }

    .mobile-nav-items {
      display: flex;
      align-items: center;
      justify-content: space-around;
      padding-top: 4px;
      width: 100%;
      margin: 0;
    }

    .mobile-nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-decoration: none !important;
      color: #8c9ba5;
      padding: 4px 0;
      transition: all 0.25s ease;
      flex: 1;
      text-align: center;
    }

    .mobile-nav-icon {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 26px;
      height: 26px;
      margin-bottom: 3px;
      color: #8c9ba5;
      transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275), color 0.25s ease, filter 0.25s ease;
    }

    .mobile-nav-icon svg {
      width: 22px;
      height: 22px;
    }

    .mobile-nav-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      color: #8c9ba5;
      transition: color 0.25s ease, text-shadow 0.25s ease;
      line-height: 1.2;
    }

    /* Active State (Glowing Orange) */
    .mobile-nav-item.active .mobile-nav-icon {
      color: #ff5722;
      transform: translateY(-2px) scale(1.08);
      filter: drop-shadow(0 2px 8px rgba(255, 87, 34, 0.75));
    }

    .mobile-nav-item.active .mobile-nav-label {
      color: #ff5722;
      text-shadow: 0 0 10px rgba(255, 87, 34, 0.45);
    }

    /* Hover/Touch feedback */
    .mobile-nav-item:active .mobile-nav-icon {
      transform: scale(0.92);
    }

    /* Home Indicator line (white bar) */
    .mobile-home-indicator {
      display: block;
      width: 120px;
      height: 4px;
      background: rgba(255, 255, 255, 0.88);
      border-radius: 100px;
      margin: 7px auto 2px;
      box-shadow: 0 0 4px rgba(255, 255, 255, 0.2);
    }

    /* Reposition floating widgets above mobile bottom bar */
    #WAButton,
    .custom-wa-widget,
    .fab-btn,
    .go-top {
      bottom: 95px !important;
    }

    body {
      padding-bottom: 85px !important;
    }
  }

  @media (min-width: 992px) {
    .mobile-bottom-nav-bar {
      display: none !important;
    }
  }
</style>
