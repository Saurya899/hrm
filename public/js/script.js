document.addEventListener('DOMContentLoaded', () => {
    // 1. Page Loader Fade Out
    const loader = document.getElementById('page-loader');
    if (loader) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('fade-out');
            }, 300);
        });
        // Fallback in case load event already fired
        setTimeout(() => {
            loader.classList.add('fade-out');
        }, 800);
    }

    // 2. Theme Management (Dark / Light Mode)
    const savedTheme = localStorage.getItem('hms-theme') || 'dark';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('hms-theme', newTheme);
            updateThemeIcon(newTheme);
            showToast('Theme Changed', `Switched to ${newTheme.toUpperCase()} mode.`, 'info');
        });
    }

    function updateThemeIcon(theme) {
        const themeIcon = document.querySelector('#theme-toggle i');
        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-sun-fill';
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill';
            }
        }
    }

    // 3. Sidebar Collapse & Expand
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mainWrapper = document.querySelector('.main-wrapper');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            // Mobile check
            if (window.innerWidth < 992) {
                sidebar.classList.toggle('mobile-show');
            } else {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
            }
        });
    }

    // Restore sidebar state for desktop
    const sidebarState = localStorage.getItem('sidebar-collapsed');
    if (sidebarState === 'true' && window.innerWidth >= 992 && sidebar) {
        sidebar.classList.add('collapsed');
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('mobile-show')) {
            if (!sidebar.contains(e.target) && sidebarToggle && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('mobile-show');
            }
        }
    });

    // 4. Sidebar Nested Submenu Logic
    const submenuTriggers = document.querySelectorAll('.menu-item-link.has-submenu');
    submenuTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const parentLi = trigger.parentElement;

            // Close other open submenus if sidebar is collapsed/expanded
            const openSubmenus = document.querySelectorAll('.sidebar-menu .menu-item.open');
            openSubmenus.forEach(item => {
                if (item !== parentLi) {
                    item.classList.remove('open');
                }
            });

            parentLi.classList.toggle('open');
        });
    });

    // 5. Simulated Skeleton Loader Toggle
    const skeletons = document.querySelectorAll('.skeleton-wrapper');
    const realContent = document.querySelectorAll('.real-content-wrapper');

    if (skeletons.length > 0 && realContent.length > 0) {
        setTimeout(() => {
            skeletons.forEach(s => s.classList.add('d-none'));
            realContent.forEach(rc => rc.classList.remove('d-none'));
        }, 1200); // Transitions to real content after 1.2s
    }

    // 6. Dynamic Notification System (Toast Notifications)
    window.showToast = function (title, message, type = 'primary') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast-glass';

        let iconClass = 'bi bi-info-circle-fill text-primary';
        if (type === 'success') iconClass = 'bi bi-check-circle-fill text-success';
        if (type === 'warning') iconClass = 'bi bi-exclamation-triangle-fill text-warning';
        if (type === 'danger') iconClass = 'bi bi-x-circle-fill text-danger';

        toast.innerHTML = `
            <i class="${iconClass}" style="font-size: 1.25rem;"></i>
            <div style="flex-grow: 1;">
                <div style="font-weight: 600; font-size: 0.9rem;">${title}</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);">${message}</div>
            </div>
            <button type="button" class="btn-close btn-close-white" style="font-size: 0.75rem; margin-left: auto;" onclick="this.parentElement.remove()"></button>
        `;

        container.appendChild(toast);

        // Trigger transition
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 400);
        }, 4000);
    }
});