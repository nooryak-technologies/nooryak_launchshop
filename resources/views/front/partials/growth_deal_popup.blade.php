{{-- Year-End Growth Deal Popup v2 - Pixel Perfect Match --}}
<div class="gd-overlay" id="gdOverlay" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Year-End Growth Deal">
    <div class="gd-backdrop" id="gdBackdrop"></div>

    <div class="gd-dialog">

        {{-- 3D Gift Box (left side, overlapping modal edge) --}}
        <div class="gd-giftbox" aria-hidden="true">
            <img src="{{ asset('images/orange_percent_giftbox.png') }}?v=12" alt="Gift Box" style="width: 100%; height: auto;">
        </div>

        {{-- White Modal Box --}}
        <div class="gd-box" id="gdBox">

            {{-- Close Button --}}
            <button type="button" class="gd-close" id="gdClose" aria-label="Close popup">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M1 1L15 15M15 1L1 15" stroke="#555" stroke-width="2.2" stroke-linecap="round"/>
                </svg>
            </button>

            {{-- Celebration ornaments matching reference image exactly --}}
            <div class="gd-celebration gd-cel-left" aria-hidden="true">
                <svg viewBox="0 0 100 100" class="gd-cel-svg">
                    <path d="M10,40 Q22,32 16,18 T28,6" stroke="#FF8B5E" stroke-width="2.5" fill="none" stroke-linecap="round" />
                    <path d="M25,48 Q37,40 31,26 T43,14" stroke="#FFA37B" stroke-width="2" fill="none" stroke-linecap="round" />
                    <path d="M5,58 Q17,50 11,36 T23,24" stroke="#FFBC9F" stroke-width="1.5" fill="none" stroke-linecap="round" />
                    <path d="M55,30 L57,35 L62,35 L58,39 L60,44 L55,41 L50,44 L52,39 L48,35 L53,35 Z" fill="#3B82F6" />
                    <path d="M35,65 L37,68 L41,68 L38,71 L39,75 L35,73 L31,75 L32,71 L29,68 L33,68 Z" fill="#FF5A2C" />
                    <path d="M75,50 L76.5,52 L79.5,52 L77,54 L78,57 L75,55.5 L72,57 L73,54 L70.5,52 L73.5,52 Z" fill="#FFB700" />
                </svg>
            </div>
            <div class="gd-celebration gd-cel-right" aria-hidden="true">
                <svg viewBox="0 0 100 100" class="gd-cel-svg">
                    <circle cx="50" cy="20" r="5" fill="none" stroke="#3B82F6" stroke-width="2" />
                    <path d="M25,40 L27,45 L32,45 L28,49 L30,54 L25,51 L20,54 L22,49 L18,45 L23,45 Z" fill="#FFB700" />
                    <path d="M70,35 L72,40 L77,40 L73,44 L75,49 L70,46 L65,49 L67,44 L63,40 L68,40 Z" fill="#FFB700" />
                    <path d="M60,60 Q70,55 65,45 T75,35" stroke="#FFA37B" stroke-width="2" fill="none" stroke-linecap="round" />
                    <path d="M85,55 L90,65" stroke="#FF5A2C" stroke-width="2" fill="none" stroke-linecap="round" />
                </svg>
            </div>

            {{-- Top Ribbon Badge --}}
            <div class="gd-ribbon-wrap">
                <div class="gd-ribbon">
                    <i class="fas fa-crown" style="margin-right: 6px; font-size: 11.5px; color: white;"></i>
                    YEAR-END GROWTH DEAL
                </div>
            </div>

            {{-- Main Heading --}}
            <h2 class="gd-heading">Unlock Your Biggest<br><span>Savings of the Year!</span></h2>
            <p class="gd-subtext">Premium tools. Powerful growth. Unbeatable annual prices.<br>Offer expires when the timer hits zero.</p>

            {{-- Countdown Timer --}}
            <div class="gd-timer-section">
                <span class="gd-sparkle-left">✦</span>
                <p class="gd-timer-lbl">Claim it before time runs out</p>
                <div class="gd-timer-row">
                    <div class="gd-tblock">
                        <span class="gd-tnum" id="gd-days">01</span>
                        <span class="gd-tunit">DAYS</span>
                    </div>
                    <span class="gd-tsep">:</span>
                    <div class="gd-tblock">
                        <span class="gd-tnum" id="gd-hours">23</span>
                        <span class="gd-tunit">HOURS</span>
                    </div>
                    <span class="gd-tsep">:</span>
                    <div class="gd-tblock">
                        <span class="gd-tnum" id="gd-mins">45</span>
                        <span class="gd-tunit">MINUTES</span>
                    </div>
                    <span class="gd-tsep">:</span>
                    <div class="gd-tblock">
                        <span class="gd-tnum" id="gd-secs">59</span>
                        <span class="gd-tunit">SECONDS</span>
                    </div>
                </div>
                <span class="gd-sparkle-right">✦</span>
            </div>

            {{-- Pricing Cards Outer (extra right space for 65% badge) --}}
            <div class="gd-cards-outer">
                <div class="gd-cards-grid">

                    {{-- Standard Card --}}
                    <div class="gd-card gd-std">
                        <div class="gd-card-header">
                            <div class="gd-hexagon-icon">
                                <svg viewBox="0 0 100 100" class="gd-hex-svg">
                                    <polygon points="50,5 90,28 90,72 50,95 10,72 10,28" fill="#FFF5F2" stroke="#FF5A2C" stroke-width="3.5" />
                                </svg>
                                <i class="fas fa-star gd-hex-inner-icon"></i>
                            </div>
                            <div class="gd-card-meta">
                                <h3 class="gd-card-name">Standard</h3>
                                <p class="gd-card-tagline gd-tagline-standard">Smart choice for growing brands</p>
                            </div>
                        </div>
                        <div class="gd-great-val">
                            <i class="fas fa-check-circle"></i> Great Value
                        </div>
                        <div class="gd-price-row">
                            <span class="gd-original-price">₹14,283/year</span>
                            <span class="gd-save-tag">Save ₹9,284</span>
                        </div>
                        <div class="gd-price-big">₹4,999<span class="gd-per">/year</span></div>
                        <p class="gd-billed">Billed annually</p>
                        <ul class="gd-feats">
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Unlimited Products</li>
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Custom Domain</li>
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Secure Payments</li>
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Email &amp; Chat Support</li>
                        </ul>
                        <a href="{{ route('front.pricing') }}" class="gd-btn-border">Choose Standard &nbsp;→</a>
                    </div>

                    {{-- Premium Card --}}
                    <div class="gd-card gd-pre">
                        <div class="gd-card-header">
                            <div class="gd-hexagon-icon">
                                <svg viewBox="0 0 100 100" class="gd-hex-svg">
                                    <polygon points="50,5 90,28 90,72 50,95 10,72 10,28" fill="#FFF5F2" stroke="#FF5A2C" stroke-width="3.5" />
                                </svg>
                                <i class="fas fa-crown gd-hex-inner-icon"></i>
                            </div>
                            <div class="gd-card-meta">
                                <h3 class="gd-card-name">
                                    Premium&nbsp;
                                    <span class="gd-most-loved"><i class="fas fa-heart"></i>&nbsp;Most Loved</span>
                                </h3>
                                <p class="gd-card-tagline gd-tagline-premium">The complete toolkit to scale faster</p>
                            </div>
                        </div>
                        <div class="gd-price-row" style="margin-top:16px;">
                            <span class="gd-original-price">₹28,569/year</span>
                            <span class="gd-save-tag">Save ₹18,570</span>
                        </div>
                        <div class="gd-price-big">₹9,999<span class="gd-per">/year</span></div>
                        <p class="gd-billed">Billed annually</p>
                        <ul class="gd-feats">
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Everything in Standard</li>
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Advanced Analytics</li>
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Priority Support</li>
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Free .com Domain</li>
                            <li><span class="gd-check-circle"><i class="fas fa-check"></i></span>Zero Transaction Fees</li>
                        </ul>
                        <a href="{{ route('front.pricing') }}" class="gd-btn-fill">Upgrade to Premium &nbsp;→</a>
                        <span class="gd-card-sparkle">✦</span>
                    </div>
                </div>

                {{-- 65% OFF Badge (outside premium card, right side) --}}
                <div class="gd-off-badge">
                    <i class="fas fa-fire"></i>
                    <span>Up to</span>
                    <strong>65%</strong>
                    <span>OFF</span>
                </div>
            </div>

            {{-- Trust Row --}}
            <div class="gd-trust">
                <div class="gd-ti">
                    <div class="gd-ti-ico"><i class="fas fa-shield-alt"></i></div>
                    <div><strong>Cancel Anytime</strong><span>No questions asked</span></div>
                </div>
                <div class="gd-ti">
                    <div class="gd-ti-ico"><i class="fas fa-lock"></i></div>
                    <div><strong>Secure Checkout</strong><span>100% safe &amp; encrypted</span></div>
                </div>
                <div class="gd-ti">
                    <div class="gd-ti-ico"><i class="fas fa-globe"></i></div>
                    <div><strong>Free Domain</strong><span>.com on annual plans</span></div>
                </div>
                <div class="gd-ti">
                    <div class="gd-ti-ico"><i class="fas fa-headset"></i></div>
                    <div><strong>Priority Support</strong><span>We're here for you</span></div>
                </div>
            </div>

            {{-- Dismiss --}}
            <div class="gd-footer">
                <a href="#" class="gd-dismiss" id="gdDismiss">I'll decide later <i class="fas fa-angle-right"></i></a>
            </div>

        </div>{{-- .gd-box --}}
    </div>{{-- .gd-dialog --}}
