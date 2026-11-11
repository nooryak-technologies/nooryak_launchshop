<!-- Best Sale Start -->
<section class="best-sale pb-100 lazy">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title title-center mb-40">
          <h2 class="title mb-30">
            {{ $userSec->tab_section_title ?? ($keywords['Tab Section'] ?? __('Tab Section')) }} </h2>
          <div class="tabs-navigation tabs-navigation-scroll d-flex">
            <ul class="nav nav-tabs" data-hover="fancyHover">
              @foreach ($tabs as $key => $tab)
                <li class="nav-item ">
                  <button class="nav-link hover-effect radius-sm {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab"
                    data-bs-target="#{{ $tab->slug }}" type="button">{{ $tab->name }}</button>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="tab-content">
          <div class="tab-pane active">
            <div class="row">
              @for ($skeleton=1;$skeleton<=4;$skeleton++)
              <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                <div class="product-default product-center radius-xl mb-30">
                  <figure class="product-img skeleton skeleton-big-img"></figure>
                  <div class="product-details">
                    <div class="product-category text-sm d-flex justify-content-center">
                      <div class="skeleton skeleton-category"></div>
                    </div>
                    <h4 class="skeleton skeleton-title"></h4>
                    <div class="d-flex justify-content-center align-items-center">
                      <div class="skeleton skeleton-ratings">
                      </div>
                    </div>
                    <div class="product-price">
                      <span class="new-price skeleton skeleton-price"></span>
                      <span class="old-price text-decoration-line-through skeleton skeleton-price"></span>
                    </div>
                  </div>
                  <div class="btn-icon-group d-flex justify-content-center">
                    <span class="count-period skeleton skeleton-btn-icon"></span>
                    <span class="count-period skeleton skeleton-btn-icon"></span>
                    <span class="count-period skeleton skeleton-btn-icon"></span>
                    <span class="count-period skeleton skeleton-btn-icon"></span>
                  </div>

                </div>

              </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Best Sale End -->

