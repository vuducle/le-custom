# SimpleLightbox Integration

This theme includes SimpleLightbox for image lightbox functionality in the about section.

## Current Setup

SimpleLightbox is loaded from CDN and is fully compatible with WordPress. The files are loaded in `inc/about-section.php`:

- **CSS**: `https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css`
- **JS**: `https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js`

## Local Files Setup (Alternative)

**Note**: PhotoSwipe 5.3.8 only provides ES6 modules, not UMD files. For local files, you would need to:

1. **Download PhotoSwipe files**:

   ```bash
   # Create directory
   mkdir -p assets/vendor/photoswipe

   # Download files
   curl -L -o assets/vendor/photoswipe/photoswipe.css https://cdn.jsdelivr.net/npm/photoswipe@5.3.8/dist/photoswipe.css
   curl -L -o assets/vendor/photoswipe/photoswipe.esm.js https://cdn.jsdelivr.net/npm/photoswipe@5.3.8/dist/photoswipe.esm.js
   curl -L -o assets/vendor/photoswipe/photoswipe-lightbox.esm.js https://cdn.jsdelivr.net/npm/photoswipe@5.3.8/dist/photoswipe-lightbox.esm.js
   ```

2. **Update the enqueue function** in `inc/about-section.php`:

   ```php
   // PhotoSwipe CSS
   wp_enqueue_style(
       'photoswipe',
       get_template_directory_uri() . '/assets/vendor/photoswipe/photoswipe.css',
       [],
       '5.3.8'
   );

   // PhotoSwipe JS (ES6 module)
   wp_enqueue_script(
       'photoswipe',
       get_template_directory_uri() . '/assets/vendor/photoswipe/photoswipe.esm.js',
       [],
       '5.3.8',
       true
   );
   wp_script_add_data('photoswipe', 'type', 'module');

   // PhotoSwipe Lightbox JS (ES6 module)
   wp_enqueue_script(
       'photoswipe-lightbox',
       get_template_directory_uri() . '/assets/vendor/photoswipe/photoswipe-lightbox.esm.js',
       ['photoswipe'],
       '5.3.8',
       true
   );
   wp_script_add_data('photoswipe-lightbox', 'type', 'module');
   ```

3. **Update the initialization file** to use local imports:

   ```javascript
   // In assets/js/photoswipe-init.js
   import PhotoSwipe from "/assets/vendor/photoswipe/photoswipe.esm.js";
   import PhotoSwipeLightbox from "/assets/vendor/photoswipe/photoswipe-lightbox.esm.js";
   ```

## Usage

SimpleLightbox is automatically initialized for images in the about section. Images with the class `.about-image-gallery` will open in a lightbox when clicked.

### HTML Structure

```html
<div class="about-image-gallery">
  <a href="large-image.jpg">
    <img src="thumbnail-image.jpg" alt="Description" />
  </a>
</div>
```

### Required Attributes

- `href`: URL of the large image
- `alt`: Alt text for the image (used as caption)

## SimpleLightbox Features

SimpleLightbox provides:

- Touch/swipe support for mobile devices
- Keyboard navigation (arrow keys, ESC)
- Image captions from alt text
- Smooth animations
- Zoom functionality
- Counter display
- No additional HTML required

## Customization

To customize SimpleLightbox behavior, edit `assets/js/lightbox-init.js`.

## Troubleshooting

If SimpleLightbox doesn't work:

1. Check browser console for errors
2. Verify SimpleLightbox files are loading (Network tab)
3. Ensure images have the correct class and structure
4. Check if the `.about-image-gallery` class is present
