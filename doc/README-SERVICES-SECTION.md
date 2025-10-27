# Services Section Documentation

## Overview

The Services Section is a modern, glassmorphism-styled component that can be positioned as an overlay on the hero section or as a separate section. It supports both German and English content and is fully customizable through the WordPress Customizer.

## Features

- **Glassmorphism Design**: Modern frosted glass effect with backdrop blur
- **Dual Language Support**: Separate content for German and English pages
- **Flexible Positioning**: Can be positioned as an overlay or separate section
- **Fully Editable**: All content can be modified through WordPress Customizer
- **Responsive Design**: Optimized for all screen sizes
- **Hover Effects**: Smooth animations and transitions

## Configuration

### Accessing the Settings

1. Go to **Appearance → Customize** in WordPress admin
2. Navigate to **Services Section** in the left sidebar

### Available Settings

#### Section Content

- **Section Title (German)**: Main heading for German pages
- **Section Description (German)**: Subtitle text for German pages
- **Section Title (English)**: Main heading for English pages
- **Section Description (English)**: Subtitle text for English pages

#### Services List

- **Services (German)**: JSON array of services for German pages
- **Services (English)**: JSON array of services for English pages

#### Display Options

- **Show Services Section**: Toggle to show/hide the entire section
- **Services Position**: Choose between "Overlay on Hero" or "Separate Section"

## Services JSON Structure

Each service in the JSON array should have the following structure:

```json
{
  "title": "Service Title",
  "description": "Service description text",
  "button_text": "Button Text",
  "button_url": "#",
  "icon": "icon_name"
}
```

### Available Icons

- `aesthetic` - Dental aesthetics icon
- `prosthetics` - Dental prosthetics icon
- `pediatric` - Pediatric dentistry icon
- `periodontics` - Periodontology icon
- `default` - Default lightning bolt icon

### Example JSON

```json
[
  {
    "title": "Zahnästhetik",
    "description": "Lücken, Fehlstellungen und Verfärbungen beeinträchtigen unser ästhetisches Empfinden. Mit Veneers, Bleaching und Co. verbessern wir die Zahnästhetik!",
    "button_text": "Mehr erfahren",
    "button_url": "#",
    "icon": "aesthetic"
  },
  {
    "title": "Zahnersatz & Zahnerhaltung",
    "description": "Geht es um Zahnersatz oder die Rettung Ihrer Zähne, bieten sich verschiedene Optionen an. Gerne beraten wir Sie in unserer Praxis individuell und fachgerecht!",
    "button_text": "Mehr erfahren",
    "button_url": "#",
    "icon": "prosthetics"
  }
]
```

## Language Detection

The system automatically detects the language based on:

1. **Page Slug**: Pages with `-de` or `-en` in the slug
2. **URL Path**: URLs containing `/de/` or `/en/`
3. **Default**: Falls back to German if no language is detected

## Positioning Options

### Overlay Mode (Default)

- Positioned absolutely over the hero section
- Glassmorphism effect with backdrop blur
- Translates down by 50% to create overlay effect
- White text with semi-transparent backgrounds

### Separate Section Mode

- Standard section with white background
- Traditional card-based layout
- Dark text on light backgrounds

## Styling

### Glassmorphism Effect (Overlay Mode)

- Background: `bg-white/10` (10% white opacity)
- Backdrop blur: `backdrop-blur-md`
- Border: `border border-white/20`
- Shadow: `shadow-2xl`

### Hover Effects

- Cards lift up slightly (`hover:-translate-y-1`)
- Enhanced shadow (`hover:shadow-xl`)
- Smooth transitions (`transition-all duration-300`)

### Responsive Grid

- Mobile: Single column
- Tablet: 2 columns (`md:grid-cols-2`)
- Desktop: 4 columns (`lg:grid-cols-4`)

## Implementation

### Template Usage

The services section is automatically included in both German and English landing pages:

```php
<?php get_template_part('template-parts/services-section'); ?>
```

### Manual Integration

To add the services section to other templates:

```php
<?php
$services_data = le_custom_get_services_data();
if ($services_data['show'] && !empty($services_data['list'])) {
    get_template_part('template-parts/services-section');
}
?>
```

## Customization

### Adding New Icons

To add new icons, modify the `le_custom_get_service_icon()` function in `template-parts/services-section.php`:

```php
function le_custom_get_service_icon($icon_name) {
    $icons = [
        'your_icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="..."></path>
        </svg>',
        // ... existing icons
    ];

    return $icons[$icon_name] ?? $icons['default'];
}
```

### Custom Styling

The section uses Tailwind CSS classes. To customize the styling:

1. Modify the classes in `template-parts/services-section.php`
2. Add custom CSS to `style.css` if needed
3. Update the glassmorphism effect by modifying the background and backdrop classes

## Troubleshooting

### Services Not Displaying

1. Check if "Show Services Section" is enabled in Customizer
2. Verify that services JSON is valid
3. Ensure the page template is properly detecting the language

### Language Issues

1. Check page slug for language indicators (`-de`, `-en`)
2. Verify URL structure for language detection
3. Ensure separate content is set for both languages

### Styling Problems

1. Check if Tailwind CSS is properly loaded
2. Verify backdrop-blur support in the browser
3. Ensure proper z-index values for overlay positioning

## Browser Support

- **Backdrop Blur**: Modern browsers (Chrome 76+, Firefox 70+, Safari 9+)
- **CSS Grid**: All modern browsers
- **CSS Transforms**: All modern browsers
- **Fallback**: Graceful degradation for older browsers
