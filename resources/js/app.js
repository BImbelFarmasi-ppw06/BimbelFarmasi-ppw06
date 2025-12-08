import './bootstrap';

/**
 * Keyboard Navigation & Accessibility Enhancements
 */

// Mobile menu toggle with keyboard support
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        // Click handler
        mobileMenuButton.addEventListener('click', () => {
            toggleMenu();
        });

        // Keyboard handler (Enter & Space)
        mobileMenuButton.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleMenu();
            }
        });

        function toggleMenu() {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
            
            // Focus first menu item when opening
            if (!isExpanded) {
                const firstMenuItem = mobileMenu.querySelector('a, button');
                firstMenuItem?.focus();
            }
        }

        // Close menu on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileMenuButton.getAttribute('aria-expanded') === 'true') {
                toggleMenu();
                mobileMenuButton.focus();
            }
        });
    }

    // Smooth scroll for anchor links with keyboard support
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            smoothScrollToTarget(this, e);
        });

        // Keyboard support
        anchor.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                smoothScrollToTarget(this, e);
            }
        });
    });

    function smoothScrollToTarget(element, event) {
        const href = element.getAttribute('href');
        if (href === '#') return;
        
        const target = document.querySelector(href);
        if (target) {
            event.preventDefault();
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Set focus to target for screen readers
            target.setAttribute('tabindex', '-1');
            target.focus();
        }
    }

    // Skip to main content link
    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.textContent = 'Skip to main content';
    skipLink.className = 'sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-blue-600 focus:text-white focus:rounded';
    document.body.insertBefore(skipLink, document.body.firstChild);

    // Focus visible indicator for keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-nav');
        }
    });

    document.addEventListener('mousedown', () => {
        document.body.classList.remove('keyboard-nav');
    });

    // Announce dynamic content changes to screen readers
    window.announceToScreenReader = (message, politeness = 'polite') => {
        const announcement = document.createElement('div');
        announcement.setAttribute('role', 'status');
        announcement.setAttribute('aria-live', politeness);
        announcement.setAttribute('aria-atomic', 'true');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        
        // Remove after announcement
        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    };
});
});
