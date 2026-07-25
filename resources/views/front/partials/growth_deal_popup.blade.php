{{-- Year-End Growth Deal Popup v2 - Pixel Perfect Match --}}
<div class="gd-overlay" id="gdOverlay" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Year-End Growth Deal">
    <div class="gd-backdrop" id="gdBackdrop"></div>

    <div class="gd-dialog">

        {{-- 3D Gift Box (left side, overlapping modal edge) --}}
        <div class="gd-giftbox" aria-hidden="true">
            <svg viewBox="0 0 180 235" xmlns="http://www.w3.org/2000/svg">
                {{-- Drop shadow --}}
                <ellipse cx="90" cy="226" rx="58" ry="9" fill="rgba(200,80,20,0.08)"/>
                {{-- Cloud puffs at base --}}
                <ellipse cx="48" cy="205" rx="24" ry="15" fill="white" opacity="0.95"/>
                <ellipse cx="72" cy="213" rx="30" ry="17" fill="white" opacity="0.97"/>
                <ellipse cx="104" cy="211" rx="28" ry="16" fill="white" opacity="0.97"/>
                <ellipse cx="134" cy="204" rx="22" ry="14" fill="white" opacity="0.95"/>
                {{-- Box body main --}}
                <rect x="20" y="100" width="140" height="103" rx="5" fill="#FF6C35"/>
                {{-- Box body left shading --}}
                <rect x="20" y="100" width="38" height="103" rx="5" fill="rgba(0,0,0,0.08)"/>
                {{-- Vertical ribbon --}}
                <rect x="68" y="100" width="28" height="103" fill="white" opacity="0.92"/>
                {{-- Horizontal ribbon --}}
                <rect x="20" y="138" width="140" height="22" fill="white" opacity="0.92"/>
                {{-- Box lid --}}
                <rect x="12" y="76" width="156" height="28" rx="5" fill="#FF8B4E"/>
                {{-- Lid left shading --}}
                <rect x="12" y="76" width="38" height="28" rx="5" fill="rgba(0,0,0,0.07)"/>
                {{-- Vertical ribbon on lid --}}
                <rect x="68" y="76" width="28" height="28" fill="white" opacity="0.92"/>
                {{-- Left bow loop --}}
                <ellipse cx="57" cy="62" rx="28" ry="18" fill="#FF8B4E" transform="rotate(-22, 57, 62)"/>
                <ellipse cx="57" cy="62" rx="17" ry="10" fill="#FF6C35" transform="rotate(-22, 57, 62)"/>
                {{-- Right bow loop --}}
                <ellipse cx="123" cy="62" rx="28" ry="18" fill="#FF8B4E" transform="rotate(22, 123, 62)"/>
                <ellipse cx="123" cy="62" rx="17" ry="10" fill="#FF6C35" transform="rotate(22, 123, 62)"/>
                {{-- Left ribbon tail --}}
                <path d="M76 80 Q62 94 54 106" stroke="#FF8B4E" stroke-width="6" fill="none" stroke-linecap="round"/>
                {{-- Right ribbon tail --}}
                <path d="M104 80 Q118 94 128 106" stroke="#FF8B4E" stroke-width="6" fill="none" stroke-linecap="round"/>
                {{-- Bow center knot --}}
                <circle cx="90" cy="70" r="14" fill="#FF5A1F"/>
                <circle cx="90" cy="70" r="8" fill="#FF8B4E"/>
                {{-- % sign on box front --}}
                <text x="90" y="180" font-size="34" font-weight="900" fill="white" text-anchor="middle"
                      font-family="Arial Black, Arial, sans-serif" opacity="0.96">%</text>
                {{-- Decorative confetti near gift box --}}
                <text x="4"   y="50"  font-size="18" fill="#FFB700">✦</text>
                <text x="155" y="32"  font-size="12" fill="#FF5A2C">✦</text>
                <text x="165" y="88"  font-size="9"  fill="#3B82F6">●</text>
                <text x="2"   y="125" font-size="10" fill="#FF5A2C">✦</text>
                {{-- Small curvy line decoration --}}
                <path d="M 162 55 Q 170 48 163 42" stroke="#FFB700" stroke-width="2.5" fill="none" stroke-linecap="round"/>
            </svg>
        </div>

        {{-- White Modal Box --}}
        <div class="gd-box" id="gdBox">

            {{-- Close Button --}}
            <button type="button" class="gd-close" id="gdClose" aria-label="Close popup">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M1 1L15 15M15 1L1 15" stroke="#555" stroke-width="2.2" stroke-linecap="round"/>
                </svg>
            </button>

            {{-- Decorative Stars scattered in header area --}}
            <span class="gd-deco gd-d1">✦</span>
            <span class="gd-deco gd-d2">✦</span>
            <span class="gd-deco gd-d3"></span>
            <span class="gd-deco gd-d4">✦</span>
            <span class="gd-deco gd-d5">/</span>
            <span class="gd-deco gd-d6">✦</span>

            {{-- Top Ribbon Badge --}}
            <div class="gd-ribbon-wrap">
                <div class="gd-ribbon">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="white" style="margin-right:6px; flex-shrink:0;">
                        <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6L12 2z"/>
                    </svg>
                    YEAR-END GROWTH DEAL
                </div>
            </div>

            {{-- Main Heading --}}
            <h2 class="gd-heading">Unlock Your Biggest<br><span>Savings of the Year!</span></h2>
            <p class="gd-subtext">Premium tools. Powerful growth. Unbeatable annual prices.<br>Offer expires when the timer hits zero.</p>

            {{-- Countdown Timer --}}
            <div class="gd-timer-section">
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
                <span class="gd-sparkle">✦</span>
            </div>

            {{-- Pricing Cards Outer (extra right space for 65% badge) --}}
            <div class="gd-cards-outer">
                <div class="gd-cards-grid">

                    {{-- Standard Card --}}
                    <div class="gd-card gd-std">
                        <div class="gd-card-header">
                            <div class="gd-icon gd-icon-std">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="gd-card-meta">
                                <h3 class="gd-card-name">Standard</h3>
                                <p class="gd-card-tagline">Smart choice for growing brands</p>
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
                            <li><i class="fas fa-check"></i>Unlimited Products</li>
                            <li><i class="fas fa-check"></i>Custom Domain</li>
                            <li><i class="fas fa-check"></i>Secure Payments</li>
                            <li><i class="fas fa-check"></i>Email &amp; Chat Support</li>
                        </ul>
                        <a href="{{ route('front.pricing') }}" class="gd-btn-border">Choose Standard &nbsp;→</a>
                    </div>

                    {{-- Premium Card --}}
                    <div class="gd-card gd-pre">
                        <div class="gd-card-header">
                            <div class="gd-icon gd-icon-pre">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div class="gd-card-meta">
                                <h3 class="gd-card-name">
                                    Premium&nbsp;
                                    <span class="gd-most-loved"><i class="fas fa-heart"></i>&nbsp;Most Loved</span>
                                </h3>
                                <p class="gd-card-tagline">The complete toolkit to scale faster</p>
                            </div>
                        </div>
                        <div class="gd-price-row" style="margin-top:16px;">
                            <span class="gd-original-price">₹28,569/year</span>
                            <span class="gd-save-tag">Save ₹18,570</span>
                        </div>
                        <div class="gd-price-big">₹9,999<span class="gd-per">/year</span></div>
                        <p class="gd-billed">Billed annually</p>
                        <ul class="gd-feats">
                            <li><i class="fas fa-check"></i>Everything in Standard</li>
                            <li><i class="fas fa-check"></i>Advanced Analytics</li>
                            <li><i class="fas fa-check"></i>Priority Support</li>
                            <li><i class="fas fa-check"></i>Free .com Domain</li>
                            <li><i class="fas fa-check"></i>Zero Transaction Fees</li>
                        </ul>
                        <a href="{{ route('front.pricing') }}" class="gd-btn-fill">Upgrade to Premium &nbsp;→</a>
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
.gd-giftbox svg { width: 100%; height: auto; }

