<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ !empty($storeName) ? $storeName . ' - ' : '' }}{{ __('We are working on it') }}</title>
  @if(!empty($favicon))
    <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">
  @else
    <link rel="shortcut icon" href="{{ asset('assets/front/img/favicon.png') }}" type="image/x-icon">
  @endif
  <style>
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
      color: #1e293b;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 24px;
      line-height: 1.5;
    }
    .error-guard-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 48px 40px;
      max-width: 620px;
      width: 100%;
      text-align: center;
      box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.05);
      position: relative;
      overflow: hidden;
    }
    .error-guard-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #ff5a2c, #f59e0b, #10b981);
    }
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #fef3c7;
      color: #b45309;
      font-size: 13px;
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 9999px;
      margin-bottom: 24px;
      letter-spacing: 0.3px;
    }
    .status-dot {
      width: 8px;
      height: 8px;
      background: #f59e0b;
      border-radius: 50%;
      box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
      }
      70% {
        transform: scale(1);
        box-shadow: 0 0 0 8px rgba(245, 158, 11, 0);
      }
      100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
      }
    }
    .illustration-wrap {
      width: 110px;
      height: 110px;
      margin: 0 auto 24px;
      background: #fff7ed;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ff5a2c;
    }
    .illustration-wrap svg {
      width: 60px;
      height: 60px;
      animation: gentle-spin 12s linear infinite;
    }
    @keyframes gentle-spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    h1.error-title {
      font-size: 28px;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 12px;
      letter-spacing: -0.5px;
    }
    p.error-desc {
      font-size: 16px;
      color: #64748b;
      margin-bottom: 32px;
      max-width: 480px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.6;
    }
    .btn-group-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      justify-content: center;
    }
    .guard-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 13px 26px;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
      border: 1px solid transparent;
    }
    .guard-btn-primary {
      background: #ff5a2c;
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(255, 90, 44, 0.25);
    }
    .guard-btn-primary:hover {
      background: #e0481d;
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(255, 90, 44, 0.35);
      color: #ffffff;
    }
    .guard-btn-secondary {
      background: #f1f5f9;
      color: #334155;
      border-color: #e2e8f0;
    }
    .guard-btn-secondary:hover {
      background: #e2e8f0;
      color: #0f172a;
    }
    .guard-footer-note {
      margin-top: 32px;
      font-size: 13px;
      color: #94a3b8;
    }

    /* Developer Debug Accordion (Visible only in debug mode) */
    .debug-box {
      margin-top: 28px;
      text-align: left;
      border: 1px solid #fed7aa;
      background: #fffaf5;
      border-radius: 12px;
      padding: 16px 20px;
      font-size: 13px;
    }
    .debug-header {
      font-weight: 700;
      color: #c2410c;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      user-select: none;
    }
    .debug-content {
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px dashed #fed7aa;
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
      color: #431407;
      max-height: 250px;
      overflow-y: auto;
      white-space: pre-wrap;
      word-break: break-all;
    }
    @media (max-width: 576px) {
      .error-guard-card {
        padding: 36px 20px;
      }
      h1.error-title {
        font-size: 23px;
      }
      p.error-desc {
        font-size: 14px;
      }
      .guard-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="error-guard-card">
    <div class="status-badge">
      <span class="status-dot"></span>
      <span>{{ __('We are working on it') }} &bull; {{ __('Please wait') }}</span>
    </div>

    <div class="illustration-wrap">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="3"></circle>
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
      </svg>
    </div>

    <h1 class="error-title">
      {{ !empty($storeName) ? $storeName . ': ' : '' }}{{ __('We Are Working on It!') }}
    </h1>

    <p class="error-desc">
      {{ __('We are currently experiencing a temporary technical issue on this page. Our team has been automatically alerted and is resolving it. Please check back in a few moments.') }}
    </p>

    <div class="btn-group-actions">
      <button type="button" onclick="window.location.reload();" class="guard-btn guard-btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="23 4 23 10 17 10"></polyline>
          <polyline points="1 20 1 14 7 14"></polyline>
          <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
        </svg>
        <span>{{ __('Refresh Page') }}</span>
      </button>

      <a href="{{ $homeUrl ?? url('/') }}" class="guard-btn guard-btn-secondary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
          <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <span>{{ __('Back to Homepage') }}</span>
      </a>
    </div>

    @if(config('app.debug') && !empty($exception))
      <div class="debug-box">
        <div class="debug-header" onclick="document.getElementById('debugTrace').style.display = document.getElementById('debugTrace').style.display === 'none' ? 'block' : 'none';">
          <span>&#9888; Developer Diagnostic (Visible because APP_DEBUG=true)</span>
          <span style="font-size:11px;">[Toggle Details]</span>
        </div>
        <div id="debugTrace" class="debug-content" style="display:none;">
<strong>Error:</strong> {{ get_class($exception) }}
<strong>Message:</strong> {{ $exception->getMessage() }}
<strong>File:</strong> {{ $exception->getFile() }}:{{ $exception->getLine() }}

<strong>Stack Trace:</strong>
{{ $exception->getTraceAsString() }}
        </div>
      </div>
    @endif

    <div class="guard-footer-note">
      <span>&copy; {{ date('Y') }} {{ !empty($storeName) ? $storeName : config('app.name', 'LaunchShop') }}. All rights reserved.</span>
    </div>
  </div>

</body>
</html>
