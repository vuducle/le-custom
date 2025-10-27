# Hero Section Color Customization

This document explains how to use the new color customization features in the hero section.

## Overview

The hero section now supports dynamic color customization that integrates with the global color scheme from the WordPress Customizer. Text is displayed in white with shadows for optimal readability, while buttons automatically use the global colors for consistent branding.

## Available Color Options

### Background Color

- **Global Primary Light Color**: Uses the primary light color from the Customizer (default: #ecfdf5)
- **Custom Color**: Choose any custom color using the color picker

### Text Colors

- **Title & Subtitle**: Always white with text shadows for optimal readability
- **No customization needed**: Automatically optimized for all background types

### Button Colors

- **Primary Button**: Uses global primary color from Customizer (default: #059669)
- **Secondary Button**: Uses global secondary color from Customizer (default: #0ea5e9)
- **Automatic**: No manual configuration needed - buttons automatically use global colors

## How to Use

1. **Edit a Landing Page**: Go to Pages → Edit the German (de) or English (en) landing page
2. **Find Hero Section Settings**: Look for the "Hero Section Settings" meta box
3. **Configure Background Color**:
   - Choose "Global" to use the primary light color from customizer
   - Choose "Custom" to use the color picker for a custom background color
4. **Save Changes**: Update the page to apply your changes

## Global Color Integration

The hero section automatically uses colors from the WordPress Customizer:

- **Primary Color**: Used for the primary button background
- **Secondary Color**: Used for the secondary button border and text
- **Primary Light Color**: Used for background when "Global" is selected

## Background Image Priority

When a background image is set and enabled, it takes priority over all background color settings. The overlay is automatically applied for better text readability.

## Text Readability

All text (title and subtitle) is automatically displayed in white with text shadows to ensure optimal readability against any background color or image.

## Technical Implementation

### Functions Added

- `le_custom_get_hero_color_value()`: Gets the actual color value based on type and customizer settings
- `le_custom_get_hero_background_style()`: Generates CSS background styles based on settings

### Database Fields

New meta fields are stored for each page:

- `_hero_background_color_type`: 'global' or 'custom'
- `_hero_background_custom_color`: Custom color hex value

## Default Values

- **Background Color**: Global Primary Light Color
- **Text Colors**: White with shadows (automatic)
- **Button Colors**: Global colors (automatic)

## Browser Support

The color picker uses the HTML5 `<input type="color">` element, which is supported in all modern browsers.

## Troubleshooting

If colors don't appear to change:

1. Make sure you've saved the page after making changes
2. Clear any caching plugins
3. Check that the Customizer colors are set if using global colors
4. Verify that the page is using the correct template (landing-de or landing-en)
