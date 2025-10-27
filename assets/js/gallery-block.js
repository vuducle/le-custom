/**
 * Gallery Block with Lightbox and Lazy Loading
 * 
 * Handles gallery functionality including lightbox initialization
 * and integration with existing lazy loading system.
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initGalleryBlock();
    });

    /**
     * Initialize gallery block functionality
     */
    function initGalleryBlock() {
        // Initialize lightbox for galleries
        initLightbox();
        
        // Initialize lazy loading for gallery images
        initGalleryLazyLoading();
        
        // Add gallery-specific event listeners
        addGalleryEventListeners();
    }

    /**
     * Initialize SimpleLightbox for gallery images
     */
    function initLightbox() {
        if (typeof SimpleLightbox !== 'undefined') {
            // Initialize lightbox for gallery images
            new SimpleLightbox('.gallery-with-lightbox a[data-lightbox="gallery"]', {
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
                loop: true,
                rel: false,
                swipeClose: true,
                scrollZoom: true,
                scrollZoomFactor: 0.5,
                scrollZoomFactorBoost: 1.5,
                download: false,
                showCounter: true,
                alertError: true,
                alertErrorMessage: 'Image not found, next image will be loaded',
                
                // Custom gallery options
                gallery: '.gallery-with-lightbox',
                gallerySelector: 'a[data-lightbox="gallery"]',
                
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
                    addProfessionalLightboxStyling();
                },
                
                onClose: function(instance) {
                    // Remove custom class when lightbox is closed
                    document.body.classList.remove('lightbox-open');
                    
                    // Remove custom styling
                    removeProfessionalLightboxStyling();
                }
            });
        } else {
            console.warn('SimpleLightbox not loaded. Gallery lightbox functionality will not work.');
        }
    }

    /**
     * Add professional styling to lightbox
     */
    function addProfessionalLightboxStyling() {
        // Add custom CSS for professional lightbox styling
        const style = document.createElement('style');
        style.id = 'professional-lightbox-styles';
        style.textContent = `
            .sl-overlay {
                background: linear-gradient(135deg, rgba(30, 64, 175, 0.95) 0%, rgba(59, 130, 246, 0.9) 100%) !important;
                backdrop-filter: blur(8px);
            }
            
            .sl-wrapper .sl-image {
                border-radius: 12px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
            
            .sl-wrapper .sl-caption {
                background: rgba(255, 255, 255, 0.95);
                color: #1e40af;
                font-weight: 500;
                border-radius: 8px;
                padding: 12px 20px;
                margin-top: 16px;
                backdrop-filter: blur(4px);
                border: 1px solid rgba(59, 130, 246, 0.2);
            }
            
            .sl-wrapper .sl-counter {
                background: rgba(255, 255, 255, 0.95);
                color: #1e40af;
                font-weight: 600;
                border-radius: 20px;
                padding: 8px 16px;
                backdrop-filter: blur(4px);
                border: 1px solid rgba(59, 130, 246, 0.2);
            }
            
            .sl-wrapper .sl-close,
            .sl-wrapper .sl-prev,
            .sl-wrapper .sl-next {
                background: rgba(255, 255, 255, 0.95);
                color: #1e40af;
                border-radius: 50%;
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(4px);
                border: 1px solid rgba(59, 130, 246, 0.2);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .sl-wrapper .sl-close:hover,
            .sl-wrapper .sl-prev:hover,
            .sl-wrapper .sl-next:hover {
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
     * Remove professional styling from lightbox
     */
    function removeProfessionalLightboxStyling() {
        const style = document.getElementById('professional-lightbox-styles');
        if (style) {
            style.remove();
        }
    }

    /**
     * Initialize lazy loading for gallery images
     */
    function initGalleryLazyLoading() {
        // Check if Intersection Observer is supported
        if ('IntersectionObserver' in window) {
            const galleryImageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        loadGalleryImage(img);
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px', // Start loading 50px before image enters viewport
                threshold: 0.01
            });

            // Observe all gallery lazy images
            const galleryLazyImages = document.querySelectorAll('.gallery-with-lightbox .lazy-image');
            galleryLazyImages.forEach(img => galleryImageObserver.observe(img));
        } else {
            // Fallback for older browsers
            loadGalleryImagesFallback();
        }
    }

    /**
     * Load individual gallery image
     * 
     * @param {HTMLElement} img The image element to load
     */
    function loadGalleryImage(img) {
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
                const event = new CustomEvent('galleryImageLoaded', {
                    detail: { image: img }
                });
                document.dispatchEvent(event);
            };
            
            tempImage.onerror = function() {
                // Handle loading errors
                img.classList.add('lazy-error');
                console.warn('Failed to load gallery image:', img.dataset.src);
            };
            
            tempImage.src = img.dataset.src;
        }
    }

    /**
     * Fallback lazy loading for older browsers
     */
    function loadGalleryImagesFallback() {
        let galleryLazyImages = [];
        let galleryLazyImageObserver;

        function loadGalleryImageFallback(img) {
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.classList.remove('lazy-image');
                img.classList.add('lazy-loaded');
                
                // Remove from lazy images array
                const index = galleryLazyImages.indexOf(img);
                if (index > -1) {
                    galleryLazyImages.splice(index, 1);
                }
            }
        }

        function lazyLoadGallery() {
            if (galleryLazyImageObserver) return;
            
            galleryLazyImageObserver = setInterval(() => {
                const scrollTop = window.pageYOffset;
                const windowHeight = window.innerHeight;
                
                galleryLazyImages.forEach((img, index) => {
                    const rect = img.getBoundingClientRect();
                    const imgTop = rect.top + scrollTop;
                    
                    if (scrollTop + windowHeight > imgTop) {
                        loadGalleryImageFallback(img);
                    }
                });
                
                // Clear interval if no more images to load
                if (galleryLazyImages.length === 0) {
                    clearInterval(galleryLazyImageObserver);
                    galleryLazyImageObserver = null;
                }
            }, 100);
        }

        // Initialize fallback lazy loading
        galleryLazyImages = [].slice.call(document.querySelectorAll('.gallery-with-lightbox .lazy-image'));
        
        if (galleryLazyImages.length > 0) {
            lazyLoadGallery();
            
            // Re-check on scroll
            window.addEventListener('scroll', lazyLoadGallery);
            window.addEventListener('resize', lazyLoadGallery);
        }
    }

    /**
     * Add gallery-specific event listeners
     */
    function addGalleryEventListeners() {
        // Handle gallery image click events
        document.addEventListener('click', function(e) {
            const galleryImage = e.target.closest('.gallery-with-lightbox img');
            if (galleryImage) {
                // Add loading state
                galleryImage.classList.add('gallery-image-clicked');
                
                // Remove loading state after a short delay
                setTimeout(() => {
                    galleryImage.classList.remove('gallery-image-clicked');
                }, 200);
            }
        });

        // Handle keyboard navigation in lightbox
        document.addEventListener('keydown', function(e) {
            if (document.body.classList.contains('lightbox-open')) {
                // Prevent page scroll when lightbox is open
                if (e.key === 'ArrowLeft' || e.key === 'ArrowRight' || e.key === 'Escape') {
                    e.preventDefault();
                }
            }
        });

        // Handle gallery image load events
        document.addEventListener('galleryImageLoaded', function(e) {
            const img = e.detail.image;
            
            // Add fade-in animation
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.3s ease-in-out';
            
            setTimeout(() => {
                img.style.opacity = '1';
            }, 50);
        });
    }

    /**
     * Public API for external use
     */
    window.LeCustomGallery = {
        init: initGalleryBlock,
        reloadLightbox: initLightbox,
        reloadLazyLoading: initGalleryLazyLoading
    };

})(); 