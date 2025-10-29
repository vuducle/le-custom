<?php

/**
 * Theme Customizer
 * 
 * Handles all theme customization options including contact information,
 * footer settings, and other theme-wide configurations.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer additions
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_customize_register($wp_customize)
{
    // Add Color Scheme Section
    le_custom_add_color_scheme_section($wp_customize);

    // Add Contact Information Section
    le_custom_add_contact_section($wp_customize);

    // Add Footer Section
    le_custom_add_footer_section($wp_customize);

    // Add Services Section
    le_custom_add_services_section($wp_customize);

    // Add Legal Pages Section
    le_custom_add_legal_pages_section($wp_customize);

    // Add Link Component Section
    le_custom_add_link_component_section($wp_customize);

    // Add CTA Section
    le_custom_add_cta_section($wp_customize);
}

add_action('customize_register', 'le_custom_customize_register');

/**
 * Add color scheme section to customizer
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_add_color_scheme_section($wp_customize)
{
    $wp_customize->add_section('color_scheme', [
        'title'    => __('Color Scheme', 'le-custom'),
        'priority' => 25,
    ]);

    // Primary Color
    $wp_customize->add_setting('primary_color', [
        'default'           => '#059669', // emerald-600
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', [
        'label'       => __('Primary Color', 'le-custom'),
        'description' => __('Main brand color used throughout the website', 'le-custom'),
        'section'     => 'color_scheme',
    ]));

    // Secondary Color
    $wp_customize->add_setting('secondary_color', [
        'default'           => '#0ea5e9', // sky-500
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', [
        'label'       => __('Secondary Color', 'le-custom'),
        'description' => __('Accent color for highlights and secondary elements', 'le-custom'),
        'section'     => 'color_scheme',
    ]));

    // Primary Color Light (for backgrounds)
    $wp_customize->add_setting('primary_color_light', [
        'default'           => '#ecfdf5', // emerald-50
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_light', [
        'label'       => __('Primary Color Light', 'le-custom'),
        'description' => __('Light version of primary color for backgrounds', 'le-custom'),
        'section'     => 'color_scheme',
    ]));

    // Secondary Color Light (for backgrounds)
    $wp_customize->add_setting('secondary_color_light', [
        'default'           => '#f0f9ff', // sky-50
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color_light', [
        'label'       => __('Secondary Color Light', 'le-custom'),
        'description' => __('Light version of secondary color for backgrounds', 'le-custom'),
        'section'     => 'color_scheme',
    ]));

    // Selective refresh for color scheme
    $wp_customize->selective_refresh->add_partial('color_scheme', [
        'selector'        => 'body',
        'container_inclusive' => true,
        'render_callback' => 'le_custom_color_scheme_callback',
    ]);
}

/**
 * Color scheme callback for selective refresh
 */
function le_custom_color_scheme_callback()
{
    // This will refresh the entire page since colors affect the whole site
    return;
}

// Color scheme data function moved to functions.php to avoid duplication

