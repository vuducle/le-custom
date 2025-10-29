<?php

/**
 * LE Custom Theme Functions
 * 
 * Main functions file that includes all theme functionality.
 * This file serves as the entry point and includes all modular components.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include modular functionality
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/dynamic-css.php';
require_once get_template_directory() . '/inc/navigation.php';
require_once get_template_directory() . '/inc/hero-section.php';
require_once get_template_directory() . '/inc/services-admin.php';
require_once get_template_directory() . '/inc/about-section.php';
require_once get_template_directory() . '/inc/gallery-block.php';
require_once get_template_directory() . '/inc/single-image-block.php';
require_once get_template_directory() . '/inc/child-pages-block.php';
require_once get_template_directory() . '/inc/contact-form-handler.php';
require_once get_template_directory() . '/inc/sitemap-generator.php';
require_once get_template_directory() . '/inc/cookie-consent.php';
require_once get_template_directory() . '/inc/quick-edit-meta.php';

// Initialize functionality
le_custom_init_contact_form();

// Add theme support
add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('custom-logo');
add_theme_support('html5', [
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script'
]);

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', 'le_custom_enqueue_scripts');
add_action('wp_enqueue_scripts', 'le_custom_enqueue_styles');

/**
 * Enqueue theme scripts
 */
function le_custom_enqueue_scripts()
{
    // Main theme script
    wp_enqueue_script(
        'theme-js',
        get_template_directory_uri() . '/assets/js/theme.js',
        [],
        '1.0',
        true
    );

    // reCAPTCHA v3 script for contact pages
    if (is_page_template('page-contact-de.php') || is_page_template('page-contact-en.php')) {
        $recaptcha_settings = le_custom_get_recaptcha_settings();

        if ($recaptcha_settings['enabled']) {
            wp_enqueue_script(
                'google-recaptcha',
                'https://www.google.com/recaptcha/api.js?render=' . $recaptcha_settings['site_key'],
                [],
                null,
                true
            );
        }

        // Localize script for contact forms
        wp_localize_script('theme-js', 'leCustomContact', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('contact_form_nonce'),
            'recaptcha' => [
                'enabled' => $recaptcha_settings['enabled'],
                'siteKey' => $recaptcha_settings['site_key']
            ]
        ]);
    }
}

/**
 * Enqueue theme styles
 */
function le_custom_enqueue_styles()
{
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/style.css',
        [],
        '1.0'
    );

    // Enqueue compiled Tailwind CSS
    wp_enqueue_style(
        'tailwind-style',
        get_template_directory_uri() . '/dist/output.css',
        [],
        '1.0'
    );
}

/**
 * Smart Email Configuration
 * Uses SMTP only when needed (development or when server mail fails)
 */
function le_custom_smart_email_config($phpmailer)
{
    // Check if we're in development or if we should force SMTP
    $force_smtp = defined('WP_DEBUG') && WP_DEBUG;

    // You can also force SMTP by adding this to wp-config.php:
    // define('FORCE_SMTP', true);
    if (defined('FORCE_SMTP') && FORCE_SMTP) {
        $force_smtp = true;
    }

    if ($force_smtp) {
        $phpmailer->isSMTP();

        // Get email settings from WordPress customizer or use defaults
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');

        // Use customizer email if set, otherwise use admin email
        $from_email = get_theme_mod('contact_email', $admin_email);

        // SMTP Configuration - can be customized per client
        $smtp_config = le_custom_get_smtp_config();

        $phpmailer->Host = $smtp_config['host'];
        $phpmailer->SMTPAuth = $smtp_config['auth'];
        $phpmailer->Port = $smtp_config['port'];
        $phpmailer->SMTPSecure = $smtp_config['secure'];
        $phpmailer->Username = $from_email;
        $phpmailer->Password = $smtp_config['password'];
        $phpmailer->From = $from_email;
        $phpmailer->FromName = $site_name;

        // Enable debugging only in development
        $phpmailer->SMTPDebug = (defined('WP_DEBUG') && WP_DEBUG) ? 0 : 0;
    }
}
add_action('phpmailer_init', 'le_custom_smart_email_config');

/**
 * Get SMTP configuration based on hosting provider
 * Easy to customize for different clients
 */
function le_custom_get_smtp_config()
{
    // Default configuration - change this for different clients
    $config = [
        'host' => 'smtp.hostinger.com',
        'auth' => true,
        'port' => 587,
        'secure' => 'tls',
        'password' => 'Donutdrake36!' // Change this for each client
    ];

    // You can override based on domain or environment
    $domain = $_SERVER['HTTP_HOST'] ?? '';

    // Example: Different config for different domains
    if (strpos($domain, 'client1.com') !== false) {
        $config = [
            'host' => 'smtp.strato.com',
            'auth' => true,
            'port' => 587,
            'secure' => 'tls',
            'password' => 'client1_password'
        ];
    } elseif (strpos($domain, 'client2.com') !== false) {
        $config = [
            'host' => 'smtp.gmail.com',
            'auth' => true,
            'port' => 587,
            'secure' => 'tls',
            'password' => 'client2_app_password'
        ];
    }

    return $config;
}

