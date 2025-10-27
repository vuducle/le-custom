# CTA Component Documentation

## Overview

The CTA (Call-to-Action) component is a reusable section that uses configured colors from the WordPress customizer and can be included in any page or template.

## Location

The component is located at: `template-parts/cta-section.php`

## Basic Usage

### Simple Implementation

To include the CTA section with default German content:

```php
<?php get_template_part('template-parts/cta-section'); ?>
```

### Custom Content

You can customize the CTA content by setting variables before including the component:

```php
<?php
// Set custom content for the CTA
$cta_title = 'Your Custom Title';
$cta_description = 'Your custom description text here.';
$cta_primary_button_text = 'Primary Button';
$cta_secondary_button_text = 'Secondary Button';
$cta_primary_button_url = 'https://example.com';
$cta_secondary_button_url = 'mailto:info@example.com';
$cta_section_id = 'custom-cta';
$cta_background_color = '#ff0000'; // Optional: override background color

get_template_part('template-parts/cta-section');
?>
```

## Available Variables

| Variable                     | Default Value                                | Description                              |
| ---------------------------- | -------------------------------------------- | ---------------------------------------- |
| `$cta_title`                 | 'Bereit für Ihren Termin?'                   | The main heading of the CTA section      |
| `$cta_description`           | 'Vereinbaren Sie noch heute einen Termin...' | The descriptive text below the title     |
| `$cta_primary_button_text`   | 'Jetzt anrufen'                              | Text for the primary (white) button      |
| `$cta_secondary_button_text` | 'E-Mail senden'                              | Text for the secondary (outlined) button |
| `$cta_primary_button_url`    | Phone number from customizer                 | URL for the primary button               |
| `$cta_secondary_button_url`  | Email from customizer                        | URL for the secondary button             |
| `$cta_section_id`            | 'termin'                                     | HTML ID for the section                  |
| `$cta_background_color`      | Primary color from customizer                | Background color of the section          |

## Color Integration

The component automatically uses colors configured in the WordPress customizer:

- **Background Color**: Uses the primary color from the color scheme
- **Primary Button**: White background with primary color text
- **Secondary Button**: White border with white text, hover effect to white background

## Examples

### German Landing Page (Default)

```php
<?php get_template_part('template-parts/cta-section'); ?>
```

### English Landing Page

```php
<?php
$cta_title = 'Ready for Your Appointment?';
$cta_description = 'Book an appointment today for a free initial consultation and let us take care of your oral health together.';
$cta_primary_button_text = 'Call Now';
$cta_secondary_button_text = 'Send Email';
$cta_section_id = 'appointment';
get_template_part('template-parts/cta-section');
?>
```

### Custom Service Page

```php
<?php
$cta_title = 'Interested in This Treatment?';
$cta_description = 'Contact us to learn more about this procedure and schedule your consultation.';
$cta_primary_button_text = 'Get Consultation';
$cta_secondary_button_text = 'Learn More';
$cta_primary_button_url = '#contact';
$cta_secondary_button_url = '#services';
$cta_section_id = 'service-cta';
get_template_part('template-parts/cta-section');
?>
```

### Custom Background Color

```php
<?php
$cta_title = 'Special Offer!';
$cta_description = 'Limited time offer for new patients.';
$cta_background_color = '#dc2626'; // Red background
get_template_part('template-parts/cta-section');
?>
```

## Responsive Design

The component is fully responsive and includes:

- Mobile-first design
- Responsive typography (text-3xl md:text-4xl)
- Flexible button layout (flex-col sm:flex-row)
- Proper spacing and padding for all screen sizes

## Accessibility

The component includes:

- Semantic HTML structure
- Proper heading hierarchy
- Accessible button styling
- Screen reader friendly text
- Keyboard navigation support

## Animations

The CTA component includes smooth AOS (Animate On Scroll) animations:

- **Title**: Fades up with 100ms delay
- **Description**: Fades up with 200ms delay
- **Buttons**: Fade up with 400ms delay
- **Background Icon**: Fades in from left with 300ms delay
- **Button Hover**: Scale effect (105%) with smooth transitions

## Dependencies

The component requires:

- `le_custom_get_color_scheme_data()` function (from customizer)
- `le_custom_get_contact_data()` function (from customizer)
- Tailwind CSS classes
- WordPress template functions
- AOS (Animate On Scroll) library (automatically included)

## Customization

To modify the component's appearance or behavior:

1. Edit `template-parts/cta-section.php` directly
2. Override CSS classes in your theme's stylesheet
3. Use the available variables to customize content
4. Modify the color scheme in the WordPress customizer