/**
 * Add contact information section to customizer
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_add_contact_section($wp_customize)
{
    $wp_customize->add_section('contact_information', [
        'title'    => __('Contact Information', 'le-custom'),
        'priority' => 30,
    ]);

    // Practice Information
    $wp_customize->add_setting('practice_name', [
        'default'           => 'Zahnarztpraxis Armin Dorri',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('practice_name', [
        'label'   => __('Practice Name', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    // Address Settings
    $wp_customize->add_setting('contact_street', [
        'default'           => '68 Nguyễn Huệ',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('contact_street', [
        'label'   => __('Street Address', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('contact_city', [
        'default'           => 'Hồ Chí Minh 70000',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('contact_city', [
        'label'   => __('City & Postal Code', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('contact_country', [
        'default'           => 'Deutschland',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('contact_country', [
        'label'   => __('Country', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    // Phone Settings
    $wp_customize->add_setting('contact_phone_display', [
        'default'           => '030 / 62 47 92',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('contact_phone_display', [
        'label'   => __('Phone Number (Display)', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('contact_phone_link', [
        'default'           => '030624792',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('contact_phone_link', [
        'label'       => __('Phone Number (Link)', 'le-custom'),
        'description' => __('Enter phone number without spaces or special characters for click-to-call functionality', 'le-custom'),
        'section'     => 'contact_information',
        'type'        => 'text',
    ]);

    // Email Setting
    $wp_customize->add_setting('contact_email', [
        'default'           => 'denis@java.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('contact_email', [
        'label'   => __('Email Address', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'email',
    ]);

    // VAT ID Setting
    $wp_customize->add_setting('vat_id', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('vat_id', [
        'label'       => __('VAT ID / USt-IdNr.', 'le-custom'),
        'description' => __('Value Added Tax Identification Number (e.g., DE123456789)', 'le-custom'),
        'section'     => 'contact_information',
        'type'        => 'text',
    ]);

    // Opening Hours Settings - Individual Days
    $wp_customize->add_setting('opening_monday', [
        'default'           => '09:00 - 12:00 Uhr, 13:00 - 18:00 Uhr',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('opening_monday', [
        'label'   => __('Monday Hours', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('opening_tuesday', [
        'default'           => '08:00 - 12:00 Uhr, 13:00 - 18:00 Uhr',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('opening_tuesday', [
        'label'   => __('Tuesday Hours', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('opening_wednesday', [
        'default'           => '08:00 - 14:00 Uhr',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('opening_wednesday', [
        'label'   => __('Wednesday Hours', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('opening_thursday', [
        'default'           => '08:00 - 12:00 Uhr, 13:00 - 18:00 Uhr',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('opening_thursday', [
        'label'   => __('Thursday Hours', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('opening_friday', [
        'default'           => '08:00 - 14:00 Uhr',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('opening_friday', [
        'label'   => __('Friday Hours', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);


    // Languages Setting
    $wp_customize->add_setting('contact_languages', [
        'default'           => 'Deutsch & Englisch',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('contact_languages', [
        'label'   => __('Languages Spoken', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    // Appointment Information
    $wp_customize->add_setting('appointment_line1', [
        'default'           => 'Termine nach',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('appointment_line1', [
        'label'   => __('Appointment Line 1', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('appointment_line2', [
        'default'           => 'Vereinbarung',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('appointment_line2', [
        'label'   => __('Appointment Line 2', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'text',
    ]);

    // Google Maps Settings
    $wp_customize->add_setting('google_maps_iframe_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('google_maps_iframe_url', [
        'label'       => __('Google Maps iframe URL', 'le-custom'),
        'description' => __('Paste the Google Maps embed URL here (e.g., https://www.google.com/maps/embed?pb=...)', 'le-custom'),
        'section'     => 'contact_information',
        'type'        => 'url',
    ]);

    $wp_customize->add_setting('show_google_maps', [
        'default'           => true,
        'sanitize_callback' => 'le_custom_sanitize_checkbox',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('show_google_maps', [
        'label'   => __('Show Google Maps', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'checkbox',
    ]);

    // Google My Business Name Setting
    $wp_customize->add_setting('google_my_business_name', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('google_my_business_name', [
        'label'       => __('Google My Business Name', 'le-custom'),
        'description' => __('Enter your exact Google My Business listing name to improve map accuracy. Leave empty to use address only.', 'le-custom'),
        'section'     => 'contact_information',
        'type'        => 'text',
    ]);

    // Contact Bar Display Settings
    $wp_customize->add_setting('show_contact_bar', [
        'default'           => true,
        'sanitize_callback' => 'le_custom_sanitize_checkbox',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('show_contact_bar', [
        'label'   => __('Show Contact Information Bar', 'le-custom'),
        'section' => 'contact_information',
        'type'    => 'checkbox',
    ]);

    // Contact Bar Styling
    $wp_customize->add_setting('contact_bar_bg_color', [
        'default'           => '#f9fafb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'contact_bar_bg_color', [
        'label'   => __('Contact Bar Background Color', 'le-custom'),
        'section' => 'contact_information',
    ]));

    $wp_customize->add_setting('contact_bar_text_color', [
        'default'           => '#6b7280',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'contact_bar_text_color', [
        'label'   => __('Contact Bar Text Color', 'le-custom'),
        'section' => 'contact_information',
    ]));

    // reCAPTCHA v3 Settings
    $wp_customize->add_setting('recaptcha_site_key', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('recaptcha_site_key', [
        'label'       => __('reCAPTCHA Site Key', 'le-custom'),
        'description' => __('Enter your reCAPTCHA v3 site key. Get it from <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA</a>', 'le-custom'),
        'section'     => 'contact_information',
        'type'        => 'text',
    ]);

    $wp_customize->add_setting('recaptcha_secret_key', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('recaptcha_secret_key', [
        'label'       => __('reCAPTCHA Secret Key', 'le-custom'),
        'description' => __('Enter your reCAPTCHA v3 secret key. This is used for server-side verification.', 'le-custom'),
        'section'     => 'contact_information',
        'type'        => 'password',
    ]);

    $wp_customize->add_setting('recaptcha_score_threshold', [
        'default'           => '0.5',
        'sanitize_callback' => 'le_custom_sanitize_recaptcha_score',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('recaptcha_score_threshold', [
        'label'       => __('reCAPTCHA Score Threshold', 'le-custom'),
        'description' => __('Set the minimum score (0.0 to 1.0). Lower scores indicate more bot-like behavior. Default: 0.5', 'le-custom'),
        'section'     => 'contact_information',
        'type'        => 'number',
        'input_attrs' => [
            'min'  => '0.0',
            'max'  => '1.0',
            'step' => '0.1',
        ],
    ]);

    // Selective refresh for contact information
    $wp_customize->selective_refresh->add_partial('contact_information', [
        'selector'        => '.contact-info-bar',
        'container_inclusive' => true,
        'render_callback' => 'le_custom_contact_info_callback',
    ]);
}

/**
 * Add footer section to customizer
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_add_footer_section($wp_customize)
{
    $wp_customize->add_section('footer_settings', [
        'title'    => __('Footer Settings', 'le-custom'),
        'priority' => 35,
    ]);

    // Footer Background Image
    $wp_customize->add_setting('footer_background_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_background_image', [
        'label'       => __('Footer Background Image', 'le-custom'),
        'description' => __('Upload an image to use as the footer background', 'le-custom'),
        'section'     => 'footer_settings',
    ]));

    // Footer Navigation Note
    $wp_customize->add_setting('footer_navigation_note', [
        'default'           => '',
        'sanitize_callback' => '__return_empty_string',
    ]);

    $wp_customize->add_control('footer_navigation_note', [
        'label'       => __('Footer Navigation', 'le-custom'),
        'description' => __('To manage footer navigation, go to <strong>Appearance → Menus</strong> and assign a menu to the "Footer Menu" location.', 'le-custom'),
        'section'     => 'footer_settings',
        'type'        => 'hidden',
    ]);

    // Selective refresh for footer
    $wp_customize->selective_refresh->add_partial('footer_settings', [
        'selector'        => 'footer',
        'container_inclusive' => true,
        'render_callback' => 'le_custom_footer_callback',
    ]);
}

/**
 * Sanitize checkbox
 * 
 * @param bool $checked Whether the checkbox is checked
 * @return bool Sanitized checkbox value
 */
