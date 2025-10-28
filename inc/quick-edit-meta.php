<?php

/**
 * Quick Edit Meta Description
 * 
 * Adds meta description field to WordPress quick edit interface
 * and handles structured data for subpages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta description field to quick edit
 */
function le_custom_add_quick_edit_meta_description()
{
    // Add to quick edit for pages
    add_action('quick_edit_custom_box', 'le_custom_quick_edit_meta_description_field', 10, 2);
    add_action('bulk_edit_custom_box', 'le_custom_quick_edit_meta_description_field', 10, 2);
}
add_action('admin_init', 'le_custom_add_quick_edit_meta_description');

// Alternative approach - add directly to the quick edit form
add_action('admin_footer-edit.php', 'le_custom_add_quick_edit_meta_description_alternative');

/**
 * Render meta description field in quick edit
 * 
 * @param string $column_name The column name
 * @param string $post_type The post type
 */
function le_custom_quick_edit_meta_description_field($column_name, $post_type)
{
    if ($post_type !== 'page') {
        return;
    }

    // Only show once, regardless of column
    static $shown = false;
    if ($shown) {
        return;
    }
    $shown = true;
?>
    <fieldset class="inline-edit-col-right">
        <div class="inline-edit-col">
            <label class="inline-edit-group">
                <span class="title"><?php _e('Meta Description', 'le-custom'); ?></span>
                <textarea name="meta_description" rows="3" class="large-text" maxlength="160"
                    placeholder="<?php _e('Enter meta description (max 160 characters)', 'le-custom'); ?>"></textarea>
                <span
                    class="description"><?php _e('Leave empty to use hero subtitle or default description', 'le-custom'); ?></span>
            </label>
        </div>
    </fieldset>
    <?php
}

/**
 * Save enhanced meta data from quick edit
 */
function le_custom_save_quick_edit_meta_description($post_id)
{
    // Check if this is a quick edit save
    if (!isset($_POST['action']) || $_POST['action'] !== 'inline-save') {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check nonce
    if (!wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
        return;
    }

    // Get the post object
    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'page') {
        return;
    }

    // Prepare update data
    $update_data = ['ID' => $post_id];
    $needs_update = false;

    // Handle slug update
    if (isset($_POST['post_name']) && !empty($_POST['post_name'])) {
        $new_slug = sanitize_title($_POST['post_name']);
        if ($new_slug !== $post->post_name) {
            $update_data['post_name'] = $new_slug;
            $needs_update = true;
        }
    }

    // Handle parent page update
    if (isset($_POST['post_parent'])) {
        $new_parent = intval($_POST['post_parent']);
        if ($new_parent !== $post->post_parent) {
            $update_data['post_parent'] = $new_parent;
            $needs_update = true;
        }
    }

    // Update post if needed
    if ($needs_update) {
        wp_update_post($update_data);
    }

    // Save meta description if provided
    if (isset($_POST['meta_description'])) {
        $meta_description = sanitize_textarea_field($_POST['meta_description']);
        update_post_meta($post_id, '_meta_description', $meta_description);
    }

    // Save custom page title if provided
    if (isset($_POST['custom_page_title'])) {
        $custom_title = sanitize_text_field($_POST['custom_page_title']);
        update_post_meta($post_id, '_custom_page_title', $custom_title);
    }
}
add_action('save_post', 'le_custom_save_quick_edit_meta_description');

/**
 * Alternative method to add enhanced meta fields to quick edit
 */
