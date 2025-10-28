# LE Custom WordPress Theme

A modern, multilingual WordPress theme built with Tailwind CSS, designed for dental practices and medical websites.

**Authors:** Minh and Duc

## Features

- 🌍 **Multilingual Support** (German/English)
- 📧 **Advanced Contact Form System** with email notifications
- 🎨 **Responsive Design** with Tailwind CSS
- 📱 **Mobile-friendly Navigation**
- ⚡ **Fast Loading** with optimized CSS
- 🔧 **Easy Customization** via WordPress Customizer
- 📊 **SEO Optimized**
- 🎯 **Professional Email System** (works automatically on production)
- 👤 **Enhanced Page Admin Interface** with quick edit metadata management

## Setup Instructions

### 1. Install Dependencies

Navigate to the theme directory and install npm dependencies:

```bash
cd themes/le-custom
npm install
```

### 2. Build CSS

For development (with watch mode):

```bash
npm run dev
```

For production build:

```bash
npm run build
```

### 3. Activate Theme

1. Go to your WordPress admin panel
2. Navigate to Appearance > Themes
3. Activate the "LE Custom" theme

### 4. Configure Contact Information

1. Go to Appearance > Customize > Contact Information
2. Set your practice name, address, phone, and email
3. Configure opening hours
4. Save changes

### 5. Test Contact Form

1. Visit your contact page (`/kontakt/` or `/contact/`)
2. Fill out and submit the contact form
3. Check your email inbox for notifications

## Development

### File Structure

```
le-custom/
├── src/
│   └── input.css                    # Source CSS with Tailwind directives
├── assets/
│   ├── css/                         # Compiled CSS files
│   ├── js/
│   │   ├── theme.js                 # Main theme JavaScript
│   │   ├── customizer.js            # Customizer live preview
│   │   ├── services-admin.js        # Services admin functionality
│   │   └── quick-edit-meta.js       # Enhanced page admin interface
│   ├── fonts/                       # Custom fonts
│   └── img/                         # Theme images
├── inc/
│   ├── theme-setup.php              # Theme initialization
│   ├── customizer.php               # Customizer settings
│   ├── contact-form-handler.php     # Contact form email system
│   ├── navigation.php               # Navigation functionality
│   ├── hero-section.php             # Hero section components
│   ├── services-admin.php           # Services management
│   ├── quick-edit-meta.php          # Enhanced page admin interface
│   └── ...                          # Other modular components
├── template-parts/                   # Reusable template components
├── page-contact-de.php              # German contact page
├── page-contact-en.php              # English contact page
├── page-landing-de.php              # German landing page
├── page-landing-en.php              # English landing page
├── functions.php                    # Main theme functions
├── package.json                     # NPM dependencies
├── postcss.config.js                # PostCSS configuration
└── tailwind.config.js               # Tailwind CSS configuration
```

## Enhanced Page Admin Interface

### Overview

The theme includes an enhanced WordPress admin interface for managing page metadata directly from the pages list with:

- 📝 **Quick Edit Enhancement** - Edit page metadata without opening full edit screen
- 🏗️ **Page Hierarchy Management** - Set parent-child relationships easily
- 🔗 **URL Slug Editing** - Modify page slugs with auto-formatting
- 📊 **SEO Optimization** - Custom page titles and meta descriptions
- 📱 **Mobile Responsive** - Works perfectly on all devices
- ⚡ **Real-time Validation** - Character counters and format checking

### Features

#### Quick Edit Fields

- **Page Slug**: Edit URL slugs with automatic formatting (removes spaces, special characters)
- **Parent Page**: Select parent pages to create hierarchical site structure
- **Custom Page Title**: Override auto-generated SEO titles (max 70 characters)
- **Meta Description**: Set custom meta descriptions for search engines (max 160 characters)

#### Enhanced Admin Columns

- **Slug Column**: Displays current page slugs in code format
- **Parent Column**: Shows parent page with clickable edit link
- **Meta Description Column**: Preview of current meta descriptions

#### User Experience

- **Character Counters**: Real-time feedback for optimal SEO lengths
- **Auto-formatting**: Slugs automatically converted to URL-friendly format
- **Visual Feedback**: Success states, loading indicators, validation messages
- **Professional Styling**: Clean interface matching WordPress design

### How to Use

1. **Navigate** to `Pages > All Pages` in WordPress admin
2. **Click** "Quick Edit" on any page
3. **Use** enhanced fields in the right panel:
   - Set page slug (auto-formatted)
   - Choose parent page from dropdown
   - Add custom SEO title and meta description
4. **Save** changes and see immediate feedback

### Benefits

- ⚡ **Faster Workflow** - Edit metadata without full page editor
- 🎯 **Better SEO** - Easy optimization of titles and descriptions
- 🏗️ **Site Structure** - Simple hierarchy management
- 📱 **Mobile Friendly** - Touch-optimized for tablets and phones
- ✅ **Data Integrity** - Built on WordPress core functionality

For detailed usage instructions, see: [Enhanced Page Admin Documentation](doc/README-ENHANCED-PAGE-ADMIN.md)

## Contact Form System

### Overview

The theme includes a complete contact form system with:

- 📧 **AJAX Form Submission** (no page reload)
- 🌍 **Multilingual Support** (German/English)
- 🔔 **Beautiful Notification System** (replaces browser alerts)
- 📬 **Automatic Email Delivery** (works on production hosting)
- ✅ **Form Validation** and error handling
- 🎨 **Modern UI** with loading states and animations

### How It Works

1. **User submits form** → AJAX request sent to WordPress
2. **Server processes** → Validates data and sends emails
3. **Emails sent** → Admin notification + user confirmation
4. **User sees** → Success notification with animation