<!-- Best Sale Start -->
<section class="best-sale pb-100 actual-content">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title title-center mb-40">
          <h2 class="title mb-30">
            {{ $userSec->tab_section_title ?? ($keywords['Tab Section'] ?? __('Tab Section')) }} </h2>
          <div class="tabs-navigation tabs-navigation-scroll d-flex">
            <ul class="nav nav-tabs" data-hover="fancyHover">
              @foreach ($tabs as $key => $tab)
                <li class="nav-item ">
                  <button class="nav-link hover-effect radius-sm {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab"
                    data-bs-target="#{{ $tab->slug }}" type="button">{{ $tab->name }}</button>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        @php
          $tabPanes = count($tabs) > 0
              ? $tabs
              : collect([(object) ['slug' => 'default-products', 'name' => 'All', 'products' => '[]']]);
        @endphp
        <div class="tab-content">
          @foreach ($tabPanes as $i => $tabPane)
            <div class="tab-pane {{ $i == 0 ? 'active' : '' }}" id="{{ $tabPane->slug }}">
              <div class="row">
                @php
                  $product_ids = json_decode($tabPane->products ?? '[]', true) ?? [];
                  $valid_products = [];
                  if (!empty($product_ids) && is_array($product_ids)) {
                      $valid_products = \App\Models\User\UserItem::whereIn('id', $product_ids)
                          ->where('user_id', $user->id)
                          ->where('status', 1)
                          ->pluck('id')
                          ->toArray();
                  }

                  // Fallback: fetch active products directly from DB if tab has no valid assigned IDs
                  if (empty($valid_products)) {
                      $tabHint = strtolower(($tabPane->slug ?? '') . ' ' . ($tabPane->name ?? ''));
                      $fallbackQuery = \App\Models\User\UserItem::where('user_id', $user->id)
                          ->where('status', 1);

                      if (str_contains($tabHint, 'low') || str_contains($tabHint, 'price')) {
                          $fallbackQuery->orderBy('current_price', 'ASC')->orderBy('id', 'DESC');
                      } elseif (str_contains($tabHint, 'popular') || str_contains($tabHint, 'best') || str_contains($tabHint, 'rate')) {
                          $fallbackQuery->orderBy('rating', 'DESC')->orderBy('id', 'DESC');
                      } else {
                          $fallbackQuery->orderBy('id', 'DESC');
                      }

                      $valid_products = $fallbackQuery->take(8)->pluck('id')->toArray();
                  }
                  $renderedCount = 0;
                @endphp
                @if (!empty($valid_products))
                  @foreach (array_slice($valid_products, 0, 8) as $pid)
                    @php
                      $product_details = \App\Models\User\UserItem::where('id', $pid)
                          ->where('user_id', $user->id)
                          ->where('status', 1)
                          ->with([
                              'itemContents' => function ($q) use ($uLang) {
                                  $q->where('language_id', '=', $uLang);
                              },
                              'itemContents.category',
                              'sliders',
                          ])
                          ->first();
                      $content = !is_null($product_details) ? $product_details->itemContents->first() : null;
                      if (!is_null($product_details) && is_null($content)) {
                          $content = \App\Models\User\UserItemContent::where('item_id', $product_details->id)
                              ->with('category')
                              ->first();
                      }
                    @endphp

                    @if (!is_null($product_details) && !is_null(@$content->slug))
                      @php $renderedCount++; @endphp
                      <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="product-default product-center radius-xl mb-30">
                          @php
                            $item_label = DB::table('labels')
                                ->where('id', @$content->label_id)
                                ->first();
                            $label = $item_label->name ?? null;
                            $color = $item_label->color ?? null;
                          @endphp
                          <span class="label label-2"
                            style="background-color: #{{ $color }}">{{ $label }}</span>

                          <figure class="product-img mb-0">
                            <a href="{{ route('front.user.productDetails', [getParam(), 'slug' => $content->slug]) }}"
                              class="lazy-container ratio ratio-1-1">
                              <img class="lazyload default-img"
                                src="{{ asset('assets/front/images/placeholder.png') }}"
                                data-src="{{ asset('assets/front/img/user/items/thumbnail/' . $product_details->thumbnail) }}"
                                alt="">
                              <img class="lazyload hover-img"
                                src="{{ asset('assets/front/images/placeholder.png') }}"
                                data-src="{{ asset('assets/front/img/user/items/thumbnail/' . $product_details->thumbnail) }}"
                                alt="">
                            </a>
                          </figure>
                          @php
                            $flash_info = flashAmountStatus($product_details->id, $product_details->current_price);
                            $product_current_price = $flash_info['amount'];
                            $flash_status = $flash_info['status'];
                          @endphp

                          <div class="product-details">
                            @if (!empty($content->category))
                              <span class="product-category text-sm"><a
                                  href="{{ route('front.user.shop', ['category' => $content->category->slug, getParam()]) }}">{{ $content->category->name }}</a></span>
                            @endif
                            <h3 class="product-title lc-2">
                              <a
                                href="{{ route('front.user.productDetails', [getParam(), 'slug' => $content->slug]) }}">{{ $content->title }}</a>
                            </h3>

                            @if ($shop_settings->item_rating_system == 1)
                              <div class="d-flex justify-content-center align-items-center">
                                <div class="product-ratings rate text-xsm">
                                  <div class="rating" style="width:{{ $product_details->rating * 20 }}%">
                                  </div>
                                </div>
                                <span class="ratings-total">({{ reviewCount($product_details->id) }})</span>
                              </div>
                            @endif

                            <div class="product-price">
                              @if ($flash_status == true)
                                <span class="new-price">
                                  {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($product_current_price)) }}
                                </span>

                                <span class="old-price ms-1 line_through">
                                  {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($product_details->current_price)) }}
                                </span>
                              @else
                                <span class="new-price">
                                  {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($product_details->current_price)) }}
                                </span>

                                <span class="old-price ms-1 line_through">
                                  {{ symbolPrice($userCurrentCurr->symbol_position, $userCurrentCurr->symbol, currency_converter($product_details->previous_price)) }}
                                </span>
                              @endif
                            </div>
                          </div>

                          <div class="btn-icon-group btn-inline">

                            <a href="javascript:void(0)" class="btn btn-icon radius-sm hover-show quick-view-link"
                              data-bs-toggle="tooltip" data-bs-placement="top"
                              data-slug="{{ $content->slug }}"
                              data-url="{{ route('front.user.productDetails.quickview', ['slug' => $content->slug, getParam()]) }}"
                              title="{{ $keywords['Quick View'] ?? __('Quick View') }}"><i class="fal fa-eye"></i>
                            </a>

                            @if ($shop_settings->catalog_mode != 1)
                              <a class=" btn btn-icon radius-sm cart-link cursor-pointer"
                                data-title="{{ $content->title }}"
                                data-current_price="{{ currency_converter($product_current_price) }}"
                                data-item_id="{{ $product_details->id }}" data-language_id="{{ $uLang }}"
                                data-totalVari="{{ check_variation($product_details->id) }}"
                                data-variations="{{ check_variation($product_details->id) > 0 ? 'yes' : null }}"
                                data-href="{{ route('front.user.add.cart', ['id' => $product_details->id, getParam()]) }}"
                                data-bs-toggle="tooltip" data-placement="top"
                                title="{{ $keywords['Add to Cart'] ?? __('Add to Cart') }}"><i
                                  class="far fa-shopping-cart "></i>
                              </a>
                            @endif

                            <a class="btn btn-icon radius-sm" data-bs-toggle="tooltip"
                              onclick="addToCompare('{{ route('front.user.add.compare', ['id' => $product_details->id, getParam()]) }}')"
                              data-bs-placement="top" title="{{ $keywords['Compare'] ?? __('Compare') }}"><i
                                class="fal fa-random"></i></a>

                            @php
                              $customer_id = Auth::guard('customer')->check()
                                  ? Auth::guard('customer')->user()->id
                                  : null;
                              $checkWishList = $customer_id
                                  ? checkWishList($product_details->id, $customer_id)
                                  : false;
                            @endphp
                            <a href="#"
                              class="btn btn-icon hover-show radius-sm {{ $checkWishList ? 'remove-wish active' : 'add-to-wish' }}"
                              data-bs-toggle="tooltip" data-bs-placement="top"
                              data-item_id="{{ $product_details->id }}"
                              data-href="{{ route('front.user.add.wishlist', ['id' => $product_details->id, getParam()]) }}"
                              data-removeurl="{{ route('front.user.remove.wishlist', ['id' => $product_details->id, getParam()]) }}"
                              title="{{ $keywords['Add to Wishlist'] ?? __('Add to Wishlist') }}"><i
                                class="fal fa-heart"></i>
                            </a>
                          </div>

                          @if ($product_details->flash == 1)
                            <span
                              class="label-discount-percentage"><x-flash-icon></x-flash-icon>{{ $product_details->flash_amount }}%</span>
                          @endif
                        </div>
                      </div>
                    @endif
                  @endforeach
                @endif
                @if ($renderedCount === 0)
                  <div class="col-12">
                    <h5 class="title text-center mb-20">
                      {{ $keywords['NO PRODUCTS FOUND'] ?? __('NO PRODUCTS FOUND') }}
                    </h5>
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Best Sale End -->
