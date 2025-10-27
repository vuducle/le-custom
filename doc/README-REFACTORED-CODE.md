# Refactored Code Documentation

This document explains the refactored, modular structure of the LE Custom WordPress theme.

## Overview

The theme has been refactored from a single large `functions.php` file into a modular structure with separate files for different functionality. This improves maintainability, readability, and follows WordPress coding standards.

## File Structure

```
le-custom/
├── functions.php                 # Main entry point (now minimal)
├── inc/                          # Include files directory
│   ├── theme-setup.php          # Theme setup and basic functionality
│   ├── customizer.php           # Theme customizer options
│   ├── navigation.php           # Navigation and routing
│   └── hero-section.php         # Hero section management
├── assets/
│   └── js/
│       ├── theme.js             # Frontend JavaScript
│       ├── customizer.js        # Customizer JavaScript
│       └── hero-section-admin.js # Hero section admin (vanilla JS)
└── README-REFACTORED-CODE.md    # This documentation
```

## File Descriptions

### 1. `functions.php` (Main Entry Point)

- **Purpose**: Minimal entry point that includes all modular components
- **Size**: ~20 lines (down from 800+ lines)
- **Responsibilities**:
  - Security check (ABSPATH)
  - Include all modular files
  - No direct functionality

### 2. `inc/theme-setup.php`

- **Purpose**: Core theme setup and basic WordPress functionality
- **Responsibilities**:
  - Theme support features (title-tag, post-thumbnails, etc.)
  - Navigation menu registration
  - Script and style enqueuing
  - Image size registration
  - Widget area registration
  - Excerpt customization
  - Body class customization
  - Admin script enqueuing
  - Debug functionality

### 3. `inc/customizer.php`

- **Purpose**: WordPress Customizer functionality
- **Responsibilities**:
  - Contact information settings
  - Footer settings
  - Color controls
  - Selective refresh callbacks
  - Customizer script enqueuing
  - Sanitization functions

### 4. `inc/navigation.php`

- **Purpose**: Navigation and routing functionality
- **Responsibilities**:
  - Landing page template routing (/de, /en)
  - Rewrite rules for multilingual URLs
  - Language detection
  - Navigation menu selection
  - Menu fallbacks

### 5. `inc/hero-section.php`

- **Purpose**: Hero section management for landing pages
- **Responsibilities**:
  - Custom meta boxes for hero content
  - Hero data saving and retrieval
  - Default content management
  - Form rendering and validation
  - Helper functions

### 6. `assets/js/hero-section-admin.js`

- **Purpose**: Admin JavaScript for hero section (vanilla JS)
- **Responsibilities**:
  - Media uploader integration
  - Image preview functionality
  - Form interaction handling
  - No jQuery dependency

## Key Improvements

### 1. **Modularity**

- Each file has a single responsibility
- Easy to locate and modify specific functionality
- Reduced cognitive load when working on specific features

### 2. **No jQuery Dependency**

- Hero section admin JavaScript uses vanilla JavaScript
- Modern ES6+ syntax with proper error handling
- Better performance and smaller bundle size

### 3. **Better Documentation**

- Comprehensive PHPDoc comments
- Clear function descriptions
- Parameter and return type documentation
- Inline code comments for complex logic

### 4. **Improved Security**

- Proper nonce verification
- Input sanitization
- Capability checks
- Direct access prevention

### 5. **Maintainability**

- Logical file organization
- Consistent coding standards
- Easy to extend and modify
- Clear separation of concerns

## Coding Standards

### PHP Standards

- WordPress Coding Standards compliance
- Proper function naming (`le_custom_*`)
- Comprehensive documentation
- Security best practices

### JavaScript Standards

- ES6+ syntax
- No jQuery dependency
- Proper error handling
- Modular structure
- Event delegation

## Adding New Features

### 1. **New Customizer Section**

Add to `inc/customizer.php`:

```php
function le_custom_add_new_section($wp_customize) {
    $wp_customize->add_section('new_section', [
        'title' => __('New Section', 'le-custom'),
        'priority' => 40,
    ]);

    // Add settings and controls...
}
```

### 2. **New Meta Box**

Create new file `inc/new-feature.php`:

```php
<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function le_custom_add_new_meta_boxes() {
    add_meta_box(
        'new_feature_settings',
        __('New Feature Settings', 'le-custom'),
        'le_custom_new_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'le_custom_add_new_meta_boxes');
```

Then include in `functions.php`:

```php
require_once get_template_directory() . '/inc/new-feature.php';
```

### 3. **New JavaScript Feature**

Create `assets/js/new-feature.js`:

```javascript
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    // Feature initialization
  });

  function initNewFeature() {
    // Feature logic
  }
})();
```

Enqueue in `inc/theme-setup.php`:

```php
wp_enqueue_script(
    'le-custom-new-feature',
    get_template_directory_uri() . '/assets/js/new-feature.js',
    [],
    wp_get_theme()->get('Version'),
    true
);
```

## Maintenance Guidelines

### 1. **Adding Functions**

- Place functions in the appropriate module file
- Follow naming convention: `le_custom_*`
- Add proper documentation
- Include security checks

### 2. **Modifying Existing Features**

- Locate the relevant module file
- Make changes within the existing structure
- Update documentation if needed
- Test thoroughly

### 3. **Debugging**

- Use the debug function in `inc/theme-setup.php`
- Check browser console for JavaScript errors
- Verify file includes in `functions.php`
- Test in development environment first

### 4. **Performance**

- Keep files focused and minimal
- Use proper WordPress hooks
- Avoid unnecessary database queries
- Optimize JavaScript loading

## Benefits of This Structure

1. **Easier Development**: Find and modify specific features quickly
2. **Better Collaboration**: Multiple developers can work on different modules
3. **Improved Testing**: Test individual components in isolation
4. **Enhanced Security**: Proper separation and validation
5. **Future-Proof**: Easy to extend and maintain
6. **WordPress Standards**: Follows WordPress coding best practices

## Migration Notes

If migrating from the old structure:

1. All functionality has been preserved
2. No breaking changes to existing features
3. Hero section editor now uses vanilla JavaScript
4. Better organized and documented code
5. Improved performance and maintainability

## Support

For questions about the refactored code:

1. Check this documentation first
2. Review the specific module file
3. Check WordPress Codex for function references
4. Test in development environment
5. Use WordPress debugging tools

## Authors

**Minh and Duc** - WordPress theme developers specializing in modern, multilingual themes for medical and dental practices.
