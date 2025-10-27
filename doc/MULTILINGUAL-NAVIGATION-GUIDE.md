# Multilingual Navigation Setup Guide

This guide shows you how to set up separate navigation menus for German and English versions of your website.

## 🎯 **What We've Set Up**

Your theme now supports:

- **German Navigation**: `primary-de` and `footer-de`
- **English Navigation**: `primary-en` and `footer-en`
- **Default Navigation**: `primary` and `footer` (fallback)
- **Automatic Language Detection**: Based on URL (`/de/` or `/en/`)

## 📋 **Step 1: Create Navigation Menus**

### In WordPress Admin:

1. **Go to Appearance** → **Menus**
2. **Create German Menu:**

   - Click **"Create a new menu"**
   - Name: "German Navigation"
   - Add pages like:
     - Startseite (Home)
     - Über uns (About)
     - Leistungen (Services)
     - Kontakt (Contact)
   - **Display location**: Select "Primary Menu - German"
   - Click **"Save Menu"**

3. **Create English Menu:**
   - Click **"Create a new menu"**
   - Name: "English Navigation"
   - Add pages like:
     - Homepage
     - About Us
     - Services
     - Contact
   - **Display location**: Select "Primary Menu - English"
   - Click **"Save Menu"**

## 🏗️ **Step 2: Create Subpages Structure**

### German Pages (`/de/` structure):

```
/de/                    → German Homepage
/de/uber-uns/          → About Us (German)
/de/leistungen/        → Services (German)
/de/kontakt/           → Contact (German)
/de/leistungen/zahnreinigung/  → Dental Cleaning (German)
/de/leistungen/fullungen/      → Fillings (German)
```

### English Pages (`/en/` structure):

```
/en/                   → English Homepage
/en/about-us/          → About Us (English)
/en/services/          → Services (English)
/en/contact/           → Contact (English)
/en/services/cleaning/ → Dental Cleaning (English)
/en/services/fillings/ → Fillings (English)
```

## 🔧 **Step 3: Create the Pages**

### Create German Pages:

1. **Go to Pages** → **Add New**
2. **Create each page:**
   - **Über uns** (slug: `uber-uns`)
   - **Leistungen** (slug: `leistungen`)
   - **Kontakt** (slug: `kontakt`)
   - **Zahnreinigung** (slug: `zahnreinigung`, parent: Leistungen)
   - **Füllungen** (slug: `fullungen`, parent: Leistungen)

### Create English Pages:

1. **Go to Pages** → **Add New**
2. **Create each page:**
   - **About Us** (slug: `about-us`)
   - **Services** (slug: `services`)
   - **Contact** (slug: `contact`)
   - **Dental Cleaning** (slug: `cleaning`, parent: Services)
   - **Fillings** (slug: `fillings`, parent: Services)

## 🎨 **Step 4: Set Up Navigation Menus**

### German Menu Structure:

```
Startseite
├── Über uns
├── Leistungen
│   ├── Zahnreinigung
│   └── Füllungen
└── Kontakt
```

### English Menu Structure:

```
Homepage
├── About Us
├── Services
│   ├── Dental Cleaning
│   └── Fillings
└── Contact
```

## 🔗 **Step 5: Add Language Switcher**

Add this to your header template for a language switcher:

```php
<!-- Language Switcher -->
<div class="flex items-center space-x-4 ml-8">
    <a href="<?php echo home_url('/de/'); ?>" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
        DE
    </a>
    <span class="text-gray-300">|</span>
    <a href="<?php echo home_url('/en/'); ?>" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
        EN
    </a>
</div>
```

## 🚀 **Step 6: Test Your Setup**

1. **Visit German site:** `yoursite.com/de/`

   - Should show German navigation
   - All links should go to `/de/` pages

2. **Visit English site:** `yoursite.com/en/`
   - Should show English navigation
   - All links should go to `/en/` pages

## 📁 **File Structure Example**

```
WordPress Pages:
├── de (German Homepage)
├── en (English Homepage)
├── uber-uns (German About)
├── about-us (English About)
├── leistungen (German Services)
├── services (English Services)
├── zahnreinigung (German Dental Cleaning)
├── cleaning (English Dental Cleaning)
├── fullungen (German Fillings)
├── fillings (English Fillings)
├── kontakt (German Contact)
└── contact (English Contact)
```

## 🔧 **Advanced: Custom URL Structure**

If you want different URL structures, you can modify the template redirect function:

```php
// In functions.php, modify the template_redirect function
function le_custom_template_redirect($template) {
    $url = $_SERVER['REQUEST_URI'];

    // German pages
    if (preg_match('#^/de/(.*)$#', $url, $matches)) {
        $page_slug = $matches[1];
        $page = get_page_by_path($page_slug);
        if ($page) {
            global $post;
            $post = $page;
            setup_postdata($post);
            return get_template_directory() . '/page-landing-de.php';
        }
    }

    // English pages
    if (preg_match('#^/en/(.*)$#', $url, $matches)) {
        $page_slug = $matches[1];
        $page = get_page_by_path($page_slug);
        if ($page) {
            global $post;
            $post = $page;
            setup_postdata($post);
            return get_template_directory() . '/page-landing-en.php';
        }
    }

    return $template;
}
```

## 🎯 **Best Practices**

1. **Consistent Structure**: Keep the same page hierarchy in both languages
2. **SEO-Friendly URLs**: Use descriptive slugs in the respective language
3. **Menu Organization**: Group related pages logically
4. **Language Indicators**: Always show which language the user is viewing
5. **Fallback Content**: Provide default navigation if language-specific menu doesn't exist

## 🚨 **Troubleshooting**

### Navigation Not Showing:

1. Check if menus are assigned to correct locations
2. Verify pages exist and are published
3. Clear any caching plugins

### Wrong Language Showing:

1. Check URL structure (`/de/` vs `/en/`)
2. Verify language detection function
3. Test with debug output

### Links Not Working:

1. Check page slugs match navigation links
2. Verify permalink structure
3. Flush rewrite rules

## 📞 **Support**

If you need help:

1. Check the debug output in your browser
2. Verify all pages are published
3. Test with different browsers
4. Check WordPress error logs
