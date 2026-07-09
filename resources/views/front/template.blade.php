@extends('front.layout')

@section('pagename')
  - {{ $pageHeading ?? __('Templates') }}
@endsection
@php
  $additional_section_status = json_decode($bs->additional_section_status, true);
@endphp
@section('meta-description', !empty($seo) ? $seo->home_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->home_meta_keywords : '')

@section('styles')
<style>
  /* Disable the default page breadcrumb area */
  .page-title-area {
      display: none !important;
  }
  /* Give longer thumbnail preview */
  .card-image-wrap {
      height: 380px !important;
  }
  .template-card-modern:hover .scrolling-img {
      transform: translateY(calc(-100% + 380px)) !important;
  }
  .btn-template-action.admin-btn {
      background: #0e1b3d;
      color: #ffffff;
      border: 1px solid #0e1b3d;
  }
  .btn-template-action.admin-btn:hover {
      background: #1e293b;
      border-color: #1e293b;
      color: #ffffff;
  }
</style>
@endsection

@section('content')
  <!-- Modern Templates Page Wrapper -->
  <div class="modern-templates-page-wrapper pt-40 pb-120">
    <div class="container">
      
      <!-- Hero Header Section -->
      <div class="row align-items-center mb-60 mt-30 templates-hero-row">
        <div class="col-lg-7 mx-auto text-center">
          <div class="templates-hero-content" data-aos="fade-up">
            <span class="templates-hero-badge">{{ __('PREMIUM STORE DESIGNS') }}</span>
            <h1 class="templates-hero-title">
              Launch Your Dream Store <br><span>in Minutes</span>
            </h1>
            <p class="templates-hero-desc">
              Choose from our e-commerce templates built for speed, responsiveness, and conversions. Select a template and pick a plan to checkout and start selling.
            </p>
          </div>
        </div>
      </div>

      <!-- Search & Category Filter Section -->
      <div class="templates-filter-section mb-50" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 align-items-center">
          <div class="col-lg-4">
            <div class="search-box-custom">
              <i class="fas fa-search search-icon"></i>
              <input type="text" id="templateSearch" class="form-control" placeholder="Search templates by name...">
            </div>
          </div>
          <div class="col-lg-8">
            <div class="templates-tabs-wrapper">
              <button type="button" class="tab-btn active" data-filter="all">{{ __('All Templates') }}</button>
              <button type="button" class="tab-btn" data-filter="fashion">{{ __('Fashion') }}</button>
              <button type="button" class="tab-btn" data-filter="clothing">{{ __('Clothing') }}</button>
              <button type="button" class="tab-btn" data-filter="grocery">{{ __('Grocery') }}</button>
              <button type="button" class="tab-btn" data-filter="electronics">{{ __('Electronics') }}</button>
              <button type="button" class="tab-btn" data-filter="beauty">{{ __('Beauty') }}</button>
              <button type="button" class="tab-btn" data-filter="multipurpose">{{ __('Multipurpose') }}</button>
              <button type="button" class="tab-btn" data-filter="others">{{ __('Others') }}</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Templates Grid Section -->
      <div class="templates-grid-wrapper">
        <div class="row g-4 justify-content-start" id="templatesGrid">
          @foreach ($templates as $template)
            @php
              $themeName = App\Models\User\BasicSetting::where('user_id', $template->id)->pluck('theme')->first();
              $category = 'others';
              $displayName = __('Theme');
              $badgeClass = 'bg-secondary';
              
              if ($themeName == 'vegetables' || $themeName == 'grocery') {
                  $category = 'grocery';
                  $displayName = __('Grocery & Supermarket');
                  $badgeClass = 'badge-grocery';
              } elseif ($themeName == 'manti' || $themeName == 'multipurpose') {
                  $category = 'multipurpose';
                  $displayName = __('Multipurpose');
                  $badgeClass = 'badge-multi';
              } elseif ($themeName == 'fashion' || $themeName == 'apparel' || $themeName == 'jewellery' || $themeName == 'kids' || $themeName == 'clothing') {
                  $category = ($themeName == 'clothing') ? 'clothing' : 'fashion';
                  $displayName = match($themeName) {
                      'jewellery' => __('Jewellery & Accessories'),
                      'kids' => __('Kids Fashion'),
                      'clothing' => __('Clothing & Apparel'),
                      default => __('Fashion & Apparel'),
                  };
                  $badgeClass = 'badge-fashion';
              } elseif ($themeName == 'electronics' || $themeName == 'gadgets') {
                  $category = 'electronics';
                  $displayName = __('Electronics & Gadgets');
                  $badgeClass = 'badge-electronics';
              } elseif ($themeName == 'beauty' || $themeName == 'cosmetics' || $themeName == 'skinflow') {
                  $category = 'beauty';
                  $displayName = match($themeName) {
                      'skinflow' => __('Skin & Beauty Care'),
                      default => __('Beauty & Cosmetics'),
                  };
                  $badgeClass = 'badge-beauty';
              } else {
                  $category = 'others';
                  $displayName = ucfirst($themeName ?? 'Default');
                  $badgeClass = 'badge-others';
              }
              
              $previewUrl = detailsUrl($template);
              $purchaseUrl = route('front.pricing') . '?template=' . urlencode($template->username);
            @endphp
            
            <div class="col-lg-4 col-md-6 template-card-item" data-category="{{ $category }}" data-search="{{ strtolower(trim($displayName . ' ' . ($template->shop_name ?? '') . ' ' . $template->username . ' ' . ($themeName ?? '') . ' ' . $category)) }}">
              <div class="template-card-modern">
                <!-- Image Wrapper with scroll hover effect -->
                <div class="card-image-wrap">
                  <span class="category-badge {{ $badgeClass }}">{{ $displayName }}</span>
                  <a href="{{ $previewUrl }}" target="_blank" class="image-viewport">
                    @if (!empty($template->template_img))
                      <img class="lazyload scrolling-img" src="{{ asset('assets/front/images/placeholder.png') }}"
                        data-src="{{ asset('assets/front/img/template-previews/' . $template->template_img) }}"
                        alt="{{ $displayName }} Theme" />
                    @else
                      <img class="lazyload scrolling-img" src="{{ asset('assets/front/images/placeholder.png') }}"
                        data-src="{{ asset('assets/front/img/template-previews/placeholder.png') }}"
                        alt="Placeholder Theme" />
                    @endif
                  </a>
                </div>
                
                <!-- Card Body -->
                <div class="card-body-wrap">
                  <h3 class="card-theme-title">{{ $displayName }} {{ __('Theme') }}</h3>
                  
                  <hr class="card-divider">
                  
                  <div class="card-action-row">
                    <a href="{{ $previewUrl }}" target="_blank" class="btn-template-action outline-btn">
                      <i class="fas fa-eye me-2"></i> {{ __('Live Preview') }}
                    </a>
                    <a href="{{ route('front.templates.autologin', $template->username) }}" target="_blank" class="btn-template-action admin-btn">
                      <i class="fas fa-user-cog me-2"></i> {{ __('Admin') }}
                    </a>
                    <a href="{{ $purchaseUrl }}" class="btn-template-action primary-btn">
                      <i class="fas fa-shopping-cart me-2"></i> {{ __('Purchase') }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
          @endforeach

          <!-- Custom Banner (Shown at bottom after all templates) -->
          <div class="col-12 templates-mid-banner-col my-4">
            <div class="templates-mid-banner">
              <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0 text-start">
                  <div class="banner-content">
                    <span class="banner-badge">{{ __('Tailored For You') }}</span>
                    <h3>{{ __('Need a Bespoke E-commerce Design?') }}</h3>
                    <p>{{ __('Can\'t find the perfect match? Our in-house design experts can build a fully custom storefront template tailored specifically to your brand\'s unique requirements.') }}</p>
                  </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                  <a href="{{ route('front.contact') }}" class="btn-banner-action">
                    <i class="fas fa-comment-alt-lines me-2"></i> {{ __('Talk to Our Designers') }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Filter Empty State -->
        <div id="noTemplatesMessage" class="text-center py-5 d-none">
          <i class="fal fa-store-slash text-muted" style="font-size: 64px; margin-bottom: 20px;"></i>
          <h3>No matching templates found</h3>
          <p class="text-muted">Try choosing another category or clearing your search filter.</p>
        </div>
      </div>
      
      <!-- How it Works section -->
      <div class="template-how-it-works-section mt-100" data-aos="fade-up">
        <h2 class="section-title text-center">{{ __('How It Works') }}</h2>
        <p class="section-subtitle text-center mb-5">{{ __('Get your professional e-commerce storefront live in three simple steps.') }}</p>
        
        <div class="row g-4">
          <div class="col-md-4">
            <div class="how-works-card">
              <div class="step-number">1</div>
              <h4>Choose a Design</h4>
              <p>Explore our optimized templates, view live previews, and pick the perfect layout for your business.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="how-works-card">
              <div class="step-number">2</div>
              <h4>Select Your Plan</h4>
              <p>Pick a plan matching your size and features. Get a 14-day free trial on our premium plans.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="how-works-card">
              <div class="step-number">3</div>
              <h4>Customize & Launch</h4>
              <p>Configure payments, upload products, link your domain, and start selling globally.</p>
            </div>
          </div>
        </div>
      </div>

      @if (count($faqs) > 0)
        <!-- FAQ Section -->
        <div class="template-faq-section mt-20 mb-20" data-aos="fade-up">
          <h2 class="section-title text-center">{{ __('Frequently Asked Questions') }}</h2>
          <p class="section-subtitle text-center mb-5">{{ __('Everything you need to know about our e-commerce store templates.') }}</p>
          
          <div class="faq-accordion-custom">
            @foreach ($faqs as $faq)
              <!-- FAQ Item -->
              <div class="faq-item-custom">
                <div class="faq-question-custom">
                  <span>{{ $faq->question }}</span>
                  <i class="fas fa-chevron-down faq-arrow"></i>
                </div>
                <div class="faq-answer-custom">
                  <p>{{ $faq->answer }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

    </div>
  </div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
      var activeFilter = 'all';
      var searchQuery = '';

      function filterTemplates() {
          var showCount = 0;
          var searchTerms = searchQuery.split(/\s+/).filter(Boolean);

          $('.template-card-item').each(function() {
              var category = $(this).attr('data-category');
              var searchText = $(this).attr('data-search') ? $(this).attr('data-search').toLowerCase() : '';
              var matchCategory = (activeFilter === 'all' || category === activeFilter);
              
              var matchSearch = true;
              for (var i = 0; i < searchTerms.length; i++) {
                  if (searchText.indexOf(searchTerms[i]) === -1) {
                      matchSearch = false;
                      break;
                  }
              }

              if (matchCategory && matchSearch) {
                  $(this).removeClass('d-none');
                  showCount++;
              } else {
                  $(this).addClass('d-none');
              }
          });

          if (showCount === 0) {
              $('#noTemplatesMessage').removeClass('d-none');
          } else {
              $('#noTemplatesMessage').addClass('d-none');
          }

            if (typeof AOS !== 'undefined' && AOS.refreshHard) {
              AOS.refreshHard();
            } else if (typeof AOS !== 'undefined' && AOS.refresh) {
              AOS.refresh();
            }
      }

      // Handle search keyup
        $('#templateSearch').on('input', function() {
          searchQuery = $.trim($(this).val()).toLowerCase();
          
          // Automatically switch to 'all' tab when user starts searching
          if (searchQuery !== '') {
              $('.tab-btn').removeClass('active');
              $('.tab-btn[data-filter="all"]').addClass('active');
              activeFilter = 'all';
          }
          
          filterTemplates();
      });

      // Handle category tab clicks
      $('.tab-btn').on('click', function() {
          $('.tab-btn').removeClass('active');
          $(this).addClass('active');
          activeFilter = $(this).data('filter');
          searchQuery = '';
          $('#templateSearch').val('');
          filterTemplates();
      });

      // Handle FAQ accordion click
      $('.faq-question-custom').on('click', function() {
          var $item = $(this).closest('.faq-item-custom');
          var $answer = $item.find('.faq-answer-custom');
          
          if ($item.hasClass('active')) {
              $answer.slideUp(250, function() {
                  $item.removeClass('active');
              });
          } else {
              // Close other open items
              $('.faq-item-custom.active').each(function() {
                  $(this).removeClass('active').find('.faq-answer-custom').slideUp(250);
              });
              
              $item.addClass('active');
              $answer.slideDown(250);
          }
      });
  });
</script>
@endsection