function le_custom_add_quick_edit_meta_description_alternative()
{
    $screen = get_current_screen();
    if ($screen && $screen->id === 'edit-page') {
        // Get all pages for parent dropdown
        $pages = get_pages([
            'sort_column' => 'menu_order, post_title',
            'hierarchical' => 0
        ]);

        $pages_options = '<option value="0">No parent</option>';
        foreach ($pages as $page) {
            $pages_options .= sprintf(
                '<option value="%d">%s</option>',
                $page->ID,
                str_repeat('&mdash; ', count(explode('/', trim(parse_url(get_permalink($page->ID), PHP_URL_PATH), '/'))) - 1) . esc_html($page->post_title)
            );
        }
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Add enhanced meta fields to quick edit form
                var enhancedMetaFields = `
                <fieldset class="inline-edit-col-right le-custom-meta-fields">
                    <div class="inline-edit-col">
                        <h4>Page Settings</h4>
                        <label class="inline-edit-group">
                            <span class="title">Page Slug</span>
                            <input type="text" name="post_name" class="large-text" 
                                placeholder="Page slug (URL)" />
                            <span class="description">The URL slug for this page (e.g., 'contact', 'about-us')</span>
                        </label>
                        <label class="inline-edit-group">
                            <span class="title">Parent Page</span>
                            <select name="post_parent" class="large-text">
                                <?php echo $pages_options; ?>
                            </select>
                            <span class="description">Choose a parent page to create a hierarchy</span>
                        </label>
                        <h4>SEO Settings</h4>
                        <label class="inline-edit-group">
                            <span class="title">Custom Page Title</span>
                            <input type="text" name="custom_page_title" class="large-text" maxlength="70" 
                                placeholder="Leave empty for auto-generated title" />
                            <span class="description">Custom title (max 70 chars). Leave empty for: {Page Title} - {Description} - {Dentist Name}</span>
                        </label>
                        <label class="inline-edit-group">
                            <span class="title">Meta Description</span>
                            <textarea name="meta_description" rows="3" class="large-text" maxlength="160" 
                                placeholder="Enter meta description (max 160 characters)"></textarea>
                            <span class="description">Leave empty to use hero subtitle or default description</span>
                        </label>
                    </div>
                </fieldset>
            `;

                // Insert the enhanced fields into the quick edit form
                $('.inline-edit-col-right').last().after(enhancedMetaFields);

                // Add character counters
                $('textarea[name="meta_description"]').on('input', function() {
                    var currentLength = $(this).val().length;
                    var maxLength = 160;
                    var remaining = maxLength - currentLength;

                    // Remove existing counter
                    $(this).siblings('.char-counter').remove();

                    // Add character counter
                    var counter = $(
                        '<span class="char-counter" style="display: block; margin-top: 5px; font-size: 12px; color: #666;"></span>'
                    );
                    $(this).after(counter);

                    if (remaining >= 0) {
                        counter.text(remaining + ' characters remaining');
                        counter.css('color', '#666');
                    } else {
                        counter.text('Exceeds limit by ' + Math.abs(remaining) + ' characters');
                        counter.css('color', '#dc3232');
                    }
                });

                $('input[name="custom_page_title"]').on('input', function() {
                    var currentLength = $(this).val().length;
                    var maxLength = 70;
                    var remaining = maxLength - currentLength;

                    // Remove existing counter
                    $(this).siblings('.char-counter').remove();

                    // Add character counter
                    var counter = $(
                        '<span class="char-counter" style="display: block; margin-top: 5px; font-size: 12px; color: #666;"></span>'
                    );
                    $(this).after(counter);

                    if (remaining >= 0) {
                        counter.text(remaining + ' characters remaining');
                        counter.css('color', '#666');
                    } else {
                        counter.text('Exceeds limit by ' + Math.abs(remaining) + ' characters');
                        counter.css('color', '#dc3232');
                    }
                });

                // Validate slug format
                $('input[name="post_name"]').on('input', function() {
                    var slug = $(this).val();
                    var validSlug = slug.toLowerCase()
                        .replace(/[^a-z0-9\-]/g, '-')
                        .replace(/-+/g, '-')
                        .replace(/^-|-$/g, '');

                    if (slug !== validSlug) {
                        $(this).val(validSlug);
                    }
                });
            });
        </script>
<?php
    }
}

/**
 * Add enhanced columns to pages list
 */
function le_custom_add_meta_description_column($columns)
{
    $new_columns = [];

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        // Add new columns after title
        if ($key === 'title') {
            $new_columns['page_slug'] = __('Slug', 'le-custom');
            $new_columns['page_parent'] = __('Parent', 'le-custom');
            $new_columns['meta_description'] = __('Meta Description', 'le-custom');
        }
    }

    return $new_columns;
}
add_filter('manage_pages_columns', 'le_custom_add_meta_description_column');

/**
 * Display enhanced columns in pages list
 */
