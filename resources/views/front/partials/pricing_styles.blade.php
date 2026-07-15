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
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #e6faf2;
    color: #059669;
    font-size: 13px;
    font-weight: 700;
    padding: 7px 18px;
    border-radius: 30px;
    margin-bottom: 20px;
    border: 1.5px solid #a7f3d0;
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
    width: 210px;
    background: #fff5f2;
    border: 1px solid #ffd5c8;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 4px 12px rgba(255,90,44,0.05);
    z-index: 10;
    text-align: left;
  }
  .callout-icon-wrap {
    background: #ff5a2c;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
  }
  .callout-title {
    font-size: 13px;
    font-weight: 700;
    margin: 0 0 4px 0;
    color: #0f172a;
  }
  .callout-desc {
    font-size: 11px;
    margin: 0;
    color: #475569;
    line-height: 1.4;
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
      position: relative;
      left: auto;
      top: auto;
      margin: 0 auto 24px;
      width: 100%;
      max-width: 280px;
    }
    .monthly-billing-callout .callout-arrow {
      display: none !important;
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
  }
</style>
