# Footer System Documentation

## Overview

The footer has been redesigned to match the provided image layout and is now fully modular and customizable through the WordPress Customizer.

## Structure

The footer is divided into separate template parts for easy maintenance:

### Template Parts Location

- `template-parts/footer/footer.php` - Main footer container
- `template-parts/footer/address.php` - Address section
- `template-parts/footer/contact.php` - Contact information section
- `template-parts/footer/appointments.php` - Appointments section
- `template-parts/footer/navigation.php` - Navigation links section

## Layout

The footer uses a 5-column grid layout:

1. **Address Section** - "So finden Sie uns" title with street and city
2. **Contact Section** - Phone and email with icons
3. **Appointments Section** - "Termine nach Vereinbarung"
4. **Empty Column** - Reserved space (social media removed as requested)
5. **Navigation Section** - Links with left border separator

## Customization

All footer content can be edited through the WordPress Customizer:

### Accessing Footer Settings

1. Go to **Appearance > Customize**
2. Look for **"Footer Settings"** section
3. Edit any of the following fields:

### Available Settings

#### Address Section

- **Street Address** - Default: "Wasagasse 24/8"
- **City/Postal Code** - Default: "1090 Wien"

#### Contact Section

- **Phone Number** - Default: "+43 664 - 274 537 8"
- **Email Address** - Default: "info@drsziklavari.at"

#### Appointments Section

- **Appointment Line 1** - Default: "Termine nach"
- **Appointment Line 2** - Default: "Vereinbarung"

#### Navigation Links

The footer navigation uses WordPress's built-in menu system. To set up the navigation:

1. Go to **Appearance > Menus**
2. Create a new menu or select an existing one
3. Add pages/links to the menu
4. Under "Menu Settings", check "Footer Menu" location
5. Save the menu

**Default fallback links** (if no menu is assigned):

- Kontakt
- Anfahrt
- Datenschutzerklärung
- Impressum

## Features

- **Responsive Design** - Adapts to mobile and desktop screens
- **Live Preview** - Changes appear immediately in the customizer
- **Selective Refresh** - Only the footer updates when changes are made
- **Modular Structure** - Easy to modify individual sections
- **Icon Integration** - Phone and email icons included
- **Hover Effects** - Interactive elements with smooth transitions

## Styling

The footer uses Tailwind CSS classes:

- Background: `bg-gray-900` (dark charcoal)
- Text: `text-white`
- Grid: `grid-cols-1 md:grid-cols-5` (responsive 5-column layout)
- Spacing: `gap-8` between columns
- Border: `border-l border-gray-700` for navigation separator

## Adding Social Media (Optional)

If you want to add social media back later:

1. Create `template-parts/footer/social.php`
2. Add it to the empty column in `footer.php`
3. Add corresponding customizer settings in `functions.php`

## Maintenance

To modify the footer:

1. Edit individual template parts for structural changes
2. Use the WordPress Customizer for content changes
3. Update customizer settings in `functions.php` for new fields
