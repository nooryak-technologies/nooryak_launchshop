<!-- Footer v10 (Clothing) Start -->
<footer class="footer-area footer-v10">

  <!-- Newsletter Strip (Horizontal) -->
  <div class="newsletter-strip-horizontal">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:20px;">
        <div>
          <h3>{{ @$footer->subscriber_title ?? ($keywords['Get 10% Off Your First Order'] ?? __('Get 10% Off Your First Order')) }}</h3>
          <p>{{ @$footer->subscriber_text ?? ($keywords['Join our newsletter and be the first to know about new arrivals, exclusive offers and more.'] ?? __('Join our newsletter and be the first to know about new arrivals, exclusive offers and more.')) }}</p>
        </div>
        <form class="newsletter-form" action="{{ route('front.user.subscribe', getParam()) }}">
          @csrf
          <input placeholder="{{ $keywords['Enter Your Email'] ?? __('Enter Your Email') }}" type="email" name="email" autocomplete="off" required>
          <button type="submit">{{ $keywords['Subscribe'] ?? __('Subscribe') }}</button>
        </form>
      </div>
    </div>
  </div>

  <div class="footer-top">
    <div class="container">
      <div class="row gx-xl-5 gy-4">
        <!-- Brand Info -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="footer-widget">
            <div class="footer-logo" style="margin-bottom:20px;">
              <a href="{{ route('front.user.detail.view', getParam()) }}">
                @if(!empty(@$footer->footer_logo))
                  <img src="{{ asset('assets/front/img/footer/' . @$footer->footer_logo) }}" alt="Logo">
                @else
                  <span style="font-family:var(--clothing-body-font);font-size:26px;font-weight:700;letter-spacing:0.5px;color:#000;text-transform:uppercase;">{{ $user->username }}<span>.</span></span>
                @endif
              </a>
            </div>
            <p class="footer-desc footer_description" style="font-size:13px;line-height:1.6;margin-bottom:20px;">
              {{ @$footer->footer_text ?? ($keywords['Modern style for every story. Quality you can feel.'] ?? __('Modern style for every story. Quality you can feel.')) }}
            </p>
            @if(count($social_medias) > 0)
              <div class="social-link" style="margin-top:20px;display:flex;gap:10px;">
                @foreach($social_medias as $social)
                  @php $url = preg_match('/^https?:\/\//', $social->url) ? $social->url : 'http://' . $social->url; @endphp
                  <a style="width:32px;height:32px;border-radius:50%;background:#e0e0e0;color:#000;display:flex;align-items:center;justify-content:center;font-size:13px;transition:background 0.3s;" href="{{ $url }}" target="_blank" onmouseover="this.style.background='#000';this.style.color='#fff';" onmouseout="this.style.background='#e0e0e0';this.style.color='#000';">
                    <i class="{{ $social->icon }}"></i>
                  </a>
                @endforeach
              </div>
            @endif
          </div>
        </div>

        <!-- Useful Links -->
        <div class="col-lg-3 col-md-6 col-6">
          <div class="footer-widget">
            <h4 class="footer-heading">{{ $footer->useful_links_title ?? __('Quick Links') }}</h4>
            @if(count($ulinks) == 0)
              <p style="color:#888;font-size:13px;">{{ $keywords['NO LINKS FOUND'] ?? __('NO LINKS FOUND') }}</p>
            @else
              <ul class="footer-links" style="list-style:none;padding-left:0;line-height:2.2;">
                @foreach($ulinks as $link)
                  @if($loop->iteration > 6) @break @endif
                  <li><a href="{{ $link->url }}">{{ $link->name }}</a></li>
                @endforeach
              </ul>
            @endif
          </div>
        </div>

        <!-- Collections -->
        <div class="col-lg-3 col-md-6 col-6">
          <div class="footer-widget">
            <h4 class="footer-heading">{{ $keywords['Collections'] ?? __('Collections') }}</h4>
            <ul class="footer-links" style="list-style:none;padding-left:0;line-height:2.2;">
              @foreach($categories->take(6) as $cat)
                <li><a href="{{ route('front.user.shop', [getParam(), 'category=' . $cat->slug]) }}">{{ $cat->name }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>

        <!-- Contact Us -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="footer-widget">
            <h4 class="footer-heading">{{ $keywords['Contact Us'] ?? __('Contact Us') }}</h4>
            @php
              $phone_numbers = !empty(@$userContact->contact_numbers) ? explode(',', $userContact->contact_numbers) : [];
              $emails        = !empty(@$userContact->contact_mails)   ? explode(',', $userContact->contact_mails)   : [];
              $addresses     = !empty(@$userContact->contact_addresses)? explode(PHP_EOL, $userContact->contact_addresses) : [];
            @endphp
            <ul class="footer-links" style="list-style:none;padding-left:0;line-height:2.2;font-size:13px;color:#555;">
              @if(count($phone_numbers) > 0)
                <li>
                  <i class="fal fa-phone" style="margin-right:8px;"></i>
                  @foreach($phone_numbers as $pn)
                    <a href="tel:{{ $pn }}">{{ $pn }}</a>{{ !$loop->last ? ', ' : '' }}
                  @endforeach
                </li>
              @endif
              @if(count($emails) > 0)
                <li>
                  <i class="fal fa-envelope" style="margin-right:8px;"></i>
                  @foreach($emails as $em)
                    <a href="mailto:{{ $em }}">{{ $em }}</a>{{ !$loop->last ? ', ' : '' }}
                  @endforeach
                </li>
              @endif
              @if(count($addresses) > 0)
                @foreach($addresses as $address)
                  <li>
                    <i class="fal fa-map-marker-alt" style="margin-right:8px;"></i>
                    {{ $address }}
                  </li>
                @endforeach
              @endif
            </ul>
            @includeIf('user-front.partials.pwa-app-button')
          </div>
        </div>
      </div>
    </div>
  </div>

  @if($ubs->copyright_section == 1)
    <div class="footer-bottom">
      <div class="container">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
          <p>{!! replaceBaseUrl($footer->copyright_text ?? null) !!}</p>
          <p style="font-size:12px;color:rgba(0,0,0,0.4);">
            <i class="fal fa-shield-alt" style="margin-right:6px;"></i>{{ $keywords['Secure Payments'] ?? __('Secure Payments') }}
          </p>
        </div>
      </div>
    </div>
  @endif
</footer>
<!-- Footer v10 (Clothing) End -->

@includeIf('user-front.clothing.partials.mobile-menu')
