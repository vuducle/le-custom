<?php

/**
 * Hero Section Management
 * 
 * Handles custom meta boxes and functionality for editable hero sections
 * on landing pages.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add custom meta boxes for landing page hero sections
 */
function le_custom_add_hero_meta_boxes()
{
    add_meta_box(
        'hero_section_settings',
        __('Hero Section Settings', 'le-custom'),
        'le_custom_hero_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'le_custom_add_hero_meta_boxes');

/**
 * Hero meta box callback function
 * 
 * Renders the hero section settings form in the WordPress admin
 * 
 * @param WP_Post $post The post object being edited
 */
function le_custom_hero_meta_box_callback($post)
{
    // Add nonce for security
    wp_nonce_field('le_custom_hero_meta_box', 'le_custom_hero_meta_box_nonce');

    // Get current values
    $hero_data = le_custom_get_hero_data($post->ID);

    // Set default values based on page slug
    $hero_data = le_custom_set_hero_defaults($hero_data, $post->post_name);

    // Get global color scheme data
    $color_scheme = le_custom_get_color_scheme_data();

?>
    <div class="hero-settings-container" style="margin: 20px 0;">
        <h3 style="margin-bottom: 15px;"><?php _e('Hero Section Content', 'le-custom'); ?></h3>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="hero_title"><?php _e('Hero Title', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="text" id="hero_title" name="hero_title"
                        value="<?php echo esc_attr($hero_data['title']); ?>" class="regular-text" />
                    <p class="description"><?php _e('Main heading for the hero section', 'le-custom'); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="hero_subtitle"><?php _e('Hero Subtitle', 'le-custom'); ?></label>
                </th>
                <td>
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="3"
                        class="large-text"><?php echo esc_textarea($hero_data['subtitle']); ?></textarea>
                    <p class="description"><?php _e('Subtitle text below the main heading', 'le-custom'); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="hero_primary_button_text"><?php _e('Primary Button Text', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="text" id="hero_primary_button_text" name="hero_primary_button_text"
                        value="<?php echo esc_attr($hero_data['primary_button_text']); ?>" class="regular-text" />
                    <p class="description"><?php _e('Text for the primary call-to-action button', 'le-custom'); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="hero_primary_button_url"><?php _e('Primary Button URL', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="text" id="hero_primary_button_url" name="hero_primary_button_url"
                        value="<?php echo esc_attr($hero_data['primary_button_url']); ?>" class="regular-text" />
                    <p class="description"><?php _e('URL or anchor link for the primary button', 'le-custom'); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="hero_secondary_button_text"><?php _e('Secondary Button Text', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="text" id="hero_secondary_button_text" name="hero_secondary_button_text"
                        value="<?php echo esc_attr($hero_data['secondary_button_text']); ?>" class="regular-text" />
                    <p class="description"><?php _e('Text for the secondary button', 'le-custom'); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="hero_secondary_button_url"><?php _e('Secondary Button URL', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="text" id="hero_secondary_button_url" name="hero_secondary_button_url"
                        value="<?php echo esc_attr($hero_data['secondary_button_url']); ?>" class="regular-text" />
                    <p class="description"><?php _e('URL or anchor link for the secondary button', 'le-custom'); ?></p>
                </td>
            </tr>
        </table>

        <h3 style="margin: 30px 0 15px 0;"><?php _e('Color Settings', 'le-custom'); ?></h3>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="hero_title_color_type"><?php _e('Title Color', 'le-custom'); ?></label>
                </th>
                <td>
                    <select id="hero_title_color_type" name="hero_title_color_type" class="color-type-selector">
                        <option value="global" <?php selected($hero_data['title_color_type'], 'global'); ?>>
                            <?php _e('Use Global Primary Color', 'le-custom'); ?>
                            (<?php echo esc_html($color_scheme['primary']); ?>)
                        </option>
                        <option value="custom" <?php selected($hero_data['title_color_type'], 'custom'); ?>>
                            <?php _e('Custom Color', 'le-custom'); ?>
                        </option>
                    </select>
                    <div id="hero_title_custom_color_container"
                        style="margin-top: 10px; <?php echo ($hero_data['title_color_type'] !== 'custom') ? 'display: none;' : ''; ?>">
                        <input type="color" id="hero_title_custom_color" name="hero_title_custom_color"
                            value="<?php echo esc_attr($hero_data['title_custom_color'] ?: '#ffffff'); ?>" />
                        <span class="description"><?php _e('Choose custom title color', 'le-custom'); ?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="hero_subtitle_color_type"><?php _e('Subtitle Color', 'le-custom'); ?></label>
                </th>
                <td>
                    <select id="hero_subtitle_color_type" name="hero_subtitle_color_type" class="color-type-selector">
                        <option value="global" <?php selected($hero_data['subtitle_color_type'], 'global'); ?>>
                            <?php _e('Use Global Secondary Color', 'le-custom'); ?>
                            (<?php echo esc_html($color_scheme['secondary']); ?>)
                        </option>
                        <option value="custom" <?php selected($hero_data['subtitle_color_type'], 'custom'); ?>>
                            <?php _e('Custom Color', 'le-custom'); ?>
                        </option>
                    </select>
                    <div id="hero_subtitle_custom_color_container"
                        style="margin-top: 10px; <?php echo ($hero_data['subtitle_color_type'] !== 'custom') ? 'display: none;' : ''; ?>">
                        <input type="color" id="hero_subtitle_custom_color" name="hero_subtitle_custom_color"
                            value="<?php echo esc_attr($hero_data['subtitle_custom_color'] ?: '#6b7280'); ?>" />
                        <span class="description"><?php _e('Choose custom subtitle color', 'le-custom'); ?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="hero_background_color_type"><?php _e('Background Color', 'le-custom'); ?></label>
                </th>
                <td>
                    <select id="hero_background_color_type" name="hero_background_color_type" class="color-type-selector">
                        <option value="global" <?php selected($hero_data['background_color_type'], 'global'); ?>>
                            <?php _e('Use Global Primary Light Color', 'le-custom'); ?>
                            (<?php echo esc_html($color_scheme['primary_light']); ?>)
                        </option>
                        <option value="custom" <?php selected($hero_data['background_color_type'], 'custom'); ?>>
                            <?php _e('Custom Color', 'le-custom'); ?>
                        </option>
                    </select>
                    <div id="hero_background_custom_color_container"
                        style="margin-top: 10px; <?php echo ($hero_data['background_color_type'] !== 'custom') ? 'display: none;' : ''; ?>">
                        <input type="color" id="hero_background_custom_color" name="hero_background_custom_color"
                            value="<?php echo esc_attr($hero_data['background_custom_color'] ?: '#ffffff'); ?>" />
                        <span class="description"><?php _e('Choose custom background color', 'le-custom'); ?></span>
                    </div>
                </td>
            </tr>
        </table>

        <h3 style="margin: 30px 0 15px 0;"><?php _e('Background Media Settings', 'le-custom'); ?></h3>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="hero_use_background_media"><?php _e('Use Background Media', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="checkbox" id="hero_use_background_media" name="hero_use_background_media" value="1"
                        <?php checked($hero_data['use_background_media'], '1'); ?> />
                    <p class="description">
                        <?php _e('Check to use a custom background image or video instead of the default gradient', 'le-custom'); ?>
                    </p>
                </td>
            </tr>

            <tr id="hero_media_type_row"
                style="<?php echo ($hero_data['use_background_media'] !== '1') ? 'display: none;' : ''; ?>">
                <th scope="row">
                    <label for="hero_media_type"><?php _e('Media Type', 'le-custom'); ?></label>
                </th>
                <td>
                    <select id="hero_media_type" name="hero_media_type">
                        <option value="image" <?php selected($hero_data['media_type'], 'image'); ?>>
                            <?php _e('Image', 'le-custom'); ?>
                        </option>
                        <option value="video" <?php selected($hero_data['media_type'], 'video'); ?>>
                            <?php _e('Video (Auto-play, Loop, Muted)', 'le-custom'); ?>
                        </option>
                    </select>
                    <p class="description">
                        <?php _e('Choose between image or video background. Videos will play automatically in loop without sound.', 'le-custom'); ?>
                    </p>
                </td>
            </tr>

            <tr id="hero_background_image_row"
                style="<?php echo ($hero_data['use_background_media'] !== '1' || $hero_data['media_type'] !== 'image') ? 'display: none;' : ''; ?>">
                <th scope="row">
                    <label for="hero_background_image"><?php _e('Background Image', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="hidden" id="hero_background_image" name="hero_background_image"
                        value="<?php echo esc_attr($hero_data['background_image']); ?>" />
                    <div id="hero_background_image_preview" style="margin-bottom: 10px;">
                        <?php if ($hero_data['background_image']): ?>
                            <img src="<?php echo esc_url($hero_data['background_image']); ?>"
                                style="max-width: 200px; height: auto; border: 1px solid #ddd;"
                                alt="<?php _e('Hero background image preview', 'le-custom'); ?>" />
                        <?php endif; ?>
                    </div>
                    <button type="button" id="upload_hero_background_image" class="button">
                        <?php _e('Choose Image', 'le-custom'); ?>
                    </button>
                    <button type="button" id="remove_hero_background_image" class="button"
                        style="margin-left: 10px; <?php echo empty($hero_data['background_image']) ? 'display: none;' : ''; ?>">
                        <?php _e('Remove Image', 'le-custom'); ?>
                    </button>
                    <p class="description">
                        <?php _e('Upload or choose an image for the hero section background', 'le-custom'); ?>
                    </p>
                </td>
            </tr>

            <tr id="hero_background_video_row"
                style="<?php echo ($hero_data['use_background_media'] !== '1' || $hero_data['media_type'] !== 'video') ? 'display: none;' : ''; ?>">
                <th scope="row">
                    <label for="hero_background_video"><?php _e('Background Video', 'le-custom'); ?></label>
                </th>
                <td>
                    <input type="hidden" id="hero_background_video" name="hero_background_video"
                        value="<?php echo esc_attr($hero_data['background_video']); ?>" />
                    <div id="hero_background_video_preview" style="margin-bottom: 10px;">
                        <?php if ($hero_data['background_video']): ?>
                            <video controls style="max-width: 200px; height: auto; border: 1px solid #ddd;">
                                <source src="<?php echo esc_url($hero_data['background_video']); ?>" type="video/mp4">
                                <?php _e('Your browser does not support the video tag.', 'le-custom'); ?>
                            </video>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="upload_hero_background_video" class="button">
                        <?php _e('Choose Video', 'le-custom'); ?>
                    </button>
                    <button type="button" id="remove_hero_background_video" class="button"
                        style="margin-left: 10px; <?php echo empty($hero_data['background_video']) ? 'display: none;' : ''; ?>">
                        <?php _e('Remove Video', 'le-custom'); ?>
                    </button>
                    <p class="description">
                        <?php _e('Upload or choose a video for the hero section background. Recommended: MP4 format, optimized for web.', 'le-custom'); ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>


<?php
}

/**
 * Set default values for hero section based on page slug
 * 
 * @param array $hero_data Current hero data
 * @param string $page_slug Page slug (de/en)
 * @return array Updated hero data with defaults
 */
function le_custom_set_hero_defaults($hero_data, $page_slug)
{
    $defaults = [
        'de' => [
            'title' => 'Willkommen in unserer Zahnarztpraxis',
            'subtitle' => 'Professionelle Zahnmedizin mit modernster Technologie und persönlicher Betreuung für Ihre Zahngesundheit.',
            'primary_button_text' => 'Termin vereinbaren',
            'primary_button_url' => '#termin',
            'secondary_button_text' => 'Unsere Leistungen',
            'secondary_button_url' => '#leistungen',
        ],
        'en' => [
            'title' => 'Welcome to Our Dental Practice',
            'subtitle' => 'Professional dentistry with state-of-the-art technology and personalized care for your oral health.',
            'primary_button_text' => 'Book Appointment',
            'primary_button_url' => '#appointment',
            'secondary_button_text' => 'Our Services',
            'secondary_button_url' => '#services',
        ]
    ];

    if (isset($defaults[$page_slug])) {
        foreach ($defaults[$page_slug] as $key => $default_value) {
            if (empty($hero_data[$key])) {
                $hero_data[$key] = $default_value;
            }
        }
    }

    // Set default color types if not already set
    if (empty($hero_data['title_color_type'])) {
        $hero_data['title_color_type'] = 'global';
    }
    if (empty($hero_data['subtitle_color_type'])) {
        $hero_data['subtitle_color_type'] = 'global';
    }
    if (empty($hero_data['background_color_type'])) {
        $hero_data['background_color_type'] = 'global';
    }

    return $hero_data;
}

/**
 * Save hero meta box data
 * 
 * @param int $post_id The post ID being saved
 */
function le_custom_save_hero_meta_box($post_id)
{
    // Check if nonce is valid
    if (
        !isset($_POST['le_custom_hero_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['le_custom_hero_meta_box_nonce'], 'le_custom_hero_meta_box')
    ) {
        return;
    }

    // Check if user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save hero section data
    $fields = [
        'hero_title' => 'sanitize_text_field',
        'hero_subtitle' => 'sanitize_textarea_field',
        'hero_primary_button_text' => 'sanitize_text_field',
        'hero_primary_button_url' => 'sanitize_text_field',
        'hero_secondary_button_text' => 'sanitize_text_field',
        'hero_secondary_button_url' => 'sanitize_text_field',
        'hero_background_image' => 'esc_url_raw',
        'hero_background_video' => 'esc_url_raw', // New field for video URL
        'hero_media_type' => 'sanitize_text_field', // New field for media type
        'hero_title_color_type' => 'sanitize_text_field',
        'hero_subtitle_color_type' => 'sanitize_text_field',
        'hero_background_color_type' => 'sanitize_text_field',
        'hero_title_custom_color' => 'sanitize_hex_color',
        'hero_subtitle_custom_color' => 'sanitize_hex_color',
        'hero_background_custom_color' => 'sanitize_hex_color',
    ];

    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = call_user_func($sanitize_function, $_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }

    // Handle checkbox separately
    $hero_use_background_media = isset($_POST['hero_use_background_media']) ? '1' : '0';
    update_post_meta($post_id, '_hero_use_background_media', $hero_use_background_media);
}
add_action('save_post', 'le_custom_save_hero_meta_box');

/**
 * Helper function to get hero section data
 * 
 * @param int|null $post_id The post ID to get data for, defaults to current post
 * @return array Hero section data
 */
function le_custom_get_hero_data($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $hero_data = [
        'title' => get_post_meta($post_id, '_hero_title', true),
        'subtitle' => get_post_meta($post_id, '_hero_subtitle', true),
        'primary_button_text' => get_post_meta($post_id, '_hero_primary_button_text', true),
        'primary_button_url' => get_post_meta($post_id, '_hero_primary_button_url', true),
        'secondary_button_text' => get_post_meta($post_id, '_hero_secondary_button_text', true),
        'secondary_button_url' => get_post_meta($post_id, '_hero_secondary_button_url', true),
        'background_image' => get_post_meta($post_id, '_hero_background_image', true),
        'background_video' => get_post_meta($post_id, '_hero_background_video', true), // New field for video URL
        'use_background_media' => get_post_meta($post_id, '_hero_use_background_media', true), // New field for media type
        'media_type' => get_post_meta($post_id, '_hero_media_type', true), // New field for media type
        'title_color_type' => get_post_meta($post_id, '_hero_title_color_type', true),
        'subtitle_color_type' => get_post_meta($post_id, '_hero_subtitle_color_type', true),
        'background_color_type' => get_post_meta($post_id, '_hero_background_color_type', true),
        'title_custom_color' => get_post_meta($post_id, '_hero_title_custom_color', true),
        'subtitle_custom_color' => get_post_meta($post_id, '_hero_subtitle_custom_color', true),
        'background_custom_color' => get_post_meta($post_id, '_hero_background_custom_color', true),
    ];

    return $hero_data;
}

/**
 * Get the actual color value for hero elements based on type and customizer settings
 * 
 * @param string $color_type The color type (global/custom)
 * @param string $custom_color The custom color value
 * @param string $global_color_key The key for the global color (primary, secondary, etc.)
 * @return string The final color value
 */
function le_custom_get_hero_color_value($color_type, $custom_color, $global_color_key = 'primary')
{
    if ($color_type === 'custom' && !empty($custom_color)) {
        return $custom_color;
    }

    // Use global color from customizer
    $color_scheme = le_custom_get_color_scheme_data();
    return isset($color_scheme[$global_color_key]) ? $color_scheme[$global_color_key] : '#000000';
}

/**
 * Get hero background style based on settings
 * 
 * @param array $hero_data Hero section data
 * @return string CSS background style
 */
function le_custom_get_hero_background_style($hero_data)
{
    // If using background media, prioritize it
    if (!empty($hero_data['use_background_media'])) {
        if ($hero_data['media_type'] === 'image' && !empty($hero_data['background_image'])) {
            return 'background-image: url(' . esc_url($hero_data['background_image']) . '); background-size: cover; background-position: center;';
        }
        // For video backgrounds, we'll handle it in the display function
        return '';
    }

    // Handle background color types
    switch ($hero_data['background_color_type']) {
        case 'custom':
            $color = le_custom_get_hero_color_value('custom', $hero_data['background_custom_color']);
            return 'background-color: ' . $color . ';';

        case 'global':
        default:
            $color = le_custom_get_hero_color_value('global', '', 'primary_light');
            return 'background-color: ' . $color . ';';
    }
}

/**
 * Check if current page is a subpage (not a landing page)
 * 
 * @return bool True if it's a subpage
 */
function le_custom_is_subpage()
{
    $current_page = get_post();
    if (!$current_page) {
        return false;
    }

    // Check if it's a landing page template
    $template = get_page_template_slug($current_page->ID);
    if ($template === 'page-landing-de.php' || $template === 'page-landing-en.php') {
        return false;
    }

    // Check if it's a landing page by slug
    $page_slug = $current_page->post_name;
    if ($page_slug === 'de' || $page_slug === 'en') {
        return false;
    }

    return true;
}

/**
 * Get subpage hero section HTML
 * 
 * @param int|null $post_id The post ID to get data for, defaults to current post
 * @return string HTML for subpage hero section
 */
function le_custom_get_subpage_hero_html($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $post = get_post($post_id);
    if (!$post) {
        return '';
    }

    // Get featured image
    $featured_image = get_the_post_thumbnail_url($post_id, 'full');
    $title = get_the_title($post_id);

    // Get global colors
    $color_scheme = le_custom_get_color_scheme_data();
    $primary_color = $color_scheme['primary'];

    // Build background style
    $bg_style = '';
    if ($featured_image) {
        $bg_style = 'background-image: url(' . esc_url($featured_image) . '); background-size: cover; background-position: center;';
    } else {
        $bg_style = 'background-color: ' . $color_scheme['primary_light'] . ';';
    }

    ob_start();
?>
    <section class="relative py-20 lg:py-32" style="<?php echo $bg_style; ?>">
        <?php if ($featured_image): ?>
            <!-- Dark overlay for better text readability -->
            <div class="absolute inset-0 bg-black/40"></div>
        <?php endif; ?>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"
                    data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                    <?php echo esc_html($title); ?>
                </h1>

                <!-- <?php if ($featured_image): ?>
                    <div class="mt-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
                        <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($title); ?>"
                            class="w-full h-auto rounded-lg shadow-2xl" style="max-height: 400px; object-fit: cover;">
                    </div>
                <?php endif; ?> -->
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Display hero section based on page type
 * 
 * @param int|null $post_id The post ID to get data for, defaults to current post
 */
function le_custom_display_hero_section($post_id = null)
{
    if (le_custom_is_subpage()) {
        echo le_custom_get_subpage_hero_html($post_id);
    } else {
        // Display regular hero section for landing pages
        $hero_data = le_custom_get_hero_data($post_id);
        $hero_bg_style = le_custom_get_hero_background_style($hero_data);
        $color_scheme = le_custom_get_color_scheme_data();
        $primary_color = $color_scheme['primary'];
        $secondary_color = $color_scheme['secondary'];
    ?>
        <section class="relative py-20 lg:py-32" style="<?php echo $hero_bg_style; ?>">
            <?php if (!empty($hero_data['use_background_media'])): ?>
                <?php if ($hero_data['media_type'] === 'video' && !empty($hero_data['background_video'])): ?>
                    <!-- Background video -->
                    <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
                        <source src="<?php echo esc_url($hero_data['background_video']); ?>" type="video/mp4">
                    </video>
                    <!-- Dark overlay for background videos -->
                    <div class="absolute inset-0 bg-black/40"></div>
                <?php elseif ($hero_data['media_type'] === 'image' && !empty($hero_data['background_image'])): ?>
                    <!-- Dark overlay for background images -->
                    <div class="absolute inset-0 bg-black/40"></div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"
                        data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                        <?php echo esc_html($hero_data['title'] ?: 'Willkommen in unserer Zahnarztpraxis'); ?>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 leading-relaxed text-white"
                        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);" data-aos="fade-up" data-aos-delay="200"
                        data-aos-duration="800">
                        <?php echo esc_html($hero_data['subtitle'] ?: 'Professionelle Zahnmedizin mit modernster Technologie und persönlicher Betreuung für Ihre Zahngesundheit.'); ?>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400"
                        data-aos-duration="800">
                        <?php if ($hero_data['primary_button_text']): ?>
                            <a href="<?php echo esc_url($hero_data['primary_button_url'] ?: '#termin'); ?>"
                                class="text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors duration-200"
                                style="background-color: <?php echo esc_attr($primary_color); ?>; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                                onmouseover="this.style.backgroundColor='<?php echo esc_attr($primary_color); ?>'; this.style.filter='brightness(1.1)'"
                                onmouseout="this.style.backgroundColor='<?php echo esc_attr($primary_color); ?>'; this.style.filter='brightness(1)'">
                                <?php echo esc_html($hero_data['primary_button_text']); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($hero_data['secondary_button_text']): ?>
                            <a href="<?php echo esc_url($hero_data['secondary_button_url'] ?: '#leistungen'); ?>"
                                class="px-8 py-4 rounded-lg text-lg font-semibold transition-colors duration-200 text-white"
                                style="background-color: <?php echo esc_attr($secondary_color); ?>; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                                onmouseover="this.style.backgroundColor='<?php echo esc_attr($secondary_color); ?>'; this.style.filter='brightness(0.8)'"
                                onmouseout="this.style.backgroundColor='<?php echo esc_attr($secondary_color); ?>'; this.style.filter='brightness(1)'">
                                <?php echo esc_html($hero_data['secondary_button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
}
