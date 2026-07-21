<!-- PWA Sticky Bottom Install Banner -->
<div id="pwa-install-banner" class="pwa-install-banner-bar">
  <div style="display: flex; align-items: center; gap: 14px;">
    <img src="{{ !empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : asset('assets/front/img/logo.png') }}"
         style="width: 46px; height: 46px; object-fit: contain; border-radius: 10px; border: 1px solid #f1f5f9; padding: 2px; background: #fff;"
         alt="App Logo">
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
    <button type="button" id="pwa-install-btn" onclick="triggerPwaInstall()"
            style="background: #0f172a; color: #ffffff; border: none; border-radius: 6px; padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; outline: none;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
        <polyline points="7 10 12 15 17 10"></polyline>
        <line x1="12" y1="15" x2="12" y2="3"></line>
      </svg>
      Install
    </button>
    <button type="button" onclick="dismissPwaBanner()"
            style="background: transparent; border: none; font-size: 22px; color: #94a3b8; cursor: pointer; padding: 0 4px; line-height: 1;"
            aria-label="Close">&times;</button>
  </div>
</div>

<style>
.pwa-install-banner-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 999999;
  background: #ffffff;
  border-top: 1px solid #e2e8f0;
  box-shadow: 0 -4px 20px rgba(0,0,0,0.10);
  padding: 12px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
</style>

<script>
  let deferredPwaPrompt = null;

  // Capture the install event as early as possible
  window.addEventListener('beforeinstallprompt', function(e) {
    e.preventDefault();
    deferredPwaPrompt = e;
    // Show the banner once the browser says it's installable
    var banner = document.getElementById('pwa-install-banner');
    if (banner) banner.style.display = 'flex';
  });

  // Hide banner if already installed
  window.addEventListener('appinstalled', function() {
    dismissPwaBanner();
  });

  function triggerPwaInstall() {
    if (deferredPwaPrompt) {
      // Directly trigger the native browser install dialog
      deferredPwaPrompt.prompt();
      deferredPwaPrompt.userChoice.then(function(result) {
        if (result.outcome === 'accepted') {
          dismissPwaBanner();
        }
        deferredPwaPrompt = null;
      });
    }
    // If no prompt available (already installed or not supported), do nothing
  }

  function dismissPwaBanner() {
    var banner = document.getElementById('pwa-install-banner');
    if (banner) banner.style.display = 'none';
    try { localStorage.setItem('pwa_dismissed', '1'); } catch(e) {}
  }

  // Register service worker for PWA installability
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(function() {});
  }
</script>