</div>{{-- .gd-overlay --}}

{{-- ============================
     STYLES
     ============================ --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap');

/* Apply Outfit font to headings and highlight texts to match reference image */
.gd-heading, .gd-card-name, .gd-tnum, .gd-ribbon, .gd-price-big, .gd-off-badge strong, .gd-ti strong {
    font-family: 'Outfit', sans-serif !important;
}

/* ── Reset in scope ── */
.gd-overlay *, .gd-overlay *::before, .gd-overlay *::after {
    box-sizing: border-box;
}

/* ── Overlay ── */
.gd-overlay {
    position: fixed;
    inset: 0;
    z-index: 1000001;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.32s ease, visibility 0.32s ease;
}
.gd-overlay.gd-show {
    opacity: 1;
    visibility: visible;
}

/* ── Backdrop ── */
.gd-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.52);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    cursor: pointer;
}

/* ── Dialog Wrapper (positions gift box + white box together) ── */
.gd-dialog {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 760px;
    /* On desktop, shift right slightly so gift box doesn't overflow viewport */
    margin-left: 60px;
    display: flex;
    flex-direction: column;
}

/* ── 3D Gift Box ── */
.gd-giftbox {
    position: absolute;
    left: -90px;
    top: 24px;
    width: 148px;
    pointer-events: none;
    z-index: 10;
    animation: gdFloat 4s ease-in-out infinite;
    filter: drop-shadow(0 16px 24px rgba(255, 90, 30, 0.22));
}
.gd-giftbox img { width: 100%; height: auto; }

