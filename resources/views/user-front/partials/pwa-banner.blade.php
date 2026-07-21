<!-- PWA Bottom Sticky Install Banner -->
<div id="pwa-install-banner" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; z-index: 999999; background: #ffffff; border-top: 1px solid #e2e8f0; box-shadow: 0 -4px 25px rgba(0,0,0,0.12); padding: 12px 24px; align-items: center; justify-content: space-between; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
  <div style="display: flex; align-items: center; gap: 14px;">
    <img src="{{ !empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : asset('assets/front/images/placeholder.png') }}" style="width: 46px; height: 46px; object-fit: contain; border-radius: 10px; border: 1px solid #f1f5f9; padding: 2px; background: #fff;" alt="App Logo">
    <div>
      <div style="font-size: 14px; font-weight: 700; color: #0f172a; line-height: 1.2;">
        Add {{ $userBs->website_title ?? ($user->shop_name ?? $user->username) }} to Home Screen
      </div>
      <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
        Install for a faster app-like experience
      </div>
    </div>
  </div>

  <div style="display: flex; align-items: center; gap: 10px;">
    <button type="button" onclick="triggerPwaInstall()" style="background: #0f172a; color: #ffffff; border: none; border-radius: 6px; padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s; outline: none;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
        <polyline points="7 10 12 15 17 10"></polyline>
        <line x1="12" y1="15" x2="12" y2="3"></line>
      </svg>
      Install
    </button>
    <button type="button" onclick="dismissPwaBanner()" style="background: transparent; border: none; font-size: 22px; color: #94a3b8; cursor: pointer; padding: 0 4px; line-height: 1;" aria-label="Close">
      &times;
    </button>
  </div>
</div>

<!-- Dynamic PWA Installation Script -->
<script>
  let deferredPwaPrompt = null;

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPwaPrompt = e;
    const banner = document.getElementById('pwa-install-banner');
    if (banner && !localStorage.getItem('pwa_banner_dismissed')) {
      banner.style.display = 'flex';
    }
  });

  function triggerPwaInstall() {
    if (deferredPwaPrompt) {
      deferredPwaPrompt.prompt();
      deferredPwaPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          dismissPwaBanner();
        }
        deferredPwaPrompt = null;
      });
    } else {
      const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
      if (isIOS) {
        alert('To install this App on iOS:\n1. Tap the Share button at the bottom of Safari.\n2. Scroll down and select "Add to Home Screen".');
      } else {
        alert('To install this App:\n1. Tap your browser menu (3 dots at top right).\n2. Select "Add to Home Screen" or "Install App".');
      }
    }
  }

  function dismissPwaBanner() {
    const banner = document.getElementById('pwa-install-banner');
    if (banner) banner.style.display = 'none';
    localStorage.setItem('pwa_banner_dismissed', 'true');
  }

  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(function() {});
  }
</script>
