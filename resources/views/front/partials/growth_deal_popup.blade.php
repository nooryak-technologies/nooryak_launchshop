<!-- Year-End Growth Deal Popup -->
<div class="modal fade popup-growth-deal" id="growthDealModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content growth-modal-content">
            <button type="button" class="growth-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            
            <div class="growth-modal-body">
                <!-- Background decorative elements -->
                <div class="growth-bg-element star-1">✦</div>
                <div class="growth-bg-element star-2">✦</div>
                <div class="growth-bg-element star-3">✦</div>
                <div class="growth-bg-element star-4">✦</div>
                <div class="growth-bg-element circle-1"></div>
                <div class="growth-bg-element circle-2"></div>
                <div class="growth-bg-element present-box">
                    <img src="{{ asset('assets/front/img/present-box-icon.png') }}" alt="Gift Box" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB4PSIyMCIgeT0iNDAiIHdpZHRoPSI2MCIgaGVpZ2h0PSI0MCIgZmlsbD0iI2ZmNWEyYyIvPjxyZWN0IHg9IjE1IiB5PSIyNSIgd2lkdGg9IjcwIiBoZWlnaHQ9IjE1IiBmaWxsPSIjZTA0ODFkIi8+PHJlY3QgeD0iNDUiIHk9IjI1IiB3aWR0aD0iMTAiIGhlaWdodD0iNTUiIGZpbGw9IiNmZmYiLz48L3N2Zz4='">
                    <div class="present-percent">%</div>
                </div>

                <!-- Top Ribbon -->
                <div class="growth-ribbon-wrap">
                    <div class="growth-ribbon">
                        <i class="fas fa-crown"></i> YEAR-END GROWTH DEAL
                    </div>
                </div>

                <!-- Headers -->
                <h2 class="growth-title">Unlock Your Biggest<br><span>Savings of the Year!</span></h2>
                <p class="growth-subtitle">Premium tools. Powerful growth. Unbeatable annual prices.<br>Offer expires when the timer hits zero.</p>

                <!-- Timer Section -->
                <div class="growth-timer-container">
                    <div class="timer-label">Claim it before time runs out</div>
                    <div class="growth-timer" id="growthDealTimer">
                        <div class="time-block">
                            <span class="time-num" id="gd-days">01</span>
                            <span class="time-text">DAYS</span>
                        </div>
                        <span class="time-colon">:</span>
                        <div class="time-block">
                            <span class="time-num" id="gd-hours">23</span>
                            <span class="time-text">HOURS</span>
                        </div>
                        <span class="time-colon">:</span>
                        <div class="time-block">
                            <span class="time-num" id="gd-mins">45</span>
                            <span class="time-text">MINUTES</span>
                        </div>
                        <span class="time-colon">:</span>
                        <div class="time-block">
                            <span class="time-num" id="gd-secs">59</span>
                            <span class="time-text">SECONDS</span>
                        </div>
                    </div>
                </div>

                <!-- Pricing Cards -->
                <div class="growth-pricing-row">
                    <!-- Standard Card -->
                    <div class="growth-card standard-card">
                        <div class="card-header-top">
                            <div class="card-icon standard-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="card-title-area">
                                <h3>Standard</h3>
                                <p>Smart choice for growing brands</p>
                            </div>
                        </div>
                        <div class="card-badge-wrap text-center mt-2 mb-3">
                            <span class="badge-great-value"><i class="fas fa-check-circle"></i> Great Value</span>
                        </div>
                        <div class="card-price-area">
                            <div class="price-strike-row">
                                <span class="strike-price">₹14,283/year</span>
                                <span class="save-badge">Save ₹9,284</span>
                            </div>
                            <div class="main-price">
                                <strong>₹4,999</strong><span class="period">/year</span>
                            </div>
                            <div class="billed-text">Billed annually</div>
                        </div>
                        <ul class="card-features">
                            <li><i class="fas fa-check text-orange"></i> Unlimited Products</li>
                            <li><i class="fas fa-check text-orange"></i> Custom Domain</li>
                            <li><i class="fas fa-check text-orange"></i> Secure Payments</li>
                            <li><i class="fas fa-check text-orange"></i> Email & Chat Support</li>
                        </ul>
                        <div class="card-action text-center mt-4">
                            <a href="{{ route('front.pricing') }}" class="btn-growth-outline">Choose Standard &rarr;</a>
                        </div>
                    </div>

                    <!-- Premium Card -->
                    <div class="growth-card premium-card">
                        <!-- Floating Badge -->
                        <div class="floating-discount-badge">
                            <i class="fas fa-fire"></i>
                            <span>Up to</span>
                            <strong>65%</strong>
                            <span>OFF</span>
                        </div>

                        <div class="card-header-top">
                            <div class="card-icon premium-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div class="card-title-area" style="position: relative;">
                                <h3>Premium <span class="badge-most-loved"><i class="fas fa-heart"></i> Most Loved</span></h3>
                                <p>The complete toolkit to scale faster</p>
                            </div>
                        </div>
                        <div class="card-price-area mt-4">
                            <div class="price-strike-row">
                                <span class="strike-price">₹28,569/year</span>
                                <span class="save-badge premium-save">Save ₹18,570</span>
                            </div>
                            <div class="main-price">
                                <strong>₹9,999</strong><span class="period">/year</span>
                            </div>
                            <div class="billed-text">Billed annually</div>
                        </div>
                        <ul class="card-features mt-3">
                            <li><i class="fas fa-check text-orange"></i> Everything in Standard</li>
                            <li><i class="fas fa-check text-orange"></i> Advanced Analytics</li>
                            <li><i class="fas fa-check text-orange"></i> Priority Support</li>
                            <li><i class="fas fa-check text-orange"></i> Free .com Domain</li>
                            <li><i class="fas fa-check text-orange"></i> Zero Transaction Fees</li>
                        </ul>
                        <div class="card-action text-center mt-4">
                            <a href="{{ route('front.pricing') }}" class="btn-growth-solid">Upgrade to Premium &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Features Footer -->
                <div class="growth-features-footer mt-4">
                    <div class="feat-col">
                        <i class="fas fa-shield-check"></i>
                        <div>
                            <strong>Cancel Anytime</strong>
                            <span>No questions asked</span>
                        </div>
                    </div>
                    <div class="feat-col">
                        <i class="fas fa-lock"></i>
                        <div>
                            <strong>Secure Checkout</strong>
                            <span>100% safe & encrypted</span>
                        </div>
                    </div>
                    <div class="feat-col">
                        <i class="fas fa-globe"></i>
                        <div>
                            <strong>Free Domain</strong>
                            <span>.com on annual plans</span>
                        </div>
                    </div>
                    <div class="feat-col">
                        <i class="fas fa-headset"></i>
                        <div>
                            <strong>Priority Support</strong>
                            <span>We're here for you</span>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="#" class="growth-dismiss" data-dismiss="modal">I'll decide later &gt;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Growth Deal Popup CSS */
