# CTA Section Customizer Integration

## Overview

The CTA (Call-to-Action) section is now fully editable through the WordPress Customizer. This allows site administrators to customize the CTA content, styling, and behavior without editing code.

## Customizer Settings

### Location

The CTA settings can be found in the WordPress Customizer under:
**Appearance → Customize → CTA Section**

### Available Settings

#### Content Settings (Multilingual)

1. **CTA Title (German/English)**

   - Default German: "Bereit für Ihren Termin?"
   - Default English: "Ready for Your Appointment?"
   - Field type: Text input

2. **CTA Description (German/English)**

   - Default German: "Vereinbaren Sie noch heute einen Termin für eine kostenlose Erstberatung und lassen Sie uns gemeinsam für Ihre Zahngesundheit sorgen."
   - Default English: "Schedule an appointment today for a free initial consultation and let us work together for your dental health."
   - Field type: Textarea

3. **Primary Button Text (German/English)**

   - Default German: "Jetzt anrufen"
   - Default English: "Call Now"
   - Field type: Text input

4. **Secondary Button Text (German/English)**
   - Default German: "E-Mail senden"
   - Default English: "Send Email"
   - Field type: Text input

#### URL Settings

5. **Primary Button URL**

   - Description: Leave empty to use phone number from contact settings, or enter a custom URL
   - Field type: URL input
   - Default: Uses `tel:` + contact phone number

6. **Secondary Button URL**
   - Description: Leave empty to use email from contact settings, or enter a custom URL
   - Field type: URL input
   - Default: Uses `mailto:` + contact email

#### Styling Settings

7. **CTA Section ID**

   - Description: HTML ID for the CTA section (used for anchor links)
   - Field type: Text input
   - Default: "termin"

8. **CTA Background Color**
   - Description: Leave empty to use primary color from color scheme
   - Field type: Color picker
   - Default: Uses primary color from color scheme

#### Display Settings

9. **Show CTA Section**
   - Description: Enable or disable the CTA section
   - Field type: Checkbox
   - Default: Enabled (true)

## Language Detection

The CTA section automatically detects the current language and displays the appropriate content:

- **German pages**: Uses `_de` suffix settings
- **English pages**: Uses `_en` suffix settings
- **Fallback**: Uses German content if language detection fails

## Usage in Templates

### Basic Usage

```php
get_template_part('template-parts/cta-section');
```

### With Custom Overrides

```php
$custom_title = 'Custom CTA Title';
$custom_description = 'Custom description text';
get_template_part('template-parts/cta-section', null, [
    'cta_title' => $custom_title,
    'cta_description' => $custom_description
]);
```

## Data Retrieval

### Get CTA Data Programmatically

```php
$cta_data = le_custom_get_cta_data();
```

Returns an array with:

- `title`: CTA title for current language
- `description`: CTA description for current language
- `primary_button_text`: Primary button text for current language
- `secondary_button_text`: Secondary button text for current language
- `primary_button_url`: Primary button URL (falls back to phone)
- `secondary_button_url`: Secondary button URL (falls back to email)
- `section_id`: HTML ID for the section
- `background_color`: Background color (falls back to primary color)
- `show`: Whether to show the section

## Integration with Contact Data

The CTA section automatically integrates with the contact information:

- **Phone Button**: Uses the phone number from contact settings if no custom URL is provided
- **Email Button**: Uses the email from contact settings if no custom URL is provided
- **Background Color**: Falls back to the primary color from the color scheme if no custom color is set

## Live Preview

All CTA settings support live preview in the WordPress Customizer, allowing instant visual feedback when making changes.

## Selective Refresh

The CTA section supports selective refresh, meaning only the CTA section updates when changes are made, rather than refreshing the entire page.

## Security

All user inputs are properly sanitized:

- Text fields: `sanitize_text_field()`
- Textareas: `sanitize_textarea_field()`
- URLs: `esc_url_raw()`
- Colors: `sanitize_hex_color()`
- HTML classes: `sanitize_html_class()`
- Checkboxes: Custom sanitization function

## Troubleshooting

### CTA Section Not Showing

1. Check if "Show CTA Section" is enabled in the customizer
2. Verify that the template is calling `get_template_part('template-parts/cta-section')`
3. Check for any JavaScript errors in the browser console

### Language Not Switching

1. Ensure the language detection function `le_custom_get_current_language()` is working
2. Verify that both German and English content is set in the customizer
3. Check if the page URL contains language indicators

### Buttons Not Working

1. Verify that contact information is set in the contact settings
2. Check if custom URLs are properly formatted
3. Ensure no JavaScript conflicts are preventing button clicks

## Migration from Hardcoded Values

If you were previously using hardcoded values in the CTA section, the customizer will automatically use the default values. You can then customize them through the WordPress admin interface.

## Future Enhancements

Potential future improvements:

- Add more button styling options
- Include animation settings
- Add conditional display rules
- Support for multiple CTA sections
- Integration with analytics tracking
