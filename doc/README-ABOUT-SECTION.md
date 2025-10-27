# About Section - Multiple Content Blocks

## Overview

The About Section has been enhanced to support multiple content blocks with flexible positioning options. This allows clients to create rich, dynamic about sections with various layouts and content arrangements.

## Features

### Multiple Content Blocks

- Add unlimited content blocks to the about section
- Each block can have its own title, content, image, and features list
- Blocks are displayed sequentially with proper spacing

### Layout Positioning Options

Each block supports four different layout options:

1. **Text Left, Image Right** (default)

   - Text content on the left, image on the right
   - Traditional layout for most content

2. **Image Left, Text Right**

   - Image on the left, text content on the right
   - Good for visual-first content

3. **Text Only**

   - Centered text content without images
   - Perfect for testimonials, mission statements, or key messages

4. **Image Only**
   - Large centered image without text
   - Ideal for showcasing facilities, team photos, or visual content

### Content Elements

Each block can include:

- **Title**: Main heading for the block
- **Content**: Rich text content with HTML formatting support
- **Image**: Optional image with PhotoSwipe lightbox integration
- **Features List**: Optional bullet points with checkmark icons
- **Layout Position**: Choose how content is positioned

### Rich Text Formatting

The content field supports HTML formatting for enhanced text styling:

- **Bold text**: `<strong>important text</strong>`
- **Italic text**: `<em>emphasized text</em>`
- **Highlighted text**: `<mark>highlighted text</mark>`
- **Links**: `<a href="https://example.com">link text</a>`
- **Line breaks**: `<br>` for paragraph breaks

## Admin Interface

### Accessing the About Section Settings

1. Edit any page using the German or English landing page template
2. Scroll down to the "About Section Settings" meta box
3. The interface will show existing blocks or create a default one

### Managing Blocks

- **Add New Block**: Click "Add New About Block" to create additional content blocks
- **Remove Block**: Click "Remove Block" on any block (minimum 1 block required)
- **Reorder**: Blocks are displayed in the order they appear in the admin

### Block Configuration

For each block, you can configure:

#### Basic Content

- **Block Title**: Main heading for this content block
- **Content**: Rich text content with HTML formatting support

#### Media

- **Image**: Upload or choose an image (recommended: 600x400px)
- **Image Preview**: See the selected image in the admin
- **Remove Image**: Clear the image selection

#### Layout

- **Layout Position**: Choose from four positioning options:
  - Text Left, Image Right
  - Image Left, Text Right
  - Text Only (No Image)
  - Image Only (No Text)

#### Features

- **Features List**: Add multiple bullet points
- **Add Feature**: Click to add new feature items
- **Remove Feature**: Remove individual feature items

## Frontend Display

### Responsive Design

- All layouts are fully responsive
- Mobile-first design with proper breakpoints
- Images scale appropriately on all devices

### PhotoSwipe Integration

- Images are clickable and open in a lightbox
- Smooth transitions and zoom functionality
- Keyboard navigation support

### Visual Elements

- **Checkmark Icons**: Green checkmarks for feature lists
- **Hover Effects**: Subtle animations on images and buttons
- **Consistent Spacing**: Proper margins and padding throughout
- **Rich Text Styling**: Highlighted text, styled links, and formatted content

## Code Structure

### Data Storage

About section data is stored in post meta with the key `_about_section_data`:

```php
[
    'blocks' => [
        [
            'title' => 'Block Title',
            'content' => 'Block content text',
            'image' => 'image-url.jpg',
            'position' => 'left', // left, right, text-only, image-only
            'features' => ['Feature 1', 'Feature 2', 'Feature 3']
        ],
        // ... more blocks
    ]
]
```

### Template Logic

The template checks for the new block structure first, then falls back to legacy single-block format:

```php
<?php if (!empty($about_data['blocks'])): ?>
    <!-- New multi-block structure -->
    <?php foreach ($about_data['blocks'] as $block): ?>
        <!-- Render each block based on position -->
    <?php endforeach; ?>
<?php else: ?>
    <!-- Legacy single-block fallback -->
<?php endif; ?>
```

## Backward Compatibility

The system maintains full backward compatibility:

- Existing single-block about sections continue to work
- Legacy data structure is preserved
- Templates gracefully fall back to old format if no blocks exist

## Usage Examples

### Example 1: Practice Introduction + Team Photo

- Block 1: "About Our Practice" (Text Left, Image Right)
- Block 2: "Our Team" (Image Only)

### Example 2: Services Overview + Testimonial

- Block 1: "Our Services" (Text Left, Image Right)
- Block 2: "Patient Testimonial" (Text Only)

### Example 3: Facility Showcase

- Block 1: "Modern Facilities" (Image Left, Text Right)
- Block 2: "Treatment Rooms" (Image Only)
- Block 3: "Why Choose Us" (Text Only)

### Example 4: Rich Content with Formatting

- Block 1: "About Our Practice" with highlighted text and links
- Block 2: "Patient Testimonials" with italic quotes
- Block 3: "Special Offers" with bold call-to-action text

## Customization

### Adding New Layout Options

To add new layout positions, modify:

1. `inc/about-section.php` - Add option to admin interface
2. Template files - Add rendering logic for new position
3. Default values in `le_custom_set_about_defaults()`

### Styling Customization

- All blocks use Tailwind CSS classes
- Custom CSS can be added to `assets/css/` directory
- Responsive breakpoints follow Tailwind conventions

## Troubleshooting

### Common Issues

**Blocks not saving:**

- Check WordPress permissions
- Verify nonce validation
- Check for JavaScript errors in browser console

**Images not displaying:**

- Verify image URLs are correct
- Check file permissions
- Ensure PhotoSwipe scripts are loaded

**Layout not working:**

- Clear browser cache
- Check for CSS conflicts
- Verify Tailwind CSS is loaded

### Debug Information

Enable WordPress debug mode to see detailed error messages:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## Future Enhancements

Potential improvements for future versions:

- Drag-and-drop block reordering
- More layout options (3-column, masonry, etc.)
- Advanced image galleries
- Animation options
- Conditional display logic
- Integration with page builders
