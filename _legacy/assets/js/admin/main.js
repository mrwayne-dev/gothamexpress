/**
 * TruePath Express - Admin Dashboard JS
 * Vanilla JS - No jQuery dependency
 */

(function () {
    'use strict';

    // --- Preloader ---
    var preloader = document.getElementById('preloader');
    if (preloader) {
        window.addEventListener('load', function () {
            preloader.classList.add('hidden');
            setTimeout(function () { preloader.remove(); }, 400);
        });
    }

    // --- Sidebar Toggle (mobile) ---
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var menuBtn = document.getElementById('mobileMenuBtn');
    var closeBtn = document.getElementById('sidebarClose');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('open');
        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (menuBtn) menuBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // --- User Dropdown ---
    var dropdownBtn = document.getElementById('userDropdownBtn');
    var dropdown = document.getElementById('userDropdown');

    if (dropdownBtn && dropdown) {
        dropdownBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        document.addEventListener('click', function () {
            dropdown.classList.remove('open');
        });

        dropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    // --- Logout ---
    function doLogout() {
        if (confirm('Log out?')) {
            fetch('/api/auth/logout.php')
                .then(function () {
                    window.location.href = '/admin.auth.login';
                })
                .catch(function () {
                    window.location.href = '/admin.auth.login';
                });
        }
    }

    var logoutBtn = document.getElementById('logoutBtn');
    var dropdownLogout = document.getElementById('dropdownLogout');

    if (logoutBtn) logoutBtn.addEventListener('click', doLogout);
    if (dropdownLogout) {
        dropdownLogout.addEventListener('click', function (e) {
            e.preventDefault();
            doLogout();
        });
    }

    // --- Toast Notifications ---
    window.adminToast = function (msg, type) {
        type = type || 'info';
        var container = document.getElementById('toastContainer');
        if (!container) return;

        var toast = document.createElement('div');
        toast.className = 'toast ' + type;

        var iconMap = { success: 'check-circle', error: 'x-circle', info: 'info' };
        toast.innerHTML = '<i class="ph-bold ph-' + (iconMap[type] || 'info') + '"></i>' + msg;

        container.appendChild(toast);
        requestAnimationFrame(function () { toast.classList.add('show'); });

        setTimeout(function () {
            toast.classList.remove('show');
            setTimeout(function () { toast.remove(); }, 300);
        }, 4000);
    };

})();