function le_custom_sanitize_checkbox($checked)
{
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize reCAPTCHA score threshold
 * 
 * @param string $score The score value
 * @return float Sanitized score between 0.0 and 1.0
 */
function le_custom_sanitize_recaptcha_score($score)
{
    $score = floatval($score);
    return max(0.0, min(1.0, $score));
}

/**
 * Get reCAPTCHA settings
 * 
 * @return array reCAPTCHA configuration
 */
function le_custom_get_recaptcha_settings()
{
    return [
        'site_key' => get_theme_mod('recaptcha_site_key', ''),
        'secret_key' => get_theme_mod('recaptcha_secret_key', ''),
        'score_threshold' => get_theme_mod('recaptcha_score_threshold', '0.5'),
        'enabled' => !empty(get_theme_mod('recaptcha_site_key', '')) && !empty(get_theme_mod('recaptcha_secret_key', ''))
    ];
}

/**
 * Verify reCAPTCHA token
 * 
 * @param string $token reCAPTCHA token
 * @param string $action Action name
 * @return array Verification result
 */
function le_custom_verify_recaptcha($token, $action = 'contact_form')
{
    $recaptcha_settings = le_custom_get_recaptcha_settings();

    if (!$recaptcha_settings['enabled']) {
        return ['success' => true, 'score' => 1.0, 'reason' => 'reCAPTCHA not configured'];
    }

    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
            'secret' => $recaptcha_settings['secret_key'],
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ]
    ]);

    if (is_wp_error($response)) {
        return ['success' => false, 'score' => 0.0, 'reason' => 'Network error'];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!$data['success']) {
        return ['success' => false, 'score' => 0.0, 'reason' => 'Invalid token'];
    }

    // Check action
    if (isset($data['action']) && $data['action'] !== $action) {
        return ['success' => false, 'score' => 0.0, 'reason' => 'Action mismatch'];
    }

    // Check score
    $score = $data['score'] ?? 0.0;
    $threshold = floatval($recaptcha_settings['score_threshold']);

    if ($score < $threshold) {
        return ['success' => false, 'score' => $score, 'reason' => 'Score too low'];
    }

    return ['success' => true, 'score' => $score, 'reason' => 'Verified'];
}

