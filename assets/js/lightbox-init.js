/**
 * SimpleLightbox Initialization
 * 
 * Handles lightbox functionality for about section images
 * Uses SimpleLightbox library (WordPress compatible)
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize SimpleLightbox for about section images
    if (typeof SimpleLightbox !== 'undefined') {
        new SimpleLightbox('.about-image-gallery a', {
            // Lightbox options
            captions: true,
            captionSelector: 'img',
            captionType: 'attr',
            captionsData: 'alt',
            captionPosition: 'bottom',
            animationSpeed: 250,
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
            alertErrorMessage: 'Image not found, next image will be loaded'
        });
    } else {
        console.warn('SimpleLightbox not loaded. Image lightbox functionality will not work.');
    }
}); 