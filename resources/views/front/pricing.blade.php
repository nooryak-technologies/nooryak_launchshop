@extends('front.layout')

@section('pagename')
  - {{ $pageHeading ?? __('Pricing') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->pricing_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->pricing_meta_keywords : '')

@section('styles')
  @include('front.partials.pricing_styles')
@endsection


@section('content')
@php
  $selectedTemplate = request()->query('template');
  if (\Schema::hasTable('package_features')) {
      $allFeatures = \App\Models\PackageFeature::whereNotIn('name', ['Disqus', 'Bank Transfer Integrations', 'Facebook Pixel'])
          ->whereNotIn('keyword', ['Disqus', 'Bank Transfer Integrations', 'Facebook Pixel'])
          ->orderBy('serial_number', 'asc')
          ->get();
  } else {
      $allFeatures = collect();
  }
@endphp

  <!-- Modern Pricing Page wrapper -->
  <div class="modern-pricing-page-wrapper pt-40 pb-120">
    <div class="container">

      <!-- Hero Header Section – centered to match reference -->
      <div class="pricing-hero-center" data-aos="fade-up">
        <div class="pricing-eyebrow-badge">SIMPLE, TRANSPARENT PRICING</div>
        <h1>Choose the <strong>perfect plan</strong> for your business</h1>
        <p class="subtitle font-weight-medium">Launch your store in minutes and scale as your business grows.</p>
      </div>

      @include('front.partials.pricing_cards')

      <!-- Explore Store Designs Banner -->
      <div class="text-center mt-5 mb-5" data-aos="fade-up">
        <div style="display:inline-block; background:linear-gradient(135deg,#fff5f2 0%,#fff9f7 100%); border:2px solid #ff5a2c; border-radius:14px; padding:20px 36px; max-width:560px; box-shadow:0 4px 20px rgba(255,90,44,0.10);">
          <p style="font-size:15px; font-weight:600; color:#4a5568; margin-bottom:10px;">
            {{ __('Looking for a specific store style?') }}
          </p>
          <a href="{{ route('front.templates.view') }}" style="display:inline-flex; align-items:center; gap:8px; background:#ff5a2c; color:#fff; font-size:16px; font-weight:700; padding:12px 28px; border-radius:10px; text-decoration:none; transition:all 0.2s ease; box-shadow:0 4px 14px rgba(255,90,44,0.25);" onmouseover="this.style.background='#e04d24';this.style.boxShadow='0 6px 20px rgba(255,90,44,0.35)';" onmouseout="this.style.background='#ff5a2c';this.style.boxShadow='0 4px 14px rgba(255,90,44,0.25)';">
            <i class="fas fa-palette"></i> {{ __('Explore Store Themes') }} <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>



      <!-- Detailed compare plans section -->
      @php
        // Task 2: Show ALL plans – Basic (monthly) + Standard (yearly) + Premium (yearly)
        $comparePackages = collect();
        $basicPkg = \App\Models\Package::where('status','1')->where('title','Basic')->orderBy('price','asc')->first();
        if ($basicPkg) $comparePackages->push($basicPkg);
        $stdPkg = \App\Models\Package::where('status','1')->where('title','Standard')->where('term','yearly')->first();
        if (!$stdPkg) $stdPkg = \App\Models\Package::where('status','1')->where('title','Standard')->first();
        if ($stdPkg) $comparePackages->push($stdPkg);
        $premPkg = \App\Models\Package::where('status','1')->where('title','Premium')->where('term','yearly')->first();
        if (!$premPkg) $premPkg = \App\Models\Package::where('status','1')->where('title','Premium')->first();
        if ($premPkg) $comparePackages->push($premPkg);

        // Build comparison rows
        $compareRows = [];

        if ($allFeatures->isEmpty()) {
            $compareRows[] = [
                'type' => 'limit',
                'label' => 'Products Limit',
                'key' => 'product_limit',
                'ent_val' => 'Unlimited'
            ];
            $compareRows[] = [
                'type' => 'limit',
                'label' => 'Categories Limit',
                'key' => 'categories_limit',
                'ent_val' => 'Unlimited'
            ];
            $compareRows[] = [
                'type' => 'limit',
                'label' => 'Orders Limit',
                'key' => 'order_limit',
                'ent_val' => 'Unlimited'
            ];
            $compareRows[] = [
                'type' => 'limit',
                'label' => 'Additional Languages',
                'key' => 'language_limit',
                'ent_val' => 'Unlimited'
            ];
            $compareRows[] = [
                'type' => 'limit',
                'label' => 'Posts Limit',
                'key' => 'post_limit',
                'ent_val' => 'Unlimited'
            ];
            $compareRows[] = [
                'type' => 'limit',
                'label' => 'Custom Pages Limit',
                'key' => 'number_of_custom_page',
                'ent_val' => 'Unlimited'
            ];
            foreach ($allPfeatures as $f) {
                if ($f !== 'Posts Limit') {
                    $compareRows[] = [
                        'type' => 'flag',
                        'label' => $f,
                        'keyword' => $f,
                        'ent_val' => true
                    ];
                }
            }
        } else {
            foreach ($allFeatures as $feature) {
                if ($feature->type === 'limit') {
                    $compareRows[] = [
                        'type' => 'limit',
                        'label' => str_replace('{limit} ', '', $feature->name),
                        'key' => $feature->limit_key,
                        'ent_val' => 'Unlimited'
                    ];
                } else {
                    $compareRows[] = [
                        'type' => 'flag',
                        'label' => $feature->name,
                        'keyword' => $feature->keyword ?: $feature->name,
                        'ent_val' => true
                    ];
                }
            }
        }

        // Show first 6 rows initially, hide the rest
        $visibleCompareCount = 6;
        $visibleCompareRows = array_slice($compareRows, 0, $visibleCompareCount);
        $hiddenCompareRows = array_slice($compareRows, $visibleCompareCount);
      @endphp

      <div class="compare-features-section mt-100" data-aos="fade-up">
        <h2 class="section-title text-center mb-5">Compare Plan Features</h2>
        
        <div class="table-responsive">
          <table class="table compare-table">
            <thead>
              <tr>
                <th style="width: 35%;">Features</th>
                @foreach ($comparePackages as $pkg)
                  <th style="text-align: center;" class="{{ strtolower($pkg->title) == 'standard' ? 'highlight-column-header' : '' }}">
                    @if (strtolower($pkg->title) == 'standard')
                      <div class="highlight-wrapper">
                        <i class="fas fa-star text-orange me-1"></i> {{ __($pkg->title) }}
                      </div>
                    @else
                      {{ __($pkg->title) }}
                    @endif
                    <div style="font-size:11px;font-weight:600;color:#94a3b8;">{{ strtolower($pkg->term) == 'monthly' ? 'Monthly' : 'Yearly' }}</div>
                  </th>
                @endforeach
                <th style="text-align:center;">Enterprise</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($visibleCompareRows as $row)
                <tr>
                  <td>{{ __($row['label']) }}</td>
                  @foreach ($comparePackages as $pkg)
                    <td class="text-center {{ strtolower($pkg->title) == 'standard' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                      @if ($row['type'] == 'limit')
                        @php $val = $pkg->{$row['key']}; @endphp
                        {{ $val == 999999 ? __('Unlimited') : ($val ?: '0') }}
                      @else
                        @php
                          $pkgFeats = json_decode($pkg->features, true) ?: [];
                          $hasFeat = in_array($row['keyword'], $pkgFeats);
                        @endphp
                        @if ($hasFeat)
                          <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                        @else
                          <span class="feat-check-circle times"><i class="fas fa-times"></i></span>
                        @endif
                      @endif
                    </td>
                  @endforeach
                  {{-- Enterprise column: always ✓ for flag rows, Unlimited for limit rows --}}
                  <td class="text-center">
                    @if($row['type'] == 'limit')
                      Unlimited
                    @else
                      <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
            
            @if (count($hiddenCompareRows) > 0)
              <tbody id="compare-features-hidden-rows" class="compare-rows-hidden">
                  @foreach ($hiddenCompareRows as $row)
                  <tr>
                    <td>{{ __($row['label']) }}</td>
                    @foreach ($comparePackages as $pkg)
                      <td class="text-center {{ strtolower($pkg->title) == 'standard' ? 'highlight-column font-weight-bold text-dark' : '' }}">
                        @if ($row['type'] == 'limit')
                          @php $val = $pkg->{$row['key']}; @endphp
                          {{ $val == 999999 ? __('Unlimited') : ($val ?: '0') }}
                        @else
                          @php
                            $pkgFeats = json_decode($pkg->features, true) ?: [];
                            $hasFeat = in_array($row['keyword'], $pkgFeats);
                          @endphp
                          @if ($hasFeat)
                            <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                          @else
                            <span class="feat-check-circle times"><i class="fas fa-times"></i></span>
                          @endif
                        @endif
                      </td>
                    @endforeach
                    {{-- Enterprise column --}}
                    <td class="text-center">
                      @if($row['type'] == 'limit')
                        Unlimited
                      @else
                        <span class="feat-check-circle"><i class="fas fa-check"></i></span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            @endif
          </table>
        </div>

        @if (count($hiddenCompareRows) > 0)
          <div class="text-center mt-4">
            <button class="btn btn-orange-outline px-4 py-2" type="button" id="btn-toggle-compare-rows" style="font-size:16px; font-weight:700; padding:14px 32px !important; border-radius:10px;">
              View More Features <i class="fas fa-chevron-down ms-2"></i>
            </button>
          </div>
        @endif
      </div>

      @if (count($faqs) > 0)
        <!-- FAQ Section collapse grid -->
        <div class="pricing-faq-section " data-aos="fade-up">
          <h2 class="section-title text-center mb-50">Frequently Asked Questions</h2>
          
          <div class="row">
            <!-- Left Column accordion -->
            <div class="col-md-6 mb-4 mb-md-0">
              <div class="accordion" id="faqAccordionLeft">
                @foreach ($faqs as $index => $faq)
                  @if ($index % 2 == 0)
                    <div class="accordion-item faq-item">
                      <h3 class="accordion-header" id="faqHL{{ $faq->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCL{{ $faq->id }}" aria-expanded="false" aria-controls="faqCL{{ $faq->id }}">
                          {{ $faq->question }}
                        </button>
                      </h3>
                      <div id="faqCL{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="faqHL{{ $faq->id }}" data-bs-parent="#faqAccordionLeft">
                        <div class="accordion-body">
                          {{ $faq->answer }}
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
            
            <!-- Right Column accordion -->
            <div class="col-md-6">
              <div class="accordion" id="faqAccordionRight">
                @foreach ($faqs as $index => $faq)
                  @if ($index % 2 != 0)
                    <div class="accordion-item faq-item">
                      <h3 class="accordion-header" id="faqHR{{ $faq->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCR{{ $faq->id }}" aria-expanded="false" aria-controls="faqCR{{ $faq->id }}">
                          {{ $faq->question }}
                        </button>
                      </h3>
                      <div id="faqCR{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="faqHR{{ $faq->id }}" data-bs-parent="#faqAccordionRight">
                        <div class="accordion-body">
                          {{ $faq->answer }}
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endif

      <!-- Bottom final CTA conversion card -->
      <div class="pricing-footer-cta-card " data-aos="fade-up">
        <div class="row align-items-center">
          <div class="col-lg-7 d-flex align-items-center  mb-lg-0">
            <div class="cta-store-icon me-4 d-none d-sm-block">
              <div class="roof-span"></div>
              <div class="window-span"></div>
            </div>
            <div class="cta-text">
              <h3>Ready to Launch Your Store?</h3>
              <p>Join thousands of successful entrepreneurs. 10-Days Money Back Guarantee — no credit card required.</p>
            </div>
          </div>
          <div class="col-lg-5 text-lg-end">
            <div class="cta-buttons-wrapper d-flex justify-content-lg-end justify-content-center">
              <div class="cta-btn-block">
                <a href="{{ route('front.templates.view') }}" class="btn-pricing-action btn-white-outline px-4">
                  Browse Themes
                </a>
                <span class="btn-subtext">Find your perfect look</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('scripts')
<script>
  // ── New V2: See More Features toggle per card ──
  function togglePlanFeatures(pkgId, btn) {
    var $extra = document.getElementById('extra-' + pkgId);
    var $txt   = btn.querySelector('.see-more-txt');
    var $icon  = btn.querySelector('.see-more-icon');
    if (!$extra) return;
    if ($extra.classList.contains('open')) {
      $extra.classList.remove('open');
      $txt.textContent  = 'See More Features';
      $icon.className   = 'fas fa-arrow-right see-more-icon';
      $icon.style.fontSize = '11px';
    } else {
      $extra.classList.add('open');
      $txt.textContent  = 'See Less Features';
      $icon.className   = 'fas fa-arrow-up see-more-icon';
      $icon.style.fontSize = '11px';
    }
  }

  $(document).ready(function() {

    // ── Compare table "View More Features" button ──
    var $tbody     = $('#compare-features-hidden-rows');
    var $toggleBtn = $('#btn-toggle-compare-rows');

    if ($tbody.length && $toggleBtn.length) {
      $tbody.hide();
      $toggleBtn.on('click', function(e) {
        e.preventDefault();
        if ($tbody.is(':visible')) {
          $tbody.find('tr').fadeOut(200);
          setTimeout(function() {
            $tbody.hide();
            $tbody.find('tr').css('display', '');
          }, 220);
          $toggleBtn.html('View More Features <i class="fas fa-chevron-down ms-2"></i>');
        } else {
          $tbody.css('display', 'table-row-group');
          $tbody.find('tr').hide().each(function(i, row) {
            $(row).delay(i * 35).fadeIn(280);
          });
          $toggleBtn.html('Show Less Features <i class="fas fa-chevron-up ms-2"></i>');
        }
      });
    }

  });
</script>
@endsection
