<!-- Footer Start -->
<footer class="footer-area footer-v7">
  <!-- Background Image -->
  <img class="lazyload blur-up bg-img"
    data-src="{{ !is_null(@$footer->background_image) ? asset('assets/front/img/footer/' . $footer->background_image) : asset('assets/user-front/images/pet/footer-bg.jpg') }}"
    alt="Bg-img">
  <div class="footer-top pt-100 pb-70">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
          <div class="footer-widget">
            <div class="navbar-brand">
              <a href="{{ route('front.user.detail.view', getParam()) }}">
                <img src="{{ !empty($footer->footer_logo) ? asset('assets/front/img/footer/' . $footer->footer_logo) : (!empty($userBs->dark_logo) ? asset('assets/front/img/user/' . $userBs->dark_logo) : (!empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : asset('assets/front/img/logo.png'))) }}"
                  alt="{{ $userBs->website_title ?? 'Logo' }}"
                  style="max-height: 60px; max-width: 220px; width: auto; height: auto; object-fit: contain; display: block !important;">
              </a>
            </div>
            <p class="text fw-medium footer_description">
              {{ @$footer->footer_text ?? '' }}
            </p>
            @if (strlen(@$footer->footer_text) > 250)
              <span class="show-more-footer">{{ $keywords['Show More'] ?? __('Show More') }} +</span>
            @endif

            @if (count($social_medias) > 0)
              <div class="social-link">
                @foreach ($social_medias as $social)
                  @php
                    $url = preg_match('/^https?:\/\//', $social->url) ? $social->url : 'http://' . $social->url;
                  @endphp
                  <a class="" style="background: #{{ $social->background_color }}" href="{{ $url }}"
                    target="_blank">
                    <i class="{{ $social->icon }}"></i>
                  </a>
                @endforeach
              </div>
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
                @if (count($ulinks) > 0)
                  @foreach ($ulinks as $link)
                    <li>
                      <a href="{{ $link->url }}">{{ $link->name }}</a>
                    </li>
                  @endforeach
                @else
                  <li><a href="{{ route('front.user.privacy_policy', getParam()) }}">{{ $keywords['Privacy Policy'] ?? __('Privacy Policy') }}</a></li>
                  <li><a href="{{ route('front.user.terms_conditions', getParam()) }}">{{ $keywords['Terms & Conditions'] ?? __('Terms & Conditions') }}</a></li>
                  <li><a href="{{ route('front.user.refund_policy', getParam()) }}">{{ $keywords['Refund Policy'] ?? __('Refund Policy') }}</a></li>
                  <li><a href="{{ route('front.user.shipping_policy', getParam()) }}">{{ $keywords['Shipping Policy'] ?? __('Shipping Policy') }}</a></li>
                @endif
              </ul>
            @endif
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-6">
          <div class="footer-widget">
            <h3>{{ $keywords['Contact Us'] ?? __('Contact Us') }}</h3>
            @php
              $phoneRaw = !empty(@$userContact->contact_numbers) ? $userContact->contact_numbers : (!empty(@$user->phone) ? $user->phone : @$userBs->contact_number);
              $mailRaw = !empty(@$userContact->contact_mails) ? $userContact->contact_mails : (!empty(@$user->email) ? $user->email : @$userBs->email);
              $addrRaw = !empty(@$userContact->contact_addresses) ? $userContact->contact_addresses : (!empty(@$user->address) ? $user->address : @$userBs->address);
              $phone_numbers = !empty($phoneRaw) ? explode(',', $phoneRaw) : [];
              $emails = !empty($mailRaw) ? explode(',', $mailRaw) : [];
              $addresses = !empty($addrRaw) ? preg_split('/\r\n|\r|\n/', $addrRaw) : [];
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
  </div>
  <div class="copy-right-area border-top-medium">
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
<!-- Footer End -->
