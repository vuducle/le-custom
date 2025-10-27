<?php

/**
 * Services Admin Interface
 * 
 * Provides a user-friendly interface for managing services instead of editing JSON
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu for services management
 */
function le_custom_add_services_admin_menu()
{
    add_theme_page(
        __('Services Management', 'le-custom'),
        __('Services', 'le-custom'),
        'manage_options',
        'le-custom-services',
        'le_custom_services_admin_page'
    );
}
add_action('admin_menu', 'le_custom_add_services_admin_menu');

/**
 * Register admin scripts and styles
 */
function le_custom_services_admin_scripts($hook)
{
    if ($hook !== 'appearance_page_le-custom-services') {
        return;
    }

    wp_enqueue_script(
        'le-custom-services-admin',
        get_template_directory_uri() . '/assets/js/services-admin.js',
        ['jquery', 'jquery-ui-sortable'],
        wp_get_theme()->get('Version'),
        true
    );

    wp_enqueue_style(
        'le-custom-services-admin',
        get_template_directory_uri() . '/assets/css/services-admin.css',
        [],
        wp_get_theme()->get('Version')
    );

    // Localize script for AJAX
    wp_localize_script('le-custom-services-admin', 'leCustomServices', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('le_custom_services_nonce'),
        'strings' => [
            'confirmDelete' => __('Are you sure you want to delete this service?', 'le-custom'),
            'saving' => __('Saving...', 'le-custom'),
            'saved' => __('Services saved successfully!', 'le-custom'),
            'error' => __('Error saving services. Please try again.', 'le-custom')
        ]
    ]);
}
add_action('admin_enqueue_scripts', 'le_custom_services_admin_scripts');

/**
 * Services admin page content
 */
function le_custom_services_admin_page()
{
    // Handle form submission
    if (isset($_POST['submit_services']) && wp_verify_nonce($_POST['le_custom_services_nonce'], 'le_custom_services_action')) {
        le_custom_save_services_from_admin();
    }

    // Get current services data
    $german_services = json_decode(get_theme_mod('services_list_de', '[]'), true);
    $english_services = json_decode(get_theme_mod('services_list_en', '[]'), true);

    // Available icons
    $available_icons = [
        'aesthetic' => __('Dental Aesthetics', 'le-custom'),
        'prosthetics' => __('Dental Prosthetics', 'le-custom'),
        'pediatric' => __('Pediatric Dentistry', 'le-custom'),
        'periodontics' => __('Periodontology', 'le-custom'),
        'surgery' => __('Dental Surgery', 'le-custom'),
        'hygiene' => __('Dental Hygiene', 'le-custom'),
        'orthodontics' => __('Orthodontics', 'le-custom'),
        'implantology' => __('Implantology', 'le-custom'),
        'emergency' => __('Emergency Care', 'le-custom'),
        'default' => __('Default Icon', 'le-custom')
    ];
?>
<div class="wrap">
    <h1><?php _e('Services Management', 'le-custom'); ?></h1>
    <p class="description">
        <?php _e('Manage your dental services for both German and English pages. Add, edit, or remove services using the form below.', 'le-custom'); ?>
    </p>

    <form method="post" action="">
        <?php wp_nonce_field('le_custom_services_action', 'le_custom_services_nonce'); ?>

        <div class="nav-tab-wrapper">
            <a href="#german-services" class="nav-tab nav-tab-active"
                data-tab="german"><?php _e('German Services', 'le-custom'); ?></a>
            <a href="#english-services" class="nav-tab"
                data-tab="english"><?php _e('English Services', 'le-custom'); ?></a>
        </div>

        <!-- German Services Tab -->
        <div id="german-services" class="tab-content active">
            <h2><?php _e('German Services', 'le-custom'); ?></h2>
            <div class="services-container" data-language="de">
                <?php if (!empty($german_services)): ?>
                <?php foreach ($german_services as $index => $service): ?>
                <?php le_custom_render_service_form($service, $index, $available_icons, 'de'); ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button button-secondary add-service" data-language="de">
                <?php _e('Add New Service', 'le-custom'); ?>
            </button>
        </div>

        <!-- English Services Tab -->
        <div id="english-services" class="tab-content">
            <h2><?php _e('English Services', 'le-custom'); ?></h2>
            <div class="services-container" data-language="en">
                <?php if (!empty($english_services)): ?>
                <?php foreach ($english_services as $index => $service): ?>
                <?php le_custom_render_service_form($service, $index, $available_icons, 'en'); ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button button-secondary add-service" data-language="en">
                <?php _e('Add New Service', 'le-custom'); ?>
            </button>
        </div>

        <p class="submit">
            <input type="submit" name="submit_services" class="button button-primary"
                value="<?php _e('Save All Services', 'le-custom'); ?>">
            <span class="spinner" style="float: none; margin-top: 0;"></span>
        </p>
    </form>
</div>

<!-- Service Template (hidden) -->
<div id="service-template" style="display: none;">
    <?php le_custom_render_service_form([], '{{index}}', $available_icons, '{{language}}'); ?>
</div>
<?php
}

/**
 * Render individual service form
 */