/**
 * Development email configuration
 * Redirects all emails to your development email for testing
 */
function le_custom_redirect_emails($email_data)
{
    // Only redirect in development environment
    if (defined('WP_DEBUG') && WP_DEBUG) {
        // Replace with your email address
        $email_data['to'] = 'info@le-vu-duc.com';

        // Add original recipient to subject for debugging
        $original_to = is_array($email_data['to']) ? implode(', ', $email_data['to']) : $email_data['to'];
        $email_data['subject'] = '[DEV] ' . $email_data['subject'] . ' (Original: ' . $original_to . ')';
    }

    return $email_data;
}
add_filter('wp_mail', 'le_custom_redirect_emails');

/**
 * Test email functionality
 * Add this URL parameter to test: ?test_email=1
 */
function le_custom_test_email()
{
    if (isset($_GET['test_email']) && current_user_can('manage_options')) {
        $to = 'info@le-vu-duc.com';
        $subject = 'Test Email from WordPress - ' . date('Y-m-d H:i:s');
        $message = 'This is a test email to verify that WordPress can send emails from your development environment.';
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        $result = wp_mail($to, $subject, $message, $headers);

        if ($result) {
            echo '<div style="background: green; color: white; padding: 20px; margin: 20px;">✅ Email sent successfully to info@le-vu-duc.com</div>';
        } else {
            echo '<div style="background: red; color: white; padding: 20px; margin: 20px;">❌ Email failed to send</div>';
        }

        exit;
    }
}
add_action('init', 'le_custom_test_email');

/**
 * Get services data based on current language
 * 
 * @return array Services data including title, description, list, and settings
 */
/**
 * Detect language based on page template or URL
 * 
 * @return string Language code ('de' or 'en')
 */
function le_custom_detect_language()
{
    global $post;

    // Check if we're on a German or English landing page
    if ($post && $post->post_name) {
        if (strpos($post->post_name, '-de') !== false || strpos($post->post_name, 'deutsch') !== false) {
            return 'de';
        } elseif (strpos($post->post_name, '-en') !== false || strpos($post->post_name, 'english') !== false) {
            return 'en';
        }
    }

    // Check URL for language indicators
    $current_url = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($current_url, '/de/') !== false || strpos($current_url, '-de') !== false) {
        return 'de';
    } elseif (strpos($current_url, '/en/') !== false || strpos($current_url, '-en') !== false) {
        return 'en';
    }

    // Default to German
    return 'de';
}

/**
 * Get services data based on current language
 * 
 * @return array Services data including title, description, list, and settings
 */
function le_custom_get_services_data()
{
    $language = le_custom_detect_language();

    // Get services data based on language
    $services_title = get_theme_mod('services_section_title_' . $language, $language === 'de' ? 'Unsere Leistungen' : 'Our Services');
    $services_description = get_theme_mod(
        'services_section_description_' . $language,
        $language === 'de'
            ? 'Wir bieten ein umfassendes Spektrum an zahnmedizinischen Behandlungen für Ihre optimale Zahngesundheit.'
            : 'We offer a comprehensive range of dental treatments for your optimal oral health.'
    );
    $services_list = json_decode(get_theme_mod('services_list_' . $language, '[]'), true);
    $show_services = get_theme_mod('show_services_section', true);
    $services_position = get_theme_mod('services_position', 'overlay');

    return [
        'title' => $services_title,
        'description' => $services_description,
        'list' => $services_list,
        'show' => $show_services,
        'position' => $services_position,
        'language' => $language
    ];
}

/**
 * Get contact information data
 * 
 * This is a wrapper function to make contact data easily accessible
 * throughout the theme. It uses the centralized contact data function.
 * 
 * @return array Contact information data
 */
function le_custom_get_contact_info()
{
    return le_custom_get_contact_data();
}

/**
 * Get formatted contact information for display
 * 
 * @param string $type Type of contact info to get ('address', 'phone', 'email', 'hours', 'languages')
 * @return string Formatted contact information
 */
function le_custom_get_formatted_contact($type = 'address')
{
    $contact_data = le_custom_get_contact_data();

    switch ($type) {
        case 'address':
            return $contact_data['address']['street'] . ', ' . $contact_data['address']['city'];

        case 'phone':
            return $contact_data['phone']['display'];

        case 'phone_link':
            return $contact_data['phone']['link'];

        case 'email':
            return $contact_data['email'];

        case 'hours':
            $hours = [];
            foreach ($contact_data['opening_hours'] as $day => $hours_text) {
                if (!empty($hours_text)) {
                    $hours[] = $hours_text;
                }
            }
            return implode('<br>', $hours);

        case 'languages':
            return $contact_data['languages'];

        case 'practice_name':
            return $contact_data['practice_name'];

        default:
            return '';
    }
}