function le_custom_display_meta_description_column($column, $post_id)
{
    switch ($column) {
        case 'page_slug':
            $post = get_post($post_id);
            echo '<code>' . esc_html($post->post_name) . '</code>';
            break;

        case 'page_parent':
            $parent_id = wp_get_post_parent_id($post_id);
            if ($parent_id) {
                $parent_title = get_the_title($parent_id);
                $parent_link = get_edit_post_link($parent_id);
                echo '<a href="' . esc_url($parent_link) . '">' . esc_html($parent_title) . '</a>';
            } else {
                echo '<span class="no-parent">' . __('No parent', 'le-custom') . '</span>';
            }
            break;

        case 'meta_description':
            $meta_description = get_post_meta($post_id, '_meta_description', true);

            if (empty($meta_description)) {
                // Try to get from hero subtitle
                $hero_data = le_custom_get_hero_data($post_id);
                $meta_description = $hero_data['subtitle'] ?: '';
            }

            if (!empty($meta_description)) {
                $meta_description = wp_strip_all_tags($meta_description);
                $meta_description = substr($meta_description, 0, 160);
                echo '<div class="meta-description-preview">' . esc_html($meta_description) . '</div>';
            } else {
                echo '<span class="no-meta-description">' . __('No description set', 'le-custom') . '</span>';
            }
            break;
    }
}
add_action('manage_pages_custom_column', 'le_custom_display_meta_description_column', 10, 2);

/**
 * Enqueue JavaScript for quick edit functionality
 */
function le_custom_enqueue_quick_edit_script()
{
    $screen = get_current_screen();

    if ($screen && $screen->id === 'edit-page') {
        // Enqueue JavaScript only
        wp_enqueue_script(
            'le-custom-quick-edit',
            get_template_directory_uri() . '/assets/js/quick-edit-meta.js',
            ['jquery'],
            '2.0',
            true
        );

        wp_localize_script('le-custom-quick-edit', 'leCustomQuickEdit', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('le_custom_quick_edit_nonce')
        ]);
    }
}
add_action('admin_enqueue_scripts', 'le_custom_enqueue_quick_edit_script');

/**
 * AJAX handler to get complete page data for quick edit
 */
function le_custom_get_page_data_ajax()
{
    check_ajax_referer('le_custom_quick_edit_nonce', 'nonce');

    if (!current_user_can('edit_posts')) {
        wp_die(__('Insufficient permissions', 'le-custom'));
    }

    $post_id = intval($_POST['post_id']);
    $post = get_post($post_id);

    if (!$post) {
        wp_send_json_error(['message' => 'Post not found']);
    }

    $data = [
        'meta_description' => get_post_meta($post_id, '_meta_description', true),
        'custom_title' => get_post_meta($post_id, '_custom_page_title', true),
        'parent_id' => $post->post_parent,
        'slug' => $post->post_name
    ];

    wp_send_json_success($data);
}
add_action('wp_ajax_le_custom_get_page_data', 'le_custom_get_page_data_ajax');

/**
 * AJAX handler to get meta description for quick edit (legacy support)
 */
function le_custom_get_meta_description_ajax()
{
    check_ajax_referer('le_custom_quick_edit_nonce', 'nonce');

    if (!current_user_can('edit_posts')) {
        wp_die(__('Insufficient permissions', 'le-custom'));
    }

    $post_id = intval($_POST['post_id']);
    $meta_description = get_post_meta($post_id, '_meta_description', true);

    wp_send_json_success(['meta_description' => $meta_description]);
}
add_action('wp_ajax_le_custom_get_meta_description', 'le_custom_get_meta_description_ajax');

/**
 * Get meta description for a post with fallback logic
 * 
 * @param int|null $post_id The post ID
 * @return string The meta description
 */