### Email System

#### Production (Live Site)

- ✅ **Automatic**: Uses server's built-in mail function
- ✅ **No Configuration**: Works out of the box
- ✅ **Professional**: Reliable email delivery

#### Development (Local Environment)

- 🔧 **SMTP Required**: Uses configured SMTP settings
- 🔧 **Testing**: All emails redirected to development email
- 🔧 **Debugging**: Detailed error messages available

### Configuration

#### For Production (Recommended)

1. **Deploy to hosting** (Hostinger, Strato, etc.)
2. **Set admin email** in WordPress Settings
3. **Test contact form** - works automatically!

#### For Development

1. **Enable WP_DEBUG** in `wp-config.php`
2. **Configure SMTP** in `functions.php` (if needed)
3. **Test with** `yoursite.com/?test_email=1`

### Customization

#### Change Email Settings

Edit `functions.php` → `le_custom_get_smtp_config()`:

```php
$config = [
    'host' => 'smtp.hostinger.com',
    'auth' => true,
    'port' => 587,
    'secure' => 'tls',
    'password' => 'your_password'
];
```

#### Add New Languages

1. **Create notification messages** in `assets/js/theme.js`
2. **Add language detection** in `getCurrentLanguage()`
3. **Create contact page** (e.g., `page-contact-fr.php`)

### Customization

1. **Styling**: Edit `src/input.css` to add custom styles
2. **Configuration**: Modify `tailwind.config.js` for theme customization
3. **Templates**: Edit PHP files to modify layout and functionality
4. **Contact Form**: Customize in `inc/contact-form-handler.php`
5. **Email Templates**: Modify email HTML in contact form handler
6. **Page Admin Interface**: Customize in `inc/quick-edit-meta.php` and `assets/js/quick-edit-meta.js`

### Build Process

The theme uses PostCSS to process Tailwind CSS:

- `src/input.css` contains Tailwind directives and custom styles
- PostCSS processes this file and outputs to `dist/output.css`
- The compiled CSS is automatically enqueued by WordPress

## Multilingual Support

### Overview

The theme supports multiple languages with:

- 🌍 **Automatic Language Detection** (URL patterns, page templates)
- 📝 **Localized Content** (German/English contact forms)
- 🔔 **Multilingual Notifications** (success/error messages)
- 📧 **Localized Email Templates** (admin and user emails)

### Language Detection

The system automatically detects the current language based on:

1. **URL Patterns**: `/kontakt/` (German) vs `/contact/` (English)
2. **Page Templates**: `page-contact-de.php` vs `page-contact-en.php`
3. **Body Classes**: `page-contact-de` vs `page-contact-en`

### Adding New Languages

1. **Create Contact Page**: `page-contact-[lang].php`
2. **Add Language Detection**: Update `getCurrentLanguage()` in `assets/js/theme.js`
3. **Add Messages**: Add to `notificationMessages` object
4. **Create Email Templates**: Add to `le_custom_get_notification_messages()`

## Troubleshooting

### Contact Form Issues

#### Emails Not Sending

1. **Check hosting**: Ensure mail server is configured
2. **Test email**: Visit `yoursite.com/?test_email=1`
3. **Enable SMTP**: Add `define('FORCE_SMTP', true);` to `wp-config.php`
4. **Check spam folder**: Emails might be filtered

#### Form Not Submitting

1. **Check console**: Look for JavaScript errors
2. **Verify AJAX**: Ensure `admin-ajax.php` is accessible
3. **Check nonce**: Verify nonce is being generated correctly

#### Notification Not Showing

1. **Check JavaScript**: Ensure `theme.js` is loaded
2. **Verify language**: Check if language detection works
3. **Test notifications**: Use browser console to test `showNotification()`

### Development Issues

#### Local Email Testing

1. **Enable WP_DEBUG**: Set to `true` in `wp-config.php`
2. **Configure SMTP**: Update settings in `functions.php`
3. **Test redirect**: All emails go to development email
4. **Check logs**: Look in `wp-content/debug.log`

### Available Scripts

- `npm run build` - Build CSS once
- `npm run watch` - Build CSS and watch for changes
- `npm run dev` - Alias for watch mode

## Deployment & Client Setup

### For Clients (Production)

#### Quick Setup

1. **Upload theme** to WordPress themes directory
2. **Activate theme** in WordPress admin
3. **Configure contact info** in Customizer
4. **Test contact form** - works automatically!

#### No Configuration Needed

- ✅ **Emails work automatically** on production hosting
- ✅ **No SMTP setup** required
- ✅ **No plugins** needed
- ✅ **Professional email delivery**

### For Developers

#### Development Environment

1. **Enable debugging**: `define('WP_DEBUG', true);`
2. **Configure SMTP**: Update settings in `functions.php`
3. **Test emails**: Use `?test_email=1` parameter
4. **Check logs**: Monitor `wp-content/debug.log`

#### Customization for Different Clients

1. **Update SMTP settings** in `le_custom_get_smtp_config()`
2. **Change email templates** in contact form handler
3. **Add new languages** following multilingual guide
4. **Customize styling** via Tailwind CSS

### Email Configuration Examples

#### Hostinger

```php
'host' => 'smtp.hostinger.com',
'port' => 587,
'secure' => 'tls'
```

#### Strato

```php
'host' => 'smtp.strato.com',
'port' => 587,
'secure' => 'tls'
```

#### Gmail

```php
'host' => 'smtp.gmail.com',
'port' => 587,
'secure' => 'tls'
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## License

This theme is open source and available under the GPL v2 or later.