@keyframes gdFloat {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-9px); }
}

/* ── White Box ── */
.gd-box {
    background: linear-gradient(180deg, #FFFFFF 0%, #FFFDFB 100%);
    border: 1.5px solid rgba(255, 90, 44, 0.12);
    border-radius: 22px;
    padding: 22px 30px 14px;
    box-shadow: 0 30px 80px rgba(255, 90, 44, 0.08), 0 10px 30px rgba(0, 0, 0, 0.04);
    position: relative;
    width: 100%;
    max-height: 115dvh;
    overflow-y: auto;
    overflow-x: visible;
    scrollbar-width: thin;
    scrollbar-color: #f0ece9 transparent;
    font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
.gd-box::-webkit-scrollbar { width: 3px; }
.gd-box::-webkit-scrollbar-thumb { background: #e2ded9; border-radius: 3px; }::-webkit-scrollbar-thumb { background: #e2ded9; border-radius: 3px; }

/* ── Close Button ── */
.gd-close {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #f9fafb;
    border: 1.5px solid #e2e8f0;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.18s, transform 0.18s;
    z-index: 10;
    padding: 0;
}
.gd-close:hover { background: #f1f5f9; transform: scale(1.08); }

/* ── Celebration Ornaments ── */
.gd-celebration {
    position: absolute;
    width: 90px;
    height: 90px;
    pointer-events: none;
    z-index: 1;
}
.gd-cel-left {
    top: 3%;
    left: 2%;
    transform: rotate(-10deg);
}
.gd-cel-right {
    top: 2%;
    right: 2%;
    transform: rotate(10deg);
}
.gd-cel-svg {
    width: 100%;
    height: 100%;
    overflow: visible;
}

/* ── Ribbon Badge ── */
.gd-ribbon-wrap { text-align: center; margin-bottom: 12px; }
.gd-ribbon {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(90deg, #FF6B3D 0%, #FF3D1F 100%);
    color: #fff;
    padding: 7px 18px;
    border-radius: 30px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    box-shadow: 0 5px 16px rgba(255, 90, 44, 0.3);
}

/* ── Heading ── */
.gd-heading {
    text-align: center;
    font-size: 28px;
    font-weight: 800;
    color: #0F172A;
    line-height: 1.15;
    margin: 0 0 6px;
    letter-spacing: -0.5px;
}
.gd-heading span { color: #FF5A2C; }

.gd-subtext {
    text-align: center;
    font-size: 13px;
    color: #64748B;
    line-height: 1.5;
    margin: 0 0 16px;
}

/* ── Timer ── */
.gd-timer-section {
    position: relative;
    max-width: 440px;
    margin: 0 auto 18px;
    background: linear-gradient(180deg, #ffffff 0%, #FFFDFB 100%);
    border: 1.2px solid rgba(255, 90, 44, 0.16);
    border-radius: 20px;
    padding: 10px 18px 8px;
    box-shadow: 0 8px 30px rgba(255, 90, 44, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.8);
    text-align: center;
}
.gd-timer-lbl {
    font-size: 11.5px;
    font-weight: 600;
    color: #475569;
    margin: 0 0 6px;
    letter-spacing: 0.5px;
}
.gd-timer-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
}
.gd-tblock {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 50px;
}
.gd-tnum {
    font-size: 38px;
    font-weight: 800;
    color: #FF5A2C;
    line-height: 1;
    font-variant-numeric: tabular-nums;
    letter-spacing: -1px;
}
.gd-tunit {
    font-size: 8px;
    font-weight: 700;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 4px;
}
.gd-tsep {
    font-size: 28px;
    font-weight: 700;
    color: #FF5A2C;
    line-height: 1;
    padding-bottom: 8px;
    align-self: center;
}
.gd-sparkle-left, .gd-sparkle-right, .gd-card-sparkle {
    position: absolute;
    font-size: 16px;
    color: #FFB700;
    animation: gdTwinkle 2s ease-in-out infinite;
    pointer-events: none;
    line-height: 1;
}
.gd-sparkle-left {
    left: -12px;
    top: 55%;
    transform: translateY(-50%);
    animation-delay: 0.3s;
}
.gd-sparkle-right {
    right: -12px;
    top: 45%;
    transform: translateY(-50%);
    animation-delay: 0.7s;
}
.gd-card-sparkle {
    right: 12px;
    bottom: 12px;
    animation-delay: 1.1s;
    font-size: 18px;
}

@keyframes gdTwinkle {
    0%, 100% { opacity: 0.3; transform: scale(0.85); }
    50%       { opacity: 1;   transform: scale(1.15); }
}

/* ── Cards Outer (holds grid + 65% badge) ── */
.gd-cards-outer {
    position: relative;
    padding-right: 52px; /* space for 65% off badge */
    margin-bottom: 14px;
}

/* ── Cards Grid ── */
.gd-cards-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

/* ── Card Base ── */
.gd-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 16px 16px 14px;
    border: 1.5px solid #E5E7EB;
    position: relative;
    box-shadow: 0 2px 14px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
}
.gd-pre {
    border: 2px solid #FF5A2C;
    box-shadow: 0 6px 28px rgba(255, 90, 44, 0.1);
}

/* ── Card Header ── */
.gd-card-header {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 0;
}
.gd-hexagon-icon {
    position: relative;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.gd-hex-svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}
.gd-hex-inner-icon {
    position: relative;
    z-index: 2;
    font-size: 18px;
    color: #FF5A2C;
}
.gd-card-name {
    font-size: 20px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 3px;
    line-height: 1.2;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
}
.gd-card-tagline {
    font-size: 13px;
    margin: 0;
    font-weight: 500;
}
.gd-tagline-standard {
    color: #C25E3D;
}
.gd-tagline-premium {
    color: #FF5A2C;
}
/* ── Great Value Badge ── */
.gd-great-val {
    margin: 10px 0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    color: #FF5A2C;
    background: #FFF5F2;
    border: 1px solid rgba(255, 90, 44, 0.16);
    padding: 3px 10px;
    border-radius: 20px;
    width: fit-content;
}
.gd-great-val i { font-size: 10px; }

/* ── Most Loved Badge ── */
.gd-most-loved {
    background: #FF5A2C;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 20px;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    vertical-align: middle;
}
.gd-most-loved i { font-size: 9px; }

/* ── 65% OFF Badge ── */
.gd-off-badge {
    position: absolute;
    right: -28px;
    top: 42%;
    transform: translateY(-50%);
    width: 86px;
    height: 86px;
    background: #ffffff;
    border: 2.5px solid #FF5A2C;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    box-shadow: 0 10px 25px rgba(255, 90, 44, 0.14), 0 0 15px rgba(255, 90, 44, 0.15);
    z-index: 5;
    line-height: 1.15;
}
.gd-off-badge i    { font-size: 14px; color: #FF5A2C; margin-bottom: 2px; }
.gd-off-badge span { font-size: 9px; font-weight: 700; color: #C25E3D; text-transform: uppercase; }
.gd-off-badge strong { font-size: 24px; font-weight: 900; color: #FF5A2C; display: block; }

/* ── Pricing ── */
.gd-price-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 10px 0 2px;
}
.gd-original-price {
    font-size: 13px;
    color: #94A3B8;
    text-decoration: line-through;
    font-weight: 500;
}
.gd-save-tag {
    background: #DCFCE7;
    color: #16A34A;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 10px;
    white-space: nowrap;
}
.gd-price-big {
    font-size: 30px;
    font-weight: 800;
    color: #0F172A;
    line-height: 1;
    margin-bottom: 3px;
}
.gd-per {
    font-size: 13.5px;
    font-weight: 500;
    color: #64748B;
}
.gd-billed {
    font-size: 12px;
    color: #64748B;
    margin: 0 0 10px;
}

/* ── Feature List ── */
.gd-feats {
    list-style: none;
    padding: 0;
    margin: 0 0 10px;
    flex: 1;
}
.gd-feats li {
    font-size: 12.5px;
    color: #475569;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.gd-check-circle {
    width: 17px;
    height: 17px;
    background: #FFF0EB;
    border: 1px solid rgba(255, 90, 44, 0.15);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 2px;
    flex-shrink: 0;
}
.gd-check-circle i {
    font-size: 8px;
    color: #FF5A2C;
    line-height: 1;
}

/* ── Buttons ── */
.gd-btn-border, .gd-btn-fill {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 10px 14px;
    margin-top: 12px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.22s ease;
    cursor: pointer;
}
.gd-btn-border {
    border: 1.5px solid #FF5A2C;
    color: #FF5A2C;
    background: transparent;
}
.gd-btn-border:hover { background: #FFF5F2; color: #FF5A2C; text-decoration: none; }

.gd-btn-fill {
    background: #FF5A2C;
    color: #fff;
    border: none;
    box-shadow: 0 4px 18px rgba(255, 90, 44, 0.32);
}
.gd-btn-fill:hover { background: #E04E22; color: #fff; text-decoration: none; transform: translateY(-1px); box-shadow: 0 7px 24px rgba(255,90,44,0.42); }

/* ── Trust Row ── */
.gd-trust {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    background: #FFFBF9;
    border: 1px solid rgba(255, 90, 44, 0.1);
    border-radius: 12px;
    padding: 10px 6px;
    margin-bottom: 12px;
}
.gd-ti {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 6px;
    border-right: 1px solid #E2E8F0;
}
.gd-ti:last-child { border-right: none; }
.gd-ti-ico {
    width: 28px;
    height: 28px;
    background: #FFF0EB;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FF5A2C;
    font-size: 11.5px;
    flex-shrink: 0;
}
.gd-ti strong {
    display: block;
    font-size: 10.5px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 2px;
}
.gd-ti span {
    display: block;
    font-size: 9px;
    color: #64748B;
    line-height: 1.3;
}

/* ── Footer / Dismiss ── */
.gd-footer { text-align: center; }
.gd-dismiss {
    font-size: 12.5px;
    color: #64748B;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: color 0.18s;
}
.gd-dismiss:hover { color: #1E293B; text-decoration: none; }

/* ===========================================
   RESPONSIVE
   =========================================== */

/* Hide gift box on screens too narrow to accommodate it */
@media (max-width: 960px) {
    .gd-dialog { margin-left: 0; }
    .gd-giftbox { display: none; }
}

/* Tablet adjustments */
@media (max-width: 767px) {
    .gd-box { padding: 24px 18px 18px; border-radius: 18px; }
    .gd-heading { font-size: 26px; }
    .gd-subtext { font-size: 13px; }
    .gd-tnum { font-size: 36px; }
    .gd-tsep { font-size: 28px; }
    .gd-tblock { min-width: 44px; }
    .gd-timer-row { padding: 12px 14px 10px; gap: 4px; }
    .gd-sparkle { display: none; }

    /* Stack cards */
    .gd-cards-outer { padding-right: 0; }
    .gd-cards-grid { grid-template-columns: 1fr; }

    /* Move 65% badge inside premium card area */
    .gd-off-badge {
        position: absolute;
        right: 16px;
        top: -22px;
        transform: none;
        width: 60px;
        height: 60px;
    }
    .gd-off-badge strong { font-size: 16px; }
    .gd-off-badge i { font-size: 10px; }
    .gd-off-badge span { font-size: 7.5px; }
    .gd-pre { margin-top: 30px; } /* space for badge */

    /* Trust 2 columns */
    .gd-trust { grid-template-columns: 1fr 1fr; gap: 10px; padding: 12px; }
    .gd-ti { border-right: none !important; border-bottom: 1px solid #E2E8F0; padding: 8px 4px; }
    .gd-ti:nth-child(odd)  { border-right: 1px solid #E2E8F0 !important; }
    .gd-ti:nth-child(3),
    .gd-ti:nth-child(4)    { border-bottom: none; }
    .gd-price-big { font-size: 30px; }
}

/* Small mobile */
@media (max-width: 480px) {
    .gd-overlay { padding: 10px; }
    .gd-box { padding: 20px 14px 16px; border-radius: 14px; }
    .gd-heading { font-size: 22px; }
    .gd-ribbon { font-size: 10.5px; padding: 7px 16px; letter-spacing: 1px; }
    .gd-tnum { font-size: 30px; }
    .gd-tsep { font-size: 22px; }
    .gd-tblock { min-width: 34px; }
    .gd-tunit { font-size: 7.5px; }
    .gd-timer-row { gap: 2px; padding: 10px 10px 8px; }
    .gd-card { padding: 18px 14px 16px; }
    .gd-price-big { font-size: 26px; }
    .gd-trust { grid-template-columns: 1fr 1fr; font-size: 9px; }
}

/* Viewport height-based layout scaling to prevent vertical scrollbars on desktop */
@media (min-width: 961px) and (max-height: 850px) {
    .gd-dialog {
        transform: scale(0.92);
        transform-origin: center center;
    }
}
@media (min-width: 961px) and (max-height: 780px) {
    .gd-dialog {
        transform: scale(0.85);
        transform-origin: center center;
    }
}
@media (min-width: 961px) and (max-height: 700px) {
    .gd-dialog {
        transform: scale(0.78);
        transform-origin: center center;
    }
}
@media (min-width: 961px) and (max-height: 620px) {
    .gd-dialog {
        transform: scale(0.70);
        transform-origin: center center;
    }
}
</style>

{{-- ============================
     SCRIPT
     ============================ --}}
<script>
(function() {
    'use strict';

    var overlay   = document.getElementById('gdOverlay');
    var backdrop  = document.getElementById('gdBackdrop');
    var closeBtn  = document.getElementById('gdClose');
    var dismissEl = document.getElementById('gdDismiss');

    /* ── Show / Hide ── */
    function openPopup() {
        if (!overlay) return;
        overlay.classList.add('gd-show');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function closePopup() {
        if (!overlay) return;
        overlay.classList.remove('gd-show');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    /* Auto-open after 1.5 s */
    if (overlay) setTimeout(openPopup, 1500);

    /* Close handlers */
    if (closeBtn)  closeBtn.addEventListener('click', closePopup);
    if (backdrop)  backdrop.addEventListener('click', closePopup);
    if (dismissEl) dismissEl.addEventListener('click', function(e){ e.preventDefault(); closePopup(); });
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closePopup(); });

    /* ── Persistent Countdown ── */
    var SK = 'gdTimerEnd_v2';
    var endTs = parseInt(sessionStorage.getItem(SK), 10);
    if (!endTs || isNaN(endTs) || endTs < Date.now()) {
        /* 1 day 23h 45m 59s */
        endTs = Date.now() + (1*86400 + 23*3600 + 45*60 + 59) * 1000;
        sessionStorage.setItem(SK, endTs);
    }

    var elD = document.getElementById('gd-days');
    var elH = document.getElementById('gd-hours');
    var elM = document.getElementById('gd-mins');
    var elS = document.getElementById('gd-secs');

    function pad(n){ return n < 10 ? '0'+n : ''+n; }
    function tick(){
        var diff = Math.max(0, endTs - Date.now());
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000)  / 60000);
        var s = Math.floor((diff % 60000)    / 1000);
        if(elD) elD.textContent = pad(d);
        if(elH) elH.textContent = pad(h);
        if(elM) elM.textContent = pad(m);
        if(elS) elS.textContent = pad(s);
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
