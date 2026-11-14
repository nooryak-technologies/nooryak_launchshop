<style>
  /* Hide breadcrumb */
  .page-title-area { display: none !important; }

  /* ── Page wrapper ── */
  .modern-pricing-page-wrapper {
    background-color: #fafbfc !important;
  }
  .pricing-v2-section {
    /* padding: 40px 0 100px; */
  }

  /* ── Centered hero header ── */
  .pricing-hero-center {
    text-align: center;
    padding: 56px 0 0;
  }
  .pricing-eyebrow-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #ff5a2c;
    margin-bottom: 14px;
  }
  .pricing-hero-center h1 {
    font-size: 40px;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.15;
    margin-bottom: 14px;
  }
  .pricing-hero-center h1 span {
    color: #ff5a2c;
  }
  .pricing-hero-center h1 strong {
    color: #ff5a2c;
    font-weight: 900;
  }
  .pricing-hero-center .subtitle {
    font-size: 16px;
    color: #64748b;
    margin-bottom: 24px;
  }
  .pricing-save-pill {
    position: relative;
    display: inline-block;
    background: #22c55e;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 12px;
    margin-bottom: 12px;
    box-shadow: 0 4px 10px rgba(34, 197, 94, 0.2);
    align-self: center;
    border: none;
  }
  .pricing-save-pill::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 70%;
    transform: translateX(-50%);
    border-width: 6px 6px 0;
    border-style: solid;
    border-color: #22c55e transparent;
    display: block;
    width: 0;
  }

  /* Standard Most Popular Callout Box (Positioned on Right side of Standard card) */
  .standard-most-popular-callout {
      position: absolute;
    right: -317px;
    top: -144px;
    width: 220px;
    background: linear-gradient(135deg, #ffffff 0%, #fff3f0 100%);
    border: 2px solid #ff5a2c;
    border-radius: 14px;
    padding: 16px;
    box-shadow: 0 12px 35px rgba(255, 90, 44, 0.25), 0 0 20px rgba(255, 90, 44, 0.15);
    z-index: 10;
    text-align: left;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .standard-most-popular-callout:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 40px rgba(255, 90, 44, 0.3), 0 0 25px rgba(255, 90, 44, 0.25);
  }
  .standard-most-popular-callout .callout-title {
    color: #ff5a2c;
    font-size: 14px;
    font-weight: 800;
  }
  .standard-most-popular-callout .callout-icon-wrap {
    background: linear-gradient(135deg, #ff5a2c 0%, #e0451a 100%) !important;
    box-shadow: 0 4px 10px rgba(255, 90, 44, 0.35);
  }
  .standard-most-popular-callout .callout-arrow-left {
    position: absolute;
    right: 170px;
    bottom: -45px;
    z-index: 2;
    filter: drop-shadow(0 2px 4px rgba(255, 90, 44, 0.2));
  }

  /* Basic Most Popular Callout Box (Top of Basic card on Yearly tab) */
  .basic-most-popular-callout {
    position: absolute;
        top: -137px;
    left: 63%;
    transform: translateX(-50%);
    width: 230px;
    background: linear-gradient(135deg, #ffffff 0%, #fff3f0 100%);
    border: 2px solid #ff5a2c;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 12px 35px rgba(255, 90, 44, 0.25), 0 0 20px rgba(255, 90, 44, 0.15);
    z-index: 10;
    text-align: left;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .basic-most-popular-callout:hover {
    transform: translateX(-50%) translateY(-2px);
    box-shadow: 0 16px 40px rgba(255, 90, 44, 0.3), 0 0 25px rgba(255, 90, 44, 0.25);
  }
  .basic-most-popular-callout .callout-title {
    color: #ff5a2c;
    font-size: 14px;
    font-weight: 800;
  }
  .basic-most-popular-callout .callout-icon-wrap {
    background: linear-gradient(135deg, #ff5a2c 0%, #e0451a 100%) !important;
    box-shadow: 0 4px 10px rgba(255, 90, 44, 0.35);
  }
  .basic-most-popular-callout .callout-arrow-to-standard {
    position: absolute;
    left: 80px;
    bottom: -40px;
    z-index: 2;
    filter: drop-shadow(0 2px 4px rgba(255, 90, 44, 0.2));
  }

  /* Enterprise Callout Box (Top of Enterprise card on Yearly tab) */
  .enterprise-callout-box {
    position: absolute;
    top: -155px;
    left: 36%;
    transform: translateX(-50%);
    width: 230px;
    background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%);
    border: 2px solid #f59e0b;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 12px 35px rgba(245, 158, 11, 0.22), 0 0 20px rgba(245, 158, 11, 0.12);
    z-index: 10;
    text-align: left;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .enterprise-callout-box:hover {
    transform: translateX(-50%) translateY(-2px);
    box-shadow: 0 16px 40px rgba(245, 158, 11, 0.28), 0 0 25px rgba(245, 158, 11, 0.20);
  }
  .enterprise-callout-box .callout-title {
    color: #d97706;
    font-size: 14px;
    font-weight: 800;
  }
  .enterprise-callout-box .callout-icon-wrap,
  .callout-icon-wrap.star {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    color: #fff;
    box-shadow: 0 4px 10px rgba(245, 158, 11, 0.35);
  }
  .enterprise-callout-box .callout-arrow-left {
    position: absolute;
    right: 170px;
    bottom: -50px;
    z-index: 2;
    filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.25));
  }

  /* ── Toggle pill tabs ── */
  .pricing-toggle-wrap {
    text-align: center;
    /* margin-bottom: 48px; */
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .pricing-pill-tabs {
    display: inline-flex;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 50px;
    padding: 5px;
    gap: 4px;
    list-style: none;
    margin: 0 auto;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
  }
  .pricing-pill-tabs .nav-item { margin: 0; }
  .pricing-pill-tabs .nav-link {
    border: none;
    border-radius: 50px;
    padding: 10px 28px;
    font-size: 15px;
    font-weight: 700;
    color: #475569;
    background: transparent;
    transition: all 0.25s ease;
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .pricing-pill-tabs .nav-link.active {
    background: #ff5a2c;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(255,90,44,0.25);
  }

  .yearly-free-domain-note {
    font-size: 13px;
    color: #64748b;
    text-align: center;
    margin-bottom: 32px;
  }
  .yearly-free-domain-note span { color: #ff5a2c; font-weight: 700; }

  /* ── Monthly Billing Callout ── */
  .monthly-billing-callout {
    position: absolute;
    left: -240px;
    top: -45px;
    width: 220px;
    background: linear-gradient(135deg, #ffffff 0%, #fff3f0 100%);
    border: 2px solid #ff5a2c;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 12px 35px rgba(255, 90, 44, 0.25), 0 0 20px rgba(255, 90, 44, 0.15);
    z-index: 10;
    text-align: left;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .monthly-billing-callout:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 40px rgba(255, 90, 44, 0.3), 0 0 25px rgba(255, 90, 44, 0.25);
  }
  .callout-icon-wrap {
    background: linear-gradient(135deg, #ff5a2c 0%, #e0451a 100%) !important;
    color: #fff;
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(255, 90, 44, 0.35);
  }
  .callout-title {
    font-size: 14px;
    font-weight: 800;
    margin: 0 0 4px 0;
    color: #ff5a2c;
  }
  .callout-desc {
    font-size: 12px;
    margin: 0;
    color: #475569;
    line-height: 1.45;
  }
  .callout-arrow {
    position: absolute;
    left: 20px;
    bottom: -45px;
    z-index: 2;
  }

  /* ── Cards grid ── */
  .pricing-cards-row {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    flex-wrap: wrap;
    justify-content: center;
    position: relative;
  }

  .pricing-card-v2 {
    flex: 1 1 210px;
    max-width: 260px;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 20px;
    padding: 28px 22px 24px;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    color: #1e293b;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
  }
  .pricing-card-v2:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
  }

  /* Basic card → white bg, black border */
  .pricing-card-v2.card-basic {
    background: #ffffff;
    border: 2px solid #000000;
  }
  /* Standard card → very light orange background, orange border (RECOMMENDED) */
  .pricing-card-v2.card-recommended {
    background: #fffaf7;
    border: 2px solid #ff5a2c;
    box-shadow: 0 12px 40px rgba(255,90,44,0.12);
    color: #1e293b;
    transform: scale(1.02);
  }
  /* Premium card → very light gold background, gold border (BEST VALUE) */
  .pricing-card-v2.card-best-value {
    background: #fffef2;
    border: 2px solid #f59e0b;
    box-shadow: 0 12px 40px rgba(245,158,11,0.08);
    color: #1e293b;
  }
  /* Enterprise white card with black border */
  .pricing-card-v2.card-enterprise {
    background: #ffffff;
    border: 2px solid #000000;
  }

  .plan-v2-wa-btn {
    width: 50px;
    height: 48px;
    border-radius: 12px;
    background: #22c55e;
    color: #fff !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    transition: transform 0.2s, background-color 0.2s;
    flex-shrink: 0;
    text-decoration: none !important;
    border: none;
    margin-top: auto;
  }
  .plan-v2-wa-btn:hover {
    background: #16a34a;
    transform: scale(1.05);
  }

  /* Top badge */
  .plan-top-badge {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 16px;
    border-radius: 20px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
  .badge-recommended { background: #ff5a2c; color: #fff; }
  .badge-best-value   { background: #f59e0b; color: #fff; }

  /* Plan icon area */
  .plan-v2-icon {
    text-align: center;
    margin: 0 auto 12px;
    width: 56px;
    height: 56px;
    background: #fff3f0;
    color: #ff5a2c;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }

  /* Plan title */
  .plan-v2-title {
    font-size: 22px;
    font-weight: 800;
    margin: 8px 0 4px;
    color: #0f172a;
    text-align: center;
  }
  .plan-v2-subtitle {
    font-size: 12px;
    color: #64748b;
    text-align: center;
    margin-bottom: 14px;
  }

  /* Price block */
  .plan-v2-price-block {
    text-align: center;
    margin-bottom: 4px;
  }
  .plan-v2-currency { font-size: 18px; font-weight: 700; vertical-align: top; margin-top: 8px; display: inline-block; color: #0f172a; }
  .plan-v2-amount   { font-size: 42px; font-weight: 900; line-height: 1; color: #0f172a; }
  .plan-v2-period   { font-size: 13px; font-weight: 500; color: #64748b; }

  .plan-v2-billing-note {
    font-size: 11px;
    color: #64748b;
    text-align: center;
    margin-bottom: 18px;
    padding: 3px 10px;
    border-radius: 20px;
  }
  /* Terms badge group */
  .plan-terms-badge-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    margin-bottom: 14px;
  }
  .plan-terms-badge-group .plan-monthly-badge {
    margin-bottom: 0 !important;
  }
  /* Monthly billing badge on basic */
  .plan-monthly-badge {
    display: inline-block;
    background: #fff3f0;
    color: #ff5a2c;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
    border: 1px solid #ffd5c8;
    margin-bottom: 12px;
  }
  /* Attractive Free 2 Months for Yearly Plan Badge */
  .plan-yearly-free-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    color: #b45309;
    border: 1px solid #fde68a;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: 0.2px;
    box-shadow: 0 2px 6px rgba(245, 158, 11, 0.12);
    transition: all 0.2s ease;
  }
  .plan-yearly-free-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(245, 158, 11, 0.18);
  }

  /* Feature list */
  .plan-v2-features {
    list-style: none;
    padding: 0;
    margin: 0 0 4px;
    flex: 1;
  }
  .plan-v2-features li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 15px;
    padding: 5px 0;
    color: #334155;
  }

  /* Check icons */
  .plan-v2-features li .fi-check {
    color: #10b981;
    font-size: 14px;
    flex-shrink: 0;
    margin-top: 2px;
  }
  /* Unavailable features: line-through text, muted X icon */
  .plan-v2-features li.feat-disabled {
    opacity: 0.55;
  }
  .plan-v2-features li.feat-disabled > span:last-child {
    text-decoration: line-through;
    text-decoration-color: #e80c0c;
  }
  .plan-v2-features li .fi-times {
    color: #e80c0c;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 2px;
  }
  /* Premium free domain special class */
  .plan-v2-features li.feat-free-domain-premium {
    color: #059669 !important;
    font-weight: 700;
  }

  /* Free domain highlight row */
  .plan-v2-features li.feat-free-domain {
    color: #059669;
    font-weight: 700;
  }

  /* See more toggle */
  .plan-v2-see-more {
    background: none;
    border: none;
    padding: 6px 0;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: opacity 0.2s;
    color: #ff5a2c;
    margin-bottom: 14px;
  }
  .plan-v2-extra-features {
    display: none;
    overflow: hidden;
  }
  .plan-v2-extra-features.open {
    display: block;
  }

  /* Mobile-only callout boxes styling */
  .mobile-most-popular-callout {
    display: none;
    width: 100%;
    max-width: 320px;
    margin: 0 auto 20px auto;
    background: linear-gradient(135deg, #ffffff 0%, #fff3f0 100%);
    border: 2px solid #ff5a2c;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 12px 35px rgba(255, 90, 44, 0.15);
    text-align: left;
    box-sizing: border-box;
  }
  .mobile-most-popular-callout .callout-title {
    color: #ff5a2c;
    font-size: 14px;
    font-weight: 800;
  }
  .mobile-most-popular-callout .callout-icon-wrap {
    background: linear-gradient(135deg, #ff5a2c 0%, #e0451a 100%) !important;
    box-shadow: 0 4px 10px rgba(255, 90, 44, 0.2);
  }

  .mobile-most-people-choose-callout {
    display: none;
    width: 100%;
    max-width: 320px;
    margin: 0 auto 20px auto;
    background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%);
    border: 2px solid #f59e0b;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 12px 35px rgba(245, 158, 11, 0.22), 0 0 20px rgba(245, 158, 11, 0.12);
    text-align: left;
    box-sizing: border-box;
  }
  .mobile-most-people-choose-callout .callout-title {
    color: #d97706;
    font-size: 14px;
    font-weight: 800;
  }
  .mobile-most-people-choose-callout .callout-icon-wrap {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25);
  }

  .mobile-monthly-billing-callout {
    display: none;
    width: 100%;
    max-width: 320px;
    margin: 0 auto 20px auto;
    background: linear-gradient(135deg, #ffffff 0%, #fff3f0 100%);
    border: 2px solid #ff5a2c;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 12px 35px rgba(255, 90, 44, 0.15);
    text-align: left;
    box-sizing: border-box;
  }
  .mobile-monthly-billing-callout .callout-title {
    color: #ff5a2c;
    font-size: 14px;
    font-weight: 800;
    margin: 0 0 4px 0;
  }
  .mobile-monthly-billing-callout .callout-desc {
    font-size: 12px;
    margin: 0;
    color: #475569;
    line-height: 1.45;
  }
  .mobile-monthly-billing-callout .callout-icon-wrap {
    background: linear-gradient(135deg, #ff5a2c 0%, #e0451a 100%) !important;
    color: #fff;
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(255, 90, 44, 0.2);
  }

  /* CTA button */
  .plan-v2-btn {
    display: block;
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    margin-top: auto;
    cursor: pointer;
  }
  /* Basic & Enterprise outline button */
  .btn-v2-outline {
    background: transparent;
    border-color: #ff5a2c;
    color: #ff5a2c;
  }
  .btn-v2-outline:hover { background: #ff5a2c; color: #fff; }

  /* Standard & Premium solid orange button */
  .card-recommended .plan-v2-btn,
  .card-best-value .plan-v2-btn {
    background: #ff5a2c;
    color: #ffffff;
    border-color: #ff5a2c;
  }
  .card-recommended .plan-v2-btn:hover,
  .card-best-value .plan-v2-btn:hover {
    background: #e04d24;
    border-color: #e04d24;
    color: #ffffff;
  }

  /* Enterprise button */
  .card-enterprise .plan-v2-btn {
    background: transparent;
    border-color: #cbd5e1;
    color: #334155;
  }
  .card-enterprise .plan-v2-btn:hover { background: #cbd5e1; color: #334155; }

  /* Divider line above features */
  .plan-v2-divider {
       border: none;
    border-top: 1px solid #313233;
    margin: 0px 0 14px;
  }

  /* Trust row below cards (mockup layout) */
  .pricing-v2-trust {
    display: flex;
    justify-content: space-around;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px;
    margin-top: 48px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    width: 100%;
    max-width: 1100px;
    margin-left: auto;
    margin-right: auto;
    flex-wrap: nowrap;
    box-sizing: border-box;
  }
  .pricing-v2-trust-item {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    justify-content: flex-start;
    padding: 0 24px;
    text-align: left;
  }
  .pricing-v2-trust-item:not(:last-child) {
    border-right: 1.5px solid #e2e8f0;
  }
  .pricing-v2-trust-item span {
    font-size: 13px;
    color: #475569;
    line-height: 1.35;
  }
  .pricing-v2-trust-item span strong {
    color: #0f172a;
    font-weight: 700;
  }
  .pricing-v2-trust-item span small {
    color: #64748b;
    font-size: 11px;
    display: block;
    margin-top: 2px;
  }
  .pricing-v2-trust .trust-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
  }
  .trust-icon.green  { background: #e6faf2; color: #10b981; }
  .trust-icon.orange { background: #fff3f0; color: #ff5a2c; }
  .trust-icon.purple { background: #f3e8ff; color: #a855f7; }

  /* Responsive */
  @media(max-width:1200px) {
    .monthly-billing-callout {
      display: none !important;
    }
    .premium-most-chosen-callout, 
    .standard-most-popular-callout, 
    .basic-most-popular-callout, 
    .enterprise-callout-box {
      display: none !important;
    }
    .mobile-most-popular-callout,
    .mobile-most-people-choose-callout,
    .mobile-monthly-billing-callout {
      display: block !important;
    }
    .pricing-card-v2 {
      margin-bottom: 24px;
    }
  }
  @media(max-width:991px) {
    .pricing-card-v2 {
      flex: 0 0 100% !important;
      width: 100% !important;
      max-width: 340px !important;
      margin-bottom: 28px !important;
    }
    .pricing-cards-row {
      flex-direction: column !important;
      align-items: center !important;
    }
    /* Hide all plan icon badges (paper plane / telegram, rocket, crown) on mobile view */
    .pricing-card-v2 .plan-v2-icon {
      display: none !important;
    }
  }
  @media(max-width:768px) {
    .pricing-hero-center h1 { font-size: 28px; }
    .card-recommended { transform: none; }
    .pricing-v2-trust {
      flex-direction: column;
      gap: 20px;
      padding: 24px 16px;
      box-sizing: border-box;
    }
    .pricing-v2-trust-item {
      width: 100%;
      justify-content: flex-start;
      padding-left: calc(50% - 115px);
      box-sizing: border-box;
    }
    .pricing-v2-trust-item:not(:last-child) {
      border-right: none;
      border-bottom: 1.5px solid #e2e8f0;
      padding-bottom: 16px;
    }
    .plan-v2-features li {
      justify-content: center;
      text-align: center;
    }
    .plan-v2-see-more {
      width: 100%;
      justify-content: center;
      display: flex;
    }

    .pricing-v2-trust{
      margin-top:10px;
    }
  }

  /* ── Mobile View Only: 2-Column Compact Pricing Cards + Features Popup ── */
  @media (max-width: 767.98px) {
    .pricing-v2-section .pricing-cards-row {
      display: grid !important;
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      gap: 10px !important;
      align-items: stretch !important;
      justify-items: stretch !important;
      flex-direction: initial !important;
      width: 100% !important;
    }

    .pricing-card-v2 .mobile-most-popular-callout,
    .pricing-card-v2 .mobile-most-people-choose-callout,
    .pricing-card-v2 .mobile-monthly-billing-callout {
      display: none !important;
    }

    .pricing-card-v2 {
      flex: none !important;
      width: 100% !important;
      max-width: 100% !important;
      min-width: 0 !important;
      height: 100% !important;
      margin-bottom: 6px !important;
      padding: 16px 10px 12px !important;
      border-radius: 14px !important;
      box-sizing: border-box !important;
    }

    .pricing-card-v2.card-recommended {
      transform: none !important;
    }

    .plan-top-badge {
      font-size: 9px !important;
      padding: 3px 10px !important;
      top: -11px !important;
      letter-spacing: 0.5px !important;
    }

    .plan-v2-title {
      font-size: 15px !important;
      margin: 2px 0 3px !important;
      line-height: 1.2 !important;
    }

    .plan-v2-subtitle {
      font-size: 10.5px !important;
      line-height: 1.3 !important;
      margin-bottom: 8px !important;
    }

    .plan-v2-price-block {
      margin-bottom: 2px !important;
    }

    .plan-v2-currency {
      font-size: 13px !important;
      margin-top: 3px !important;
    }

    .plan-v2-amount {
      font-size: 24px !important;
    }

    .card-enterprise .plan-v2-amount {
      font-size: 22px !important;
    }

    .plan-v2-period {
      font-size: 11px !important;
    }

    .plan-v2-billing-note {
      font-size: 10px !important;
      margin-bottom: 8px !important;
      padding: 0 !important;
    }

    .plan-terms-badge-group {
      margin-bottom: 8px !important;
      gap: 3px !important;
    }

    .plan-monthly-badge {
      font-size: 9.5px !important;
      padding: 2px 8px !important;
      margin-bottom: 0 !important;
    }

    .plan-yearly-free-badge {
      font-size: 9.5px !important;
      padding: 2px 8px !important;
    }

    .plan-v2-divider {
      margin: 0 0 8px !important;
    }

    .pricing-card-v2 .plan-v2-features {
      margin: 0 0 6px !important;
    }

    .pricing-card-v2 .plan-v2-features li {
      justify-content: flex-start !important;
      text-align: left !important;
      align-items: flex-start !important;
      gap: 5px !important;
      font-size: 11px !important;
      line-height: 1.3 !important;
      padding: 3px 0 !important;
      word-break: break-word !important;
    }

    .pricing-card-v2 .plan-v2-features li .fi-check,
    .pricing-card-v2 .plan-v2-features li .fi-times,
    .pricing-card-v2 .plan-v2-features li .fi-globe-premium {
      font-size: 11px !important;
      margin-top: 2px !important;
    }

    .pricing-card-v2 .plan-v2-features li.feat-free-domain-premium {
      background: #E8F5E9 !important;
      border-radius: 6px !important;
      padding: 3px 5px !important;
    }

    .plan-v2-extra-features,
    .plan-v2-extra-features.open {
      display: none !important;
    }

    .plan-v2-see-more {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: flex-start !important;
      width: 100% !important;
      padding: 4px 0 6px !important;
      margin-bottom: 8px !important;
      color: #16A34A !important;
      font-size: 11px !important;
      font-weight: 700 !important;
      text-align: left !important;
    }

    .plan-v2-plus-circle {
      width: 14px;
      height: 14px;
      background: #16A34A;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 7px;
      flex-shrink: 0;
      margin-left: 3px;
    }

    .plan-v2-btn {
      padding: 9px 6px !important;
      font-size: 11.5px !important;
      border-radius: 8px !important;
      line-height: 1.2 !important;
      white-space: nowrap !important;
    }

    .plan-v2-wa-btn {
      width: 36px !important;
      height: 36px !important;
      font-size: 16px !important;
      border-radius: 8px !important;
    }
  }

  /* ── Mobile Plan Features Popup Modal ── */
  .plan-feats-mobile-overlay {
    position: fixed;
    inset: 0;
    z-index: 1000010;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.2s ease, visibility 0.2s ease;
  }

  .plan-feats-mobile-overlay.open {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
  }

  .plan-feats-mobile-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
  }

  .plan-feats-mobile-box {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 360px;
    max-height: 86vh;
    overflow: visible;
    background: #ffffff;
    border-radius: 18px;
    padding: 24px 16px 16px;
    box-shadow: 0 22px 50px rgba(0, 0, 0, 0.28);
    border: 2.5px solid #ff5a2c;
    display: flex;
    flex-direction: column;
  }

  .plan-feats-mobile-box.tone-basic,
  .plan-feats-mobile-box.tone-enterprise {
    border-color: #0f172a;
    box-shadow: 0 22px 50px rgba(15, 23, 42, 0.30), 0 0 0 4px rgba(15, 23, 42, 0.12);
  }

  .plan-feats-mobile-box.tone-recommended {
    border-color: #ff5a2c;
    box-shadow: 0 22px 50px rgba(255, 90, 44, 0.30), 0 0 0 4px rgba(255, 90, 44, 0.16);
  }

  .plan-feats-mobile-box.tone-best-value {
    border-color: #f59e0b;
    box-shadow: 0 22px 50px rgba(245, 158, 11, 0.30), 0 0 0 4px rgba(245, 158, 11, 0.18);
  }

  .plan-feats-mobile-box.tone-best-value .plan-feats-mobile-cta {
    background: linear-gradient(135deg, #f59e0b, #ea580c);
    border-color: transparent;
    color: #ffffff;
  }

  .plan-feats-mobile-badge {
    position: absolute;
    top: -13px;
    left: 50%;
    transform: translateX(-50%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 16px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    color: #ffffff;
    white-space: nowrap;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
    background: linear-gradient(135deg, #ff6b35, #ff3b1f);
  }

  .plan-feats-mobile-badge.badge-basic {
    background: linear-gradient(135deg, #1e293b, #0f172a);
  }

  .plan-feats-mobile-badge.badge-recommended {
    background: linear-gradient(135deg, #ff6b35, #ff3b1f);
  }

  .plan-feats-mobile-badge.badge-best-value {
    background: linear-gradient(135deg, #fbbf24, #f97316);
  }

  .plan-feats-mobile-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: #ff5a2c;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    cursor: pointer;
  }

  .plan-feats-mobile-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 6px;
    padding-top: 6px;
    margin-bottom: 10px;
  }

  .plan-feats-mobile-title {
    margin: 0;
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
  }

  .plan-feats-mobile-price {
    display: inline-flex;
    align-items: baseline;
    justify-content: center;
    gap: 4px;
    font-size: 30px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
  }

  .plan-feats-mobile-amount {
    font-size: 30px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
  }

  .plan-feats-mobile-period {
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
  }

  .plan-feats-mobile-subtitle {
    font-size: 12px;
    font-weight: 700;
    color: #16a34a;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e2e8f0;
  }

  .plan-feats-mobile-list {
    margin: 0 0 14px !important;
    max-height: 46vh;
    overflow-y: auto;
    padding-right: 4px;
  }

  .plan-feats-mobile-list li {
    justify-content: flex-start !important;
    text-align: left !important;
    font-size: 13px !important;
    padding: 4px 0 !important;
  }

  .plan-feats-mobile-cta {
    background: #ff5a2c !important;
    color: #ffffff !important;
    border-color: #ff5a2c !important;
    padding: 10px 14px !important;
    font-size: 13.5px !important;
  }

  /* Change orange checkmark circles to green, keeping cancel marks red */
  .feat-check-circle:not(.times):not(.muted):not(.detail) {
    background: #10b981 !important;
    color: #ffffff !important;
    box-shadow: none !important;
  }

  /* Equal height of pricing cards on desktop */
  @media (min-width: 992px) {
    .pricing-card-v2.package-1, .pricing-card-v2.plan-basic {
      min-height: 670px;
    }
    .pricing-card-v2.package-2, .pricing-card-v2.plan-standard {
      min-height: 670px;
    }
    .pricing-card-v2.package-3, .pricing-card-v2.plan-premium {
      min-height: 670px;
    }
    .pricing-card-v2.package-enterprise, .pricing-card-v2.card-enterprise {
      min-height: 670px;
    }
  }

  /* Blinking animation for Hero Badge (#1 Ecommerce Builder For Sales & Growth) */
  .hero-badge {
    animation: heroBadgeBlink 1.5s ease-in-out infinite !important;
  }

  @keyframes heroBadgeBlink {
    0%, 100% {
      opacity: 1;
      border-color: rgba(255, 90, 44, 0.6);
      box-shadow: 0 0 0 0 rgba(255, 90, 44, 0.4);
      transform: scale(1);
    }
    50% {
      /* opacity: 0.4; */
      border-color: rgba(255, 90, 44, 1);
      box-shadow: 0 0 16px 4px rgba(255, 90, 44, 0.45);
      transform: scale(1.03);
    }
  /* Animated clicking hand icon */
  .animated-click-hand {
    display: inline-block !important;
    margin-left: 6px !important;
    font-size: 16px !important;
    animation: handClickPulse 1.2s cubic-bezier(0.25, 1, 0.5, 1) infinite !important;
    transform-origin: bottom right;
  }

  @keyframes handClickPulse {
    0%, 100% {
      transform: translate(0, 0) scale(1) rotate(0deg);
    }
    30% {
      transform: translate(-3px, -3px) scale(1.22) rotate(-12deg);
    }
    55% {
      transform: translate(1px, 1px) scale(0.88) rotate(6deg);
    }
    75% {
      transform: translate(-1px, -1px) scale(1.08) rotate(-4deg);
    }
  }
</style>
