<!-- Footer Start -->
<footer class="footer-area">
  <!-- Background Image -->
  <div class="bg-overlay">
    <img class="lazyload blur-up bg-img"
      data-src="{{ !is_null(@$footer->background_image) ? asset('assets/front/img/footer/' . $footer->background_image) : asset('assets/user-front/images/footer-bg-1.jpg') }}"
      alt="Bg-img">
  </div>

  <div class="footer-top ">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
          <div class="footer-widget">
            <div class="navbar-brand">
              <a href="{{ route('front.user.detail.view', getParam()) }}">
                <img class="lazyload"
                  src="{{ !empty($footer->footer_logo) ? asset('assets/front/img/footer/' . $footer->footer_logo) : (!empty($userBs->dark_logo) ? asset('assets/front/img/user/' . $userBs->dark_logo) : (!empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : asset('assets/front/img/logo.png'))) }}"
                  alt="Logo">
              </a>
            </div>
            <p class="text footer_description">{{ @$footer->footer_text ?? '' }}</p>
            @if (strlen(@$footer->footer_text) > 250)
              <span class="show-more-footer">{{ $keywords['Show More'] ?? __('Show More') }} +</span>
            @endif
          </div>
        </div>

        <div class="{{ count($ulinks) <= 5 ? 'col-lg-2 col-md-3 col-6' : 'col-lg-3 col-md-4 col-6' }}">
          <div class="footer-widget">
            <h3>{{ $footer->useful_links_title ?? __('Useful Links') }}</h3>
            @if (count($ulinks) == 0)
              <h6 class="title mb-20">
                {{ $keywords['NO LINKS FOUND'] ?? __('NO LINKS FOUND') }}
              </h6>
            @else
              <ul class="footer-links">
                @foreach ($ulinks as $link)
                  @if ($loop->iteration > 4)
                    @break
                  @endif
                  <li>
                    <a href="{{ $link->url }}">{{ $link->name }}</a>
                  </li>
                @endforeach
                <li><a href="{{ route('front.user.privacy_policy', getParam()) }}">{{ $keywords['Privacy Policy'] ?? __('Privacy Policy') }}</a></li>
                <li><a href="{{ route('front.user.terms_conditions', getParam()) }}">{{ $keywords['Terms & Conditions'] ?? __('Terms & Conditions') }}</a></li>
                <li><a href="{{ route('front.user.refund_policy', getParam()) }}">{{ $keywords['Refund Policy'] ?? __('Refund Policy') }}</a></li>
                <li><a href="{{ route('front.user.shipping_policy', getParam()) }}">{{ $keywords['Shipping Policy'] ?? __('Shipping Policy') }}</a></li>
              </ul>
            @endif
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-6">
          <div class="footer-widget">
            <h3>{{ $keywords['Contact Us'] ?? __('Contact Us') }}</h3>
            @php
              $phone_numbers = !empty(@$userBs->contact_number) 
                ? explode(',', $userBs->contact_number) 
                : (!empty(@$user->phone) ? [$user->phone] : (!empty(@$userContact->contact_numbers) ? explode(',', $userContact->contact_numbers) : []));
              $emails = !empty(@$userBs->email) 
                ? explode(',', $userBs->email) 
                : (!empty(@$user->email) ? [$user->email] : (!empty(@$userContact->contact_mails) ? explode(',', $userContact->contact_mails) : []));
              $addresses = !empty(@$userBs->address) 
                ? explode(PHP_EOL, $userBs->address) 
                : (!empty(@$user->address) ? [$user->address] : (!empty(@$userContact->contact_addresses) ? explode(PHP_EOL, $userContact->contact_addresses) : []));
            @endphp

            <ul class="footer-links">

              @if (count($phone_numbers) > 0)
                <li>
                  <div class="footer-widget-number">
                    @foreach ($phone_numbers as $phone_number)
                      <a href="tel: {{ $phone_number }}">{{ $phone_number }}</a>
                    @endforeach
                  </div>
                </li>
              @endif
              @if (count($emails) > 0)
                <li>
                  <div class="footer-widget-email">
                    @foreach ($emails as $email)
                      <a href="mailto: {{ $email }}">{{ $email }}</a>
                    @endforeach
                  </div>
                </li>
              @endif
              @if (count($addresses) > 0)
                @foreach ($addresses as $address)
                  <li>
                    {{ $address }}
                  </li>
                @endforeach
              @endif

              @if (count($social_medias) > 0)
                <li>
                  <div class="social-link">
                    @foreach ($social_medias as $social)
                      @php
                        $url = preg_match('/^https?:\/\//', $social->url) ? $social->url : 'http://' . $social->url;
                      @endphp
                      <a href="{{ $url }}" target="_blank">
                        <i class="{{ $social->icon }}"></i>
                      </a>
                    @endforeach
                  </div>
                </li>
              @endif
            </ul>
          </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
          <div class="footer-widget">
            <h3>{{ @$footer->subscriber_title ?? ($keywords['Subscribe'] ?? __('Subscribe')) }}</h3>
            <p>{{ @$footer->subscriber_text }}</p>
            <form class="newsletter-form form-inline w-100" action="{{ route('front.user.subscribe', getParam()) }}">
              @csrf
              <div class="input-group p-0 rounded-pill">
                <input class="form-control"
                  placeholder="{{ $keywords['Enter_Email_Address'] ?? __('Enter Your Email') }}" type="text"
                  name="email" autocomplete="off">
                <button class="btn btn-lg btn-primary rounded-pill icon-end shadow" type="submit">
                  {{ $keywords['Subscribe'] ?? __('Subscribe') }} <i class="fal fa-paper-plane"></i>
                </button>
              </div>
            </form>
            @includeIf('user-front.partials.pwa-app-button')
          </div>
        </div>

      </div>
    </div>

      <div class="copy-right-area border-top">
        <div class="container">
          <div class="copy-right-content">
            <span>
              {!! replaceBaseUrl(@$footer->copyright_text ?? null) ?: ('Copyright &copy; ' . date('Y') . ' ' . ($userBs->website_title ?? 'Metroshop') . '. All Rights Reserved.') !!}
              <span class="powered-by-link"> | Powered by <a href="https://launchshop.in/" target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: underline; font-weight: 600;">launchshop.in</a> | <a href="javascript:void(0)" class="launchshop-disclaimer-trigger" style="color: inherit; text-decoration: underline; font-weight: 600; font-size: 13.5px;"><i class="fal fa-shield-alt mr-1"></i> Disclaimer</a></span>
              
            </span>
          </div>
        </div>
      </div>
