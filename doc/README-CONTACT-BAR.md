# Contact Information Bar - CMS Editable

The contact information bar at the top of the website is now fully editable through the WordPress Customizer.

## How to Edit Contact Information

### 1. Access the Customizer

1. Log into your WordPress admin panel
2. Go to **Appearance** → **Customize**
3. Click on **Contact Information** in the left sidebar

### 2. Available Settings

#### Basic Information

- **Address**: The physical address displayed in the contact bar
- **Phone Number**: The phone number as displayed to visitors
- **Phone Link**: The phone number for click-to-call functionality (numbers only, no spaces)
- **Email Address**: The email address for mailto links

#### Display Options

- **Show Contact Information Bar**: Toggle to show/hide the entire contact bar
- **Contact Bar Background Color**: Customize the background color
- **Contact Bar Text Color**: Customize the text color

### 3. Live Preview

All changes are previewed in real-time as you make them. You can see exactly how your changes will look before publishing.

### 4. Publishing Changes

Click **Publish** to save your changes and make them live on your website.

## Technical Details

### Files Modified

- `functions.php` - Added customizer settings and controls
- `template-parts/contact-info.php` - Template part for contact information
- `assets/js/customizer.js` - Live preview functionality
- `header.php` - Updated to use template part

### Features

- ✅ **Live Preview**: See changes instantly
- ✅ **Selective Refresh**: Only updates the contact bar, not the entire page
- ✅ **Validation**: Email addresses are validated
- ✅ **Sanitization**: All inputs are properly sanitized
- ✅ **Responsive**: Works on all screen sizes
- ✅ **Accessibility**: Proper ARIA labels and keyboard navigation

### Default Values

- Address: "Moltkeplatz 4a, 23566 Lübeck"
- Phone: "0451 / 62 47 92"
- Phone Link: "0451624792"
- Email: "info@zahnarztpraxis-durkalets.de"
- Background Color: Light gray (#f9fafb)
- Text Color: Gray (#6b7280)

## Customization Examples

### Change Contact Information

1. Go to Customizer → Contact Information
2. Update the address, phone, or email fields
3. Click Publish

### Hide Contact Bar

1. Go to Customizer → Contact Information
2. Uncheck "Show Contact Information Bar"
3. Click Publish

### Change Colors

1. Go to Customizer → Contact Information
2. Use the color pickers for background and text colors
3. Click Publish

## Troubleshooting

### Contact Bar Not Showing

- Check if "Show Contact Information Bar" is enabled
- Ensure at least one contact field (address, phone, or email) has content

### Phone Link Not Working

- Make sure the "Phone Link" field contains only numbers
- Remove spaces, dashes, and other characters

### Colors Not Updating

- Clear your browser cache
- Check if your theme's CSS is overriding the customizer styles

## Support

For technical support or questions about the contact information bar, please refer to the theme documentation or contact your developer.
