# Color System Documentation

## Overview

The LE Custom theme now includes a comprehensive color system with emerald-600 as the primary color and sky-500 as the secondary color, designed to be family-friendly for a dentist website. All colors are configurable through the WordPress customizer.

## Color Palette

### Primary Colors (Emerald Family)

- **Primary Color**: `#059669` (emerald-600) - Main brand color
- **Primary Light**: `#ecfdf5` (emerald-50) - Light backgrounds

### Secondary Colors (Sky Family)

- **Secondary Color**: `#0ea5e9` (sky-500) - Accent color
- **Secondary Light**: `#f0f9ff` (sky-50) - Light backgrounds

## Customizer Integration

### Color Scheme Section

The color system is fully integrated into the WordPress customizer under the "Color Scheme" section with the following options:

1. **Primary Color** - Main brand color used throughout the website
2. **Secondary Color** - Accent color for highlights and secondary elements
3. **Primary Color Light** - Light version of primary color for backgrounds
4. **Secondary Color Light** - Light version of secondary color for backgrounds

### Live Preview

All color changes are reflected in real-time in the customizer preview, including:

- Navigation elements
- Service section backgrounds and buttons
- Contact information links
- Focus states and accessibility elements
- Custom scrollbar

## Implementation Details

### CSS Custom Properties

The theme uses CSS custom properties (CSS variables) for dynamic color application:

```css
:root {
  --primary-color: #059669;
  --primary-color-light: #ecfdf5;
  --secondary-color: #0ea5e9;
  --secondary-color-light: #f0f9ff;
}
```

### Dynamic CSS Output

Colors are dynamically output through PHP in the `inc/dynamic-css.php` file, ensuring that customizer changes are immediately reflected.

### Tailwind Configuration

The Tailwind CSS configuration has been updated to include the new color palette:

```javascript
colors: {
    primary: {
        50: '#ecfdf5',
        100: '#d1fae5',
        200: '#a7f3d0',
        300: '#6ee7b7',
        400: '#34d399',
        500: '#10b981',
        600: '#059669',
        700: '#047857',
        800: '#065f46',
        900: '#064e3b',
    },
    secondary: {
        50: '#f0f9ff',
        100: '#e0f2fe',
        200: '#bae6fd',
        300: '#7dd3fc',
        400: '#38bdf8',
        500: '#0ea5e9',
        600: '#0284c7',
        700: '#0369a1',
        800: '#075985',
        900: '#0c4a6e',
    }
}
```

## Usage Examples

### In PHP Templates

```php
<?php
$color_scheme = le_custom_get_color_scheme_data();
?>
<div style="background-color: <?php echo esc_attr($color_scheme['primary_light']); ?>;">
    <button style="background-color: <?php echo esc_attr($color_scheme['primary']); ?>;">
        Click me
    </button>
</div>
```

### In CSS

```css
.my-element {
  background-color: var(--primary-color-light);
  color: var(--primary-color);
  border-color: var(--secondary-color);
}
```

### In Tailwind Classes

```html
<div class="bg-primary-600 text-white">
  <span class="text-secondary-500">Accent text</span>
</div>
```

## Files Modified

1. **`tailwind.config.js`** - Updated color palette
2. **`inc/customizer.php`** - Added color scheme section
3. **`inc/dynamic-css.php`** - New file for dynamic CSS output
4. **`style.css`** - Updated to use CSS custom properties
5. **`template-parts/services-section.php`** - Updated to use dynamic colors
6. **`assets/js/customizer.js`** - Added live preview functionality
7. **`functions.php`** - Included dynamic CSS file

## Benefits

1. **Family-Friendly Design** - Emerald and sky colors are calming and professional
2. **Dental Industry Appropriate** - Colors convey trust, cleanliness, and professionalism
3. **Fully Customizable** - All colors can be changed through the WordPress customizer
4. **Consistent Implementation** - Uses CSS custom properties for maintainability
5. **Live Preview** - Changes are reflected immediately in the customizer
6. **Accessibility** - Proper contrast ratios maintained across color combinations

## Future Enhancements

- Color scheme presets for different dental specialties
- Dark mode support
- Seasonal color variations
- Advanced color palette generator
