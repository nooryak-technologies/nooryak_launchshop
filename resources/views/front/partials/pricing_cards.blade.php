<!-- ─── PRICING V2 SECTION ─── -->
@php
  $selectedTemplate = request()->query('template');
  if (\Schema::hasTable('package_features')) {
      $allFeatures = \App\Models\PackageFeature::whereNotIn('name', ['Disqus', 'Bank Transfer Integrations'])
          ->whereNotIn('keyword', ['Disqus', 'Bank Transfer Integrations'])
          ->orderBy('serial_number', 'asc')
          ->get();
  } else {
      $allFeatures = collect();
  }
@endphp
<div class="pricing-v2-section" data-aos="fade-up">

  <!-- Toggle -->
  <div class="pricing-toggle-wrap">
    @if(in_array('yearly', array_map('strtolower', (array)$terms)) && empty($hidePill))
      <div class="pricing-save-pill">
        🏷️ Save up to 60% with yearly billing!
      </div>
    @endif
    <ul class="pricing-pill-tabs nav" id="pricing-tabs" role="tablist">
      @foreach ($terms as $term)
        <li class="nav-item" role="presentation">
          <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                  id="{{ strtolower($term) }}-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#tab-{{ strtolower($term) }}"
                  type="button"
                  role="tab"
                  aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            {{ __(ucfirst(strtolower($term))) }}
          </button>
        </li>
      @endforeach
    </ul>
    @if(in_array('yearly', array_map('strtolower', (array)$terms)))
      <p class="yearly-free-domain-note mt-3">🎁 Premium & Enterprise Plans include Free Domains For Every Year.</p>
    @endif
  </div>


  <!-- Cards -->
  <div class="tab-content" id="pricing-tabs-content">
    @foreach ($terms as $term)
      @php
        $packages = \App\Models\Package::where('status', '1')
            ->where('term', strtolower($term))
            ->orderBy('price', 'asc')
            ->get();
      @endphp
      <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
           id="tab-{{ strtolower($term) }}"
           role="tabpanel">
        <div class="pricing-cards-row">

          @foreach ($packages as $index => $package)
            @php
              $titleKey    = strtolower($package->title);

              $isRecommended = ($titleKey == 'standard');
              $isBestValue   = ($titleKey == 'premium');
              $isBasic       = ($titleKey == 'basic');
              $cardClass     = $isRecommended ? 'card-recommended' : ($isBestValue ? 'card-best-value' : ($isBasic ? 'card-basic' : ''));

              // Subtitle
              $subtitles = [
                  'basic' => 'Start your own online store',
                  'standard' => 'Elevate Your E-commerce Journey',
                  'premium' => 'Best for Small Business Owners.'
              ];
              $planSubtitle = $subtitles[$titleKey] ?? ucfirst($titleKey).' plan';

              $periodLabel = strtolower($package->term) == 'lifetime' ? 'one-time' : (strtolower($package->term) == 'yearly' ? 'year' : 'month');
              // Features
              $pFeatures = json_decode($package->features, true) ?: [];
              $packageFormattedFeatures = [];
              
              if ($allFeatures->isEmpty()) {
                  $packageFormattedFeatures = [];
                  
                  $limitVal = $package->categories_limit ?? 0;
                  if ($limitVal > 0 || $limitVal == 999999) {
                      $packageFormattedFeatures[] = ['text' => 'Categories Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                  }
                  $limitVal = $package->product_limit ?? 0;
                  if ($limitVal > 0 || $limitVal == 999999) {
                      $packageFormattedFeatures[] = ['text' => 'Products Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                  }
                  $limitVal = $package->order_limit ?? 0;
                  if ($limitVal > 0 || $limitVal == 999999) {
                      $packageFormattedFeatures[] = ['text' => 'Orders Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                  }
                  $limitVal = $package->language_limit ?? 0;
                  if ($limitVal > 0 || $limitVal == 999999) {
                      $packageFormattedFeatures[] = ['text' => 'Additional Languages : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                  }
                  $limitVal = $package->post_limit ?? 0;
                  if ($limitVal > 0 || $limitVal == 999999) {
                      $packageFormattedFeatures[] = ['text' => 'Posts Limit : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                  }
                  $limitVal = $package->number_of_custom_page ?? 0;
                  if ($limitVal > 0 || $limitVal == 999999) {
                      $packageFormattedFeatures[] = ['text' => 'Custom Pages : '.($limitVal==999999?'Unlimited':$limitVal), 'has' => true];
                  }
                  
                  $fallbackPills = [
                      'Custom Domain' => 'Custom Domain',
                      'Subdomain' => 'Subdomain',
                      'QR Builder' => 'QR Builder',
                      'Blog' => 'Blog',
                      'Custom Page' => 'Custom Page',
                      'Google Login' => 'Google Login',
                      'Google Analytics' => 'Google Analytics',
                      'Google Recaptcha' => 'Google Recaptcha',
                      'WhatsApp Chat Button' => 'WhatsApp Chat Button',
                      'Tawk to' => 'Tawk to',
                      'AI Content & Image Generator' => 'AI Content & Image Generator'
                  ];
                  foreach ($fallbackPills as $k => $name) {
                      if ($k === 'AI Content & Image Generator') {
                          continue;
                      }
                      if ($k !== 'Blog' && $k !== 'Custom Page') {
                          if (in_array($k, $pFeatures)) {
                              $packageFormattedFeatures[] = ['text' => $name, 'has' => true];
                          }
                      }
                  }
              } else {
                  foreach ($allFeatures as $feature) {
                      if ($feature->keyword === 'AI Content & Image Generator' || $feature->name === 'AI Content & Image Generator') {
                          continue;
                      }
                      $has = false;
                      $rawName = $feature->name;
                      $text = str_replace(['Free .in Domain', '.in Domain'], ['Free .com Domain', '.com Domain'], $rawName);
                      
                      if ($feature->type === 'limit') {
                          $limitVal = $package->{$feature->limit_key} ?? 0;
                          $formattedVal = ($limitVal == 999999) ? __('Unlimited') : $limitVal;
                          if ($feature->limit_key === 'order_limit' && $limitVal != 999999) {
                              $formattedVal .= '/' . ($package->term == 'monthly' ? 'm' : 'yr');
                          }
                          $text = str_replace('{limit}', $formattedVal, $text);
                          $has = ($limitVal > 0 || $limitVal == 999999);
                      } elseif ($feature->type === 'standard') {
                          $has = in_array($feature->keyword, $pFeatures);
                          if ($has && !empty($feature->limit_key)) {
                              $limitVal = $package->{$feature->limit_key} ?? 0;
                              $formattedVal = ($limitVal == 999999) ? __('Unlimited') : $limitVal;
                              $text = str_replace('{limit}', $formattedVal, $text);
                          } elseif (!empty($feature->limit_key)) {
                              $limitVal = $package->{$feature->limit_key} ?? 0;
                              $formattedVal = ($limitVal == 999999) ? __('Unlimited') : $limitVal;
                              $text = str_replace('{limit}', $formattedVal, $text);
                          }
                      } elseif ($feature->type === 'custom') {
                          if (stripos($text, 'Free .com Domain') !== false || stripos($text, 'Free .in Domain') !== false) {
                              if (strtolower($package->term) == 'monthly') {
                                  $has = false;
                              } else {
                                  $has = in_array('Free .com Domain', $pFeatures) || in_array('Free .in Domain', $pFeatures) || in_array($feature->name, $pFeatures);
                              }
                          } else {
                              $has = in_array($feature->name, $pFeatures);
                          }
                      }
                      
                      $packageFormattedFeatures[] = ['text' => $text, 'has' => $has];
                  }
              }
 
              // Post-process features to customize "Additional Languages" dynamically based on plan title key
              // Basic: strikeout, Standard: 1 Additional Language, Premium: 3 Additional Languages
              
              // Find if "Additional Languages" already exists in the formatted features
              $foundLangKey = false;
              foreach ($packageFormattedFeatures as $key => $feat) {
                  if (stripos($feat['text'], 'Additional Languages') !== false || stripos($feat['text'], 'languages') !== false) {
                      $foundLangKey = $key;
                      break;
                  }
              }
              
              $customText = 'Additional Languages';
              $customHas = false;
              
              if ($titleKey === 'standard') {
                  $customText = '1 Additional Language';
                  $customHas = true;
              } elseif ($titleKey === 'premium') {
                  $customText = '3 Additional Languages';
                  $customHas = true;
              }
              
              if ($foundLangKey !== false) {
                  // Override the existing feature
                  $packageFormattedFeatures[$foundLangKey]['text'] = $customText;
                  $packageFormattedFeatures[$foundLangKey]['has'] = $customHas;
              } else {
                  // If it doesn't exist, append it
                  $packageFormattedFeatures[] = ['text' => $customText, 'has' => $customHas];
              }
 
              $visibleCount = 7;
              $visibleFeats = array_slice($packageFormattedFeatures, 0, $visibleCount);
              $extraFeats   = array_slice($packageFormattedFeatures, $visibleCount);

              // CTA href
              if ($package->is_trial === '1' && $package->price != 0) {
                $ctaHref = $selectedTemplate
                  ? (Route::has('front.register.view') ? route('front.register.view', ['status'=>'regular','id'=>$package->id]).'?template='.urlencode($selectedTemplate) : url('/'))
                  : (Route::has('front.select.template') ? route('front.select.template', ['status'=>'regular','id'=>$package->id]) : url('/'));
              } elseif ($package->price == 0) {
                $ctaHref = $selectedTemplate
                  ? (Route::has('front.register.view') ? route('front.register.view', ['status'=>'regular','id'=>$package->id]).'?template='.urlencode($selectedTemplate) : url('/'))
                  : (Route::has('front.select.template') ? route('front.select.template', ['status'=>'regular','id'=>$package->id]) : url('/'));
              } else {
                $ctaHref = $selectedTemplate
                  ? (Route::has('front.register.view') ? route('front.register.view', ['status'=>'regular','id'=>$package->id]).'?template='.urlencode($selectedTemplate) : url('/'))
                  : (Route::has('front.select.template') ? route('front.select.template', ['status'=>'regular','id'=>$package->id]) : url('/'));
              }
@endphp

            <div class="pricing-card-v2 {{ $cardClass }} package-{{ $package->id }} plan-{{ $titleKey }}">
              @if($titleKey == 'standard')
                <!-- Mobile-only Most Popular Callout -->
                <div class="mobile-most-popular-callout d-lg-none">
                  <div class="d-flex align-items-start gap-2">
                    <div class="callout-icon-wrap rocket" style="background:#ff5a2c; color:#fff;">
                      <i class="fas fa-rocket"></i>
                    </div>
                    <div class="callout-text">
                      <h5 class="callout-title">Most Popular</h5>
                      <p class="callout-desc">Ideal balance for growing businesses with all essential tools.</p>
                    </div>
                  </div>
                </div>
              @endif

              @if($titleKey == 'premium')
                <!-- Mobile-only Most People Choose Callout -->
                <div class="mobile-most-people-choose-callout d-lg-none">
                  <div class="d-flex align-items-start gap-2">
                    <div class="callout-icon-wrap star" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; color:#fff;">
                      <i class="fas fa-star"></i>
                    </div>
                    <div class="callout-text">
                      <h5 class="callout-title">Most People Choose</h5>
                      <p class="callout-desc">Best value with all premium features and a free domain.</p>
                    </div>
                  </div>
                </div>
              @endif

              @if($titleKey == 'basic')
                <!-- Basic Most Popular Callout Box (Top of Basic card, points to Standard) -->
                <div class="basic-most-popular-callout d-none d-lg-block">
                  <div class="d-flex align-items-start gap-2">
                    <div class="callout-icon-wrap rocket" style="background:#ff5a2c; color:#fff;">
                      <i class="fas fa-rocket"></i>
                    </div>
                    <div class="callout-text">
                      <h5 class="callout-title">Most Popular</h5>
                      <p class="callout-desc">Ideal balance for growing businesses with all essential tools.</p>
                    </div>
                  </div>
                  <div class="callout-arrow-to-standard">
                    <svg width="180" height="45" viewBox="0 0 180 45" fill="none">
                      <path d="M10,0 C10,30 120,40 165,40" stroke="#ff5a2c" stroke-dasharray="4,4" stroke-width="1.8" stroke-linecap="round" />
                      <path d="M157,34 L167,40 L157,46" stroke="#ff5a2c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                    </svg>
                  </div>
                </div>
              @endif

              {{-- Top badge --}}
              @if($isRecommended)
                <span class="plan-top-badge badge-recommended">RECOMMENDED</span>
              @elseif($isBestValue)
                <span class="plan-top-badge badge-best-value">BEST VALUE</span>
              @endif

              {{-- Icon --}}
              <div class="plan-v2-icon">
                @if($titleKey == 'basic') <i class="fas fa-paper-plane"></i>
                @elseif($titleKey == 'standard') <i class="fas fa-rocket"></i>
                @elseif($titleKey == 'premium') <i class="fas fa-crown"></i>
                @else <i class="fas fa-building"></i>
                @endif
              </div>

              {{-- Title --}}
              <h3 class="plan-v2-title">Ecom {{ __($package->title) }}</h3>
              <p class="plan-v2-subtitle">{{ $planSubtitle }}</p>

              {{-- Price --}}
              <div class="plan-v2-price-block">
                @if($package->price == 0)
                  <span class="plan-v2-amount">{{ __('Free') }}</span>
                @else
                  <span class="plan-v2-currency">{{ $be->base_currency_symbol }}</span><span class="plan-v2-amount">{{ number_format($package->price, 0) }}</span>
                  <span class="plan-v2-period"> / {{ $periodLabel }}</span>
                @endif
              </div>
              <p class="plan-v2-billing-note">
                @if(strtolower($package->term) == 'yearly')
                  Billed yearly
                @elseif(strtolower($package->term) == 'monthly')
                  Billed monthly
                @elseif(strtolower($package->term) == 'lifetime')
                  Lifetime access
                @else
                  One-time access fee
                @endif
              </p>

              <hr class="plan-v2-divider">

              {{-- Visible features --}}
              <ul class="plan-v2-features">
                @foreach($visibleFeats as $feat)
                  @php
                    $isPremiumFreeDomain = ($titleKey == 'premium' && $feat['has'] && (stripos($feat['text'], 'Free .com Domain') !== false || stripos($feat['text'], 'Free .in Domain') !== false || stripos($feat['text'], 'Free Domain') !== false));
                  @endphp
                  <li class="{{ !$feat['has'] ? 'feat-disabled' : '' }} {{ $isPremiumFreeDomain ? 'feat-free-domain-premium' : '' }}">
                    @if($isPremiumFreeDomain)
                      <i class="fas fa-globe fi-globe-premium" style="color: #10b981; font-size: 15px; flex-shrink: 0; margin-top: 2px;"></i>
                    @elseif($feat['has'])
                      <i class="fas fa-check fi-check"></i>
                    @else
                      <i class="fas fa-times fi-times"></i>
                    @endif
                    <span>{{ __(str_replace(['Free .in Domain', '.in Domain'], ['Free .com Domain', '.com Domain'], $feat['text'])) }}</span>
                  </li>
                @endforeach
              </ul>

              {{-- Extra features (collapsed) --}}
              @php $hasExtra = (count($extraFeats) > 0); @endphp
              @if($hasExtra)
                <div class="plan-v2-extra-features" id="extra-{{ strtolower($term) }}-{{ $package->id }}">
                  <ul class="plan-v2-features" style="margin-bottom:8px;">
                    @foreach($extraFeats as $ef)
                      @php
                        $isPremiumFreeDomainExtra = ($titleKey == 'premium' && $ef['has'] && (stripos($ef['text'], 'Free .com Domain') !== false || stripos($ef['text'], 'Free .in Domain') !== false || stripos($ef['text'], 'Free Domain') !== false));
                      @endphp
                      <li class="{{ !$ef['has'] ? 'feat-disabled' : '' }} {{ $isPremiumFreeDomainExtra ? 'feat-free-domain-premium' : '' }}">
                        @if($isPremiumFreeDomainExtra)
                          <i class="fas fa-globe fi-globe-premium" style="color: #10b981; font-size: 15px; flex-shrink: 0; margin-top: 2px;"></i>
                        @elseif($ef['has'])
                          <i class="fas fa-check fi-check"></i>
                        @else
                          <i class="fas fa-times fi-times"></i>
                        @endif
                        <span>{{ __(str_replace(['Free .in Domain', '.in Domain'], ['Free .com Domain', '.com Domain'], $ef['text'])) }}</span>
                      </li>
                    @endforeach
                  </ul>
                </div>
                @php
                  $modalTone = $isRecommended
                      ? 'recommended'
                      : ($isBestValue
                          ? 'best-value'
                          : (($isBasic || $index === 0) ? 'basic' : 'enterprise'));
                  $modalBadge = $modalTone === 'basic'
                      ? 'STARTER PLAN'
                      : ($modalTone === 'recommended'
                          ? 'RECOMMENDED'
                          : ($modalTone === 'best-value' ? 'BEST VALUE' : ''));
                @endphp
                <button type="button" class="plan-v2-see-more"
                        data-plan-title="Ecom {{ __($package->title) }}"
                        data-plan-price="{{ $package->price == 0 ? __('Free') : $be->base_currency_symbol . number_format($package->price, 0) . ' / ' . $periodLabel }}"
                        data-plan-href="{{ $ctaHref }}"
                        data-plan-cta="Select Ecom {{ __($package->title) }}"
                        data-plan-tone="{{ $modalTone }}"
                        data-plan-badge="{{ $modalBadge }}"
                        onclick="togglePlanFeatures('{{ strtolower($term) }}-{{ $package->id }}', this)">
                  <span class="see-more-txt d-none d-md-inline">See More Features</span>
                  <span class="see-more-mobile-label d-inline-flex d-md-none align-items-center gap-1">
                    <span>{{ $isBestValue ? 'Advanced Features' : 'More Features' }}</span>
                    <span class="plan-v2-plus-circle"><i class="fas fa-plus"></i></span>
                  </span>
                  <i class="fas fa-arrow-right see-more-icon d-none d-md-inline-block" style="font-size:11px;"></i>
                </button>
              @endif

              {{-- CTA Button with correct name --}}
              <a href="{{ $ctaHref }}" class="plan-v2-btn {{ ($isRecommended || $isBestValue) ? '' : 'btn-v2-outline' }}">
                Select Ecom {{ __($package->title) }}
              </a>

            </div><!-- /.pricing-card-v2 -->
          @endforeach

          @php
            $customSetting = \App\Models\CustomPackageSetting::getSettings();
            $showEnterprise = ($customSetting->enterprise_status ?? 1) == 1;
          @endphp
          @if($showEnterprise)
          {{-- Enterprise card --}}
            <div class="pricing-card-v2 card-enterprise package-enterprise">
              <!-- Enterprise Callout Box (Most Chosen) -->
              <div class="enterprise-callout-box d-none d-lg-block">
                <div class="d-flex align-items-start gap-2">
                  <div class="callout-icon-wrap star" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; color:#fff;">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="callout-text">
                    <h5 class="callout-title">Most People Choose</h5>
                    <p class="callout-desc">Best value with all premium features and a free domain.</p>
                  </div>
                </div>
                <div class="callout-arrow-left">
                  <svg width="120" height="48" viewBox="0 0 120 48" fill="none">
                    <path d="M110,0 C110,32 50,42 15,42" stroke="#f59e0b" stroke-dasharray="4,4" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M23,36 L13,42 L23,48" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                  </svg>
                </div>
              </div>
              <div class="plan-v2-icon" style="color:#ff5a2c;"><i class="fas fa-building"></i></div>
              <h3 class="plan-v2-title">Enterprise</h3>
              <p class="plan-v2-subtitle">Kickstart Your E-commerce Business.</p>
              <div class="plan-v2-price-block">
                <span class="plan-v2-amount" style="font-size:34px;color:#0f172a;">Custom</span>
              </div>
              <p class="plan-v2-billing-note">Tailored to your needs</p>
              <hr class="plan-v2-divider">
              <ul class="plan-v2-features">
                <li><i class="fas fa-globe fi-check" style="color: #10b981;"></i><span style="color: #10b981; font-weight: 700;">Free .com Domain Every Year</span></li>
                <li><i class="fas fa-check fi-check"></i><span>Everything in Premium</span></li>
                <li><i class="fas fa-check fi-check"></i><span>Unlimited Staff Accounts</span></li>
                <li><i class="fas fa-check fi-check"></i><span>Dedicated Account Manager</span></li>
                <li><i class="fas fa-check fi-check"></i><span>Custom Integrations</span></li>
                <li><i class="fas fa-check fi-check"></i><span>SLA &amp; Uptime Guarantee</span></li>
                <li><i class="fas fa-check fi-check"></i><span>Priority 24/7 Support</span></li>
              </ul>
              <div style="display:flex;gap:8px;margin-top:auto;width:100%;">
                <a href="{{ Route::has('front.contact') ? route('front.contact') : url('/') }}" class="plan-v2-btn" style="flex:1;margin-top:0;">Talk to Sales</a>
                <a href="https://wa.me/917200770351?text=Hi%2C%20I%20want%20to%20enquire%20about%20the%20Enterprise%20Plan%20for%20LaunchShop." target="_blank" class="plan-v2-wa-btn">
                  <i class="fab fa-whatsapp"></i>
                </a>
              </div>
            </div>
          @endif

        </div><!-- /.pricing-cards-row -->

        <!-- Trust row -->
        <div class="pricing-v2-trust ">
          <div class="pricing-v2-trust-item">
            <span class="trust-icon green"><i class="fas fa-shield-alt"></i></span>
            <span><strong>10-Days Money Back Guarantee</strong><br><small>Risk-free, no questions asked</small></span>
          </div>
          <div class="pricing-v2-trust-item">
            <span class="trust-icon orange"><i class="fas fa-times"></i></span>
            <span><strong>Cancel Anytime</strong><br><small>No lock-in contracts</small></span>
          </div>
          <div class="pricing-v2-trust-item">
            <span class="trust-icon purple"><i class="fas fa-lock"></i></span>
            <span><strong>Secure Checkout</strong><br><small>Your data is 100% safe</small></span>
          </div>
        </div>

      </div>
    @endforeach
  </div>

</div>

@once
  <div class="plan-feats-mobile-overlay" id="planFeatsMobileOverlay" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="planFeatsModalTitle">
    <div class="plan-feats-mobile-backdrop" onclick="closeMobilePlanFeaturesModal()"></div>
    <div class="plan-feats-mobile-box">
      <span id="planFeatsModalBadge" class="plan-feats-mobile-badge"></span>
      <button type="button" class="plan-feats-mobile-close" onclick="closeMobilePlanFeaturesModal()" aria-label="Close features popup">
        <i class="fas fa-times"></i>
      </button>
      <div class="plan-feats-mobile-header">
        <h4 id="planFeatsModalTitle" class="plan-feats-mobile-title"></h4>
        <div id="planFeatsModalPrice" class="plan-feats-mobile-price"></div>
      </div>
      <div class="plan-feats-mobile-subtitle">More Features Included</div>
      <ul id="planFeatsModalList" class="plan-v2-features plan-feats-mobile-list"></ul>
      <a href="#" id="planFeatsModalCta" class="plan-v2-btn plan-feats-mobile-cta"></a>
    </div>
  </div>

  <script>
    function openMobilePlanFeaturesModal(pkgId, btn) {
      var overlay = document.getElementById('planFeatsMobileOverlay');
      var extraWrap = document.getElementById('extra-' + pkgId);
      if (!overlay || !extraWrap) return false;

      var titleEl = document.getElementById('planFeatsModalTitle');
      var priceEl = document.getElementById('planFeatsModalPrice');
      var listEl  = document.getElementById('planFeatsModalList');
      var ctaEl   = document.getElementById('planFeatsModalCta');

      const boxEl = overlay.querySelector('.plan-feats-mobile-box');
      const badgeEl = document.getElementById('planFeatsModalBadge');
      const cardEl = btn ? btn.closest('.pricing-card-v2') : null;
      const planTone = (btn && btn.getAttribute('data-plan-tone'))
        || (cardEl && cardEl.classList.contains('card-recommended') ? 'recommended'
          : (cardEl && cardEl.classList.contains('card-best-value') ? 'best-value'
            : (cardEl && cardEl.classList.contains('card-basic') ? 'basic' : 'enterprise')));
      const planBadgeAttr = btn ? btn.getAttribute('data-plan-badge') : null;
      const cardBadge = cardEl ? cardEl.querySelector('.plan-top-badge') : null;
      const badgeText = planBadgeAttr !== null
        ? planBadgeAttr.trim()
        : (planTone === 'recommended'
            ? (cardBadge ? cardBadge.textContent.trim() : 'RECOMMENDED')
            : (planTone === 'best-value'
                ? (cardBadge ? cardBadge.textContent.trim() : 'BEST VALUE')
                : (planTone === 'basic' ? 'STARTER PLAN' : '')));

      if (boxEl && badgeEl) {
        boxEl.classList.remove('tone-recommended', 'tone-best-value', 'tone-basic', 'tone-enterprise');
        badgeEl.classList.remove('badge-recommended', 'badge-best-value', 'badge-basic');
        boxEl.classList.add('tone-' + planTone);

        if (badgeText) {
          badgeEl.style.display = 'inline-flex';
          badgeEl.classList.add('badge-' + planTone);
          badgeEl.textContent = badgeText;
        } else {
          badgeEl.style.display = 'none';
          badgeEl.textContent = '';
        }
      }

      titleEl.textContent = btn.getAttribute('data-plan-title') || '';
      const rawPrice = (btn.getAttribute('data-plan-price') || '').trim();
      const priceParts = rawPrice.split(/\s*\/\s*/);
      if (priceParts.length >= 2) {
        priceEl.innerHTML = '';
        const amtSpan = document.createElement('span');
        amtSpan.className = 'plan-feats-mobile-amount';
        amtSpan.textContent = priceParts[0];
        const perSpan = document.createElement('span');
        perSpan.className = 'plan-feats-mobile-period';
        perSpan.textContent = '/ ' + priceParts.slice(1).join(' / ');
        priceEl.appendChild(amtSpan);
        priceEl.appendChild(perSpan);
      } else {
        priceEl.textContent = rawPrice;
      }
      ctaEl.className = 'plan-v2-btn plan-feats-mobile-cta' + ((planTone === 'basic' || planTone === 'enterprise') ? ' btn-v2-outline' : '');
      ctaEl.textContent   = btn.getAttribute('data-plan-cta') || 'Select Plan';
      ctaEl.setAttribute('href', btn.getAttribute('data-plan-href') || '#');

      var extraUl = extraWrap.querySelector('ul.plan-v2-features');
      listEl.innerHTML = extraUl ? extraUl.innerHTML : '';

      overlay.classList.add('open');
      overlay.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      return true;
    }

    function closeMobilePlanFeaturesModal() {
      var overlay = document.getElementById('planFeatsMobileOverlay');
      if (!overlay) return;
      overlay.classList.remove('open');
      overlay.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeMobilePlanFeaturesModal();
      }
    });
  </script>
@endonce