// Contact data function moved to functions.php to avoid duplication

/**
 * Get formatted address string
 * 
 * @return string Formatted address
 */
function le_custom_get_formatted_address()
{
    $contact_data = le_custom_get_contact_data();
    return $contact_data['address']['street'] . ', ' . $contact_data['address']['city'];
}

/**
 * Get full address for structured data
 * 
 * @return array Full address data
 */
function le_custom_get_structured_address()
{
    $contact_data = le_custom_get_contact_data();
    return [
        '@type' => 'PostalAddress',
        'streetAddress' => $contact_data['address']['street'],
        'addressLocality' => $contact_data['address']['city'],
        'addressCountry' => $contact_data['address']['country'],
    ];
}

/**
 * Get opening hours for structured data
 * 
 * @return array Opening hours data
 */
function le_custom_get_structured_opening_hours()
{
    $contact_data = le_custom_get_contact_data();
    $opening_hours = $contact_data['opening_hours'];

    $structured_hours = [];

    // Parse individual days and create structured data
    $days = [
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday'
    ];

    foreach ($days as $day_key => $day_name) {
        if (!empty($opening_hours[$day_key])) {
            // Parse time ranges from the opening hours string
            $time_ranges = le_custom_parse_opening_hours($opening_hours[$day_key]);

            foreach ($time_ranges as $range) {
                $structured_hours[] = [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => $day_name,
                    'opens' => $range['opens'],
                    'closes' => $range['closes'],
                ];
            }
        }
    }

    return $structured_hours;
}

/**
 * Parse opening hours string to extract time ranges
 * 
 * @param string $hours_string The opening hours string (e.g., "09:00 - 12:00 Uhr, 13:00 - 18:00 Uhr")
 * @return array Array of time ranges with 'opens' and 'closes' keys
 */
function le_custom_parse_opening_hours($hours_string)
{
    $ranges = [];

    // Remove "Uhr" and other text, keep only time patterns
    $cleaned = preg_replace('/[^\d\s\-\:,]/', '', $hours_string);

    // Split by comma to get individual time ranges
    $time_blocks = explode(',', $cleaned);

    foreach ($time_blocks as $block) {
        $block = trim($block);

        // Match time patterns like "09:00 - 12:00"
        if (preg_match('/(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})/', $block, $matches)) {
            $ranges[] = [
                'opens' => $matches[1],
                'closes' => $matches[2]
            ];
        }
    }

    // If no ranges found, try to extract single time range
    if (empty($ranges) && preg_match('/(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})/', $hours_string, $matches)) {
        $ranges[] = [
            'opens' => $matches[1],
            'closes' => $matches[2]
        ];
    }

    return $ranges;
}

/**
 * Generate structured data JSON-LD for the practice
 * 
 * @return string JSON-LD structured data
 */
