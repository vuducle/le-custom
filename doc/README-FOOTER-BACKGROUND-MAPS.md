# Footer Background Image and Google Maps Setup Guide

## Overview

The footer now features a modern 3-column glassmorphism design with a customizable background image, embedded Google Maps iframe, and WordPress-powered navigation. The contact information and maps can be configured through the WordPress Customizer, while navigation is managed through WordPress Menus.

## How to Access the Settings

1. Log into your WordPress admin panel
2. Go to **Appearance** → **Customize**
3. Look for the **Footer Settings** section

## Footer Background Image

### Setting Up the Background Image

1. In the **Footer Settings** section, find **Footer Background Image**
2. Click **Select Image** to upload or choose an existing image
3. The image will automatically be applied as the footer background
4. A dark overlay will be added automatically to ensure text readability

### Image Recommendations

- **Size**: 1920x1080 pixels or larger for best results
- **Format**: JPG, PNG, or WebP
- **File size**: Keep under 2MB for optimal loading speed
- **Content**: Choose images that work well with dark overlays (dental office, medical equipment, etc.)

## Google Maps Integration

### Getting the Google Maps Embed URL

1. Go to [Google Maps](https://maps.google.com)
2. Search for your dental practice location
3. Click **Share** → **Embed a map**
4. Copy the iframe URL (starts with `https://www.google.com/maps/embed?pb=...`)

### Setting Up Google Maps

1. In the **Footer Settings** section, find **Google Maps iframe URL**
2. Paste the copied URL from Google Maps
3. Check the **Show Google Maps** checkbox to display the map
4. The map will appear in the center column of the 3-column footer layout

### Map Display Options

- **Show/Hide**: Use the **Show Google Maps** checkbox to toggle visibility
- **Responsive**: The map automatically adjusts to different screen sizes
- **Layout**: 3-column layout with contact info (left), maps (center), and navigation (right)
- **Styling**: Modern glassmorphism design with backdrop blur and transparency effects

## Footer Navigation Management

### Setting Up Footer Navigation

1. Go to **Appearance** → **Menus**
2. Create a new menu or select an existing one
3. Add pages, custom links, or other menu items
4. In the **Menu Settings** section, check **Footer Menu** location
5. Click **Save Menu**

### Navigation Features

- **WordPress Menu System**: Full WordPress menu management
- **Drag & Drop**: Reorder menu items easily
- **Add/Remove**: Add new pages or remove existing ones
- **Custom Links**: Add external links or custom URLs
- **Fallback Menu**: Default menu appears if no menu is assigned

## Technical Details

### Background Image Features

- **Cover sizing**: Image covers the entire footer area
- **Center positioning**: Image is centered for optimal display
- **No repeat**: Image doesn't repeat
- **Overlay**: Lighter overlay (40% opacity) to showcase glassmorphism effects
- **Responsive**: Works on all device sizes

### Glassmorphism Design Features

- **Backdrop blur**: Modern blur effects on all content cards
- **Transparency**: Semi-transparent backgrounds with white/10 opacity
- **Borders**: Subtle white borders with 20% opacity
- **Shadows**: Enhanced shadow effects for depth
- **Rounded corners**: Modern 2xl border radius for all cards

### Google Maps Features

- **Lazy loading**: Map loads only when needed
- **Security**: Uses `no-referrer-when-downgrade` policy
- **Accessibility**: Proper iframe attributes for screen readers
- **Performance**: Optimized loading with proper attributes

## Troubleshooting

### Background Image Not Showing

- Check that the image was uploaded successfully
- Verify the image URL is accessible
- Clear any caching plugins if using them

### Google Maps Not Displaying

- Verify the iframe URL is correct and complete
- Check that **Show Google Maps** is enabled
- Ensure the URL starts with `https://www.google.com/maps/embed`

### Text Readability Issues

- The dark overlay should automatically ensure text readability
- If text is still hard to read, consider using a darker or more contrasting background image

## Customization Tips

### Background Image Ideas

- Dental office interior shots
- Medical equipment (subtle)
- Abstract medical/dental patterns
- Professional office environments

### Google Maps Best Practices

- Use the exact location of your practice
- Test the embed URL in a browser first
- Consider the map size and zoom level for your location
- Update the map if you move locations

## Support

If you encounter any issues with these features, please contact your web developer or refer to the main theme documentation.
