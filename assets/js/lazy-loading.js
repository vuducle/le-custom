/**
 * Lazy Loading Implementation
 * 
 * Uses Intersection Observer API for efficient image lazy loading
 * with fallback for older browsers
 */

(function() {
    'use strict';

    // Check if Intersection Observer is supported
    if ('IntersectionObserver' in window) {
        // Modern browsers - use Intersection Observer
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    loadImage(img);
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px', // Start loading 50px before image enters viewport
            threshold: 0.01
        });

        // Observe all lazy images
        document.addEventListener('DOMContentLoaded', function() {
            const lazyImages = document.querySelectorAll('.lazy-image');
            lazyImages.forEach(img => imageObserver.observe(img));
        });

    } else {
        // Fallback for older browsers - use scroll event
        let lazyImages = [];
        let lazyImageObserver;

        function loadImage(img) {
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.classList.remove('lazy-image');
                img.classList.add('lazy-loaded');
                
                // Remove from lazy images array
                const index = lazyImages.indexOf(img);
                if (index > -1) {
                    lazyImages.splice(index, 1);
                }
            }
        }

        function lazyLoad() {
            if (lazyImageObserver) return;
            
            lazyImageObserver = setInterval(() => {
                const scrollTop = window.pageYOffset;
                const windowHeight = window.innerHeight;
                
                lazyImages.forEach((img, index) => {
                    const rect = img.getBoundingClientRect();
                    const imgTop = rect.top + scrollTop;
                    
                    if (scrollTop + windowHeight > imgTop) {
                        loadImage(img);
                    }
                });
                
                // Clear interval if no more images to load
                if (lazyImages.length === 0) {
                    clearInterval(lazyImageObserver);
                    lazyImageObserver = null;
                }
            }, 100);
        }

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            lazyImages = [].slice.call(document.querySelectorAll('.lazy-image'));
            
            if (lazyImages.length > 0) {
                lazyLoad();
                
                // Re-check on scroll
                window.addEventListener('scroll', lazyLoad);
                window.addEventListener('resize', lazyLoad);
            }
        });
    }

    // Load image function for modern browsers
    function loadImage(img) {
        if (img.dataset.src) {
            // Create a new image to preload
            const tempImage = new Image();
            
            tempImage.onload = function() {
                img.src = img.dataset.src;
                img.classList.remove('lazy-image');
                img.classList.add('lazy-loaded');
                
                // Trigger custom event for other scripts
                const event = new CustomEvent('imageLoaded', {
                    detail: { image: img }
                });
                document.dispatchEvent(event);
            };
            
            tempImage.onerror = function() {
                // Handle loading errors
                img.classList.add('lazy-error');
                console.warn('Failed to load image:', img.dataset.src);
            };
            
            tempImage.src = img.dataset.src;
        }
    }

    // Add loading animation
    function addLoadingAnimation() {
        const style = document.createElement('style');
        style.textContent = `
            .lazy-image {
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
            }
            
            .lazy-loaded {
                opacity: 1;
                animation: none;
                background: none;
            }
            
            .lazy-error {
                opacity: 0.5;
                background: #f8f8f8;
                border: 1px solid #ddd;
            }
            
            @keyframes loading {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }
        `;
        document.head.appendChild(style);
    }

    // Initialize loading animation
    addLoadingAnimation();

})(); 