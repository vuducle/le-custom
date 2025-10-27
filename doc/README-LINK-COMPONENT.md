# Link Component Documentation

## Overview

The Link Component is a customizable button that appears in the header of the website. It allows clients to easily configure the URL, text, icon, and visibility through the WordPress Customizer.

## Features

- **Customizable URL**: Set any external link (e.g., Doctolib appointment page)
- **Customizable Text**: Change the button text to match your needs
- **Icon Selection**: Choose from 5 different icons (Calendar, Phone, External Link, Heart, Star)
- **Show/Hide Toggle**: Enable or disable the component entirely
- **Responsive Design**: Works on both desktop and mobile devices
- **External Link Handling**: Opens in new tab with proper security attributes

## Configuration

### Accessing the Customizer

1. Go to **Appearance > Customize** in your WordPress admin
2. Look for the **"Link Component"** section in the left sidebar

### Available Settings

#### Link URL

- **Type**: URL field
- **Description**: Enter the URL for the link component (e.g., Doctolib appointment page)
- **Example**: `https://www.doctolib.de/praxis/berlin/your-practice`

#### Link Text

- **Type**: Text field
- **Default**: "Doctolib"
- **Description**: Enter the text to display on the link button
- **Examples**: "Book Appointment", "Online Booking", "Schedule Visit"

#### Link Icon

- **Type**: Dropdown selection
- **Default**: Calendar
- **Options**:
  - **Calendar**: Appointment/booking icon
  - **Phone**: Phone call icon
  - **External Link**: External link icon
  - **Heart**: Heart/love icon
  - **Star**: Star/favorite icon

#### Show Link Component

- **Type**: Checkbox
- **Default**: Enabled
- **Description**: Enable or disable the link component in the header

## Usage Examples

### Doctolib Integration

```
URL: https://www.doctolib.de/praxis/berlin/your-practice
Text: "Termin buchen"
Icon: Calendar
Show: Enabled
```

### Phone Call Button

```
URL: tel:+49123456789
Text: "Anrufen"
Icon: Phone
Show: Enabled
```

### External Website Link

```
URL: https://your-external-website.com
Text: "Mehr Info"
Icon: External Link
Show: Enabled
```

## Technical Details

### File Structure

- **Customizer Settings**: `inc/customizer.php` (lines 893-970)
- **Helper Function**: `le_custom_get_link_component_data()`
- **Desktop Template**: `template-parts/header/link-component.php`
- **Mobile Integration**: `template-parts/header/mobile-navigation.php`

### CSS Classes

The component uses the existing `appointment-cta` class for styling, ensuring consistency with the theme's design system.

### Security Features

- URLs are sanitized using `esc_url_raw()`
- External links open in new tabs with `target="_blank"`
- Proper security attributes: `rel="noopener noreferrer"`

## Customization

### Adding New Icons

To add new icons, modify the `le_custom_get_link_icon_svg()` function in `template-parts/header/link-component.php` and add the new option to the customizer choices.

### Styling

The component inherits styling from the `appointment-cta` class. To customize the appearance, modify the CSS in your theme's stylesheet.

### Conditional Display

The component automatically hides if:

- The "Show Link Component" setting is disabled
- No URL is provided
- The URL field is empty

## Troubleshooting

### Component Not Visible

1. Check if "Show Link Component" is enabled in the customizer
2. Verify that a URL is entered in the "Link URL" field
3. Clear any caching plugins
4. Check browser console for JavaScript errors

### Styling Issues

1. Ensure the `appointment-cta` CSS class is properly defined
2. Check for CSS conflicts with other theme elements
3. Verify Tailwind CSS is loading correctly

### Mobile Display Issues

1. Check the mobile navigation template for proper integration
2. Verify responsive breakpoints are working correctly
3. Test on different mobile devices and screen sizes

## Best Practices

1. **Use Descriptive Text**: Choose button text that clearly indicates the action
2. **Select Appropriate Icons**: Match the icon to the action (calendar for appointments, phone for calls)
3. **Test External Links**: Always test that external links work correctly
4. **Mobile Testing**: Verify the component works well on mobile devices
5. **Performance**: Keep URLs short and efficient

## Support

For technical support or customization requests, refer to the theme documentation or contact the development team.