@keyframes gdFloat {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-9px); }
}

/* ── White Box ── */
.gd-box {
    background: #ffffff;
    border-radius: 22px;
    padding: 30px 36px 22px;
    box-shadow: 0 24px 70px rgba(0, 0, 0, 0.16);
    position: relative;
    width: 100%;
    max-height: calc(100dvh - 36px);
    overflow-y: auto;
    overflow-x: visible;
    scrollbar-width: thin;
    scrollbar-color: #f0ece9 transparent;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
.gd-box::-webkit-scrollbar { width: 3px; }
.gd-box::-webkit-scrollbar-thumb { background: #e2ded9; border-radius: 3px; }

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

/* ── Decorative Stars ── */
.gd-deco {
    position: absolute;
    pointer-events: none;
    line-height: 1;
    animation: gdTwinkle 2.5s ease-in-out infinite;
}
.gd-d1 { top: 7%;  left: 14%; font-size: 15px; color: #FFB700; animation-delay: 0s;   }
.gd-d2 { top: 20%; right: 10%; font-size: 19px; color: #FF5A2C; animation-delay: 0.6s; }
.gd-d3 { /* hollow blue circle */
    top: 5%; right: 26%;
    width: 9px; height: 9px;
    border-radius: 50%;
    border: 2px solid #3B82F6;
    background: transparent;
    animation-delay: 1.1s;
}
.gd-d4 { top: 16%; left: 42%; font-size: 11px; color: #FFB700; animation-delay: 0.3s; }
.gd-d5 { top: 9%; right: 16%; font-size: 20px; color: #FF8040; font-weight: 300; transform: rotate(15deg); animation-delay: 0.9s; }
.gd-d6 { top: 4%; right: 6%;  font-size: 12px; color: #FF5A2C; animation-delay: 1.5s; }

@keyframes gdTwinkle {
    0%, 100% { opacity: 0.45; transform: scale(1); }
    50%       { opacity: 1;    transform: scale(1.25); }
}

/* ── Ribbon Badge ── */
.gd-ribbon-wrap { text-align: center; margin-bottom: 14px; }
.gd-ribbon {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(90deg, #FF6B3D 0%, #FF3D1F 100%);
    color: #fff;
    padding: 8px 22px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.3px;
    text-transform: uppercase;
    box-shadow: 0 5px 16px rgba(255, 90, 44, 0.38);
}

/* ── Heading ── */
.gd-heading {
    text-align: center;
    font-size: 34px;
    font-weight: 800;
    color: #0F172A;
    line-height: 1.18;
    margin: 0 0 10px;
    letter-spacing: -0.5px;
}
.gd-heading span { color: #FF5A2C; }

.gd-subtext {
    text-align: center;
    font-size: 14px;
    color: #64748B;
    line-height: 1.6;
    margin: 0 0 20px;
}

/* ── Timer ── */
.gd-timer-section {
    position: relative;
    max-width: 500px;
    margin: 0 auto 22px;
}
.gd-timer-lbl {
    text-align: center;
    font-size: 12.5px;
    font-weight: 500;
    color: #475569;
    margin: 0 0 9px;
}
.gd-timer-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: linear-gradient(170deg, #ffffff 0%, #FFF6F2 100%);
    border: 1px solid rgba(255, 90, 44, 0.13);
    border-radius: 16px;
    padding: 16px 22px 14px;
    box-shadow: 0 4px 22px rgba(255, 90, 44, 0.05), inset 0 1px 0 rgba(255,255,255,0.8);
}
.gd-tblock {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 58px;
}
.gd-tnum {
    font-size: 48px;
    font-weight: 800;
    color: #FF5A2C;
    line-height: 1;
    font-variant-numeric: tabular-nums;
    letter-spacing: -1px;
}
.gd-tunit {
    font-size: 9px;
    font-weight: 700;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 6px;
}
.gd-tsep {
    font-size: 38px;
    font-weight: 700;
    color: #FF5A2C;
    line-height: 1;
    padding-bottom: 16px;
    align-self: flex-end;
}
.gd-sparkle {
    position: absolute;
    right: -14px;
    top: 50%;
    transform: translateY(-30%);
    font-size: 17px;
    color: #FFB700;
    animation: gdTwinkle 2.2s ease-in-out infinite;
    pointer-events: none;
}

/* ── Cards Outer (holds grid + 65% badge) ── */
.gd-cards-outer {
    position: relative;
    padding-right: 52px; /* space for 65% off badge */
    margin-bottom: 18px;
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
    padding: 22px 20px 20px;
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
.gd-icon {
    width: 50px;
    height: 50px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    /* Hexagon shape */
    clip-path: polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%);
}
.gd-icon-std { background: #FFF2ED; color: #FF5A2C; }
.gd-icon-pre { background: #FFF2ED; color: #FF5A2C; }

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
    color: #FF5A2C;
    margin: 0;
    font-weight: 500;
}

/* ── Great Value Badge ── */
.gd-great-val {
    margin: 12px 0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 700;
    color: #DC2626;
    background: #FEF2F2;
    border: 1px solid rgba(220, 38, 38, 0.14);
    padding: 4px 12px;
    border-radius: 20px;
    width: fit-content;
}
.gd-great-val i { font-size: 11px; }

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
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 66px;
    height: 66px;
    background: #ffffff;
    border: 2px solid #FF5A2C;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    box-shadow: 0 4px 18px rgba(255, 90, 44, 0.22);
    z-index: 5;
    line-height: 1.1;
}
.gd-off-badge i    { font-size: 12px; color: #FF5A2C; margin-bottom: 1px; }
.gd-off-badge span { font-size: 8.5px; font-weight: 700; color: #FF5A2C; text-transform: uppercase; }
.gd-off-badge strong { font-size: 18px; font-weight: 900; color: #FF5A2C; display: block; }

/* ── Pricing ── */
.gd-price-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 14px 0 4px;
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
    font-size: 36px;
    font-weight: 800;
    color: #0F172A;
    line-height: 1;
    margin-bottom: 3px;
}
.gd-per {
    font-size: 14px;
    font-weight: 500;
    color: #64748B;
}
.gd-billed {
    font-size: 12px;
    color: #64748B;
    margin: 0 0 14px;
}

/* ── Feature List ── */
.gd-feats {
    list-style: none;
    padding: 0;
    margin: 0 0 auto;
    flex: 1;
}
.gd-feats li {
    font-size: 13.5px;
    color: #374151;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.gd-feats li i {
    font-size: 11px;
    color: #FF5A2C;
    flex-shrink: 0;
}

/* ── Buttons ── */
.gd-btn-border, .gd-btn-fill {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 12px 16px;
    margin-top: 16px;
    border-radius: 10px;
    font-size: 14px;
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
    background: #F8FAFC;
    border: 1px solid #F1F5F9;
    border-radius: 12px;
    padding: 13px 8px;
    margin-bottom: 14px;
}
.gd-ti {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 8px;
    border-right: 1px solid #E2E8F0;
}
.gd-ti:last-child { border-right: none; }
.gd-ti-ico {
    width: 30px;
    height: 30px;
    background: #FFF5F2;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FF5A2C;
    font-size: 13px;
    flex-shrink: 0;
}
.gd-ti strong {
    display: block;
    font-size: 11px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 2px;
}
.gd-ti span {
    display: block;
    font-size: 10px;
    color: #64748B;
    line-height: 1.3;
}

/* ── Footer / Dismiss ── */
.gd-footer { text-align: center; }
.gd-dismiss {
    font-size: 13.5px;
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
