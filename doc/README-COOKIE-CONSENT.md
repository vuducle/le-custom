# Cookie Consent Overlay System

A comprehensive, SEO-friendly, and performant cookie consent solution for WordPress themes that supports both German and English languages.

## Features

- **GDPR Compliant**: Full compliance with EU data protection regulations
- **SEO Optimized**: No blocking scripts, structured data support
- **Performance Optimized**: Lazy loading, minimal impact on page load
- **Accessible**: WCAG 2.1 AA compliant with keyboard navigation and screen reader support
- **Mobile Responsive**: Optimized for all device sizes
- **Multilingual**: German and English support with automatic language detection
- **Customizable**: Extensive customization options via WordPress Customizer
- **Modern Design**: Clean, professional interface with smooth animations

## Installation

The cookie consent system is automatically included with the theme. No additional installation steps are required.

## Configuration

### WordPress Customizer Settings

Navigate to **Appearance > Customize > Cookie Consent** to configure:

- **Show Analytics Cookies Option**: Enable/disable analytics cookie choice
- **Show Marketing Cookies Option**: Enable/disable marketing cookie choice
- **Position**: Choose between bottom, top, or center overlay position
- **Theme**: Light or dark theme
- **Enable Animations**: Toggle smooth animations

### Language Detection

The system automatically detects the current language based on:

1. URL path (e.g., `/en/` for English)
2. Language parameter (`?lang=en`)
3. Defaults to German if no language is detected

## Usage

### Basic Implementation

The cookie consent overlay is automatically displayed to users who haven't given consent. No additional code is required.

### Checking Consent Status

```php
// In PHP
$cookie_consent = new LE_Cookie_Consent();

if ($cookie_consent->has_consent('necessary')) {
    // Load necessary scripts
    wp_enqueue_script('form-handler');
}
```

```javascript
// In JavaScript
if (LE_Cookie_Consent.hasConsent("necessary")) {
  // Load necessary scripts
  loadFormHandler();
}
```

### Listening for Consent Changes

```javascript
document.addEventListener("cookieConsentChanged", function (event) {
  const consent = event.detail.consent;

  if (consent.necessary) {
    // Initialize necessary functionality
    console.log("Necessary cookies accepted");
  }
});
```

### Manual Consent Management

```javascript
// Accept all cookies
LE_Cookie_Consent.acceptAll();

// Accept selected cookies
LE_Cookie_Consent.acceptSelected();

// Reject all cookies (except necessary)
LE_Cookie_Consent.rejectAll();

// Close overlay
LE_Cookie_Consent.close();

// Get consent data
const consentData = LE_Cookie_Consent.getConsentData();
```

## Customization

### Styling

The cookie consent overlay automatically uses the primary color from your WordPress Customizer. The system generates dynamic CSS that applies your theme's primary color to:

- Primary buttons
- Toggle switches
- Focus indicators
- Loading spinner

You can also customize the colors using CSS custom properties:

```css
:root {
  --cookie-consent-primary-color: #your-color;
  --cookie-consent-primary-hover: #your-hover-color;
  --cookie-consent-primary-focus: #your-focus-color;
}
```

### Custom Positions

Add custom CSS for additional positioning options:

```css
.cookie-consent-custom {
  position: fixed;
  top: 20px;
  right: 20px;
  max-width: 400px;
  transform: translateX(100%);
  transition: transform 0.3s ease;
}

.cookie-consent-custom.show {
  transform: translateX(0);
}
```

### Custom Themes

Create custom themes by extending the existing CSS:

```css
.cookie-consent-custom-theme .cookie-consent-container {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 20px;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
```

## Cookie Types

### Necessary Cookies

- **Always enabled**: Cannot be disabled
- **Purpose**: Essential website functionality
- **Examples**: Session management, security tokens, form submissions

## GDPR Compliance

### Required Features

✅ **Explicit Consent**: Users must actively choose their preferences
✅ **Granular Control**: Separate toggles for different cookie types
✅ **Easy Withdrawal**: Users can change preferences at any time
✅ **Clear Information**: Detailed descriptions of each cookie type
✅ **No Pre-ticked Boxes**: All optional cookies start unchecked
✅ **Consent Records**: Timestamp and version tracking

### Privacy Policy Integration

The system automatically links to:

- Privacy Policy page (`/de/datenschutzerklaerung/` or `/en/datenschutzerklaerung/`)
- Imprint page (`/de/impressum/` or `/en/impressum/`)

## Accessibility Features

### WCAG 2.1 AA Compliance

