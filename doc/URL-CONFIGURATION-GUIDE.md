# URL Configuration Guide for Landing Pages

This guide shows you how to set up URLs for your German (/de) and English (/en) landing pages.

## Quick Setup (Recommended)

### Step 1: Create the Pages

1. **Go to WordPress Admin** → **Pages** → **Add New**

2. **Create German Page:**

   - Title: "Startseite" or "Homepage"
   - Template: Select "Landing Page - German"
   - Slug: Set to `de`

3. **Create English Page:**
   - Title: "Homepage" or "Home"
   - Template: Select "Landing Page - English"
   - Slug: Set to `en`

### Step 2: Set Page Slugs

For each page:

1. In the **Permalink** section (below title)
2. Click **Edit** next to the permalink
3. Change to:
   - German: `de`
   - English: `en`
4. Click **OK**

### Step 3: Configure Permalinks

1. Go to **Settings** → **Permalinks**
2. Select **Post name**
3. Click **Save Changes**

### Step 4: Flush Rewrite Rules

1. Go to **Settings** → **Permalinks**
2. Click **Save Changes** again (this flushes rewrite rules)

## Result

Your URLs will be:

- `yoursite.com/de/` (German landing page)
- `yoursite.com/en/` (English landing page)

## Alternative Methods

### Method 2: Using Multilingual Plugin

**WPML (Premium):**

1. Install WPML
2. Add German and English languages
3. Create pages in both languages
4. WPML handles URLs automatically

**Polylang (Free):**

1. Install Polylang
2. Add languages
3. Create pages and set language
4. URLs: `yoursite.com/de/` and `yoursite.com/en/`

### Method 3: Custom .htaccess

Add to your `.htaccess` file:

```apache
# Redirect /de to German landing page
RewriteRule ^de/?$ /index.php?pagename=de [L,QSA]

# Redirect /en to English landing page
RewriteRule ^en/?$ /index.php?pagename=en [L,QSA]
```

## Troubleshooting

### URLs Not Working?

1. **Check Permalinks:**

   - Go to Settings → Permalinks
   - Select "Post name"
   - Save changes

2. **Flush Rewrite Rules:**

   - Go to Settings → Permalinks
   - Click "Save Changes" again

3. **Check Page Slugs:**

   - Ensure pages have slugs `de` and `en`
   - No spaces or special characters

4. **Check Template Assignment:**
   - Verify pages use correct templates
   - "Landing Page - German" for German page
   - "Landing Page - English" for English page

### Common Issues

**404 Errors:**

- Flush rewrite rules
- Check page slugs are correct
- Ensure pages are published

**Wrong Template Loading:**

- Check template assignment in page editor
- Verify template files exist in theme directory

**URLs Redirecting Wrong:**

- Check for conflicting plugins
- Verify .htaccess rules
- Clear any caching plugins

## Testing Your Setup

1. Visit `yoursite.com/de/` - should show German landing page
2. Visit `yoursite.com/en/` - should show English landing page
3. Check that templates load correctly
4. Test responsive design on mobile

## Next Steps

After URL setup:

1. Customize content in each page
2. Update contact information
3. Add images and media
4. Test all links and forms
5. Set up language switcher in navigation

## Support

If you need help:

1. Check WordPress error logs
2. Disable plugins temporarily
3. Switch to default theme to test
4. Contact your hosting provider for .htaccess issues
