<!-- PWA Bottom Sticky Install Banner -->
<div id="pwa-install-banner" class="pwa-install-banner-bar" style="display: none;">
  <div style="display: flex; align-items: center; gap: 14px;">
    <img src="{{ !empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : asset('assets/front/img/logo.png') }}" style="width: 46px; height: 46px; object-fit: contain; border-radius: 10px; border: 1px solid #f1f5f9; padding: 2px; background: #fff;" alt="App Logo">
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

<!-- Custom PWA Install Modal -->
<div id="pwa-install-modal" class="pwa-modal-overlay" style="display: none;">
  <div class="pwa-modal-box">
    <div class="pwa-modal-header">
      <img src="{{ !empty($userBs->logo) ? asset('assets/front/img/user/' . $userBs->logo) : asset('assets/front/img/logo.png') }}" class="pwa-modal-icon" alt="Logo">
      <div>
        <h5 class="pwa-modal-title">Install {{ $userBs->website_title ?? ($user->shop_name ?? $user->username) }} App</h5>
        <p class="pwa-modal-sub">Fast, lightweight & works offline</p>
      </div>
    </div>

    <div class="pwa-modal-body">
      <div class="pwa-step-item">
        <div class="pwa-step-badge">1</div>
        <div>Tap the browser menu <strong>(⋮ or Share)</strong></div>
      </div>
      <div class="pwa-step-item">
        <div class="pwa-step-badge">2</div>
        <div>Select <strong>"Add to Home Screen"</strong> or <strong>"Install App"</strong></div>
      </div>
    </div>

    <div class="pwa-modal-footer">
      <button type="button" onclick="closePwaModal()" class="btn-pwa-cancel">Got it</button>
      <button type="button" onclick="executePwaInstall()" class="btn-pwa-action">
        <i class="fas fa-download me-1"></i> Install Now
      </button>
    </div>
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
  box-shadow: 0 -4px 25px rgba(0,0,0,0.12);
  padding: 12px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
.pwa-modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(15, 23, 42, 0.65);
  backdrop-filter: blur(4px);
  z-index: 9999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.pwa-modal-box {
  background: #ffffff;
  border-radius: 16px;
  max-width: 420px;
  width: 100%;
  padding: 24px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.2);
  animation: pwaSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  text-align: left;
}
@keyframes pwaSlideUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
.pwa-modal-header {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 20px;
}
.pwa-modal-icon {
  width: 52px;
  height: 52px;
  object-fit: contain;
  border-radius: 12px;
  border: 1px solid #f1f5f9;
  padding: 4px;
  background: #fff;
}
.pwa-modal-title {
  font-size: 16px;
  font-weight: 700;
  color: #0f172a;
  margin: 0;
}
.pwa-modal-sub {
  font-size: 13px;
  color: #64748b;
  margin: 2px 0 0 0;
}
.pwa-step-item {
  display: flex;
  align-items: center;
  gap: 12px;
  background: #f8fafc;
  border: 1px solid #f1f5f9;
  padding: 12px 16px;
  border-radius: 10px;
  margin-bottom: 10px;
  font-size: 13px;
  color: #334155;
}
.pwa-step-badge {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #0f172a;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 12px;
  flex-shrink: 0;
}
.pwa-modal-footer {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}
.btn-pwa-cancel {
  flex: 1;
  background: #f1f5f9;
  color: #475569;
  border: none;
  padding: 10px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
}
.btn-pwa-action {
  flex: 2;
  background: #0f172a;
  color: #ffffff;
  border: none;
  padding: 10px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
}
</style>

<!-- Dynamic PWA Installation Script -->
<script>
  let deferredPwaPrompt = null;

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPwaPrompt = e;
  });

  document.addEventListener('DOMContentLoaded', function() {
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
      openPwaModal();
    }
  }

  function executePwaInstall() {
    if (deferredPwaPrompt) {
      deferredPwaPrompt.prompt();
      deferredPwaPrompt = null;
      closePwaModal();
    } else {
      closePwaModal();
    }
  }

  function openPwaModal() {
    const modal = document.getElementById('pwa-install-modal');
    if (modal) modal.style.display = 'flex';
  }

  function closePwaModal() {
    const modal = document.getElementById('pwa-install-modal');
    if (modal) modal.style.display = 'none';
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
