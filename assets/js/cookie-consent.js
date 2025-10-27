/**
 * Cookie Consent JavaScript
 * 
 * Modern, accessible, and performant cookie consent management
 * with ES6+ syntax and comprehensive error handling.
 * 
 * Features:
 * - GDPR compliant consent management
 * - Accessibility (WCAG 2.1 AA)
 * - Performance optimized
 * - Mobile responsive
 * - Keyboard navigation support
 * - Focus management
 * - Error handling and logging
 * 
 * @version 1.0.0
 */

(function() {
    'use strict';

    // Global namespace for cookie consent
    window.LE_Cookie_Consent = window.LE_Cookie_Consent || {};

    /**
     * Cookie Consent Manager Class
     */
    class CookieConsentManager {
        constructor() {
            this.overlay = null;
            this.isVisible = false;
            this.isLoading = false;
            this.focusableElements = [];
            this.previousActiveElement = null;
            this.settings = window.leCookieConsent?.settings || {};
            this.translations = window.leCookieConsent?.translations || {};
            
            this.init();
        }

        /**
         * Initialize the cookie consent manager
         */
        init() {
            try {
                this.overlay = document.getElementById('cookie-consent-overlay');
                
                if (!this.overlay) {
                    console.warn('Cookie consent overlay not found');
                    return;
                }

                this.setupEventListeners();
                this.showOverlay();
                
            } catch (error) {
                console.error('Error initializing cookie consent:', error);
            }
        }

        /**
         * Setup event listeners
         */
        setupEventListeners() {
            // Close button
            const closeBtn = this.overlay.querySelector('.cookie-consent-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => this.close());
            }

            // Button actions
            const acceptAllBtn = this.overlay.querySelector('[onclick*="acceptAll"]');
            const acceptSelectedBtn = this.overlay.querySelector('[onclick*="acceptSelected"]');
            const rejectAllBtn = this.overlay.querySelector('[onclick*="rejectAll"]');

            if (acceptAllBtn) {
                acceptAllBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.acceptAll();
                });
            }

            if (acceptSelectedBtn) {
                acceptSelectedBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.acceptSelected();
                });
            }

            if (rejectAllBtn) {
                rejectAllBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.rejectAll();
                });
            }

            // Keyboard navigation
            this.overlay.addEventListener('keydown', (e) => this.handleKeydown(e));

            // Focus trap
            this.overlay.addEventListener('focusin', (e) => this.handleFocusIn(e));
            this.overlay.addEventListener('focusout', (e) => this.handleFocusOut(e));

            // Prevent clicks outside from closing (for center position)
            if (this.settings.position === 'center') {
                this.overlay.addEventListener('click', (e) => {
                    if (e.target === this.overlay) {
                        e.stopPropagation();
                    }
                });
            }
        }

        /**
         * Show the cookie consent overlay
         */
        showOverlay() {
            if (this.isVisible || this.isLoading) {
                return;
            }

            try {
                // Store current active element for focus restoration
                this.previousActiveElement = document.activeElement;

                // Get focusable elements
                this.focusableElements = this.getFocusableElements();

                // Show overlay with animation
                this.overlay.classList.add('show');
                this.isVisible = true;

                // Focus management
                this.trapFocus();

                // Announce to screen readers
                this.announceToScreenReader(this.translations.title || 'Cookie Consent');

                // Add loading state if needed
                if (this.settings.animation === false) {
                    this.overlay.setAttribute('data-animation', 'false');
                }

            } catch (error) {
                console.error('Error showing cookie consent overlay:', error);
            }
        }

        /**
         * Hide the cookie consent overlay
         */
        hideOverlay() {
            if (!this.isVisible) {
                return;
            }

            try {
                this.overlay.classList.remove('show');
                this.isVisible = false;

                // Restore focus
                if (this.previousActiveElement && this.previousActiveElement.focus) {
                    this.previousActiveElement.focus();
                }

                // Remove loading state
                this.overlay.classList.remove('cookie-consent-loading');
                this.isLoading = false;

            } catch (error) {
                console.error('Error hiding cookie consent overlay:', error);
            }
        }

        /**
         * Accept all cookies
         */
        async acceptAll() {
            try {
                this.setLoadingState(true);

                const consentData = {
                    necessary: true
                };

                await this.saveConsent(consentData);
                this.hideOverlay();

            } catch (error) {
                console.error('Error accepting all cookies:', error);
                this.setLoadingState(false);
            }
        }

        /**
         * Accept selected cookies (same as accept all since only necessary cookies)
         */
        async acceptSelected() {
            this.acceptAll();
        }

        /**
         * Reject all cookies (same as accept all since only necessary cookies)
         */
        async rejectAll() {
            this.acceptAll();
        }

        /**
         * Close the overlay without saving
         */
        close() {
            // For GDPR compliance, we should still save a "reject all" consent
            // when the user closes without making a choice
            this.rejectAll();
        }

        /**
         * Get checkbox value
         */
        getCheckboxValue(id) {
            const checkbox = document.getElementById(id);
            return checkbox ? checkbox.checked : false;
        }

        /**
         * Save consent via AJAX
         */
        async saveConsent(consentData) {
            if (!window.leCookieConsent?.ajaxUrl) {
                throw new Error('AJAX URL not configured');
            }

            const formData = new FormData();
            formData.append('action', 'cookie_consent_save');
            formData.append('nonce', window.leCookieConsent.nonce || '');

            const response = await fetch(window.leCookieConsent.ajaxUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.data?.message || 'Failed to save consent');
            }

            // Set cookie locally as well
            this.setCookieLocally(consentData);

            // Trigger consent events
            this.triggerConsentEvents(consentData);

            return result;
        }

        /**
         * Set cookie locally
         */
        setCookieLocally(consentData) {
            const cookieData = {
                consent_given: true,
                timestamp: Math.floor(Date.now() / 1000),
                necessary: true,
                version: '1.0'
            };

            const cookieValue = JSON.stringify(cookieData);
            const expires = new Date(Date.now() + (this.settings.cookieExpiry * 1000));

            document.cookie = `${this.settings.cookieName}=${encodeURIComponent(cookieValue)}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
        }

        /**
         * Trigger consent events
         */
        triggerConsentEvents(consentData) {
            // Custom event for other scripts to listen to
            const event = new CustomEvent('cookieConsentChanged', {
                detail: {
                    consent: { necessary: true },
                    timestamp: Date.now()
                }
            });

            document.dispatchEvent(event);

            // Update body classes
            document.body.classList.remove('cookie-consent-pending');
            document.body.classList.add('cookie-consent-given');
        }

        /**
         * Set loading state
         */
        setLoadingState(loading) {
            this.isLoading = loading;
            
            if (loading) {
                this.overlay.classList.add('cookie-consent-loading');
            } else {
                this.overlay.classList.remove('cookie-consent-loading');
            }
        }

        /**
         * Get focusable elements within the overlay
         */
        getFocusableElements() {
            const focusableSelectors = [
                'button:not([disabled])',
                'input:not([disabled])',
                'select:not([disabled])',
                'textarea:not([disabled])',
                'a[href]',
                '[tabindex]:not([tabindex="-1"])'
            ];

            return Array.from(this.overlay.querySelectorAll(focusableSelectors.join(', ')))
                .filter(el => !el.disabled && el.offsetParent !== null);
        }

        /**
         * Trap focus within the overlay
         */
        trapFocus() {
            if (this.focusableElements.length === 0) {
                return;
            }

            // Focus first element
            this.focusableElements[0].focus();
        }

        /**
         * Handle focus in
         */
        handleFocusIn(event) {
            // Keep track of focus for trap
            if (!this.focusableElements.includes(event.target)) {
                this.focusableElements = this.getFocusableElements();
            }
        }

        /**
         * Handle focus out
         */
        handleFocusOut(event) {
            // If focus leaves the overlay, trap it back
            setTimeout(() => {
                if (!this.overlay.contains(document.activeElement)) {
                    this.trapFocus();
                }
            }, 10);
        }

        /**
         * Handle keyboard navigation
         */
        handleKeydown(event) {
            switch (event.key) {
                case 'Escape':
                    event.preventDefault();
                    this.close();
                    break;
                    
                case 'Tab':
                    this.handleTabKey(event);
                    break;
            }
        }

        /**
         * Handle tab key for focus trap
         */
        handleTabKey(event) {
            if (this.focusableElements.length === 0) {
                return;
            }

            const firstElement = this.focusableElements[0];
            const lastElement = this.focusableElements[this.focusableElements.length - 1];

            if (event.shiftKey) {
                // Shift + Tab
                if (document.activeElement === firstElement) {
                    event.preventDefault();
                    lastElement.focus();
                }
            } else {
                // Tab
                if (document.activeElement === lastElement) {
                    event.preventDefault();
                    firstElement.focus();
                }
            }
        }

        /**
         * Announce to screen readers
         */
        announceToScreenReader(message) {
            // Create or update live region
            let liveRegion = document.getElementById('cookie-consent-live-region');
            
            if (!liveRegion) {
                liveRegion = document.createElement('div');
                liveRegion.id = 'cookie-consent-live-region';
                liveRegion.className = 'cookie-consent-sr-only';
                liveRegion.setAttribute('aria-live', 'polite');
                liveRegion.setAttribute('aria-atomic', 'true');
                document.body.appendChild(liveRegion);
            }

            liveRegion.textContent = message;
        }

        /**
         * Check if consent is given
         */
        static hasConsent(type = 'all') {
            const cookie = document.cookie
                .split('; ')
                .find(row => row.startsWith(`${window.leCookieConsent?.settings?.cookieName || 'cookie_consent_julia_nguyen'}=`));

            if (!cookie) {
                return false;
            }

            try {
                const consentData = JSON.parse(decodeURIComponent(cookie.split('=')[1]));
                
                if (type === 'all') {
                    return consentData.consent_given || false;
                }
                
                // Only necessary cookies are supported
                if (type === 'necessary') {
                    return consentData.necessary || false;
                }
                
                return false;
            } catch (error) {
                console.error('Error parsing consent cookie:', error);
                return false;
            }
        }

        /**
         * Get consent data
         */
        static getConsentData() {
            const cookie = document.cookie
                .split('; ')
                .find(row => row.startsWith(`${window.leCookieConsent?.settings?.cookieName || 'cookie_consent_julia_nguyen'}=`));

            if (!cookie) {
                return null;
            }

            try {
                return JSON.parse(decodeURIComponent(cookie.split('=')[1]));
            } catch (error) {
                console.error('Error parsing consent cookie:', error);
                return null;
            }
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            new CookieConsentManager();
        });
    } else {
        new CookieConsentManager();
    }

    // Expose static methods globally
    window.LE_Cookie_Consent.acceptAll = function() {
        const manager = document.querySelector('#cookie-consent-overlay')?.__cookieManager;
        if (manager) {
            manager.acceptAll();
        }
    };

    window.LE_Cookie_Consent.acceptSelected = function() {
        const manager = document.querySelector('#cookie-consent-overlay')?.__cookieManager;
        if (manager) {
            manager.acceptSelected();
        }
    };

    window.LE_Cookie_Consent.rejectAll = function() {
        const manager = document.querySelector('#cookie-consent-overlay')?.__cookieManager;
        if (manager) {
            manager.rejectAll();
        }
    };

    window.LE_Cookie_Consent.close = function() {
        const manager = document.querySelector('#cookie-consent-overlay')?.__cookieManager;
        if (manager) {
            manager.close();
        }
    };

    window.LE_Cookie_Consent.hasConsent = CookieConsentManager.hasConsent;
    window.LE_Cookie_Consent.getConsentData = CookieConsentManager.getConsentData;

})(); 