function le_custom_generate_structured_data()
{
    $contact_data = le_custom_get_contact_data();

    $structured_data = [
        '@context' => 'https://schema.org',
        '@type' => 'Dentist',
        'name' => $contact_data['practice_name'],
        'address' => le_custom_get_structured_address(),
        'telephone' => $contact_data['phone']['link'],
        'email' => $contact_data['email'],
        'openingHoursSpecification' => le_custom_get_structured_opening_hours(),
        'availableLanguage' => $contact_data['languages'],
        'url' => home_url(),
        'sameAs' => [
            // Add social media URLs here if available
        ],
    ];

    return json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Output structured data in head section
 */
function le_custom_output_structured_data()
{
    $structured_data = le_custom_generate_structured_data();
    echo '<script type="application/ld+json">' . $structured_data . '</script>' . "\n";
}
add_action('wp_head', 'le_custom_output_structured_data');

/**
 * Contact information callback for selective refresh
 */
function le_custom_contact_info_callback()
{
    get_template_part('template-parts/contact-info');
}

/**
 * Footer callback for selective refresh
 */
function le_custom_footer_callback()
{
    get_template_part('template-parts/footer/footer');
}

/**
 * Enqueue customizer scripts
 */
function le_custom_customize_preview_js()
{
    wp_enqueue_script(
        'le-custom-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        ['customize-preview'],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('customize_preview_init', 'le_custom_customize_preview_js');

/**
 * Add services section to customizer
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_add_services_section($wp_customize)
{
    $wp_customize->add_section('services_settings', [
        'title'    => __('Services Section', 'le-custom'),
        'priority' => 40,
    ]);

    // Services Section Title (German)
    $wp_customize->add_setting('services_section_title_de', [
        'default'           => 'Unsere Leistungen',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('services_section_title_de', [
        'label'   => __('Section Title (German)', 'le-custom'),
        'section' => 'services_settings',
        'type'    => 'text',
    ]);

    // Services Section Description (German)
    $wp_customize->add_setting('services_section_description_de', [
        'default'           => 'Wir bieten ein umfassendes Spektrum an zahnmedizinischen Behandlungen für Ihre optimale Zahngesundheit.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('services_section_description_de', [
        'label'   => __('Section Description (German)', 'le-custom'),
        'section' => 'services_settings',
        'type'    => 'textarea',
    ]);

    // Services Section Title (English)
    $wp_customize->add_setting('services_section_title_en', [
        'default'           => 'Our Services',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('services_section_title_en', [
        'label'   => __('Section Title (English)', 'le-custom'),
        'section' => 'services_settings',
        'type'    => 'text',
    ]);

    // Services Section Description (English)
    $wp_customize->add_setting('services_section_description_en', [
        'default'           => 'We offer a comprehensive range of dental treatments for your optimal oral health.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('services_section_description_en', [
        'label'   => __('Section Description (English)', 'le-custom'),
        'section' => 'services_settings',
        'type'    => 'textarea',
    ]);

    // Services (JSON array) - German
    $wp_customize->add_setting('services_list_de', [
        'default'           => json_encode([
            [
                'title' => 'Zahnästhetik',
                'description' => 'Lücken, Fehlstellungen und Verfärbungen beeinträchtigen unser ästhetisches Empfinden. Mit Veneers, Bleaching und Co. verbessern wir die Zahnästhetik!',
                'button_text' => 'Mehr erfahren',
                'button_url' => '#',
                'icon' => 'aesthetic'
            ],
            [
                'title' => 'Zahnersatz & Zahnerhaltung',
                'description' => 'Geht es um Zahnersatz oder die Rettung Ihrer Zähne, bieten sich verschiedene Optionen an. Gerne beraten wir Sie in unserer Praxis individuell und fachgerecht!',
                'button_text' => 'Mehr erfahren',
                'button_url' => '#',
                'icon' => 'prosthetics'
            ],
            [
                'title' => 'Kinderzahnheilkunde',
                'description' => 'Als Kinderzahnarzt haben wir uns auf die Behandlung kleiner Patienten spezialisiert. Wir begleiten Ihr Kind in allen Fragen der Zahnmedizin!',
                'button_text' => 'Mehr erfahren',
                'button_url' => '#',
                'icon' => 'pediatric'
            ],
            [
                'title' => 'Parodontologie',
                'description' => 'Parodontitis ist als Volkskrankheit einzustufen - fast jeder Mensch ist im Laufe seines Lebens davon betroffen. Erfahren Sie mehr über die Behandlung!',
                'button_text' => 'Mehr erfahren',
                'button_url' => '#',
                'icon' => 'periodontics'
            ]
        ]),
        'sanitize_callback' => 'le_custom_sanitize_services_json',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('services_list_de', [
        'label'       => __('Services (German)', 'le-custom'),
        'description' => __('Add, remove, or edit services for German pages. Each service should have a title, description, button text, button URL, and icon.', 'le-custom'),
        'section'     => 'services_settings',
        'type'        => 'textarea',
    ]);

    // Services (JSON array) - English
    $wp_customize->add_setting('services_list_en', [
        'default'           => json_encode([
            [
                'title' => 'Dental Aesthetics',
                'description' => 'Gaps, misalignments, and discolorations impair our aesthetic perception. With veneers, bleaching, and more, we improve dental aesthetics!',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'icon' => 'aesthetic'
            ],
            [
                'title' => 'Dental Prosthetics & Preservation',
                'description' => 'When it comes to dental prosthetics or saving your teeth, various options are available. We are happy to advise you individually and professionally in our practice!',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'icon' => 'prosthetics'
            ],
            [
                'title' => 'Pediatric Dentistry',
                'description' => 'As pediatric dentists, we specialize in treating young patients. We accompany your child in all matters of dentistry!',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'icon' => 'pediatric'
            ],
            [
                'title' => 'Periodontology',
                'description' => 'Periodontitis is to be classified as a widespread disease - almost everyone is affected by it during their lifetime. Learn more about the treatment!',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'icon' => 'periodontics'
            ]
        ]),
        'sanitize_callback' => 'le_custom_sanitize_services_json',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('services_list_en', [
        'label'       => __('Services (English)', 'le-custom'),
        'description' => __('Add, remove, or edit services for English pages. Each service should have a title, description, button text, button URL, and icon.', 'le-custom'),
        'section'     => 'services_settings',
        'type'        => 'textarea',
    ]);

    // Show Services Section
    $wp_customize->add_setting('show_services_section', [
        'default'           => true,
        'sanitize_callback' => 'le_custom_sanitize_checkbox',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('show_services_section', [
        'label'   => __('Show Services Section', 'le-custom'),
        'section' => 'services_settings',
        'type'    => 'checkbox',
    ]);

    // Services Position
    $wp_customize->add_setting('services_position', [
        'default'           => 'overlay',
        'sanitize_callback' => 'le_custom_sanitize_services_position',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('services_position', [
        'label'   => __('Services Position', 'le-custom'),
        'section' => 'services_settings',
        'type'    => 'select',
        'choices' => [
            'overlay' => __('Overlay on Hero (Glassmorphism)', 'le-custom'),
            'separate' => __('Separate Section', 'le-custom'),
        ],
    ]);

    // Selective refresh for services
    $wp_customize->selective_refresh->add_partial('services_settings', [
        'selector'        => '.services-section',
        'container_inclusive' => true,
        'render_callback' => 'le_custom_services_callback',
    ]);
}

/**
 * Sanitize services JSON
 * 
 * @param string $input JSON string
 * @return string Sanitized JSON string
 */
function le_custom_sanitize_services_json($input)
{
    $services = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return json_encode([]);
    }

    if (!is_array($services)) {
        return json_encode([]);
    }

    $sanitized_services = [];
    foreach ($services as $service) {
        if (is_array($service)) {
            $sanitized_services[] = [
                'title' => sanitize_text_field($service['title'] ?? ''),
                'description' => sanitize_textarea_field($service['description'] ?? ''),
                'button_text' => sanitize_text_field($service['button_text'] ?? ''),
                'button_url' => esc_url_raw($service['button_url'] ?? '#'),
                'icon' => sanitize_text_field($service['icon'] ?? 'default')
            ];
        }
    }

    return json_encode($sanitized_services);
}

/**
 * Sanitize services position
 * 
 * @param string $input Position value
 * @return string Sanitized position
 */
function le_custom_sanitize_services_position($input)
{
    $allowed_positions = ['overlay', 'separate'];
    return in_array($input, $allowed_positions) ? $input : 'overlay';
}

/**
 * Services callback for selective refresh
 */
function le_custom_services_callback()
{
    get_template_part('template-parts/services-section');
}

/**
 * Add legal pages section to customizer
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_add_legal_pages_section($wp_customize)
{
    $wp_customize->add_section('legal_pages', [
        'title'    => __('Legal Pages', 'le-custom'),
        'priority' => 35,
    ]);

    // Privacy Policy German
    $wp_customize->add_setting('privacy_policy_de', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('privacy_policy_de', [
        'label'       => __('Privacy Policy (German)', 'le-custom'),
        'description' => __('Enter the German privacy policy content', 'le-custom'),
        'section'     => 'legal_pages',
        'type'        => 'textarea',
    ]);

    // Privacy Policy English
    $wp_customize->add_setting('privacy_policy_en', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('privacy_policy_en', [
        'label'       => __('Privacy Policy (English)', 'le-custom'),
        'description' => __('Enter the English privacy policy content', 'le-custom'),
        'section'     => 'legal_pages',
        'type'        => 'textarea',
    ]);

    // Imprint German
    $wp_customize->add_setting('imprint_de', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('imprint_de', [
        'label'       => __('Imprint (German)', 'le-custom'),
        'description' => __('Enter the German imprint content', 'le-custom'),
        'section'     => 'legal_pages',
        'type'        => 'textarea',
    ]);

    // Imprint English
    $wp_customize->add_setting('imprint_en', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('imprint_en', [
        'label'       => __('Imprint (English)', 'le-custom'),
        'description' => __('Enter the English imprint content', 'le-custom'),
        'section'     => 'legal_pages',
        'type'        => 'textarea',
    ]);
}

/**
 * Add link component section to customizer
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_add_link_component_section($wp_customize)
{
    $wp_customize->add_section('link_component', [
        'title'    => __('Link Component', 'le-custom'),
        'priority' => 40,
    ]);

    // Link URL
    $wp_customize->add_setting('link_component_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('link_component_url', [
        'label'       => __('Link URL', 'le-custom'),
        'description' => __('Enter the URL for the link component (e.g., Doctolib appointment page)', 'le-custom'),
        'section'     => 'link_component',
        'type'        => 'url',
    ]);

    // Link Text
    $wp_customize->add_setting('link_component_text', [
        'default'           => __('Doctolib', 'le-custom'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('link_component_text', [
        'label'       => __('Link Text', 'le-custom'),
        'description' => __('Enter the text to display on the link button', 'le-custom'),
        'section'     => 'link_component',
        'type'        => 'text',
    ]);

    // Link Icon
    $wp_customize->add_setting('link_component_icon', [
        'default'           => 'calendar',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('link_component_icon', [
        'label'       => __('Link Icon', 'le-custom'),
        'description' => __('Choose the icon for the link button', 'le-custom'),
        'section'     => 'link_component',
        'type'        => 'select',
        'choices'     => [
            'calendar' => __('Calendar', 'le-custom'),
            'phone'    => __('Phone', 'le-custom'),
            'external' => __('External Link', 'le-custom'),
            'heart'    => __('Heart', 'le-custom'),
            'star'     => __('Star', 'le-custom'),
        ],
    ]);

    // Show/Hide Link
    $wp_customize->add_setting('link_component_show', [
        'default'           => true,
        'sanitize_callback' => 'le_custom_sanitize_checkbox',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('link_component_show', [
        'label'       => __('Show Link Component', 'le-custom'),
        'description' => __('Enable or disable the link component in the header', 'le-custom'),
        'section'     => 'link_component',
        'type'        => 'checkbox',
    ]);
}

/**
 * Get link component data
 * 
 * @return array Link component configuration
 */
function le_custom_get_link_component_data()
{
    return [
        'url'  => get_theme_mod('link_component_url', ''),
        'text' => get_theme_mod('link_component_text', __('Doctolib', 'le-custom')),
        'icon' => get_theme_mod('link_component_icon', 'calendar'),
        'show' => get_theme_mod('link_component_show', true),
    ];
}

/**
 * Add CTA section to customizer
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function le_custom_add_cta_section($wp_customize)
{
    $wp_customize->add_section('cta_settings', [
        'title'    => __('CTA Section', 'le-custom'),
        'priority' => 45,
    ]);

    // CTA Title (German)
    $wp_customize->add_setting('cta_title_de', [
        'default'           => 'Bereit für Ihren Termin?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_title_de', [
        'label'   => __('CTA Title (German)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'text',
    ]);

    // CTA Description (German)
    $wp_customize->add_setting('cta_description_de', [
        'default'           => 'Vereinbaren Sie noch heute einen Termin für eine kostenlose Erstberatung und lassen Sie uns gemeinsam für Ihre Zahngesundheit sorgen.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_description_de', [
        'label'   => __('CTA Description (German)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'textarea',
    ]);

    // CTA Title (English)
    $wp_customize->add_setting('cta_title_en', [
        'default'           => 'Ready for Your Appointment?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_title_en', [
        'label'   => __('CTA Title (English)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'text',
    ]);

    // CTA Description (English)
    $wp_customize->add_setting('cta_description_en', [
        'default'           => 'Schedule an appointment today for a free initial consultation and let us work together for your dental health.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_description_en', [
        'label'   => __('CTA Description (English)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'textarea',
    ]);

    // Primary Button Text (German)
    $wp_customize->add_setting('cta_primary_button_text_de', [
        'default'           => 'Jetzt anrufen',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_primary_button_text_de', [
        'label'   => __('Primary Button Text (German)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'text',
    ]);

    // Primary Button Text (English)
    $wp_customize->add_setting('cta_primary_button_text_en', [
        'default'           => 'Call Now',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_primary_button_text_en', [
        'label'   => __('Primary Button Text (English)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'text',
    ]);

    // Secondary Button Text (German)
    $wp_customize->add_setting('cta_secondary_button_text_de', [
        'default'           => 'E-Mail senden',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_secondary_button_text_de', [
        'label'   => __('Secondary Button Text (German)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'text',
    ]);

    // Secondary Button Text (English)
    $wp_customize->add_setting('cta_secondary_button_text_en', [
        'default'           => 'Send Email',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_secondary_button_text_en', [
        'label'   => __('Secondary Button Text (English)', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'text',
    ]);

    // Primary Button URL
    $wp_customize->add_setting('cta_primary_button_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_primary_button_url', [
        'label'       => __('Primary Button URL', 'le-custom'),
        'description' => __('Leave empty to use phone number from contact settings, or enter a custom URL', 'le-custom'),
        'section'     => 'cta_settings',
        'type'        => 'url',
    ]);

    // Secondary Button URL
    $wp_customize->add_setting('cta_secondary_button_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_secondary_button_url', [
        'label'       => __('Secondary Button URL', 'le-custom'),
        'description' => __('Leave empty to use email from contact settings, or enter a custom URL', 'le-custom'),
        'section'     => 'cta_settings',
        'type'        => 'url',
    ]);

    // CTA Section ID
    $wp_customize->add_setting('cta_section_id', [
        'default'           => 'termin',
        'sanitize_callback' => 'sanitize_html_class',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('cta_section_id', [
        'label'       => __('CTA Section ID', 'le-custom'),
        'description' => __('HTML ID for the CTA section (used for anchor links)', 'le-custom'),
        'section'     => 'cta_settings',
        'type'        => 'text',
    ]);

    // CTA Background Color
    $wp_customize->add_setting('cta_background_color', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cta_background_color', [
        'label'       => __('CTA Background Color', 'le-custom'),
        'description' => __('Leave empty to use primary color from color scheme', 'le-custom'),
        'section'     => 'cta_settings',
    ]));

    // Show CTA Section
    $wp_customize->add_setting('show_cta_section', [
        'default'           => true,
        'sanitize_callback' => 'le_custom_sanitize_checkbox',
        'transport'         => 'postMessage',
    ]);

    $wp_customize->add_control('show_cta_section', [
        'label'   => __('Show CTA Section', 'le-custom'),
        'section' => 'cta_settings',
        'type'    => 'checkbox',
    ]);

    // Selective refresh for CTA section
    $wp_customize->selective_refresh->add_partial('cta_settings', [
        'selector'        => '#termin',
        'container_inclusive' => true,
        'render_callback' => 'le_custom_cta_callback',
    ]);
}

/**
 * CTA callback for selective refresh
 */
function le_custom_cta_callback()
{
    get_template_part('template-parts/cta-section');
}

/**
 * Get CTA data
 * 
 * @return array CTA configuration
 */
function le_custom_get_cta_data()
{
    $contact_data = le_custom_get_contact_data();
    $color_scheme = le_custom_get_color_scheme_data();

    // Determine current language
    $current_lang = le_custom_get_current_language();
    $lang_suffix = $current_lang === 'en' ? '_en' : '_de';

    return [
        'title' => get_theme_mod('cta_title' . $lang_suffix, $current_lang === 'en' ? 'Ready for Your Appointment?' : 'Bereit für Ihren Termin?'),
        'description' => get_theme_mod('cta_description' . $lang_suffix, $current_lang === 'en' ? 'Schedule an appointment today for a free initial consultation and let us work together for your dental health.' : 'Vereinbaren Sie noch heute einen Termin für eine kostenlose Erstberatung und lassen Sie uns gemeinsam für Ihre Zahngesundheit sorgen.'),
        'primary_button_text' => get_theme_mod('cta_primary_button_text' . $lang_suffix, $current_lang === 'en' ? 'Call Now' : 'Jetzt anrufen'),
        'secondary_button_text' => get_theme_mod('cta_secondary_button_text' . $lang_suffix, $current_lang === 'en' ? 'Send Email' : 'E-Mail senden'),
        'primary_button_url' => get_theme_mod('cta_primary_button_url', '') ?: 'tel:' . $contact_data['phone']['link'],
        'secondary_button_url' => get_theme_mod('cta_secondary_button_url', '') ?: 'mailto:' . $contact_data['email'],
        'section_id' => get_theme_mod('cta_section_id', 'termin'),
        'background_color' => get_theme_mod('cta_background_color', '') ?: $color_scheme['primary'],
        'show' => get_theme_mod('show_cta_section', true),
    ];
}
