# Sitemap Generator

This theme includes a comprehensive XML sitemap generator that automatically creates sitemaps for both pages and images, with proper SEO optimization and multilingual support.

## Features

- **Main Sitemap Index**: `/sitemap.xml` - Index of all sitemaps
- **Pages Sitemap**: `/sitemap-pages.xml` - All published pages and posts
- **Images Sitemap**: `/sitemap-images.xml` - All images with metadata
- **Automatic Integration**: Automatically added to robots.txt
- **Admin Integration**: Easy access via admin bar and notices
- **Multilingual Support**: Works with German and English pages
- **SEO Optimized**: Proper priorities and change frequencies

## Sitemap URLs

Once activated, the following sitemap URLs will be available:

- **Main Sitemap**: `https://yoursite.com/sitemap.xml`
- **Pages Sitemap**: `https://yoursite.com/sitemap-pages.xml`
- **Images Sitemap**: `https://yoursite.com/sitemap-images.xml`

## What's Included

### Main Sitemap (`/sitemap.xml`)

An index file that lists all available sitemaps:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>https://yoursite.com/sitemap-pages.xml</loc>
        <lastmod>2024-01-01T00:00:00+00:00</lastmod>
    </sitemap>
    <sitemap>
        <loc>https://yoursite.com/sitemap-images.xml</loc>
        <lastmod>2024-01-01T00:00:00+00:00</lastmod>
    </sitemap>
</sitemapindex>
```

### Pages Sitemap (`/sitemap-pages.xml`)

Includes all published pages with:

- **Homepage**: Priority 1.0, weekly updates
- **Important Pages** (contact, directions, legal): Priority 0.9, monthly updates
- **Landing Pages**: Priority 0.9, weekly updates
- **Regular Pages**: Priority 0.8, monthly updates
- **Custom Post Types**: Priority 0.7, monthly updates

### Images Sitemap (`/sitemap-images.xml`)

Includes all images with:

- **Featured Images**: From pages and posts
- **Content Images**: Extracted from post content
- **Media Library**: All image attachments
- **Image Metadata**: Title, alt text, and captions

## Priority System

The sitemap uses intelligent priority assignment:

| Page Type                | Priority | Change Frequency |
| ------------------------ | -------- | ---------------- |
| Homepage                 | 1.0      | Weekly           |
| Contact/Directions/Legal | 0.9      | Monthly          |
| Landing Pages            | 0.9      | Weekly           |
| Regular Pages            | 0.8      | Monthly          |
| Custom Post Types        | 0.7      | Monthly          |

## Image Detection

The sitemap automatically detects images from:

1. **Featured Images**: Using `get_post_thumbnail_id()`
2. **Content Images**: Using regex to find `<img>` tags
3. **Background Images**: Using regex to find CSS background-image URLs
4. **Media Library**: All image attachments

## Admin Integration

### Admin Bar

For administrators, sitemap links are available in the WordPress admin bar:

- **Sitemaps** → **Main Sitemap**
- **Sitemaps** → **Pages Sitemap**
- **Sitemaps** → **Images Sitemap**

### Admin Notices

When visiting the Tools page, an admin notice displays all sitemap URLs for easy access.

## Robots.txt Integration

The sitemap is automatically added to your robots.txt file:

```
User-agent: *
Disallow: /wp-admin/
Sitemap: https://yoursite.com/sitemap.xml
```

## Multilingual Support

The sitemap generator works with multilingual pages:

- German pages (e.g., `kontakt`, `anfahrt`, `impressum`)
- English pages (e.g., `contact`, `directions`, `imprint`)
- Landing pages for both languages

## Technical Details

### File Structure

```
inc/
├── sitemap-generator.php    # Main sitemap functionality
└── ...

functions.php               # Includes sitemap generator
test-sitemap.php           # Test script for verification
```

### Functions Overview

| Function                                  | Purpose                      |
| ----------------------------------------- | ---------------------------- |
| `le_custom_register_sitemap_endpoints()`  | Registers rewrite rules      |
| `le_custom_generate_main_sitemap()`       | Generates main sitemap index |
| `le_custom_generate_pages_sitemap()`      | Generates pages sitemap      |
| `le_custom_generate_images_sitemap()`     | Generates images sitemap     |
| `le_custom_extract_images_from_content()` | Extracts images from content |
| `le_custom_add_sitemap_to_robots_txt()`   | Adds sitemap to robots.txt   |

### Rewrite Rules

The following rewrite rules are automatically added:

- `^sitemap\.xml$` → `index.php?sitemap=main`
- `^sitemap-pages\.xml$` → `index.php?sitemap=pages`
- `^sitemap-images\.xml$` → `index.php?sitemap=images`

## Testing

Use the included test script to verify functionality:

```bash
php test-sitemap.php
```

This will test:

1. Rewrite rules registration
2. Query vars registration
3. Sitemap URL generation
4. Page and image counting
5. Content image extraction
6. Robots.txt integration

## SEO Benefits

- **Search Engine Discovery**: Helps search engines find all pages and images
- **Image SEO**: Proper image metadata for better image search results
- **Crawl Efficiency**: Optimized priorities and change frequencies
- **Multilingual SEO**: Proper handling of German and English content
- **Mobile SEO**: Image sitemaps help with mobile search results

## Performance

- **On-Demand Generation**: Sitemaps are generated on request, not stored
- **Efficient Queries**: Uses optimized WordPress queries
- **Memory Efficient**: Processes content in chunks
- **Caching Friendly**: Works with WordPress caching plugins

## Troubleshooting

### Sitemap Not Accessible

1. **Flush Rewrite Rules**: Go to Settings → Permalinks and click "Save Changes"
2. **Check Permissions**: Ensure the theme has proper file permissions
3. **Verify Activation**: Make sure the theme is properly activated

### Missing Images

1. **Check Image URLs**: Ensure images have proper URLs
2. **Verify Attachments**: Check that images are properly attached to posts
3. **Content Analysis**: Verify that content images are properly formatted

### Performance Issues

1. **Limit Content**: For large sites, consider paginating sitemaps
2. **Optimize Queries**: Monitor database performance
3. **Use Caching**: Implement caching for frequently accessed sitemaps

## Customization

### Adding Custom Post Types

The sitemap automatically includes all public custom post types. To customize priorities:

```php
// In your theme's functions.php
add_filter('le_custom_sitemap_post_type_priority', function($priority, $post_type) {
    if ($post_type === 'your_custom_type') {
        return '0.9';
    }
    return $priority;
}, 10, 2);
```

### Custom Image Detection

To add custom image detection methods:

```php
// In your theme's functions.php
add_filter('le_custom_sitemap_content_images', function($images, $content) {
    // Add your custom image detection logic
    return $images;
}, 10, 2);
```

## Security

- **Direct Access Prevention**: All files include ABSPATH checks
- **Proper Escaping**: All output is properly escaped
- **Admin Only Access**: Admin features require proper capabilities
- **No Sensitive Data**: Sitemaps only include public content

## Compatibility

- **WordPress**: 5.0+
- **PHP**: 7.4+
- **Multilingual**: Compatible with WPML, Polylang, and custom solutions
- **Caching**: Works with all major caching plugins
- **SEO Plugins**: Compatible with Yoast SEO, RankMath, etc.

## Support

For issues or questions:

1. Check the test script output
2. Verify WordPress permalink settings
3. Check server error logs
4. Ensure proper file permissions
