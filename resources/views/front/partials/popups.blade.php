@php
if ($currentLang->popups()->count() > 0) {
    $popups = $currentLang->popups()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
} else {
    $popups = [];
}
@endphp

@foreach ($popups as $popup)
    @php
        $type = $popup->type;
    @endphp
    @if ($type == 1)
        <div data-popup_delay="{{$popup->delay}}" data-popup_id="{{$popup->id}}" id="modal-popup{{$popup->id}}" class="popup-wrapper">
            <div>
                <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}" data-src="{{asset('assets/front/img/popups/' . $popup->image)}}" alt="Popup Image" width="100%">
            </div>
        </div>
    @elseif ($type == 2)
        <div data-popup_delay="{{$popup->delay}}" data-popup_id="{{$popup->id}}" id="modal-popup{{$popup->id}}" class="popup-wrapper">
            <div class="popup-one bg_cover lazy" data-bg="{{asset('assets/front/img/popups/' . $popup->background_image)}}">
                <div class="popup_main-content">
                    <h1>{{$popup->title}}</h1>
                    <p>{{$popup->text}}</p>

                    @if (!empty($popup->button_url) && !empty($popup->button_text))
                    <a href="{{$popup->button_url}}" class="popup-main-btn" style="background-color: #{{$popup->button_color}};">{{$popup->button_text}}</a>
                    @endif
                </div>
            </div>
        </div>
    @elseif ($type == 3)
        <div data-popup_delay="{{$popup->delay}}" data-popup_id="{{$popup->id}}" id="modal-popup{{$popup->id}}" class="popup-wrapper">
            <div class="popup-two bg_cover lazy" data-bg="{{asset('assets/front/img/popups/' . $popup->background_image)}}">
                <div class="popup_main-content">
                    <h1>{{$popup->title}}</h1>
                    <p>{{$popup->text}}</p>
                    <div class="subscribe-form">
                        <form id="popupSubscribe{{$popup->id}}" class="subscribeForm" action="{{route('front.subscribe')}}" method="POST">
                            @csrf
                            <div class="form_group">
                                <input type="email" class="form_control" placeholder="{{__('Email Address')}}" name="email" required>
                                <p id="erremail" class="text-white mb-3 err-email"></p>
                            </div>
                            <div class="form_group">
                                <button type="submit" class="popup-main-btn" style="background-color: #{{$popup->button_color}};">{{$popup->button_text}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type == 4)
        <div data-popup_delay="{{$popup->delay}}" data-popup_id="{{$popup->id}}" id="modal-popup{{$popup->id}}" class="popup-wrapper">
            <div class="popup-three">
                <div class="popup_main-content">
                    <div class="left-bg bg_cover lazy" data-bg="{{asset('assets/front/img/popups/' . $popup->image)}}"></div>
                    <div class="right-content">
                        <h1>{{$popup->title}}</h1>
                        <p>{{$popup->text}}</p>

                        @if (!empty($popup->button_url) && !empty($popup->button_text))
                        <a href="{{$popup->button_url}}" class="popup-main-btn" style="background-color: #{{$popup->button_color}};">{{$popup->button_text}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type == 5)
        <div data-popup_delay="{{$popup->delay}}" data-popup_id="{{$popup->id}}" id="modal-popup{{$popup->id}}" class="popup-wrapper">
            <div class="popup-four">
                <div class="popup_main-content">
                    <div class="left-bg bg_cover lazy" data-bg="{{asset('assets/front/img/popups/' . $popup->image)}}"></div>
                    <div class="right-content">
                        <h1>{{$popup->title}}</h1>
                        <p>{{$popup->text}}</p>
                        <div class="subscribe-form">
                            <form id="popupSubscribe{{$popup->id}}" class="subscribeForm" action="{{route('front.subscribe')}}" method="POST">
                                @csrf
                                <div class="form_group">
                                    <input type="email" class="form_control" placeholder="{{__('Email Address')}}" name="email" required>
                                    <p id="erremail" class="text-danger mb-3 err-email"></p>
                                </div>
                                <div class="form_group">
                                    <button type="submit" class="popup-main-btn" style="background-color: #{{$popup->button_color}};">{{$popup->button_text}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type == 7)
        <div data-popup_delay="{{$popup->delay}}" data-popup_id="{{$popup->id}}" id="modal-popup{{$popup->id}}" class="popup-wrapper popup-modern-offer">
            <div class="popup-modern-content">
                <!-- Left Column (Peach/Cream Storefront Preview) -->
                <div class="popup-modern-left">
                    <div class="modern-left-logo">
                        <i class="fas fa-shopping-bag me-2" style="color:#ff5a2c;"></i><strong>Launchshop</strong><span style="color:#ff5a2c;">.in</span>
                    </div>
                    
                    <!-- Browser Mockup -->
                    <div class="modern-browser-mockup">
                        <div class="browser-header">
                            <span class="dot dot-red"></span>
                            <span class="dot dot-yellow"></span>
                            <span class="dot dot-green"></span>
                        </div>
                        <div class="browser-body">
                            <!-- Mock Store Header -->
                            <div class="mock-store-nav">
                                <div class="mock-logo">Launchshop</div>
                                <div class="mock-links">
                                    <span>Home</span><span>Shop</span><span>About</span>
                                </div>
                                <div class="mock-icons">
                                    <i class="fas fa-search"></i>
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </div>
                            <!-- Mock Store Banner -->
                            <div class="mock-store-banner">
                                <div class="mock-banner-text">
                                    <span class="badge">NEW ARRIVALS</span>
                                    <h4>Clean. Modern. Built for Growth.</h4>
                                    <button class="mock-btn">Shop Now</button>
                                </div>
                                <div class="mock-banner-img">
                                    <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=300&q=80" alt="Vase">
                                </div>
                            </div>
                            <!-- Mock Store Best Sellers -->
                            <div class="mock-store-sellers">
                                <h5>Best Sellers</h5>
                                <div class="mock-products-grid">
                                    <div class="mock-prod-card">
                                        <div class="prod-img-box"><i class="fas fa-vase" style="font-size:10px;">🏺</i></div>
                                        <span class="name">Minimal Vase</span>
                                        <span class="price">₹899</span>
                                    </div>
                                    <div class="mock-prod-card">
                                        <div class="prod-img-box"><i class="fas fa-clock" style="font-size:10px;">⌚</i></div>
                                        <span class="name">Classic Watch</span>
                                        <span class="price">₹2,499</span>
                                    </div>
                                    <div class="mock-prod-card">
                                        <div class="prod-img-box"><i class="fas fa-briefcase" style="font-size:10px;">👜</i></div>
                                        <span class="name">Everyday Tote</span>
                                        <span class="price">₹1,299</span>
                                    </div>
                                    <div class="mock-prod-card">
                                        <div class="prod-img-box"><i class="fas fa-lightbulb" style="font-size:10px;">💡</i></div>
                                        <span class="name">Desk Lamp</span>
                                        <span class="price">₹1,199</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Subdomain Badge -->
                    <div class="modern-left-subdomain">
                        <div class="subdomain-icon-box">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="subdomain-text">
                            <span class="title">Get your free branded subdomain</span>
                            <span class="domain">yourstore.launchshop.in</span>
                        </div>
                        <i class="fas fa-check-circle check-icon"></i>
                    </div>
                </div>
                
                <!-- Right Column (Offer details & Countdown) -->
                <div class="popup-modern-right">
                    <!-- Top Ribbon Badge -->
                    <div class="modern-offer-badge">
                        <i class="fas fa-fire me-1"></i> LIMITED-TIME STORE LAUNCH OFFER
                    </div>
                    
                    <!-- Title -->
                    <h2 class="modern-offer-title">
                        Launch Your <br><span>Store Today</span>
                    </h2>
                    
                    <!-- Desc -->
                    <p class="modern-offer-desc">
                        Start your ecommerce site with a free trial, pick a ready-made theme, and get your branded subdomain in minutes.
                    </p>
                    
                    <!-- Peach Ribbon -->
                    <div class="modern-offer-ribbon">
                        <span>14-Day Free Trial</span>
                        <span class="divider">+</span>
                        <span>Free Subdomain</span>
                        <span class="divider">+</span>
                        <span>Premium Themes</span>
                    </div>
                    
                    <!-- Countdown Timer -->
                    <div class="offer-timer modern-countdown" data-end_date="{{ $popup->end_date }}" data-end_time="{{ $popup->end_time }}"></div>
                    
                    <!-- Features Bullet Grid -->
                    <div class="modern-features-grid d-none d-md-grid">
                        <div class="m-feat-item">
                            <i class="fas fa-code"></i>
                            <div>
                                <strong>No coding</strong>
                                <span>required</span>
                            </div>
                        </div>
                        <div class="m-feat-item">
                            <i class="fas fa-palette"></i>
                            <div>
                                <strong>Choose from</strong>
                                <span>premium themes</span>
                            </div>
                        </div>
                        <div class="m-feat-item">
                            <i class="fas fa-bolt"></i>
                            <div>
                                <strong>Setup in</strong>
                                <span>minutes</span>
                            </div>
                        </div>
                        <div class="m-feat-item">
                            <i class="fas fa-sync-alt"></i>
                            <div>
                                <strong>Cancel</strong>
                                <span>anytime</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="modern-cta-buttons">
                        <a href="{{ route('front.index') }}" class="btn-ls-outline popup-close-btn-trigger" style="flex: 1;">
                            <i class="fas fa-store me-2"></i> Explore Now
                        </a>
                    </div>
                    
                    <!-- Bottom Notice -->
                    <div class="modern-bottom-notice">
                        <i class="fas fa-shield-alt me-1"></i> Create your store <span>before this offer ends.</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