/**
 * Check if contact information should be displayed
 * 
 * @param string $context Context where contact info is being displayed ('bar', 'footer', 'all')
 * @return bool Whether to show contact information
 */
function le_custom_should_show_contact($context = 'all')
{
    $contact_data = le_custom_get_contact_data();

    switch ($context) {
        case 'bar':
            return $contact_data['contact_bar']['show'];

        case 'footer':
            return true; // Always show in footer

        case 'all':
        default:
            return true;
    }
}

/**
 * Get contact data from theme customizer
 * 
 * @return array Contact information data
 */
function le_custom_get_contact_data()
{
    return [
        'practice_name' => get_theme_mod('practice_name', 'Zahnarztpraxis Java'),
        'address' => [
            'street' => get_theme_mod('contact_street', 'Eichhornstraße 1'),
            'city' => get_theme_mod('contact_city', '10785 Berlin'),
            'country' => get_theme_mod('contact_country', 'Deutschland'),
        ],
        'phone' => [
            'display' => get_theme_mod('contact_phone_display', '030 / 62 47 92'),
            'link' => get_theme_mod('contact_phone_link', '030624792'),
        ],
        'email' => get_theme_mod('contact_email', 'denis@java.com'),
        'vat_id' => get_theme_mod('vat_id', ''),
        'opening_hours' => [
            'monday' => get_theme_mod('opening_monday', '09:00 - 12:00 Uhr, 13:00 - 18:00 Uhr'),
            'tuesday' => get_theme_mod('opening_tuesday', '08:00 - 12:00 Uhr, 13:00 - 18:00 Uhr'),
            'wednesday' => get_theme_mod('opening_wednesday', '08:00 - 14:00 Uhr'),
            'thursday' => get_theme_mod('opening_thursday', '08:00 - 12:00 Uhr, 13:00 - 18:00 Uhr'),
            'friday' => get_theme_mod('opening_friday', '08:00 - 14:00 Uhr'),
        ],
        'languages' => get_theme_mod('contact_languages', 'Deutsch & Englisch'),
        'appointment' => [
            'line1' => get_theme_mod('appointment_line1', 'Termine nach'),
            'line2' => get_theme_mod('appointment_line2', 'Vereinbarung'),
        ],
        'maps' => [
            'iframe_url' => get_theme_mod('google_maps_iframe_url', ''),
            'show' => get_theme_mod('show_google_maps', true),
            'google_my_business_name' => get_theme_mod('google_my_business_name', ''),
        ],
        'contact_bar' => [
            'show' => get_theme_mod('show_contact_bar', true),
            'bg_color' => get_theme_mod('contact_bar_bg_color', '#f9fafb'),
            'text_color' => get_theme_mod('contact_bar_text_color', '#6b7280'),
        ],
        'legal' => [
            'privacy_policy_de' => get_theme_mod('privacy_policy_de', ''),
            'privacy_policy_en' => get_theme_mod('privacy_policy_en', ''),
            'imprint_de' => get_theme_mod('imprint_de', ''),
            'imprint_en' => get_theme_mod('imprint_en', ''),
        ],
    ];
}

/**
 * Get color scheme data
 * 
 * @return array Color scheme data
 */
function le_custom_get_color_scheme_data()
{
    return [
        'primary' => get_theme_mod('primary_color', '#059669'),
        'primary_light' => get_theme_mod('primary_color_light', '#ecfdf5'),
        'secondary' => get_theme_mod('secondary_color', '#0ea5e9'),
        'secondary_light' => get_theme_mod('secondary_color_light', '#f0f9ff'),
    ];
}

/**
 * Generate Google Maps iframe URL based on current address
 * 
 * @return string Google Maps iframe URL
 */
function le_custom_generate_google_maps_url()
{
    $contact_data = le_custom_get_contact_data();

    // Check if Google My Business name is available
    if (!empty($contact_data['maps']['google_my_business_name'])) {
        // Use Google My Business name + address for better accuracy
        $search_query = $contact_data['maps']['google_my_business_name'] . ', ' . $contact_data['address']['street'] . ', ' . $contact_data['address']['city'] . ', ' . $contact_data['address']['country'];
    } else {
        // Fall back to address only
        $search_query = $contact_data['address']['street'] . ', ' . $contact_data['address']['city'] . ', ' . $contact_data['address']['country'];
    }

    // URL encode the search query for the Google Maps iframe
    $encoded_query = urlencode($search_query);

    // Generate the Google Maps iframe URL
    $maps_url = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=' . $encoded_query;

    return $maps_url;
}
