/**
 * Hero Section Admin JavaScript
 * 
 * Handles the media uploader and form interactions for the hero section
 * meta box in the WordPress admin using vanilla JavaScript.
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initHeroSectionAdmin();
    });

    /**
     * Initialize hero section admin functionality
     */
    function initHeroSectionAdmin() {
        // Get all required elements
        const useMediaCheckbox = document.getElementById('hero_use_background_media');
        const mediaTypeSelect = document.getElementById('hero_media_type');
        const mediaTypeRow = document.getElementById('hero_media_type_row');
        const imageRow = document.getElementById('hero_background_image_row');
        const videoRow = document.getElementById('hero_background_video_row');
        
        const imageUploadBtn = document.getElementById('upload_hero_background_image');
        const imageRemoveBtn = document.getElementById('remove_hero_background_image');
        const imageInput = document.getElementById('hero_background_image');
        const imagePreview = document.getElementById('hero_background_image_preview');
        
        const videoUploadBtn = document.getElementById('upload_hero_background_video');
        const videoRemoveBtn = document.getElementById('remove_hero_background_video');
        const videoInput = document.getElementById('hero_background_video');
        const videoPreview = document.getElementById('hero_background_video_preview');

        // Check if elements exist
        if (!useMediaCheckbox || !mediaTypeSelect) {
            return; // Elements not found, probably not on the right page
        }

        // Initialize event listeners
        initMediaToggle();
        initMediaTypeSelector();
        initImageUpload();
        initVideoUpload();
        initColorSelectors();

        /**
         * Initialize media toggle functionality
         */
        function initMediaToggle() {
            useMediaCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    mediaTypeRow.style.display = 'table-row';
                    showCurrentMediaRow();
                } else {
                    mediaTypeRow.style.display = 'none';
                    imageRow.style.display = 'none';
                    videoRow.style.display = 'none';
                }
            });
        }

        /**
         * Initialize media type selector
         */
        function initMediaTypeSelector() {
            mediaTypeSelect.addEventListener('change', function() {
                showCurrentMediaRow();
            });
        }

        /**
         * Show the appropriate media row based on current selection
         */
        function showCurrentMediaRow() {
            if (!useMediaCheckbox.checked) {
                return;
            }

            const mediaType = mediaTypeSelect.value;
            
            if (mediaType === 'image') {
                imageRow.style.display = 'table-row';
                videoRow.style.display = 'none';
            } else if (mediaType === 'video') {
                imageRow.style.display = 'none';
                videoRow.style.display = 'table-row';
            }
        }

        /**
         * Initialize image upload functionality
         */
        function initImageUpload() {
            if (!imageUploadBtn || !imageRemoveBtn || !imageInput || !imagePreview) {
                return;
            }

            imageUploadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openMediaUploader('image', setBackgroundImage);
            });

            imageRemoveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                removeBackgroundImage();
            });
        }

        /**
         * Initialize video upload functionality
         */
        function initVideoUpload() {
            if (!videoUploadBtn || !videoRemoveBtn || !videoInput || !videoPreview) {
                return;
            }

            videoUploadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openMediaUploader('video', setBackgroundVideo);
            });

            videoRemoveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                removeBackgroundVideo();
            });
        }

        /**
         * Open WordPress media uploader
         * 
         * @param {string} type The media type ('image' or 'video')
         * @param {Function} callback Function to call when media is selected
         */
        function openMediaUploader(type, callback) {
            // Check if wp.media is available
            if (typeof wp === 'undefined' || !wp.media) {
                console.error('WordPress media uploader not available');
                return;
            }

            const mediaUploader = wp.media({
                title: type === 'image' ? 'Choose Hero Background Image' : 'Choose Hero Background Video',
                multiple: false,
                library: {
                    type: type
                }
            });

            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                callback(attachment.url);
            });

            mediaUploader.open();
        }

        /**
         * Set background image
         * 
         * @param {string} imageUrl The URL of the selected image
         */
        function setBackgroundImage(imageUrl) {
            imageInput.value = imageUrl;
            
            // Create preview image
            const img = document.createElement('img');
            img.src = imageUrl;
            img.style.maxWidth = '200px';
            img.style.height = 'auto';
            img.style.border = '1px solid #ddd';
            img.alt = 'Hero background image preview';
            
            // Clear existing preview and add new one
            imagePreview.innerHTML = '';
            imagePreview.appendChild(img);
            
            // Show remove button
            imageRemoveBtn.style.display = 'inline-block';
        }

        /**
         * Remove background image
         */
        function removeBackgroundImage() {
            imageInput.value = '';
            imagePreview.innerHTML = '';
            imageRemoveBtn.style.display = 'none';
        }

        /**
         * Set background video
         * 
         * @param {string} videoUrl The URL of the selected video
         */
        function setBackgroundVideo(videoUrl) {
            videoInput.value = videoUrl;
            
            // Create preview video
            const video = document.createElement('video');
            video.controls = true;
            video.style.maxWidth = '200px';
            video.style.height = 'auto';
            video.style.border = '1px solid #ddd';
            
            const source = document.createElement('source');
            source.src = videoUrl;
            source.type = 'video/mp4';
            
            video.appendChild(source);
            video.appendChild(document.createTextNode('Your browser does not support the video tag.'));
            
            // Clear existing preview and add new one
            videoPreview.innerHTML = '';
            videoPreview.appendChild(video);
            
            // Show remove button
            videoRemoveBtn.style.display = 'inline-block';
        }

        /**
         * Remove background video
         */
        function removeBackgroundVideo() {
            videoInput.value = '';
            videoPreview.innerHTML = '';
            videoRemoveBtn.style.display = 'none';
        }

        /**
         * Initialize color type selectors
         */
        function initColorSelectors() {
            const colorSelectors = document.querySelectorAll('.color-type-selector');
            
            colorSelectors.forEach(function(selector) {
                selector.addEventListener('change', function() {
                    const containerId = this.id.replace('_type', '_custom_color_container');
                    const container = document.getElementById(containerId);
                    
                    if (container) {
                        if (this.value === 'custom') {
                            container.style.display = 'block';
                        } else {
                            container.style.display = 'none';
                        }
                    }
                });
            });
        }
    }

})(); 