</footer>

<div class="mobile-menu-overlay"></div>
<!-- Responsive Mobile Menu -->
<div class="mobile-menu">
  <div class="mobile-menu-wrapper">
    <div class="mobile-menu-top">

      <div class="logo">
        <!-- logo -->
        <a href="{{ route('front.user.detail.view', getParam()) }}" class="logo">
          <img class="lazyload" src="{{ !empty(@$userBs->mobile_logo) ? asset('assets/front/img/user/' . @$userBs->mobile_logo) : (!empty(@$userBs->logo) ? asset('assets/front/img/user/' . @$userBs->logo) : asset('assets/front/img/logo.png')) }}" alt="logo">
        </a>
      </div>
      <span class="mobile-menu-close"><i class="fal fa-times"></i></span>

    </div>

    <!-- mobile-search -->
    <div class="header-search mobile-search">
      <form action="{{ route('front.user.shop', getParam()) }}" class="header-search-form rounded-pill" autocomplete="off">
        <div class="search-input">
          <input type="text" class="form-control" value="{{ request()->input('keyword') }}"
            placeholder="{{ $keywords['Im searching for'] ?? ($keywords['Search...'] ?? __('Search...')) }}..." name="keyword">
        </div>
        <button class="btn btn-icon btn-icon-2" type="submit"><i class="fal fa-search"></i></button>
      </form>
    </div>

    <!-- mobile navigation links -->
    <nav class="menu mobile-nav">
      <ul class="menu-right me-auto">
        @php
          $links = json_decode($userMenus, true) ?? [];
        @endphp
        @foreach ($links as $link)
          @php
            $href = getUserHref($link, $userCurrentLang->id);
          @endphp
          @if (!array_key_exists('children', $link))
            <li class="nav-item">
              <a class="nav-link {{ url()->current() == $href ? 'active' : '' }}" target="{{ $link['target'] }}"
                href="{{ $href }}">{{ $link['text'] }}</a>
            </li>
          @else
            <li class="nav-item has-submenu">
              <a href="{{ $href }}" target="{{ $link['target'] }}"
                class="nav-link {{ url()->current() == $href ? 'active' : '' }}">{{ $link['text'] }}<i class="fal fa-plus"></i></a>
              <ul class="submenu">
                @foreach ($link['children'] as $level2)
                  @php
                    $l2Href = getUserHref($level2, $userCurrentLang->id);
                  @endphp
                  @if (trim($level2['text']) != 'Privacy Policy')
                    <li class="nav-item">
                      <a class="nav-link" href="{{ $l2Href }}"
                        target="{{ $level2['target'] }}">{{ $level2['text'] }}</a>
                    </li>
                  @endif
                @endforeach
                @if (strtolower(trim($link['text'])) == 'pages')
                  <li><a class="nav-link" href="{{ route('front.user.privacy_policy', getParam()) }}">{{ $keywords['Privacy Policy'] ?? __('Privacy Policy') }}</a></li>
                  <li><a class="nav-link" href="{{ route('front.user.terms_conditions', getParam()) }}">{{ $keywords['Terms & Conditions'] ?? __('Terms & Conditions') }}</a></li>
                  <li><a class="nav-link" href="{{ route('front.user.refund_policy', getParam()) }}">{{ $keywords['Refund Policy'] ?? __('Refund Policy') }}</a></li>
                  <li><a class="nav-link" href="{{ route('front.user.shipping_policy', getParam()) }}">{{ $keywords['Shipping Policy'] ?? __('Shipping Policy') }}</a></li>
                @endif
              </ul>
            </li>
          @endif
        @endforeach
      </ul>
    </nav>
  </div>
  <!-- Responsive Mobile Menu -->

  <!-- menu-item-action-wrapper -->
  @includeIf('user-front.partials.mobile-menu')
  <!-- menu-item-action-wrapper -->

</div>