function le_custom_get_meta_description($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // First try to get custom meta description
    $meta_description = get_post_meta($post_id, '_meta_description', true);

    if (empty($meta_description)) {
        // Fallback to hero subtitle
        $hero_data = le_custom_get_hero_data($post_id);
        $meta_description = $hero_data['subtitle'] ?: '';
    }

    if (empty($meta_description)) {
        // Final fallback based on page type
        $page_slug = get_post_field('post_name', $post_id);
        $contact_data = le_custom_get_contact_data();

        $defaults = [
            'de' => 'Professionelle Zahnmedizin mit modernster Technologie und persönlicher Betreuung für Ihre Zahngesundheit.',
            'en' => 'Professional dental care with modern technology and personal care for your oral health.',
            'kontakt' => 'Kontaktieren Sie uns für einen Termin in unserer Zahnarztpraxis. Wir sind für Sie da.',
            'contact' => 'Contact us for an appointment at our dental practice. We are here for you.',
            'impressum' => 'Impressum und rechtliche Informationen unserer Zahnarztpraxis.',
            'imprint' => 'Imprint and legal information of our dental practice.',
            'datenschutz' => 'Datenschutzerklärung unserer Zahnarztpraxis.',
            'privacy-policy' => 'Privacy policy of our dental practice.',
            'anfahrt' => 'So finden Sie uns - Anfahrt und Kontakt zu unserer Zahnarztpraxis.',
            'directions' => 'How to find us - directions and contact to our dental practice.'
        ];

        $meta_description = $defaults[$page_slug] ?? $defaults['de'];
    }

    // Clean and truncate
    $meta_description = wp_strip_all_tags($meta_description);
    $meta_description = substr($meta_description, 0, 160);

    return $meta_description;
}

/**
 * Add structured data for subpages
 * 
 * @param int|null $post_id The post ID
 * @return array Structured data array
 */
function le_custom_get_subpage_structured_data($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $contact_data = le_custom_get_contact_data();
    $meta_description = le_custom_get_meta_description($post_id);
    $page_title = get_the_title($post_id);
    $page_url = get_permalink($post_id);
    $page_slug = get_post_field('post_name', $post_id);

    // Base structured data
    $structured_data = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $page_title,
        'description' => $meta_description,
        'url' => $page_url,
        'mainEntity' => [
            '@type' => 'Dentist',
            'name' => $contact_data['practice_name'],
            'description' => $meta_description,
            'url' => home_url(),
            'telephone' => $contact_data['phone']['link'],
            'email' => $contact_data['email'],
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => $contact_data['address']['country'],
                'addressLocality' => $contact_data['address']['city'],
                'streetAddress' => $contact_data['address']['street']
            ],
            'openingHours' => [
                $contact_data['opening_hours']['monday'],
                $contact_data['opening_hours']['tuesday'],
                $contact_data['opening_hours']['wednesday'],
                $contact_data['opening_hours']['thursday'],
                $contact_data['opening_hours']['friday']
            ]
        ]
    ];

    // Add specific structured data based on page type
    switch ($page_slug) {
        case 'kontakt':
        case 'contact':
            $structured_data['mainEntity']['@type'] = 'Dentist';
            $structured_data['mainEntity']['contactPoint'] = [
                '@type' => 'ContactPoint',
                'telephone' => $contact_data['phone']['link'],
                'contactType' => 'customer service',
                'availableLanguage' => ['German', 'English']
            ];
            break;

        case 'anfahrt':
        case 'directions':
            $structured_data['mainEntity']['@type'] = 'Dentist';
            $structured_data['mainEntity']['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => '52.5200', // Example coordinates - should be updated with actual location
                'longitude' => '13.4050'
            ];
            break;

        case 'impressum':
        case 'imprint':
            $structured_data['@type'] = 'WebPage';
            $structured_data['about'] = [
                '@type' => 'Organization',
                'name' => $contact_data['practice_name'],
                'legalName' => $contact_data['practice_name']
            ];
            break;

        case 'datenschutz':
        case 'privacy-policy':
            $structured_data['@type'] = 'WebPage';
            $structured_data['about'] = [
                '@type' => 'Organization',
                'name' => $contact_data['practice_name'],
                'privacyPolicy' => $page_url
            ];
            break;
    }

    return $structured_data;
}

/**
 * Output structured data for subpages
 * 
 * @param int|null $post_id The post ID
 */
