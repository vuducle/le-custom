# Landing Page Templates

This theme includes custom landing page templates for both German and English versions of your dental practice website.

## Available Templates

### 1. German Landing Page (`page-landing-de.php`)

- **Template Name**: "Landing Page - German"
- **Language**: German
- **URL Structure**: `/de/` (when used with German pages)

### 2. English Landing Page (`page-landing-en.php`)

- **Template Name**: "Landing Page - English"
- **Language**: English
- **URL Structure**: `/en/` (when used with English pages)

## Features

Both templates include:

- **Hero Section**: Eye-catching header with call-to-action buttons
- **Services Section**: Three main service categories with icons
- **About Section**: Practice information with opening hours
- **Call-to-Action Section**: Appointment booking and contact options
- **Content Area**: WordPress page content integration
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Modern UI**: Clean, professional design suitable for dental practices

## How to Use

### 1. Create New Pages

1. Go to **WordPress Admin** → **Pages** → **Add New**
2. Create two pages:
   - **German Page**: Title in German, set template to "Landing Page - German"
   - **English Page**: Title in English, set template to "Landing Page - English"

### 2. Set Template

When editing each page:

1. In the **Page Attributes** section (usually in the sidebar)
2. Select the appropriate template from the **Template** dropdown:
   - "Landing Page - German" for German content
   - "Landing Page - English" for English content

### 3. Configure URLs

For proper multilingual structure, set the page slugs:

- German page: `/de/` or `/de/startseite/`
- English page: `/en/` or `/en/homepage/`

### 4. Customize Content

Each template includes:

- **Pre-built sections** with dental practice content
- **Editable content area** where you can add custom WordPress content
- **Contact information** that can be customized in the theme customizer

## Customization Options

### Contact Information

Update contact details in the CTA section:

- Phone number: `tel:+49123456789`
- Email: `mailto:info@zahnarzt-praxis.de` (German) / `mailto:info@dental-practice.com` (English)

### Opening Hours

Modify the opening hours in the About section of each template file.

### Services

Update the three service categories in the Services section:

- **German**: Vorsorge & Prophylaxe, Füllungstherapie, Ästhetische Zahnmedizin
- **English**: Prevention & Prophylaxis, Restorative Dentistry, Cosmetic Dentistry

### Colors and Styling

The templates use Tailwind CSS classes. You can customize:

- Primary color: `blue-600` (currently used)
- Background colors: `gray-50`, `white`
- Text colors: `gray-900`, `gray-700`, `gray-600`

## Multilingual Setup

For proper multilingual functionality, consider using:

- **WPML** plugin for complete multilingual support
- **Polylang** plugin for language management
- **Custom language switcher** in the navigation

## SEO Considerations

- Each template includes proper heading structure (H1, H2, H3)
- Semantic HTML with appropriate sections
- Meta descriptions should be set in WordPress SEO plugins
- Schema markup can be added for local business information

## Browser Compatibility

The templates are built with:

- **Tailwind CSS** for styling
- **Modern CSS Grid and Flexbox**
- **Responsive design** for all device sizes
- **Progressive enhancement** approach

## Support

For customization or issues:

1. Check the theme's main README.md
2. Review the functions.php file for available customizer options
3. Ensure Tailwind CSS is properly compiled

## File Structure

```
le-custom/
├── page-landing-de.php     # German landing page template
├── page-landing-en.php     # English landing page template
├── README-LANDING-PAGES.md # This documentation
└── ... (other theme files)
```

## Notes

- The linter errors about undefined WordPress functions are normal in this context
- These functions are available when the templates are used within WordPress
- The templates follow WordPress coding standards and best practices
- All content is properly escaped and follows security guidelines
