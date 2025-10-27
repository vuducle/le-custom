# Troubleshooting Landing Page Redirects

If your `/de/` and `/en/` URLs are not working, follow these steps to fix the issue.

## Step 1: Check if Pages Exist

1. **Go to WordPress Admin** → **Pages**
2. **Look for pages with slugs `de` and `en`**
3. **Verify they are published** (not draft or private)

## Step 2: Check Page Templates

1. **Edit each page** (German and English)
2. **In the Page Attributes section** (sidebar)
3. **Verify template is set to:**
   - German page: "Landing Page - German"
   - English page: "Landing Page - English"

## Step 3: Flush Rewrite Rules

1. **Go to Settings** → **Permalinks**
2. **Select "Post name"** (if not already selected)
3. **Click "Save Changes"**
4. **Click "Save Changes" again** (this flushes rewrite rules)

## Step 4: Test Direct Page URLs

Try accessing the pages directly:

- `yoursite.com/de/` (should work)
- `yoursite.com/en/` (should work)

If these don't work, the issue is with the page setup, not the redirects.

## Step 5: Enable Debug Mode

Add this to your `functions.php` temporarily:

```php
// Add this at the end of functions.php
function debug_landing_pages() {
    if (is_admin()) return;

    $current_url = $_SERVER['REQUEST_URI'];
    echo '<div style="background: #f0f0f0; padding: 10px; margin: 10px;">';
    echo '<strong>Debug:</strong> Current URL: ' . $current_url . '<br>';

    $german_page = get_page_by_path('de');
    $english_page = get_page_by_path('en');

    echo 'German page: ' . ($german_page ? 'Found (ID: ' . $german_page->ID . ')' : 'Not found') . '<br>';
    echo 'English page: ' . ($english_page ? 'Found (ID: ' . $english_page->ID . ')' : 'Not found') . '<br>';
    echo '</div>';
}
add_action('wp_head', 'debug_landing_pages');
```

## Step 6: Alternative Solution (Recommended)

If redirects still don't work, use this template_include approach:

Replace the redirect function in `functions.php` with:

```php
function le_custom_template_redirect($template) {
    $current_url = $_SERVER['REQUEST_URI'];

    // Check for /de/ URL
    if (preg_match('#^/de/?$#', $current_url)) {
        $german_page = get_page_by_path('de');
        if ($german_page) {
            global $post;
            $post = $german_page;
            setup_postdata($post);
            return get_template_directory() . '/page-landing-de.php';
        }
    }

    // Check for /en/ URL
    if (preg_match('#^/en/?$#', $current_url)) {
        $english_page = get_page_by_path('en');
        if ($english_page) {
            global $post;
            $post = $english_page;
            setup_postdata($post);
            return get_template_directory() . '/page-landing-en.php';
        }
    }

    return $template;
}
add_filter('template_include', 'le_custom_template_redirect', 99);
```

## Step 7: Check for Conflicts

1. **Disable all plugins** temporarily
2. **Test the URLs** again
3. **Re-enable plugins one by one** to find the conflict

## Step 8: Check .htaccess

Make sure your `.htaccess` file doesn't have conflicting rules:

```apache
# Your .htaccess should look like this:
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```

## Step 9: Manual Page Creation

If nothing works, create the pages manually:

1. **Create German page:**

   - Title: "Startseite"
   - Slug: `de`
   - Template: "Landing Page - German"
   - Status: Published

2. **Create English page:**
   - Title: "Homepage"
   - Slug: `en`
   - Template: "Landing Page - English"
   - Status: Published

## Common Issues and Solutions

### Issue: 404 Error

**Solution:** Flush rewrite rules (Step 3)

### Issue: Wrong Template Loading

**Solution:** Check page template assignment (Step 2)

### Issue: Pages Not Found

**Solution:** Verify page slugs and status (Step 1)

### Issue: Redirect Loop

**Solution:** Use template_include approach (Step 6)

### Issue: Caching Problems

**Solution:** Clear all caches (WordPress, server, CDN)

## Testing Checklist

- [ ] Pages exist with correct slugs (`de`, `en`)
- [ ] Pages are published
- [ ] Templates are assigned correctly
- [ ] Permalinks are set to "Post name"
- [ ] Rewrite rules are flushed
- [ ] No plugin conflicts
- [ ] .htaccess is correct
- [ ] URLs work: `yoursite.com/de/` and `yoursite.com/en/`

## Still Not Working?

1. **Check WordPress error logs**
2. **Enable WP_DEBUG** in wp-config.php
3. **Contact your hosting provider**
4. **Try a different approach** (like using a multilingual plugin)

## Quick Fix

If you need a quick solution, use this in your `functions.php`:

```php
// Simple redirect for /de and /en
add_action('template_redirect', function() {
    $url = $_SERVER['REQUEST_URI'];

    if ($url === '/de/' || $url === '/de') {
        $page = get_page_by_path('de');
        if ($page) {
            wp_redirect(get_permalink($page->ID), 301);
            exit;
        }
    }

    if ($url === '/en/' || $url === '/en') {
        $page = get_page_by_path('en');
        if ($page) {
            wp_redirect(get_permalink($page->ID), 301);
            exit;
        }
    }
});
```