- **Keyboard Navigation**: Full keyboard support with focus management
- **Screen Reader Support**: ARIA labels and live regions
- **High Contrast**: Support for high contrast mode
- **Reduced Motion**: Respects user's motion preferences
- **Focus Indicators**: Clear focus indicators for all interactive elements

### Keyboard Shortcuts

- **Tab**: Navigate between elements
- **Shift + Tab**: Navigate backwards
- **Enter/Space**: Activate buttons
- **Escape**: Close overlay

## Performance Optimization

### Loading Strategy

- **Lazy Loading**: Assets only load when consent is pending
- **Minimal CSS**: Optimized styles with no unused code
- **Efficient JavaScript**: Modern ES6+ with minimal bundle size
- **No Blocking**: Scripts don't block page rendering

### Caching

- **Static Assets**: CSS and JS files are cacheable
- **Cookie Storage**: Consent data stored in browser cookies
- **No Server Calls**: Consent checking happens client-side

## Browser Support

- **Modern Browsers**: Chrome 80+, Firefox 75+, Safari 13+, Edge 80+
- **Mobile Browsers**: iOS Safari 13+, Chrome Mobile 80+
- **Fallbacks**: Graceful degradation for older browsers

## Troubleshooting

### Common Issues

#### Overlay Not Showing

1. Check if consent cookie exists
2. Verify JavaScript is loading
3. Check browser console for errors

#### Styling Issues

1. Clear browser cache
2. Check for CSS conflicts
3. Verify custom CSS specificity

#### Language Not Detecting

1. Check URL structure
2. Verify language parameter
3. Check fallback language

### Debug Mode

Enable debug logging by adding to `wp-config.php`:

```php
define('COOKIE_CONSENT_DEBUG', true);
```

### Testing

#### Manual Testing Checklist

- [ ] Overlay appears for new visitors
- [ ] Overlay doesn't appear for users with consent
- [ ] All buttons work correctly
- [ ] Keyboard navigation works
- [ ] Screen reader announces overlay
- [ ] Mobile layout is responsive
- [ ] Consent is saved correctly
- [ ] Language detection works

#### Automated Testing

```javascript
// Test consent checking
console.log("Has consent:", LE_Cookie_Consent.hasConsent());
console.log("Analytics consent:", LE_Cookie_Consent.hasConsent("analytics"));
console.log("Marketing consent:", LE_Cookie_Consent.hasConsent("marketing"));

// Test consent data
console.log("Consent data:", LE_Cookie_Consent.getConsentData());
```

## API Reference

### PHP Methods

#### `LE_Cookie_Consent::has_consent($type = 'all')`

Check if user has given consent for specific cookie type.

**Parameters:**

- `$type` (string): Cookie type ('all', 'analytics', 'marketing', 'necessary')

**Returns:** boolean

#### `LE_Cookie_Consent::get_consent_status()`

Get the current consent status.

**Returns:** array|null

### JavaScript Methods

#### `LE_Cookie_Consent.hasConsent(type = 'all')`

Check if user has given consent for specific cookie type.

**Parameters:**

- `type` (string): Cookie type ('all', 'necessary')

**Returns:** boolean

#### `LE_Cookie_Consent.getConsentData()`

Get the current consent data.

**Returns:** object|null

#### `LE_Cookie_Consent.acceptAll()`

Accept all cookie types.

#### `LE_Cookie_Consent.acceptSelected()`

Accept only selected cookie types.

#### `LE_Cookie_Consent.rejectAll()`

Reject all optional cookies.

#### `LE_Cookie_Consent.close()`

Close the consent overlay.

## Events

### `cookieConsentChanged`

Fired when consent status changes.

**Event Detail:**

```javascript
{
    consent: {
        necessary: boolean
    },
    timestamp: number
}
```

## File Structure

```
inc/
├── cookie-consent.php          # Main PHP class
assets/
├── css/
│   └── cookie-consent.css      # Styles
└── js/
    └── cookie-consent.js       # JavaScript functionality
doc/
└── README-COOKIE-CONSENT.md    # This documentation
```

## Changelog

### Version 1.0.0

- Initial release
- GDPR compliant consent management
- Multilingual support (DE/EN)
- Accessibility features
- WordPress Customizer integration
- Performance optimizations

## Support

For support and questions:

1. Check this documentation
2. Review browser console for errors
3. Test with different browsers/devices
4. Contact theme developer

## License

This cookie consent system is part of the LE Custom WordPress theme and follows the same license terms.

## Authors

**Minh and Duc** - WordPress theme developers specializing in modern, multilingual themes for medical and dental practices.
