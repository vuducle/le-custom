# Professional Single Image Block for Dental Practices

This theme includes a custom single image block specifically designed for dental practices, providing a modern, professional single image display with lightbox functionality and lazy loading for optimal performance. Perfect for showcasing individual treatment results, before & after photos, and practice highlights.

## Features

### 🖼️ **Professional Single Image Display**

- Centered, professional image layout
- Configurable image sizes (thumbnail to full size)
- Medical-grade professional styling
- Responsive design for all devices

### 🔍 **Lightbox Functionality**

- Click image to open in professional lightbox
- Keyboard navigation (escape key)
- Touch/swipe support for mobile devices
- Image captions and professional styling
- Smooth animations and transitions

### ⚡ **Lazy Loading**

- Images load only when they enter the viewport
- Reduces initial page load time
- Smooth loading animations
- Fallback support for older browsers

### 🎨 **Professional Dental Design**

- Medical-grade professional styling
- Dental practice color scheme (blues and whites)
- Trust-building visual elements
- Accessibility features for all patients
- Professional typography and spacing

## How to Use

### 1. **Adding a Single Image Block**

#### Method 1: Block Editor (Recommended)

1. Open the WordPress block editor
2. Click the "+" button to add a new block
3. Search for "Professional Single Image"
4. Select the block to add it to your page

#### Method 2: Block Pattern

1. In the block editor, click the "+" button
2. Go to the "Patterns" tab
3. Look for "Professional Single Image" in the "LE Custom Blocks" category
4. Click to insert the pattern

### 2. **Configuring Your Single Image**

Once you've added the single image block, you can configure it using the block settings panel:

#### **Display Options**

- **Show Title**: Display a title above the image
- **Show Caption**: Display a caption below the image
- **Image Size**: Choose from thumbnail, medium, large, or full size

#### **Professional Features**

- **Enable Professional Lightbox**: Allow clicking image to open in lightbox
- **Enable Performance Optimization**: Load image only when needed

#### **Adding an Image**

1. Click "Select Professional Image" in the single image block
2. Choose an image from your media library or upload a new one
3. Add a professional title and caption
4. Configure display options

### 3. **Using Regular WordPress Images**

The theme also enhances regular WordPress image blocks automatically:

1. Add a regular "Image" block in the editor
2. Select your image
3. The theme will automatically add lightbox and lazy loading functionality

## Technical Details

### **File Structure**

```
le-custom/
├── inc/
│   └── single-image-block.php          # Main single image functionality
├── assets/
│   ├── js/
│   │   ├── single-image-block.js       # Frontend single image JavaScript
│   │   └── single-image-inserter.js    # Block editor integration
│   └── css/
│       └── single-image-block.css      # Single image styling
```

### **Dependencies**

- **SimpleLightbox**: Lightbox functionality (loaded from CDN)
- **Intersection Observer API**: Lazy loading (with fallback)
- **Tailwind CSS**: Styling and responsive design

### **Performance Features**

- **Conditional Loading**: Scripts only load when single images are present
- **Lazy Loading**: Images load as they enter the viewport
- **Optimized Images**: Uses WordPress image sizes for optimal performance
- **Minimal DOM**: Efficient HTML structure

### **Browser Support**

- **Modern Browsers**: Full functionality with Intersection Observer
- **Older Browsers**: Fallback lazy loading with scroll events
- **Mobile**: Touch-friendly lightbox with swipe gestures

## Customization

### **Styling Customization**

You can customize the single image appearance by modifying `assets/css/single-image-block.css`:

```css
/* Change single image max width */
.single-image-with-lightbox {
  max-width: 1000px; /* Larger max width */
}

/* Custom hover effects */
.single-image-with-lightbox:hover {
  transform: translateY(-12px) scale(1.03); /* Different hover effect */
}

/* Custom colors */
.single-image-title {
  color: #your-color; /* Custom title color */
}
```

### **JavaScript Customization**

Modify `assets/js/single-image-block.js` for custom functionality:

```javascript
// Custom lightbox options
new SimpleLightbox(
  '.single-image-with-lightbox a[data-lightbox="single-image"]',
  {
    // Your custom options
    animationSpeed: 400,
    showCounter: false,
    // ... more options
  }
);
```

### **PHP Customization**

Edit `inc/single-image-block.php` to modify server-side functionality:

```php
// Custom single image block pattern
function le_custom_register_single_image_block_pattern() {
    register_block_pattern(
        'le-custom/custom-single-image',
        [
            'title' => __('Custom Single Image', 'le-custom'),
            // Your custom pattern content
        ]
    );
}
```

## Perfect For

### **Dental Practice Use Cases**

- **Before & After Photos**: Showcase individual treatment results
- **Practice Facilities**: Display modern equipment and offices
- **Team Photos**: Professional staff presentations
- **Treatment Procedures**: Educational patient content
- **Patient Testimonials**: Visual success stories
- **Award Recognition**: Professional achievements
- **Technology Showcase**: Modern dental equipment

### **Professional Features**

- **Trust Building**: Professional styling builds patient confidence
- **Medical Grade**: Appropriate for healthcare environments
- **Accessibility**: Works for all patients including those with disabilities
- **Mobile Friendly**: Perfect for patients browsing on phones
- **SEO Optimized**: Proper image optimization and alt text

## Examples

### **Basic Single Image**

```html
<div class="single-image-block-container">
  <h3 class="single-image-title">Treatment Result</h3>
  <figure class="single-image-with-lightbox">
    <a
      href="treatment-result.jpg"
      data-lightbox="single-image"
      title="Professional Treatment Result"
    >
      <img
        src="treatment-result-thumb.jpg"
        alt="Professional Treatment Result"
        class="lazy-image"
        data-src="treatment-result.jpg"
      />
    </a>
  </figure>
  <p class="single-image-caption">
    Professional dental treatment result showcasing our expertise and care.
  </p>
</div>
```

### **Single Image with Custom Styling**

```html
<div class="single-image-block-container">
  <h3 class="single-image-title">Before & After</h3>
  <figure class="single-image-with-lightbox">
    <img
      src="before-after.jpg"
      alt="Before and After Treatment"
      class="lazy-image"
      data-src="before-after.jpg"
    />
  </figure>
  <p class="single-image-caption">
    Dramatic transformation achieved through professional dental care.
  </p>
</div>
```

## Accessibility

The single image block includes several accessibility features:

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

## Support

For issues or questions about the single image block:

1. Check this documentation first
2. Review browser console for errors
3. Test with default WordPress theme to isolate issues
4. Check for plugin conflicts

The single image block is designed to work seamlessly with the existing theme while providing modern, accessible, and performant single image functionality perfect for dental practices.
