    <!-- Product List Start -->
    <section class="products pb-100 lazy">
      <div class="container">
        <div class="row gx-xl-4">
          <div class="col-xl-7">
            <div class="section-title title-inline title-bottom-line mb-10">
              <h2 class="title title-sm mb-0">
                {{ $userSec->top_rated_product_section_title ?? ($keywords['Top Rated'] ?? __('Top Rated')) }}
              </h2>
              <div class="slider-arrow-inline style-3" id="product-list-slider-skeleton-1-arrows">
              </div>
            </div>
            <div class="product-list mb-30">
              <div class="product-list-slider" id="product-list-slider-skeleton" data-slick='{"slidesToShow": 2}'>
                @for ($skeleton = 0; $skeleton <= 3; $skeleton++)
                  <div>
                    <div class="product-default product-inline product-inline-2 mt-20">
                      <figure class="product-img radius-md skeleton skeleton-img"></figure>
                      <div class="product-details">
                        <div class="skeleton skeleton-category"></div>
                        <h4 class="skeleton skeleton-title"></h4>
                        <div class="skeleton skeleton-ratings"></div>
                        <div class="product-price mt-1 mb-10">
                          <span class="new-price skeleton skeleton-price"></span>
                          <span class="old-price line_through skeleton skeleton-price"></span>
                        </div>
                        <div class="d-flex">
                          <span class="skeleton skeleton-btn-icon"></span>
                          <span class="skeleton skeleton-btn-icon"></span>
                          <span class="skeleton skeleton-btn-icon"></span>
                          <span class="skeleton skeleton-btn-icon"></span>
                        </div>
                      </div>
                    </div>
                    <div class="product-default product-inline product-inline-2 mt-20">
                      <figure class="product-img radius-md skeleton skeleton-img"></figure>
                      <div class="product-details">
                        <div class="skeleton skeleton-category"></div>
                        <h4 class="skeleton skeleton-title"></h4>
                        <div class="skeleton skeleton-ratings"></div>
                        <div class="product-price mt-1 mb-10">
                          <span class="new-price skeleton skeleton-price"></span>
                          <span class="old-price line_through skeleton skeleton-price"></span>
                        </div>
                        <div class="d-flex">
                          <span class="skeleton skeleton-btn-icon"></span>
                          <span class="skeleton skeleton-btn-icon"></span>
                          <span class="skeleton skeleton-btn-icon"></span>
                          <span class="skeleton skeleton-btn-icon"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endfor
              </div>
            </div>
          </div>
          @if ($ubs->right_banner_section == 1)
            @if ($banners)
              @for ($i = 0; $i <= 1; $i++)
                @if (isset($banners[$i]))
                  @if ($banners[$i]->position == 'right')
                    <div class="col-xl-5 col-lg-6">
                      <div class="banner-sm banner-sm-style-4 banner-vertical content-top pb-30 ratio radius-md">
                        <img class="lazyload bg-img blur-up " src="{{ asset('assets/front/images/placeholder.png') }}"
                          data-src="{{ asset('assets/front/img/user/banners/' . $banners[$i]->banner_img) }}"
                          alt="">
                        <div class="banner-content">
                          <div class="content-inner">
                            <span class="sub-title color-primary fw-bolder">{{ $banners[$i]->title }}</span>
                            <h2 class="title-md mb-1">{{ $banners[$i]->subtitle }}</h2>
                            <p>{{ $banners[$i]->text }}</p>
                            <a href="{{ $banners[$i]->banner_url }}"
                              class="btn btn-md btn-primary radius-sm">{{ $banners[$i]->button_text }}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                @endif
              @endfor
            @endif
          @endif
        </div>
      </div>
    </section>
    <!-- Product List End -->


    <!-- Product List Start -->
    <section class="products pb-100 actual-content">
      <div class="container">
        <div class="row gx-xl-4">
          <div class="col-xl-7">
            <div class="section-title title-inline title-bottom-line mb-10">
              <h2 class="title title-sm mb-0">
                {{ $userSec->top_rated_product_section_title ?? ($keywords['Top Rated'] ?? __('Top Rated')) }}
              </h2>
              <div class="slider-arrow-inline style-3" id="product-list-slider-1-arrows">
              </div>
            </div>
            <div class="product-list mb-30">
              @if (count($top_rated) == 0)
                <h5 class="title mb-20">
                  {{ $keywords['NO PRODUCTS FOUND'] ?? __('NO PRODUCTS FOUND') }}
                </h5>
              @else
                <div class="product-list-slider" id="product-list-slider-1" data-slick='{"slidesToShow": 2}'>
                  @foreach ($top_rated->chunk(2) as $chunk)
                    <div>
                      @foreach ($chunk as $item)
                        @php
                          $itemContent = $item->itemContents->first() ?: \App\Models\User\UserItemContent::where('item_id', $item->id)->first();
                          if (!$itemContent || empty($itemContent->slug)) { continue; }
                          $flash_info = flashAmountStatus($item->id, $item->current_price);
                          $product_current_price = $flash_info['amount'];
                          $flash_status = $flash_info['status'];
                          $customer_id = Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null;
                          $checkWishList = $customer_id ? checkWishList($item->id, $customer_id) : false;
                        @endphp
                        <div class="product-default product-inline product-inline-2 mt-20">
                          <figure class="product-img radius-md">
                            <a href="{{ route('front.user.productDetails', [getParam(), 'slug' => $itemContent->slug]) }}"
                              class="lazy-container ratio ratio-1-1">
                              <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                                data-src="{{ asset('assets/front/img/user/items/thumbnail/' . $item->thumbnail) }}"
                                alt="">
                            </a>
                          </figure>
                          <div class="product-details">
                            @if (!empty($itemContent->category))
                              <a href="{{ route('front.user.shop', ['category' => $itemContent->category->slug, getParam()]) }}"
                                class="product-category text-sm">{{ $itemContent->category->name }}</a>
                            @endif

                            <h4 class="product-title lc-1">
                              <a href="{{ route('front.user.productDetails', [getParam(), 'slug' => $itemContent->slug]) }}">{{ $itemContent->title }}</a>
                            </h4>

                            @if ($shop_settings->item_rating_system == 1)
                              <div class="d-flex align-items-center">
                                <div class="product-ratings rate text-xsm">
                                  <div class="rating" style="width:{{ $item->rating * 20 }}%"></div>
                                </div>
                                <span class="ratings-total">({{ reviewCount($item->id) }})</span>
                              </div>
                            @endif

                            <div class="product-price mt-1 mb-10">
                              @if ($flash_status == true)
                                <span class="new-price">{{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($product_current_price)) }}</span>
                                <span class="old-price line_through">{{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($item->current_price)) }}</span>
                              @else
                                <span class="new-price">{{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($item->current_price)) }}</span>
                                <span class="old-price line_through">{{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($item->previous_price)) }}</span>
                              @endif
                            </div>

                            <div class="btn-icon-group btn-inline btn-icon-group-sm">
                              @if ($shop_settings->catalog_mode != 1)
                                <a class="btn btn-icon rounded-pill cart-link cursor-pointer"
                                  data-title="{{ $itemContent->title }}"
                                  data-current_price="{{ currency_converter($product_current_price) }}"
                                  data-item_id="{{ $item->id }}"
                                  data-language_id="{{ $uLang }}"
                                  data-totalVari="{{ check_variation($item->id) }}"
                                  data-variations="{{ check_variation($item->id) > 0 ? 'yes' : null }}"
                                  data-href="{{ route('front.user.add.cart', ['id' => $item->id, getParam()]) }}"
                                  data-bs-toggle="tooltip" data-placement="top"
                                  title="{{ $keywords['Add_to_Cart'] ?? __('Add to Cart') }}"><i class="far fa-shopping-cart"></i></a>
                              @endif

                              <a href="javascript:void(0)" class="btn btn-icon rounded-pill quick-view-link"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-slug="{{ $itemContent->slug }}"
                                data-url="{{ route('front.user.productDetails.quickview', ['slug' => $itemContent->slug, getParam()]) }}"
                                title="{{ $keywords['Quick View'] ?? __('Quick View') }}"><i class="fal fa-eye"></i></a>

                              <a class="btn btn-icon rounded-pill" data-bs-toggle="tooltip"
                                onclick="addToCompare('{{ route('front.user.add.compare', ['id' => $item->id, getParam()]) }}')"
                                data-bs-placement="top" title="{{ $keywords['Compare'] ?? __('Compare') }}"><i class="fal fa-random"></i></a>

                              <a href="#"
                                class="btn btn-icon rounded-pill {{ $checkWishList ? 'remove-wish active' : 'add-to-wish' }}"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-item_id="{{ $item->id }}"
                                data-href="{{ route('front.user.add.wishlist', ['id' => $item->id, getParam()]) }}"
                                data-removeurl="{{ route('front.user.remove.wishlist', ['id' => $item->id, getParam()]) }}"
                                title="{{ $keywords['Add to Wishlist'] ?? __('Add to Wishlist') }}"><i class="fal fa-heart"></i></a>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  @endforeach

                </div>
              @endif
            </div>
          </div>
          @if ($ubs->right_banner_section == 1)
            @if ($banners)
              @for ($i = 0; $i <= 1; $i++)
                @if (isset($banners[$i]))
                  @if ($banners[$i]->position == 'right')
                    <div class="col-xl-5 col-lg-6">
                      <div class="banner-sm banner-sm-style-4 banner-vertical content-top pb-30 ratio radius-md">
                        <img class="lazyload bg-img blur-up "
                          src="{{ asset('assets/front/images/placeholder.png') }}"
                          data-src="{{ asset('assets/front/img/user/banners/' . $banners[$i]->banner_img) }}"
                          alt="">
                        <div class="banner-content">
                          <div class="content-inner">
                            <span class="sub-title color-primary fw-bolder">{{ $banners[$i]->title }}</span>
                            <h2 class="title-md mb-1">{{ $banners[$i]->subtitle }}</h2>
                            <p>{{ $banners[$i]->text }}</p>
                            <a href="{{ $banners[$i]->banner_url }}"
                              class="btn btn-md btn-primary radius-sm">{{ $banners[$i]->button_text }}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                @endif
              @endfor
            @endif
          @endif
        </div>
      </div>
    </section>
    <!-- Product List End -->