function le_custom_render_service_form($service, $index, $available_icons, $language)
{
    $service = wp_parse_args($service, [
        'title' => '',
        'description' => '',
        'button_text' => '',
        'button_url' => '#',
        'icon' => 'default'
    ]);
?>
<div class="service-item" data-index="<?php echo esc_attr($index); ?>">
    <div class="service-header">
        <h3><?php _e('Service', 'le-custom'); ?> #<?php echo intval($index) + 1; ?></h3>
        <button type="button" class="button button-link-delete remove-service">
            <?php _e('Remove', 'le-custom'); ?>
        </button>
    </div>

    <div class="service-fields">
        <div class="form-field">
            <label for="service_title_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>">
                <?php _e('Service Title', 'le-custom'); ?> *
            </label>
            <input type="text" id="service_title_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>"
                name="services[<?php echo esc_attr($language); ?>][<?php echo esc_attr($index); ?>][title]"
                value="<?php echo esc_attr($service['title']); ?>" class="regular-text" required>
        </div>

        <div class="form-field">
            <label for="service_description_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>">
                <?php _e('Description', 'le-custom'); ?> *
            </label>
            <textarea id="service_description_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>"
                name="services[<?php echo esc_attr($language); ?>][<?php echo esc_attr($index); ?>][description]"
                rows="3" class="large-text" required><?php echo esc_textarea($service['description']); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="service_button_text_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>">
                    <?php _e('Button Text', 'le-custom'); ?>
                </label>
                <input type="text"
                    id="service_button_text_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>"
                    name="services[<?php echo esc_attr($language); ?>][<?php echo esc_attr($index); ?>][button_text]"
                    value="<?php echo esc_attr($service['button_text']); ?>" class="regular-text"
                    placeholder="<?php echo $language === 'de' ? 'Mehr erfahren' : 'Learn More'; ?>">
            </div>

            <div class="form-field">
                <label for="service_button_url_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>">
                    <?php _e('Page Link', 'le-custom'); ?>
                </label>
                <input type="text"
                    id="service_button_url_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>"
                    name="services[<?php echo esc_attr($language); ?>][<?php echo esc_attr($index); ?>][button_url]"
                    value="<?php echo esc_attr($service['button_url']); ?>" class="regular-text"
                    placeholder="<?php echo $language === 'de' ? '/ueber-uns' : '/about-us'; ?>">
                <p class="description">
                    <?php echo $language === 'de'
                            ? 'Geben Sie den Pfad zur Unterseite ein (z.B. /ueber-uns, /leistungen, /kontakt)'
                            : 'Enter the path to the subpage (e.g. /about-us, /services, /contact)'; ?>
                </p>
            </div>

            <div class="form-field">
                <label for="service_icon_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>">
                    <?php _e('Icon', 'le-custom'); ?>
                </label>
                <select id="service_icon_<?php echo esc_attr($language); ?>_<?php echo esc_attr($index); ?>"
                    name="services[<?php echo esc_attr($language); ?>][<?php echo esc_attr($index); ?>][icon]"
                    class="regular-text">
                    <?php foreach ($available_icons as $icon_key => $icon_label): ?>
                    <option value="<?php echo esc_attr($icon_key); ?>" <?php selected($service['icon'], $icon_key); ?>>
                        <?php echo esc_html($icon_label); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>
<?php
}

/**
 * Save services from admin form
 */
function le_custom_save_services_from_admin()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'le-custom'));
    }

    $services = $_POST['services'] ?? [];

    // Save German services
    if (isset($services['de'])) {
        $german_services = le_custom_sanitize_services_array($services['de']);
        set_theme_mod('services_list_de', json_encode($german_services));
    }

    // Save English services
    if (isset($services['en'])) {
        $english_services = le_custom_sanitize_services_array($services['en']);
        set_theme_mod('services_list_en', json_encode($english_services));
    }

    // Add success message
    add_action('admin_notices', function () {
        echo '<div class="notice notice-success is-dismissible"><p>' .
            __('Services saved successfully!', 'le-custom') . '</p></div>';
    });
}

/**
 * Sanitize services array from form
 */
function le_custom_sanitize_services_array($services)
{
    $sanitized_services = [];

    foreach ($services as $service) {
        if (!empty($service['title']) && !empty($service['description'])) {
            $sanitized_services[] = [
                'title' => sanitize_text_field($service['title']),
                'description' => sanitize_textarea_field($service['description']),
                'button_text' => sanitize_text_field($service['button_text'] ?? ''),
                'button_url' => esc_url_raw($service['button_url'] ?? '#'),
                'icon' => sanitize_text_field($service['icon'] ?? 'default')
            ];
        }
    }

    return $sanitized_services;
}

/**
 * AJAX handler for saving services
 */
function le_custom_ajax_save_services()
{
    check_ajax_referer('le_custom_services_nonce', 'nonce');

    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'le-custom'));
    }

    $services = $_POST['services'] ?? [];

    // Save German services
    if (isset($services['de'])) {
        $german_services = le_custom_sanitize_services_array($services['de']);
        set_theme_mod('services_list_de', json_encode($german_services));
    }

    // Save English services
    if (isset($services['en'])) {
        $english_services = le_custom_sanitize_services_array($services['en']);
        set_theme_mod('services_list_en', json_encode($english_services));
    }

    // Check if any services were saved
    if (empty($services['de']) && empty($services['en'])) {
        wp_send_json_error(['message' => __('No services data received', 'le-custom')]);
    }

    wp_send_json_success(['message' => __('Services saved successfully!', 'le-custom')]);
}
add_action('wp_ajax_le_custom_save_services', 'le_custom_ajax_save_services');