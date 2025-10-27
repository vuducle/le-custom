# Google Maps Integration with Google My Business Support

This document explains how the Google Maps integration works in the LE Custom theme and how to configure it with Google My Business for better accuracy.

## Overview

The theme includes a dynamic Google Maps integration that automatically generates iframe URLs based on your contact information. When combined with Google My Business, it provides enhanced accuracy and better user experience. This integration works across all pages that display maps, including the footer and directions pages.

## Features

- **Dynamic URL Generation**: Maps URLs are automatically generated from your address
- **Google My Business Integration**: Use your exact GMB listing name for better accuracy
- **Automatic Updates**: Maps update when you change your address or business name
- **Fallback Support**: Works with address-only if no GMB name is provided
- **Multi-Page Support**: Works on footer, directions pages, and any other map implementations

## Configuration

### 1. Basic Setup

1. Go to **Appearance → Customize → Contact Information**
2. Ensure your address is correctly set:
   - Street Address
   - City & Postal Code
   - Country
3. Enable "Show Google Maps" checkbox

### 2. Google My Business Integration (Optional but Recommended)

1. Create a Google My Business listing for your practice
2. In the customizer, find the "Google My Business Name" field
3. Enter the **exact name** as it appears in your Google My Business listing
4. Example: "Zahnarztpraxis Dr. Armin Dorri" (not just "Armin Dorri")

### 3. Directions Pages

The Google Maps integration is automatically applied to:

- **Footer maps**: Shows on all pages
- **Directions pages**: German (`/anfahrt`) and English (`/directions`) pages
- **Any other map implementations**: Uses the same dynamic system

All maps will automatically update when you change your address or Google My Business name.

## How It Works

### Without Google My Business Name

- Uses: `Street Address, City, Country`
- Example: `Eichhornstraße 1, 10785 Berlin, Deutschland`

### With Google My Business Name

- Uses: `Business Name, Street Address, City, Country`
- Example: `Zahnarztpraxis Dr. Armin Dorri, Eichhornstraße 1, 10785 Berlin, Deutschland`

## Benefits of Using Google My Business Name

1. **Better Accuracy**: Google Maps will find your exact business location
2. **Brand Recognition**: Your business name appears in the map search
3. **Consistent Results**: Matches your GMB listing exactly
4. **SEO Benefits**: Aligns with your online business presence

## Technical Details

### URL Generation

The theme uses the Google Maps Embed API with the following format:

```
https://www.google.com/maps/embed/v1/place?key=API_KEY&q=SEARCH_QUERY
```

### API Key

The theme uses a public API key for basic embedding functionality. For production use with high traffic, consider:

1. Getting your own Google Maps API key
2. Adding it as a customizer setting
3. Implementing usage monitoring

## Troubleshooting

### Map Not Showing Correct Location

1. Verify your Google My Business name matches exactly
2. Check that your address is complete and accurate
3. Ensure your GMB listing is verified and published

### Map Not Loading

1. Check your internet connection
2. Verify the "Show Google Maps" setting is enabled
3. Clear browser cache and refresh

### Performance Issues

1. The map loads asynchronously for better performance
2. Consider implementing lazy loading for multiple maps
3. Monitor API usage if using a custom key

## Best Practices

1. **Keep Information Updated**: Update both GMB and theme settings when information changes
2. **Use Exact Names**: Match your GMB listing name exactly
3. **Complete Address**: Include street, city, and country for best results
4. **Regular Verification**: Periodically check that the map shows the correct location

## Future Enhancements

Potential improvements for future versions:

- Custom API key support
- Multiple location support
- Interactive map features
- Directions integration
- Street view integration
