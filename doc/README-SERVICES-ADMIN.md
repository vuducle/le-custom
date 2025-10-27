# Services Admin Interface

## Overview

The Services Admin Interface provides a user-friendly way to manage dental services for both German and English pages without having to edit complex JSON directly in the WordPress Customizer.

## Features

- **Visual Interface**: Easy-to-use form fields instead of JSON editing
- **Bilingual Support**: Separate tabs for German and English services
- **Drag & Drop**: Reorder services by dragging them
- **Icon Selection**: Dropdown menu with predefined dental icons
- **Real-time Validation**: Form validation and error handling
- **AJAX Saving**: Save changes without page reload
- **Responsive Design**: Works on desktop and mobile devices

## How to Access

1. Log into your WordPress admin panel
2. Go to **Appearance** → **Services** in the admin menu
3. You'll see two tabs: "German Services" and "English Services"

## Managing Services

### Adding a New Service

1. Click the **"Add New Service"** button in the appropriate language tab
2. Fill in the required fields:
   - **Service Title** (required)
   - **Description** (required)
   - **Button Text** (optional - defaults to "Mehr erfahren" / "Learn More")
   - **Button URL** (optional - defaults to "#")
   - **Icon** (optional - choose from predefined dental icons)

### Editing Existing Services

1. Click on any service card to expand it
2. Modify the fields as needed
3. Changes are automatically saved when you click "Save All Services"

### Removing Services

1. Click the **"Remove"** button in the service header
2. Confirm the deletion in the popup dialog

### Reordering Services

1. Click and drag the service header (the gray bar with the service number)
2. Drop it in the desired position
3. The service numbers will automatically update

## Available Icons

The interface includes these predefined dental icons:

- **Dental Aesthetics** - For cosmetic dentistry services
- **Dental Prosthetics** - For dental prosthetics and preservation
- **Pediatric Dentistry** - For children's dental care
- **Periodontology** - For gum disease treatment
- **Dental Surgery** - For surgical procedures
- **Dental Hygiene** - For cleaning and preventive care
- **Orthodontics** - For braces and alignment
- **Implantology** - For dental implants
- **Emergency Care** - For urgent dental care
- **Default Icon** - Generic service icon

## Form Fields Explained

### Required Fields

- **Service Title**: The main heading for the service (e.g., "Zahnästhetik")
- **Description**: Detailed explanation of the service (appears below the title)

### Optional Fields

- **Button Text**: Text for the call-to-action button (defaults to language-appropriate text)
- **Button URL**: Link destination for the button (defaults to "#")
- **Icon**: Visual icon representing the service type

## Technical Details

### Data Storage

- Services are stored as JSON in WordPress theme mods
- German services: `services_list_de`
- English services: `services_list_en`
- Maintains backward compatibility with existing JSON structure

### File Structure

```
inc/
├── services-admin.php          # Main admin interface logic
assets/
├── js/
│   └── services-admin.js       # JavaScript for dynamic functionality
└── css/
    └── services-admin.css      # Styling for the admin interface
```

### AJAX Endpoints

- `le_custom_save_services`: Saves services via AJAX
- Nonce protection for security
- Error handling and success messages

## Troubleshooting

### Services Not Saving

1. Check that you have administrator permissions
2. Ensure all required fields are filled
3. Try refreshing the page and saving again
4. Check browser console for JavaScript errors

### Icons Not Displaying

1. Verify that the icon name matches one of the available options
2. Check that the services section template is properly loading icons

### Language Detection Issues

1. Ensure page templates have proper language indicators (-de, -en)
2. Check URL structure for language indicators
3. Verify that language detection function is working correctly

## Migration from JSON

If you have existing services configured via JSON in the Customizer:

1. The admin interface will automatically load existing services
2. You can continue using the JSON method if preferred
3. Both methods will work simultaneously
4. Changes made in the admin interface will update the JSON automatically

## Customization

### Adding New Icons

To add new icons, modify the `$available_icons` array in `inc/services-admin.php`:

```php
$available_icons = [
    'your_icon_name' => __('Your Icon Label', 'le-custom'),
    // ... existing icons
];
```

Then add the corresponding SVG in the `le_custom_get_service_icon()` function in `template-parts/services-section.php`.

### Styling Customization

Modify `assets/css/services-admin.css` to customize the appearance of the admin interface.

### JavaScript Enhancements

Add custom functionality by modifying `assets/js/services-admin.js`.

## Support

For technical support or feature requests, please refer to the main theme documentation or contact the development team.
