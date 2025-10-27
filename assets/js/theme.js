/**
 * LE Custom Theme JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100,
            delay: 0
        });
    }
    // Mobile menu functionality
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuContent = document.getElementById('mobile-menu-content');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    
    function openMobileMenu() {
        if (mobileMenu && mobileMenuContent) {
            mobileMenu.classList.remove('hidden');
            // Trigger reflow to ensure transition works
            mobileMenuContent.offsetHeight;
            mobileMenuContent.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeMobileMenu() {
        if (mobileMenu && mobileMenuContent) {
            mobileMenuContent.classList.add('translate-x-full');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }
    }
    
    // Open mobile menu
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', openMobileMenu);
    }
    
    // Close mobile menu
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }
    
    // Close on backdrop click
    if (mobileMenuBackdrop) {
        mobileMenuBackdrop.addEventListener('click', closeMobileMenu);
    }
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });
    
    // Prevent mobile menu from closing when clicking on links within items that have children
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu .has-children > div > a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't prevent default - let the link work normally
            // But prevent the mobile menu from closing
            e.stopPropagation();
        });
    });

    // Function to add event listeners to submenu items
    function addSubmenuItemListeners() {
        const mobileSubmenuItems = document.querySelectorAll('.mobile-menu ul ul a');
        mobileSubmenuItems.forEach(item => {
            // Remove existing listeners to prevent duplicates
            item.removeEventListener('click', preventBubbling);
            // Add new listener
            item.addEventListener('click', preventBubbling);
        });
    }
    
    function preventBubbling(e) {
        e.stopPropagation(); // Prevent event bubbling to parent elements
    }

    // Prevent mobile menu from closing when clicking on submenu items
    addSubmenuItemListeners();

    // Desktop dropdown hover functionality with improved animations
    const desktopMenuItems = document.querySelectorAll('.lg\\:flex .has-children');
    desktopMenuItems.forEach(item => {
        const submenu = item.querySelector('ul');
        
        if (submenu) {
            // Show submenu on hover
            item.addEventListener('mouseenter', function() {
                submenu.style.opacity = '1';
                submenu.style.visibility = 'visible';
                submenu.style.transform = 'translateY(0)';
            });
            
            // Hide submenu when mouse leaves
            item.addEventListener('mouseleave', function() {
                submenu.style.opacity = '0';
                submenu.style.visibility = 'hidden';
                submenu.style.transform = 'translateY(2px)';
            });
        }
    });
    
    // Add active state styling for current page
    const currentMenuItem = document.querySelector('.current-menu-item');
    if (currentMenuItem) {
        const link = currentMenuItem.querySelector('a');
        if (link) {
            link.classList.add('text-blue-600', 'bg-blue-50');
        }
    }
    
    // Smooth scrolling for internal anchor links only
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only handle simple anchor links (just #id, not URLs with #)
            if (href && href.startsWith('#') && href.length > 1 && !href.includes('://')) {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = this.querySelector('input[type="submit"], button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Loading...';
            }
        });
    });
    
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => imageObserver.observe(img));
    }
    
    // Add scroll to top functionality with modern styling
    const scrollToTopButton = document.createElement('button');
    scrollToTopButton.innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    `;
    scrollToTopButton.className = 'fixed bottom-4 right-4 md:bottom-8 md:right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 opacity-0 pointer-events-none z-50 hover:scale-110';
    scrollToTopButton.id = 'scroll-to-top';
    document.body.appendChild(scrollToTopButton);
    
    // Show/hide scroll to top button
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopButton.classList.remove('opacity-0', 'pointer-events-none');
        } else {
            scrollToTopButton.classList.add('opacity-0', 'pointer-events-none');
        }
    });
    
    // Scroll to top functionality
    scrollToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Add header scroll effect
    const header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 50) {
                header.classList.add('shadow-md');
                header.classList.remove('shadow-sm');
            } else {
                header.classList.remove('shadow-md');
                header.classList.add('shadow-sm');
            }
        });
    }

    // Detect current language
    function getCurrentLanguage() {
        // Check if we're on a German or English page
        const currentUrl = window.location.pathname;
        const currentPage = document.querySelector('body');
        
        // Check for German indicators
        if (currentUrl.includes('-de') || 
            currentUrl.includes('/de/') || 
            currentPage.classList.contains('page-contact-de') ||
            currentPage.classList.contains('page-landing-de')) {
            return 'de';
        }
        
        // Check for English indicators
        if (currentUrl.includes('-en') || 
            currentUrl.includes('/en/') || 
            currentPage.classList.contains('page-contact-en') ||
            currentPage.classList.contains('page-landing-en')) {
            return 'en';
        }
        
        // Default to German
        return 'de';
    }
    
    // Notification messages in both languages
    const notificationMessages = {
        de: {
            success: 'Nachricht erfolgreich gesendet!',
            error: 'Fehler beim Senden der Nachricht. Bitte versuchen Sie es erneut.',
            validation: 'Bitte füllen Sie alle erforderlichen Felder aus.',
            sending: 'Wird gesendet...',
            close: 'Schließen'
        },
        en: {
            success: 'Message sent successfully!',
            error: 'Error sending message. Please try again.',
            validation: 'Please fill in all required fields.',
            sending: 'Sending...',
            close: 'Close'
        }
    };
    
    // Notification system
    function showNotification(message, type = 'success', duration = 5000) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification-bar');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification-bar fixed top-4 right-4 z-50 max-w-md w-full transform transition-all duration-300 ease-in-out translate-x-full`;
        
        // Set background and text colors based on type
        let bgColor, textColor, iconColor, icon;
        
        switch (type) {
            case 'success':
                bgColor = 'bg-green-50';
                textColor = 'text-green-800';
                iconColor = 'text-green-400';
                icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>`;
                break;
            case 'error':
                bgColor = 'bg-red-50';
                textColor = 'text-red-800';
                iconColor = 'text-red-400';
                icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>`;
                break;
            case 'warning':
                bgColor = 'bg-yellow-50';
                textColor = 'text-yellow-800';
                iconColor = 'text-yellow-400';
                icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>`;
                break;
            default:
                bgColor = 'bg-blue-50';
                textColor = 'text-blue-800';
                iconColor = 'text-blue-400';
                icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>`;
        }
        
        const currentLang = getCurrentLanguage();
        const closeText = notificationMessages[currentLang].close;
        
        notification.innerHTML = `
            <div class="${bgColor} border border-gray-200 rounded-lg shadow-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="${iconColor}">${icon}</div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="${textColor} text-sm font-medium">${message}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <button type="button" class="notification-close ${textColor} hover:${textColor.replace('text-', 'bg-').replace('-800', '-100')} rounded-md inline-flex focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-${bgColor.replace('bg-', '')} focus:ring-${textColor.replace('text-', '')}">
                            <span class="sr-only">${closeText}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto-remove after duration
        const autoRemove = setTimeout(() => {
            hideNotification(notification);
        }, duration);
        
        // Close button functionality
        const closeButton = notification.querySelector('.notification-close');
        closeButton.addEventListener('click', () => {
            clearTimeout(autoRemove);
            hideNotification(notification);
        });
        
        return notification;
    }
    
    function hideNotification(notification) {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
    
    // Contact form functionality
    const contactFormDE = document.getElementById('contact-form-de');
    const contactFormEN = document.getElementById('contact-form-en');
    
    function handleContactForm(form) {
        if (!form) return;
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Validate form
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                const currentLang = getCurrentLanguage();
                showNotification(notificationMessages[currentLang].validation, 'warning');
                return;
            }
            
            // Show loading state
            submitButton.disabled = true;
            const currentLang = getCurrentLanguage();
            submitButton.innerHTML = `
                <span class="flex items-center justify-center space-x-2">
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>${notificationMessages[currentLang].sending}</span>
                </span>
            `;
            
            // Prepare form data for AJAX
            const formData = new FormData(this);
            formData.append('action', 'contact_form_submit');
            formData.append('nonce', leCustomContact?.nonce || '');
            
            // Send AJAX request
            fetch(leCustomContact?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const currentLang = getCurrentLanguage();
                    submitButton.innerHTML = `
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>${notificationMessages[currentLang].success}</span>
                        </span>
                    `;
                    submitButton.classList.remove('bg-gradient-to-r', 'from-emerald-500', 'to-emerald-600', 'hover:from-emerald-600', 'hover:to-emerald-700');
                    submitButton.classList.add('bg-green-600', 'hover:bg-green-700');
                    
                    // Reset form
                    this.reset();
                    
                    // Show success notification
                    showNotification(data.data.message || notificationMessages[currentLang].success, 'success');
                    
                    // Reset button after 3 seconds
                    setTimeout(() => {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                        submitButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                        submitButton.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-emerald-600', 'hover:from-emerald-600', 'hover:to-emerald-700');
                    }, 3000);
                } else {
                    // Show error notification
                    const currentLang = getCurrentLanguage();
                    showNotification(data.data.message || notificationMessages[currentLang].error, 'error');
                    
                    // Reset button
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Contact form error:', error);
                const currentLang = getCurrentLanguage();
                showNotification(notificationMessages[currentLang].error, 'error');
                
                // Reset button
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        });
    }
    
    // Initialize contact forms
    handleContactForm(contactFormDE);
    handleContactForm(contactFormEN);
}); 