# Directions Pages with Google Maps Integration

This document describes the new directions pages that provide route calculation functionality using Google Maps integration.

## Overview

Two new page templates have been created to help visitors find directions to the dental practice:

- `page-directions-de.php` - German version (Anfahrt & Wegbeschreibung)
- `page-directions-en.php` - English version (Directions & Route)

## Features

### 🗺️ Interactive Google Maps

- Embedded Google Maps iframe showing the practice location
- Uses the Google Maps iframe URL from the customizer settings
- Fallback placeholder when map is not available
- Direct links to open in Google Maps or get directions

### 🚗 Route Calculator

- Form to enter starting address
- Transportation mode selection (Car, Walking, Bicycle, Public Transport)
- Generates Google Maps directions URLs with proper parameters
- Shows route summary and direct link to Google Maps

### 📍 Address Information

- Displays practice name and full address
- Phone number with clickable link
- Uses data from the customizer contact settings

### 🚌 Transportation Options

- Information about different transportation methods:
  - Public Transportation
  - Car (with parking information)
  - Bicycle (with parking spaces)
  - Walking (accessibility information)

### ♿ Accessibility Information

- Highlights wheelchair accessibility
- Mentions elevator and accessible restrooms
- Contact information for accessibility questions

## Technical Implementation

### Files Created

- `page-directions-de.php` - German directions page template
- `page-directions-en.php` - English directions page template

### Dependencies

- Uses existing customizer functions:
  - `le_custom_get_contact_data()` - For address and contact information
  - `le_custom_get_color_scheme_data()` - For theme colors
  - `le_custom_get_formatted_address()` - For formatted address string

### Google Maps Integration

- **Dynamic Map Display**: Automatically generates Google Maps iframe URLs based on current address
- **Google My Business Support**: Uses business name + address for enhanced accuracy when configured
- **Route Calculation**: Generates Google Maps directions URLs with parameters:
  - `driving` = `3e0`
  - `walking` = `3e2`
  - `bicycling` = `3e1`
  - `transit` = `3e3`

### JavaScript Functionality

- Form submission handling
- URL generation for Google Maps directions
- Dynamic result display
- Smooth scrolling to results

## Usage

### Creating Pages in WordPress

1. Create a new page in WordPress admin
2. Set the page template to "Directions - German" or "Directions - English"
3. Publish the page

### URL Structure

- German: `/anfahrt/` (recommended)
- English: `/directions/` (recommended)

### Customizer Settings Required

The pages use the following customizer settings:

- Practice name
- Street address
- City and country
- Phone number
- Google My Business name (optional, for enhanced accuracy)
- Map display toggle

**Note**: The Google Maps iframe URL is now automatically generated from your address and Google My Business name, so manual URL management is no longer required.

## Styling

### Design Features

- Responsive grid layout (1 column on mobile, 2 columns on desktop)
- Modern card-based design with shadows and rounded corners
- Consistent color scheme using theme colors
- Hover effects and transitions
- Icon-based information display

### Color Scheme

- Primary: Blue (#3B82F6) for maps and links
- Secondary: Green (#10B981) for directions
- Accent: Emerald gradient for buttons
- Background: Gray gradient for page background

## Browser Compatibility

### Supported Features

- Modern browsers with ES6+ support
- Responsive design for all screen sizes
- Touch-friendly interface for mobile devices

### Fallbacks

- Map placeholder when iframe fails to load
- Graceful degradation for JavaScript-disabled browsers
- Accessible form elements and navigation

## SEO Considerations

### Structured Data

- Address information is properly structured
- Contact information follows schema.org guidelines
- Accessible markup for screen readers

### Performance

- Lazy loading for Google Maps iframe
- Optimized images and icons
- Minimal JavaScript footprint

## Maintenance

### Updates Required

- Address information in customizer (automatically updates all maps)
- Google My Business name in customizer (for enhanced accuracy)
- Transportation information (if local services change)

**Note**: Maps now update automatically when you change your address or business name - no manual URL updates required.

### Monitoring

- Check Google Maps iframe functionality regularly
- Verify route calculation URLs work correctly
- Test on different devices and browsers

## Troubleshooting

### Common Issues

1. **Map not displaying**: Check iframe URL in customizer
2. **Route calculation not working**: Verify JavaScript is enabled
3. **Address not showing**: Check customizer contact settings

### Debug Steps

1. Check browser console for JavaScript errors
2. Verify customizer settings are saved
3. Test Google Maps URLs manually
4. Check iframe permissions and loading

## Future Enhancements

### Potential Improvements

- Real-time traffic information
- Estimated travel times
- Multiple route options
- Integration with local transit APIs
- Mobile app deep linking
- Voice navigation support

### Accessibility Improvements

- ARIA labels for better screen reader support
- Keyboard navigation improvements
- High contrast mode support
- Reduced motion preferences

## Support

For technical support or questions about the directions pages, refer to:

- WordPress customizer documentation
- Google Maps API documentation
- Theme development guidelines