function le_custom_output_subpage_structured_data($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Only output for subpages, not landing pages
    if (le_custom_is_subpage($post_id)) {
        $structured_data = le_custom_get_subpage_structured_data($post_id);
        echo '<script type="application/ld+json">' . "\n";
        echo json_encode($structured_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
        echo '</script>' . "\n";
    }
}

/**
 * Generate SEO-optimized page title
 * 
 * @param int|null $post_id The post ID
 * @param string|null $custom_title Custom title to use instead of post title
 * @return string The generated page title
 */
function le_custom_generate_page_title($post_id = null, $custom_title = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Check if there's a custom page title set
    $custom_page_title = get_post_meta($post_id, '_custom_page_title', true);
    if (!empty($custom_page_title)) {
        return $custom_page_title;
    }

    $contact_data = le_custom_get_contact_data();
    $dentist_name = $contact_data['practice_name'];

    // Get the main title
    if ($custom_title) {
        $title = $custom_title;
    } else {
        $title = get_the_title($post_id);
    }

    // Check if this is a landing page
    $page_slug = get_post_field('post_name', $post_id);
    $is_landing_page = ($page_slug === 'de' || $page_slug === 'en');

    // Get meta description (shortened version)
    $meta_description = le_custom_get_meta_description($post_id);

    // For landing pages, use a shorter description to leave more room for the title
    if ($is_landing_page) {
        $max_description_length = 40; // Shorter for landing pages
    } else {
        $max_description_length = 60; // Longer for subpages
    }

    if (strlen($meta_description) > $max_description_length) {
        $meta_description = substr($meta_description, 0, $max_description_length) . '...';
    }

    // Generate the title in format: {title} - {description} - {dentist name}
    $page_title = $title . ' - ' . $meta_description . ' - ' . $dentist_name;

    // Ensure total length doesn't exceed reasonable limits (around 60-70 characters)
    $max_total_length = 70;
    if (strlen($page_title) > $max_total_length) {
        // If too long, try without description
        $page_title = $title . ' - ' . $dentist_name;

        // If still too long, truncate title
        if (strlen($page_title) > $max_total_length) {
            $available_length = $max_total_length - strlen(' - ' . $dentist_name);
            $title = substr($title, 0, $available_length) . '...';
            $page_title = $title . ' - ' . $dentist_name;
        }
    }

    return $page_title;
}

/**
 * Add custom title filter for better SEO
 */
function le_custom_filter_page_title($title, $sep = '|', $seplocation = '')
{
    // Only modify titles for pages, not posts or other content types
    if (!is_page()) {
        return $title;
    }

    // Don't modify admin titles
    if (is_admin()) {
        return $title;
    }

    // Generate our custom title
    $custom_title = le_custom_generate_page_title();

    return $custom_title;
}
add_filter('wp_title', 'le_custom_filter_page_title', 10, 3);

/**
 * Override WordPress document title (for newer WordPress versions)
 */
function le_custom_document_title_parts($title_parts)
{
    // Only modify for pages
    if (!is_page()) {
        return $title_parts;
    }

    // Don't modify admin titles
    if (is_admin()) {
        return $title_parts;
    }

    // Generate our custom title
    $custom_title = le_custom_generate_page_title();

    // Replace the title parts
    $title_parts['title'] = $custom_title;
    $title_parts['site'] = ''; // Remove site name since we include dentist name

    return $title_parts;
}
add_filter('document_title_parts', 'le_custom_document_title_parts', 10, 1);

/**
 * Override WordPress document title separator
 */
function le_custom_document_title_separator($sep)
{
    if (is_page() && !is_admin()) {
        return ' - ';
    }
    return $sep;
}
add_filter('document_title_separator', 'le_custom_document_title_separator', 10, 1);

/**
 * Force custom title by removing WordPress default title tag
 */
function le_custom_remove_default_title()
{
    if (is_page() && !is_admin()) {
        remove_action('wp_head', '_wp_render_title_tag', 1);
    }
}
add_action('wp_head', 'le_custom_remove_default_title', 0);

/**
 * Debug function to test title generation
 */
function le_custom_debug_title()
{
    if (is_page() && !is_admin() && current_user_can('administrator')) {
        $custom_title = le_custom_generate_page_title();
        echo '<!-- DEBUG: Generated title: ' . esc_html($custom_title) . ' -->' . "\n";
    }
}
add_action('wp_head', 'le_custom_debug_title', 2);

/**
 * Add custom title for document head (fallback for older WordPress versions)
 */
function le_custom_add_custom_title()
{
    if (is_page() && !is_admin()) {
        $custom_title = le_custom_generate_page_title();
        echo '<title>' . esc_html($custom_title) . '</title>' . "\n";
    }
}
add_action('wp_head', 'le_custom_add_custom_title', 1);
