  <div class="col-xl-4 col-lg-6 actual-content">
    <div class="section-title title-inline title-bottom-line mb-10">
      <h2 class="title title-sm mb-0">{{ $userSec->top_rated_product_section_title ?? __('Top Rated') }}</h2>
      <div class="slider-arrow-inline product-list-slider-arrows" id="product-list-slider-1-arrows">
      </div>
    </div>
    <div class="product-list mb-20">
      @if (count($top_rated ?? []) == 0)
        <h5 class="title mb-20">
          {{ $keywords['NO PRODUCTS FOUND'] ?? __('NO PRODUCTS FOUND') }}
        </h5>
      @else
        <div class="product-list-slider" id="product-list-slider-1">
          @for ($k = 0; $k < count($top_rated); $k += 3)
            <div>
              @for ($slot = 0; $slot < 3; $slot++)
                @php
                  $ratedItem = $top_rated[$k + $slot] ?? null;
                  $ratedContent = (!empty($ratedItem) && !empty($ratedItem->itemContents) && count($ratedItem->itemContents) > 0)
                      ? $ratedItem->itemContents[0]
                      : null;
                @endphp
                @if ($ratedItem && $ratedContent && !empty($ratedContent->slug))
                  <div class="product-default product-inline product-inline-3 mt-20">
                    <figure class="product-img">
                      <a href="{{ route('front.user.productDetails', [getParam(), 'slug' => $ratedContent->slug]) }}"
                        class="lazy-container ratio ratio-1-1">
                        <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}"
                          data-src="{{ asset('assets/front/img/user/items/thumbnail/' . $ratedItem->thumbnail) }}"
                          alt="Product">
                      </a>
                    </figure>
                    <div class="product-details">
                      @if (!empty($ratedContent->category))
                        <span class="product-category text-sm"><a
                            href="{{ route('front.user.shop', ['category' => $ratedContent->category->slug, getParam()]) }}">{{ $ratedContent->category->name }}</a></span>
                      @endif
                      <h4 class="product-title lc-1 fw-bold">
                        <a
                          href="{{ route('front.user.productDetails', [getParam(), 'slug' => $ratedContent->slug]) }}">
                          {{ $ratedContent->title }}
                        </a>
                      </h4>

                      @if ($shop_settings->item_rating_system == 1)
                        <div class="d-flex align-items-center">
                          <div class="product-ratings rate text-xsm">
                            <div class="rating" style="width:{{ $ratedItem->rating * 20 }}%"></div>
                          </div>
                          <span class="ratings-total">({{ reviewCount($ratedItem->id) }})</span>
                        </div>
                      @endif

                      @php
                        $flash_info = flashAmountStatus($ratedItem->id, $ratedItem->current_price);
                        $product_current_price = $flash_info['amount'];
                        $flash_status = $flash_info['status'];
                      @endphp

                      <div class="product-price mt-1 mb-10">
                        @if ($flash_status == true)
                          <span class="new-price">
                            {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($product_current_price)) }}
                          </span>
                          <span class="old-price line_through">
                            {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($ratedItem->current_price)) }}
                          </span>
                        @else
                          <span class="new-price">
                            {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($ratedItem->current_price)) }}
                          </span>
                          <span class="old-price line_through">
                            {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($ratedItem->previous_price)) }}
                          </span>
                        @endif
                      </div>

                      <div class="btn-icon-group btn-inline btn-icon-group-sm">

                        @if ($shop_settings->catalog_mode != 1)
                          <a class="btn btn-icon radius-0 cart-link cursor-pointer"
                            data-title="{{ $ratedContent->title }}"
                            data-current_price="{{ currency_converter($product_current_price) }}"
                            data-item_id="{{ $ratedItem->id }}" data-language_id="{{ $uLang }}"
                            data-totalVari="{{ check_variation($ratedItem->id) }}"
                            data-variations="{{ check_variation($ratedItem->id) > 0 ? 'yes' : null }}"
                            data-href="{{ route('front.user.add.cart', ['id' => $ratedItem->id, getParam()]) }}"
                            data-bs-toggle="tooltip" data-placement="top"
                            title="{{ $keywords['Add_to_Cart'] ?? __('Add to Cart') }}"><i
                              class="far fa-shopping-cart "></i></a>
                        @endif

                        <a href="javascript:void(0)" class="btn btn-icon radius-0 quick-view-link"
                          data-bs-toggle="tooltip" data-bs-placement="top"
                          data-slug="{{ $ratedContent->slug }}"
                          data-url="{{ route('front.user.productDetails.quickview', ['slug' => $ratedContent->slug, getParam()]) }}"
                          title="{{ $keywords['Quick View'] ?? __('Quick View') }}"><i class="fal fa-eye"></i>
                        </a>

                        <a class="btn btn-icon radius-0" data-bs-toggle="tooltip"
                          onclick="addToCompare('{{ route('front.user.add.compare', ['id' => $ratedItem->id, getParam()]) }}')"
                          data-bs-placement="top" title="{{ $keywords['Compare'] ?? __('Compare') }}"><i
                            class="fal fa-random"></i></a>
                        @php
                          $customer_id = Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null;
                          $checkWishList = $customer_id ? checkWishList($ratedItem->id, $customer_id) : false;
                        @endphp
                        <a href="#"
                          class="btn btn-icon {{ $checkWishList ? 'remove-wish active' : 'add-to-wish' }}"
                          data-bs-toggle="tooltip" data-bs-placement="top" data-item_id="{{ $ratedItem->id }}"
                          data-href="{{ route('front.user.add.wishlist', ['id' => $ratedItem->id, getParam()]) }}"
                          data-removeurl="{{ route('front.user.remove.wishlist', ['id' => $ratedItem->id, getParam()]) }}"
                          title="{{ $keywords['Add to Wishlist'] ?? __('Add to Wishlist') }}"><i
                            class="fal fa-heart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                @endif
              @endfor
            </div>
          @endfor
        </div>
      @endif
    </div>
  </div>


  <div class="col-xl-4 col-lg-6 lazy">
    <div class="section-title title-inline title-bottom-line mb-10">
      <h2 class="title title-sm mb-0">{{ $userSec->top_rated_product_section_title ?? __('Top Rated') }}</h2>
      <div class="slider-arrow-inline product-list-slider-arrows" id="product-list-slider-skeleton-1-arrows">
      </div>
    </div>
    <div class="product-list mb-20">

      <div class="product-list-slider" id="product-list-slider-skeleton-1">
        <div>
          @for ($skeleton = 1; $skeleton <= 3; $skeleton++)
            <div class="product-default product-inline product-inline-3 mt-20">
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
          @endfor
        </div>
      </div>
    </div>
  </div>
