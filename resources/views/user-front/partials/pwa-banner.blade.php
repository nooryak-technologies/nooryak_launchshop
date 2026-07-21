<!-- PWA Sticky Bottom Install Banner – Always Visible -->
<div id="pwa-install-banner" class="pwa-install-banner-bar">
  <div style="display:flex;align-items:center;gap:14px;">
    <img src="{{ !empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : asset('assets/front/img/logo.png') }}"
         style="width:44px;height:44px;object-fit:contain;border-radius:10px;border:1px solid #e2e8f0;padding:2px;background:#fff;"
         alt="">
    <div>
      <div style="font-size:13px;font-weight:700;color:#0f172a;line-height:1.3;">
        Add {{ $userBs->website_title ?? ($user->shop_name ?? $user->username) }} to Home Screen
      </div>
      <div style="font-size:11px;color:#64748b;margin-top:1px;">
        Install for a faster app-like experience
      </div>
    </div>
  </div>
  <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
    <button id="pwa-install-btn" onclick="triggerPwaInstall()"
            style="background:#0f172a;color:#fff;border:none;border-radius:6px;padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;outline:none;white-space:nowrap;">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
        <polyline points="7 10 12 15 17 10"></polyline>
        <line x1="12" y1="15" x2="12" y2="3"></line>
      </svg>
      Install
    </button>
    <button onclick="dismissPwaBanner()"
            style="background:transparent;border:none;font-size:20px;color:#94a3b8;cursor:pointer;padding:2px 6px;line-height:1;">&times;</button>
  </div>
</div>

<style>
.pwa-install-banner-bar {
  position: fixed;
  bottom: 0; left: 0; right: 0;
  z-index: 999999;
  background: #ffffff;
  border-top: 2px solid #e2e8f0;
  box-shadow: 0 -4px 20px rgba(0,0,0,.12);
  padding: 10px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
</style>

<script>
  var deferredPwaPrompt = null;

  // Always capture beforeinstallprompt
  window.addEventListener('beforeinstallprompt', function(e) {
    e.preventDefault();
    deferredPwaPrompt = e;
  });

  window.addEventListener('appinstalled', function() {
    dismissPwaBanner();
  });

  function triggerPwaInstall() {
    if (deferredPwaPrompt) {
      // Native install dialog fires immediately
      deferredPwaPrompt.prompt();
      deferredPwaPrompt.userChoice.then(function(result) {
        deferredPwaPrompt = null;
        if (result.outcome === 'accepted') dismissPwaBanner();
      });
    } else {
      // Prompt not available yet – show install button in address bar hint
      var btn = document.getElementById('pwa-install-btn');
      var orig = btn.innerHTML;
      btn.innerHTML = '✓ Use browser menu → Install App';
      btn.style.fontSize = '11px';
      setTimeout(function() {
        btn.innerHTML = orig;
        btn.style.fontSize = '13px';
      }, 3000);
    }
  }

  function dismissPwaBanner() {
    var el = document.getElementById('pwa-install-banner');
    if (el) el.style.display = 'none';
  }

  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(function() {});
  }
</script>