.popup-growth-deal {
    z-index: 100000;
}
.popup-growth-deal .modal-dialog {
    max-width: 850px;
    margin: 1.75rem auto;
}
.growth-modal-content {
    background: #fffafa; /* very slight warm tint */
    border-radius: 20px;
    border: none;
    padding: 30px 40px 20px;
    position: relative;
    overflow: visible;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    font-family: 'Inter', sans-serif;
}
.growth-close-btn {
    position: absolute;
    top: -15px;
    right: -15px;
    width: 40px;
    height: 40px;
    background: #fff;
    border: 1px solid #eaeaea;
    border-radius: 50%;
    font-size: 24px;
    line-height: 1;
    color: #555;
    z-index: 10;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.growth-close-btn:hover {
    color: #ff5a2c;
    transform: scale(1.1);
}

/* Background elements */
.growth-bg-element {
    position: absolute;
    pointer-events: none;
}
.star-1 { top: 10%; left: 10%; color: #ffd700; font-size: 14px; opacity: 0.8; animation: pulse 2s infinite; }
.star-2 { top: 25%; right: 15%; color: #ff5a2c; font-size: 18px; opacity: 0.6; animation: pulse 3s infinite; }
.star-3 { top: 40%; left: 5%; color: #ffd700; font-size: 20px; opacity: 0.7; animation: pulse 2.5s infinite; }
.star-4 { top: 15%; right: 5%; color: #3b82f6; font-size: 12px; opacity: 0.9; animation: pulse 2s infinite; }
.circle-1 { top: 8%; right: 25%; width: 8px; height: 8px; border-radius: 50%; border: 2px solid #3b82f6; opacity: 0.5; }
.circle-2 { top: 30%; left: 20%; width: 6px; height: 6px; border-radius: 50%; background: #ff5a2c; opacity: 0.4; }

.present-box {
    top: 15%;
    left: -30px;
    width: 100px;
    z-index: 5;
}
.present-box img {
    width: 100%;
    filter: drop-shadow(0 10px 15px rgba(255, 90, 44, 0.3));
}
.present-percent {
    position: absolute;
    top: 40%;
    left: 45%;
    transform: translate(-50%, -50%);
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

/* Top Ribbon */
.growth-ribbon-wrap {
    text-align: center;
    margin-bottom: 20px;
}
.growth-ribbon {
    display: inline-block;
    background: linear-gradient(90deg, #ff6b3d 0%, #ff4220 100%);
    color: #fff;
    padding: 6px 20px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1px;
    box-shadow: 0 4px 10px rgba(255, 90, 44, 0.3);
    text-transform: uppercase;
}
.growth-ribbon i {
    margin-right: 5px;
}

/* Headers */
.growth-title {
    text-align: center;
    font-size: 36px;
    font-weight: 800;
    color: #111827;
    line-height: 1.2;
    margin-bottom: 15px;
}
.growth-title span {
    color: #ff5a2c;
}
.growth-subtitle {
    text-align: center;
    font-size: 15px;
    color: #4b5563;
    margin-bottom: 25px;
    line-height: 1.5;
}

/* Timer */
.growth-timer-container {
    background: linear-gradient(180deg, #fff 0%, #fff5f2 100%);
    border: 1px solid rgba(255, 90, 44, 0.15);
    border-radius: 16px;
    padding: 15px 30px;
    max-width: 500px;
    margin: 0 auto 30px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(255, 90, 44, 0.05);
    position: relative;
}
.growth-timer-container::before, .growth-timer-container::after {
    content: '';
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 2px;
    background: rgba(255,90,44,0.3);
}
.growth-timer-container::before { left: -10px; }
.growth-timer-container::after { right: -10px; }

.timer-label {
    font-size: 12px;
    font-weight: 600;
    color: #4b5563;
    text-transform: uppercase;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
}
.growth-timer {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
}
.time-block {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.time-num {
    font-size: 32px;
    font-weight: 800;
    color: #ff5a2c;
    line-height: 1;
}
.time-text {
    font-size: 10px;
    color: #9ca3af;
    font-weight: 600;
    margin-top: 5px;
}
.time-colon {
    font-size: 24px;
    font-weight: 700;
    color: #ff5a2c;
    margin-top: -15px;
}

/* Pricing Grid */
.growth-pricing-row {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}
.growth-card {
    flex: 1;
    background: #fff;
    border-radius: 16px;
    padding: 30px 25px;
    border: 1px solid #f3f4f6;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}
.premium-card {
    border: 2px solid #ff5a2c;
    background: linear-gradient(180deg, #fff 0%, #fffcfb 100%);
    box-shadow: 0 15px 40px rgba(255, 90, 44, 0.08);
}
.card-header-top {
    display: flex;
    align-items: center;
    gap: 15px;
}
.card-icon {
    width: 45px;
    height: 45px;
    background: #fff5f2;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
}
.standard-icon { color: #ff5a2c; }
.premium-icon { color: #ff5a2c; }

.card-title-area h3 {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 5px;
}
.card-title-area p {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}
.badge-great-value {
    font-size: 11px;
    font-weight: 600;
    color: #ff5a2c;
    background: #fff5f2;
    padding: 4px 10px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.badge-most-loved {
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    background: #ff5a2c;
    padding: 3px 8px;
    border-radius: 6px;
    vertical-align: middle;
    margin-left: 8px;
}
.floating-discount-badge {
    position: absolute;
    top: -25px;
    right: -20px;
    background: linear-gradient(135deg, #ff6b3d, #ff4220);
    color: #fff;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(255, 90, 44, 0.4);
    border: 3px solid #fff;
    z-index: 2;
    transform: rotate(10deg);
}
.floating-discount-badge i { font-size: 12px; margin-bottom: 2px; }
.floating-discount-badge span { font-size: 10px; font-weight: 700; line-height: 1; text-transform: uppercase; }
.floating-discount-badge strong { font-size: 24px; font-weight: 900; line-height: 1.1; }

.price-strike-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}
.strike-price {
    font-size: 14px;
    color: #9ca3af;
    text-decoration: line-through;
    font-weight: 500;
}
.save-badge {
    background: #dcfce7;
    color: #16a34a;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 10px;
}
.premium-save {
    background: #dcfce7;
    color: #16a34a;
}
.main-price strong {
    font-size: 38px;
    font-weight: 800;
    color: #111827;
}
.main-price .period {
    font-size: 15px;
    color: #6b7280;
    font-weight: 500;
}
.billed-text {
    font-size: 12px;
    color: #6b7280;
    margin-top: 5px;
}
.card-features {
    list-style: none;
    padding: 0;
    margin: 20px 0 0;
}
.card-features li {
    font-size: 14px;
    color: #4b5563;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.text-orange {
    color: #ff5a2c;
    font-size: 12px;
    background: #fff5f2;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-growth-outline {
    display: block;
    width: 100%;
    padding: 12px;
    border: 1.5px solid #ff5a2c;
    color: #ff5a2c;
    background: #fff;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
}
.btn-growth-outline:hover {
    background: #fff5f2;
    color: #ff5a2c;
}
.btn-growth-solid {
    display: block;
    width: 100%;
    padding: 12px;
    background: #ff5a2c;
    color: #fff;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(255, 90, 44, 0.3);
}
.btn-growth-solid:hover {
    background: #e0481d;
    color: #fff;
}

/* Features Footer */
.growth-features-footer {
    display: flex;
    justify-content: space-between;
    background: #fafafa;
    border: 1px solid #f3f4f6;
    padding: 15px 20px;
    border-radius: 12px;
}
.feat-col {
    display: flex;
    align-items: center;
    gap: 12px;
}
.feat-col i {
    font-size: 18px;
    color: #ff5a2c;
    background: #fff5f2;
    padding: 8px;
    border-radius: 8px;
}
.feat-col strong {
    display: block;
    font-size: 12px;
    color: #111827;
    margin-bottom: 2px;
}
.feat-col span {
    display: block;
    font-size: 11px;
    color: #6b7280;
}

.growth-dismiss {
    font-size: 13px;
    color: #6b7280;
    text-decoration: none;
    font-weight: 500;
}
.growth-dismiss:hover {
    color: #111827;
    text-decoration: underline;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(1); opacity: 0.5; }
}

/* Responsive */
@media (max-width: 768px) {
    .growth-pricing-row {
        flex-direction: column;
    }
    .growth-features-footer {
        flex-wrap: wrap;
        gap: 15px;
    }
    .feat-col {
        width: 45%;
    }
    .present-box {
        display: none;
    }
    .growth-title {
        font-size: 28px;
    }
    .floating-discount-badge {
        right: 0px;
        top: -15px;
        width: 65px;
        height: 65px;
    }
    .floating-discount-badge strong { font-size: 20px; }
    .floating-discount-badge span { font-size: 8px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if popup was already closed in this session (optional, but good practice)
    // Uncomment the session storage logic if you want to limit the popup visibility
    // if (!sessionStorage.getItem('growthDealClosed')) {
        setTimeout(function() {
            // Trigger bootstrap modal
            $('#growthDealModal').modal('show');
        }, 1500);
    // }

    $('#growthDealModal').on('hidden.bs.modal', function () {
        // sessionStorage.setItem('growthDealClosed', 'true');
    });

    // Simple countdown logic (simulate countdown to midnight or a specific time)
    function updateCountdown() {
        // Just a dummy logic for display: decrement seconds, reset if 0
        let secElem = document.getElementById('gd-secs');
        let minElem = document.getElementById('gd-mins');
        
        if (secElem && minElem) {
            let secs = parseInt(secElem.innerText, 10);
            let mins = parseInt(minElem.innerText, 10);
            
            if (secs > 0) {
                secs--;
            } else {
                secs = 59;
                if (mins > 0) mins--;
            }
            
            secElem.innerText = secs.toString().padStart(2, '0');
            minElem.innerText = mins.toString().padStart(2, '0');
        }
    }
    
    setInterval(updateCountdown, 1000);
});
</script>
