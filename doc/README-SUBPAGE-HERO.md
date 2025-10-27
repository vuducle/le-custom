# Subpage Hero Section

This feature automatically displays a hero section for subpages (non-landing pages) that shows the page's featured image as a background with the page title as a headline.

## How It Works

### For Subpages (Non-Landing Pages)

When a user visits any page that is **not** a landing page (`/de` or `/en`), the system automatically:

1. **Checks if it's a subpage**: Uses `le_custom_is_subpage()` to determine if the current page is not a landing page
2. **Gets the featured image**: Retrieves the page's featured image using `get_the_post_thumbnail_url()`
3. **Displays the hero section**: Shows a hero section with:
   - **Background**: The featured image (if set) or the global primary light color
   - **Headline**: The page title in large, white text with shadow
   - **Featured Image Display**: The image is also displayed below the headline for emphasis
   - **Dark Overlay**: A semi-transparent dark overlay is added when using featured images for better text readability

### For Landing Pages

Landing pages (`/de` and `/en`) continue to use the existing hero section functionality with:

- Customizable title, subtitle, and buttons
- Background image or color options
- Call-to-action buttons

## Features

### Subpage Hero Section Features

- **Automatic Detection**: Automatically detects subpages vs landing pages
- **Featured Image Support**: Uses WordPress featured images as background
- **Responsive Design**: Fully responsive with proper mobile optimization
- **Animation**: Includes AOS (Animate On Scroll) animations
- **Accessibility**: Proper alt text and semantic HTML
- **Fallback**: Uses global color scheme if no featured image is set

### Visual Design

- **Background**: Featured image covers the entire hero section
- **Overlay**: Dark overlay (40% opacity) for better text readability
- **Typography**: Large, bold white text with shadow effects
- **Image Display**: Featured image also shown below the headline with rounded corners and shadow
- **Spacing**: Proper padding and margins for optimal visual hierarchy

## Technical Implementation

### Key Functions

1. **`le_custom_is_subpage()`**: Determines if current page is a subpage
2. **`le_custom_get_subpage_hero_html()`**: Generates HTML for subpage hero section
3. **`le_custom_display_hero_section()`**: Main function that decides which hero to show

### Template Integration

- **Landing Pages**: `page-landing-de.php` and `page-landing-en.php` use the unified hero function
- **Subpages**: `page.php` template automatically includes the hero section
- **Consistent Styling**: All hero sections use the same CSS classes and animations

## Usage

### For Content Editors

1. **Set Featured Image**: Upload a featured image for any subpage in the WordPress admin
2. **Page Title**: The page title automatically becomes the hero headline
3. **No Additional Setup**: The hero section appears automatically

### For Developers

The system is fully automatic, but you can customize:

```php
// Check if current page is a subpage
if (le_custom_is_subpage()) {
    // Custom logic for subpages
}

// Get subpage hero HTML
$hero_html = le_custom_get_subpage_hero_html($post_id);

// Display hero section
le_custom_display_hero_section($post_id);
```

## Benefits

- **Consistent Design**: All pages now have a hero section
- **Easy Management**: Uses WordPress featured images (no additional fields needed)
- **Performance**: Optimized image loading and responsive design
- **SEO Friendly**: Proper heading hierarchy and semantic markup
- **User Experience**: Engaging visual introduction for all pages

## Browser Support

- Modern browsers with CSS Grid and Flexbox support
- Responsive design works on all device sizes
- Graceful fallback for older browsers
