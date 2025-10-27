# Professional Gallery Block for Dental Practices

This theme includes a custom gallery block specifically designed for dental practices, providing a modern, professional gallery with lightbox functionality and lazy loading for optimal performance. Perfect for showcasing treatment results, before & after photos, and practice facilities.

## Features

### 🖼️ **Responsive Gallery Grid**

- Automatic responsive grid layout
- Configurable number of columns (1-6)
- Adjustable gap between images
- Mobile-optimized design

### 🔍 **Lightbox Functionality**

- Click any image to open in lightbox
- Keyboard navigation (arrow keys, escape)
- Touch/swipe support for mobile devices
- Image captions and counter
- Smooth animations and transitions

### ⚡ **Lazy Loading**

- Images load only when they enter the viewport
- Reduces initial page load time
- Smooth loading animations
- Fallback support for older browsers

### 🎨 **Professional Dental Design**

- Medical-grade professional styling
- Smooth transitions and animations
- Dental practice color scheme (blues and whites)
- Accessibility features for all patients
- Trust-building visual elements

## How to Use

### 1. **Adding a Gallery Block**

#### Method 1: Block Editor (Recommended)

1. Open the WordPress block editor
2. Click the "+" button to add a new block
3. Search for "Professional Gallery"
4. Select the block to add it to your page

#### Method 2: Block Pattern

1. In the block editor, click the "+" button
2. Go to the "Patterns" tab
3. Look for "Professional Gallery" in the "LE Custom Blocks" category
4. Click to insert the pattern

### 2. **Configuring Your Gallery**

Once you've added the gallery block, you can configure it using the block settings panel:

#### **Basic Settings**

- **Gallery Title**: Add a title above your gallery
- **Columns**: Choose how many columns to display (1-6)
- **Gap**: Set the spacing between images (Small, Medium, Large)

#### **Features**

- **Show Captions**: Display image captions below images
- **Enable Lightbox**: Allow clicking images to open in lightbox
- **Enable Lazy Loading**: Load images only when needed

#### **Adding Images**

1. Click "Select Images" in the gallery block
2. Choose images from your media library or upload new ones
3. Arrange images by dragging and dropping
4. Add captions by clicking on the caption field below each image

### 3. **Using Regular WordPress Galleries**

The theme also enhances regular WordPress gallery blocks automatically:

1. Add a regular "Gallery" block in the editor
2. Select your images
3. The theme will automatically add lightbox and lazy loading functionality

## Technical Details

### **File Structure**

```
le-custom/
├── inc/
│   └── gallery-block.php          # Main gallery functionality
├── assets/
│   ├── js/
│   │   ├── gallery-block.js       # Frontend gallery JavaScript
│   │   └── gallery-inserter.js    # Block editor integration
│   └── css/
│       └── gallery-block.css      # Gallery styling
```

### **Dependencies**

- **SimpleLightbox**: Lightbox functionality (loaded from CDN)
- **Intersection Observer API**: Lazy loading (with fallback)
- **Tailwind CSS**: Styling and responsive design

### **Performance Features**

- **Conditional Loading**: Scripts only load when galleries are present
- **Lazy Loading**: Images load as they enter the viewport
- **Optimized Images**: Uses WordPress image sizes for thumbnails
- **Minimal DOM**: Efficient HTML structure

### **Browser Support**

- **Modern Browsers**: Full functionality with Intersection Observer
- **Older Browsers**: Fallback lazy loading with scroll events
- **Mobile**: Touch-friendly lightbox with swipe gestures

## Customization

### **Styling Customization**

You can customize the gallery appearance by modifying `assets/css/gallery-block.css`:

```css
/* Change gallery grid columns */
.gallery-with-lightbox {
  grid-template-columns: repeat(4, 1fr); /* 4 columns instead of auto-fit */
}

/* Custom hover effects */
.gallery-with-lightbox figure:hover {
  transform: scale(1.05); /* Different hover effect */
}

/* Custom colors */
.gallery-title {
  color: #your-color; /* Custom title color */
}
```

### **JavaScript Customization**

Modify `assets/js/gallery-block.js` for custom functionality:

```javascript
// Custom lightbox options
new SimpleLightbox('.gallery-with-lightbox a[data-lightbox="gallery"]', {
  // Your custom options
  animationSpeed: 300,
  showCounter: false,
  // ... more options
});
```

### **PHP Customization**

Edit `inc/gallery-block.php` to modify server-side functionality:

```php
// Custom gallery block pattern
function le_custom_register_gallery_block_pattern() {
    register_block_pattern(
        'le-custom/custom-gallery',
        [
            'title' => __('Custom Gallery', 'le-custom'),
            // Your custom pattern content
        ]
    );
}
```

## Troubleshooting

### **Lightbox Not Working**

1. Check if SimpleLightbox is loading (check browser console)
2. Verify images have proper `data-lightbox` attributes
3. Ensure no JavaScript conflicts with other plugins

### **Lazy Loading Issues**

1. Check browser console for errors
2. Verify images have `data-src` attributes
3. Test on different browsers (fallback should work)

### **Styling Problems**

1. Clear any caching plugins
2. Check if Tailwind CSS is loading properly
3. Verify CSS file is being enqueued

### **Performance Issues**

1. Optimize image sizes before uploading
2. Use appropriate WordPress image sizes
3. Consider using WebP format for better compression

## Examples

### **Basic Gallery**

```html
<div class="gallery-block-container">
  <h2 class="gallery-title">My Gallery</h2>
  <div class="gallery-with-lightbox">
    <figure>
      <a href="image1.jpg" data-lightbox="gallery" title="Image 1">
        <img
          src="image1-thumb.jpg"
          alt="Image 1"
          class="lazy-image"
          data-src="image1.jpg"
        />
      </a>
    </figure>
    <!-- More images... -->
  </div>
</div>
```

### **Gallery with Captions**

```html
<div class="gallery-with-lightbox">
  <figure>
    <a href="image1.jpg" data-lightbox="gallery" title="Beautiful Sunset">
      <img
        src="image1-thumb.jpg"
        alt="Beautiful Sunset"
        class="lazy-image"
        data-src="image1.jpg"
      />
    </a>
    <figcaption>Beautiful sunset over the mountains</figcaption>
  </figure>
</div>
```

## Accessibility

The gallery block includes several accessibility features:

- **Keyboard Navigation**: Full keyboard support in lightbox
- **Screen Reader Support**: Proper alt text and ARIA labels
- **Focus Management**: Clear focus indicators
- **High Contrast**: Works with high contrast mode
- **Reduced Motion**: Respects user's motion preferences

## Browser Compatibility

| Browser | Version | Lightbox | Lazy Loading  |
| ------- | ------- | -------- | ------------- |
| Chrome  | 60+     | ✅       | ✅            |
| Firefox | 55+     | ✅       | ✅            |
| Safari  | 12+     | ✅       | ✅            |
| Edge    | 79+     | ✅       | ✅            |
| IE      | 11      | ✅       | ⚠️ (Fallback) |

## Support

For issues or questions about the gallery block:

1. Check this documentation first
2. Review browser console for errors
3. Test with default WordPress theme to isolate issues
4. Check for plugin conflicts

The gallery block is designed to work seamlessly with the existing theme while providing modern, accessible, and performant gallery functionality.
