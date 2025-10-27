/**
 * Single Image Block with Lightbox and Lazy Loading
 * 
 * Handles single image functionality including lightbox initialization
 * and integration with existing lazy loading system.
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initSingleImageBlock();
    });

    /**
     * Initialize single image block functionality
     */
    function initSingleImageBlock() {
        // Initialize lightbox for single images
        initSingleImageLightbox();
        
        // Initialize lazy loading for single images
        initSingleImageLazyLoading();
        
        // Add single image specific event listeners
        addSingleImageEventListeners();
    }

    /**
     * Initialize SimpleLightbox for single images
     */
    function initSingleImageLightbox() {
        if (typeof SimpleLightbox !== 'undefined') {
            // Initialize lightbox for single images
            new SimpleLightbox('.single-image-with-lightbox a[data-lightbox="single-image"]', {
                // Lightbox options
                captions: true,
                captionSelector: 'img',
                captionType: 'attr',
                captionsData: 'alt',
                captionPosition: 'bottom',
                animationSpeed: 300,
                animationSlide: true,
                preloading: true,
                enableKeyboard: true,
                loop: false, // Single image doesn't need loop
                rel: false,
                swipeClose: true,
                scrollZoom: true,
                scrollZoomFactor: 0.5,
                scrollZoomFactorBoost: 1.5,
                download: false,
                showCounter: false, // Single image doesn't need counter
                alertError: true,
                alertErrorMessage: 'Image not found',
                
                // Professional styling options
                overlayColor: 'rgba(30, 64, 175, 0.95)',
                overlayOpacity: 0.95,
                spinner: 'spinner',
                spinnerColor: '#3b82f6',
                spinnerSize: '40px',
                
                // Callbacks
                onShow: function(instance) {
                    // Add custom class to body when lightbox is open
                    document.body.classList.add('lightbox-open');
                    
                    // Add professional styling to lightbox
                    addProfessionalSingleImageLightboxStyling();
                },
                
                onClose: function(instance) {
                    // Remove custom class when lightbox is closed
                    document.body.classList.remove('lightbox-open');
                    
                    // Remove custom styling
                    removeProfessionalSingleImageLightboxStyling();
                }
            });
        } else {
            console.warn('SimpleLightbox not loaded. Single image lightbox functionality will not work.');
        }
    }

    /**
     * Add professional styling to single image lightbox
     */
    function addProfessionalSingleImageLightboxStyling() {
        // Add custom CSS for professional lightbox styling
        const style = document.createElement('style');
        style.id = 'professional-single-image-lightbox-styles';
        style.textContent = `
            .sl-overlay {
                background: linear-gradient(135deg, rgba(30, 64, 175, 0.95) 0%, rgba(59, 130, 246, 0.9) 100%) !important;
                backdrop-filter: blur(8px);
            }
            
            .sl-wrapper .sl-image {
                border-radius: 16px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                max-width: 90vw;
                max-height: 90vh;
            }
            
            .sl-wrapper .sl-caption {
                background: rgba(255, 255, 255, 0.95);
                color: #1e40af;
                font-weight: 500;
                border-radius: 12px;
                padding: 16px 24px;
                margin-top: 20px;
                backdrop-filter: blur(4px);
                border: 1px solid rgba(59, 130, 246, 0.2);
                font-size: 1rem;
                line-height: 1.5;
            }
            
            .sl-wrapper .sl-close {
                background: rgba(255, 255, 255, 0.95);
                color: #1e40af;
                border-radius: 50%;
                width: 56px;
                height: 56px;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(4px);
                border: 1px solid rgba(59, 130, 246, 0.2);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-size: 1.5rem;
                font-weight: 600;
            }
            
            .sl-wrapper .sl-close:hover {
                background: rgba(59, 130, 246, 0.1);
                transform: scale(1.1);
            }
            
            .sl-wrapper .sl-spinner {
                border: 3px solid rgba(59, 130, 246, 0.2);
                border-top: 3px solid #3b82f6;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Remove professional styling from single image lightbox
     */
    function removeProfessionalSingleImageLightboxStyling() {
        const style = document.getElementById('professional-single-image-lightbox-styles');
        if (style) {
            style.remove();
        }
    }

    /**
     * Initialize lazy loading for single images
     */
    function initSingleImageLazyLoading() {
        // Check if Intersection Observer is supported
        if ('IntersectionObserver' in window) {
            const singleImageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        loadSingleImage(img);
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px', // Start loading 50px before image enters viewport
                threshold: 0.01
            });

            // Observe all single image lazy images
            const singleLazyImages = document.querySelectorAll('.single-image-with-lightbox .lazy-image');
            singleLazyImages.forEach(img => singleImageObserver.observe(img));
        } else {
            // Fallback for older browsers
            loadSingleImagesFallback();
        }
    }

    /**
     * Load individual single image
     * 
     * @param {HTMLElement} img The image element to load
     */
    function loadSingleImage(img) {
        if (img.dataset.src) {
            // Create a new image to preload
            const tempImage = new Image();
            
            tempImage.onload = function() {
                img.src = img.dataset.src;
                img.classList.remove('lazy-image');
                img.classList.add('lazy-loaded');
                
                // Update lightbox link href if it exists
                const lightboxLink = img.closest('a[data-lightbox]');
                if (lightboxLink) {
                    lightboxLink.href = img.dataset.src;
                }
                
                // Trigger custom event for other scripts
                const event = new CustomEvent('singleImageLoaded', {
                    detail: { image: img }
                });
                document.dispatchEvent(event);
            };
            
            tempImage.onerror = function() {
                // Handle loading errors
                img.classList.add('lazy-error');
                console.warn('Failed to load single image:', img.dataset.src);
            };
            
            tempImage.src = img.dataset.src;
        }
    }

    /**
     * Fallback lazy loading for older browsers
     */
    function loadSingleImagesFallback() {
        let singleLazyImages = [];
        let singleLazyImageObserver;

        function loadSingleImageFallback(img) {
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.classList.remove('lazy-image');
                img.classList.add('lazy-loaded');
                
                // Remove from lazy images array
                const index = singleLazyImages.indexOf(img);
                if (index > -1) {
                    singleLazyImages.splice(index, 1);
                }
            }
        }

        function lazyLoadSingleImage() {
            if (singleLazyImageObserver) return;
            
            singleLazyImageObserver = setInterval(() => {
                const scrollTop = window.pageYOffset;
                const windowHeight = window.innerHeight;
                
                singleLazyImages.forEach((img, index) => {
                    const rect = img.getBoundingClientRect();
                    const imgTop = rect.top + scrollTop;
                    
                    if (scrollTop + windowHeight > imgTop) {
                        loadSingleImageFallback(img);
                    }
                });
                
                // Clear interval if no more images to load
                if (singleLazyImages.length === 0) {
                    clearInterval(singleLazyImageObserver);
                    singleLazyImageObserver = null;
                }
            }, 100);
        }

        // Initialize fallback lazy loading
        singleLazyImages = [].slice.call(document.querySelectorAll('.single-image-with-lightbox .lazy-image'));
        
        if (singleLazyImages.length > 0) {
            lazyLoadSingleImage();
            
            // Re-check on scroll
            window.addEventListener('scroll', lazyLoadSingleImage);
            window.addEventListener('resize', lazyLoadSingleImage);
        }
    }

    /**
     * Add single image specific event listeners
     */
    function addSingleImageEventListeners() {
        // Handle single image click events
        document.addEventListener('click', function(e) {
            const singleImage = e.target.closest('.single-image-with-lightbox img');
            if (singleImage) {
                // Add loading state
                singleImage.classList.add('single-image-clicked');
                
                // Remove loading state after a short delay
                setTimeout(() => {
                    singleImage.classList.remove('single-image-clicked');
                }, 200);
            }
        });

        // Handle keyboard navigation in lightbox
        document.addEventListener('keydown', function(e) {
            if (document.body.classList.contains('lightbox-open')) {
                // Prevent page scroll when lightbox is open
                if (e.key === 'Escape') {
                    e.preventDefault();
                }
            }
        });

        // Handle single image load events
        document.addEventListener('singleImageLoaded', function(e) {
            const img = e.detail.image;
            
            // Add fade-in animation
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            
            setTimeout(() => {
                img.style.opacity = '1';
            }, 50);
        });

        // Add hover effects for single images
        document.addEventListener('mouseenter', function(e) {
            const singleImageContainer = e.target.closest('.single-image-with-lightbox');
            if (singleImageContainer) {
                singleImageContainer.classList.add('single-image-hover');
            }
        });

        document.addEventListener('mouseleave', function(e) {
            const singleImageContainer = e.target.closest('.single-image-with-lightbox');
            if (singleImageContainer) {
                singleImageContainer.classList.remove('single-image-hover');
            }
        });
    }

    /**
     * Public API for external use
     */
    window.LeCustomSingleImage = {
        init: initSingleImageBlock,
        reloadLightbox: initSingleImageLightbox,
        reloadLazyLoading: initSingleImageLazyLoading
    };

})(); 