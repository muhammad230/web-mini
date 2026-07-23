(function() {
  var STORAGE_KEY = 'fixly-theme';

  function getPreferredTheme() {
    var stored = localStorage.getItem(STORAGE_KEY);
    if (stored === 'dark' || stored === 'light') return stored;
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) return 'dark';
    return 'light';
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(STORAGE_KEY, theme);
    var toggles = document.querySelectorAll('.theme-toggle-btn');
    toggles.forEach(function(btn) {
      btn.innerHTML = theme === 'dark'
        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>'
        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>';
    });
  }

  function toggleTheme() {
    var current = document.documentElement.getAttribute('data-theme') || 'light';
    var next = current === 'dark' ? 'light' : 'dark';

    document.documentElement.classList.add('theme-transitioning');
    applyTheme(next);
    var toggles = document.querySelectorAll('.theme-toggle-btn');
    toggles.forEach(function(btn) {
      btn.classList.remove('theme-toggle-spin');
      void btn.offsetWidth;
      btn.classList.add('theme-toggle-spin');
      setTimeout(function() {
        btn.classList.remove('theme-toggle-spin');
      }, 450);
    });
    setTimeout(function() {
      document.documentElement.classList.remove('theme-transitioning');
    }, 400);
  }

  applyTheme(getPreferredTheme());

  window.themeToggle = toggleTheme;

  // Admin Responsive Sidebar Helpers
  function initAdminSidebar() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');

    if (!sidebar) return;

    if (!overlay) {
      overlay = document.createElement('div');
      overlay.id = 'sidebarOverlay';
      overlay.className = 'sidebar-overlay';
      document.body.appendChild(overlay);
    }
    overlay.onclick = closeMobileSidebar;

    var links = sidebar.querySelectorAll('a, button');
    links.forEach(function(link) {
      link.addEventListener('click', function() {
        if (window.innerWidth < 1024) {
          closeMobileSidebar();
        }
      });
    });
  }

  function toggleMobileSidebar(e) {
    if (e) e.stopPropagation();
    var sb = document.getElementById('sidebar');
    if (!sb) return;
    var isOpen = sb.classList.contains('mobile-open');
    if (isOpen) {
      closeMobileSidebar();
    } else {
      openMobileSidebar();
    }
  }

  function openMobileSidebar() {
    var sb = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    if (sb) {
      sb.classList.add('mobile-open');
    }
    if (overlay) overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileSidebar() {
    var sb = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    if (sb) {
      sb.classList.remove('mobile-open');
    }
    if (overlay) overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  window.toggleMobileSidebar = toggleMobileSidebar;
  window.closeMobileSidebar = closeMobileSidebar;

  // Desktop sidebar collapse (preserves existing behavior)
  window.toggleSidebar = function() {
    var sb = document.getElementById('sidebar');
    var main = document.getElementById('main');
    if (window.innerWidth >= 1024) {
      if (sb) sb.classList.toggle('collapsed');
      if (main) main.classList.toggle('expanded');
    }
  };

  // Close sidebar on Escape
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeMobileSidebar();
    }
  });

  // Auto-close sidebar drawer on resize to desktop
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) {
      closeMobileSidebar();
    }
  });

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminSidebar);
  } else {
    initAdminSidebar();
  }
})();
