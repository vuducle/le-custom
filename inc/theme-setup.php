<?php

/**
 * Theme Setup and Basic Functionality
 * 
 * Handles theme setup, script/style enqueuing, and basic WordPress functionality.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 * 
 * Sets up theme defaults and registers support for various WordPress features.
 */
function le_custom_theme_setup()
{
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'le-custom'),
        'primary-de' => __('Primary Menu - German', 'le-custom'),
        'primary-en' => __('Primary Menu - English', 'le-custom'),
        'footer' => __('Footer Menu', 'le-custom'),
        'footer-de' => __('Footer Menu - German', 'le-custom'),
        'footer-en' => __('Footer Menu - English', 'le-custom'),
    ]);
}
add_action('after_setup_theme', 'le_custom_theme_setup');

/**
 * Enqueue scripts and styles
 * 
 * Enqueues all necessary scripts and styles for the theme.
 */
function le_custom_scripts()
{
    // Enqueue compiled Tailwind CSS
    wp_enqueue_style(
        'le-custom-tailwind',
        get_template_directory_uri() . '/dist/output.css',
        [],
        filemtime(get_template_directory() . '/dist/output.css')
    );

    // Enqueue theme stylesheet for additional custom styles
    wp_enqueue_style(
        'le-custom-style',
        get_stylesheet_uri(),
        ['le-custom-tailwind'],
        wp_get_theme()->get('Version')
    );

    // Enqueue AOS CSS (local)
    wp_enqueue_style(
        'aos-css',
        get_template_directory_uri() . '/assets/vendor/aos/aos.css',
        [],
        '2.3.1'
    );

    // Enqueue AOS JavaScript (local)
    wp_enqueue_script(
        'aos-js',
        get_template_directory_uri() . '/assets/vendor/aos/aos.js',
        [],
        '2.3.1',
        true
    );

    // Enqueue theme JavaScript
    wp_enqueue_script(
        'le-custom-script',
        get_template_directory_uri() . '/assets/js/theme.js',
        ['aos-js'],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'le_custom_scripts');

/**
 * Enqueue admin scripts
 * 
 * Enqueues scripts needed in the WordPress admin area.
 * 
 * @param string $hook The current admin page hook
 */
function le_custom_admin_scripts($hook)
{
    global $post_type;

    // Only load on page edit screens
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ($post_type === 'page') {
            wp_enqueue_media();
            wp_enqueue_script(
                'le-custom-hero-admin',
                get_template_directory_uri() . '/assets/js/hero-section-admin.js',
                ['media-upload'],
                wp_get_theme()->get('Version'),
                true
            );
        }
    }
}
add_action('admin_enqueue_scripts', 'le_custom_admin_scripts');

/**
 * Add custom image sizes
 * 
 * Registers custom image sizes for the theme.
 */
function le_custom_image_sizes()
{
    add_image_size('le-custom-featured', 800, 450, true);
    add_image_size('le-custom-thumbnail', 400, 225, true);
}
add_action('after_setup_theme', 'le_custom_image_sizes');

/**
 * Customize excerpt length
 * 
 * @param int $length The excerpt length
 * @return int Modified excerpt length
 */
function le_custom_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'le_custom_excerpt_length');

/**
 * Customize excerpt more
 * 
 * @param string $more The excerpt more string
 * @return string Modified excerpt more string
 */
function le_custom_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'le_custom_excerpt_more');

/**
 * Add custom body classes
 * 
 * @param array $classes Array of body classes
 * @return array Modified array of body classes
 */
function le_custom_body_classes($classes)
{
    // Add a class for the current page template
    if (is_page()) {
        $classes[] = 'page-template';
    }

    return $classes;
}
add_filter('body_class', 'le_custom_body_classes');

/**
 * Register widget areas
 * 
 * Registers sidebar and widget areas for the theme.
 */
function le_custom_widgets_init()
{
    register_sidebar([
        'name'          => __('Sidebar', 'le-custom'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'le-custom'),
        'before_widget' => '<section id="%1$s" class="widget %2$s bg-white p-6 rounded-lg shadow-md mb-6">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title text-xl font-semibold text-gray-900 mb-4">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'le_custom_widgets_init');

/**
 * Debug function for development
 * 
 * Outputs debug information for landing pages (only in development)
 */
function debug_en_page()
{
    if (is_admin()) return;

    echo '<div style="background: yellow; padding: 10px; margin: 10px;">';
    echo '<strong>Debug:</strong><br>';

    $en_page = get_page_by_path('en');
    echo 'English page exists: ' . ($en_page ? 'YES (ID: ' . $en_page->ID . ')' : 'NO') . '<br>';

    $de_page = get_page_by_path('de');
    echo 'German page exists: ' . ($de_page ? 'YES (ID: ' . $de_page->ID . ')' : 'NO') . '<br>';

    echo 'Current URL: ' . $_SERVER['REQUEST_URI'] . '<br>';
    echo 'Current Language: ' . le_custom_get_current_language() . '<br>';

    // Test direct page access
    if ($en_page) {
        echo 'English page permalink: ' . get_permalink($en_page->ID) . '<br>';
    }
    if ($de_page) {
        echo 'German page permalink: ' . get_permalink($de_page->ID) . '<br>';
    }

    echo '</div>';
}
//add_action('wp_head', 'debug_en_page');

/**
 * Footer menu fallback function
 * 
 * Provides a fallback menu when no footer menu is assigned
 */
function le_custom_footer_menu_fallback()
{
    echo '<ul class="space-y-4">';
    echo '<li><a href="' . esc_url(home_url('/')) . '" class="block text-white/80 hover:text-white transition-colors duration-200">Startseite</a></li>';
    echo '<li><a href="' . esc_url(home_url('/kontakt')) . '" class="block text-white/80 hover:text-white transition-colors duration-200">Kontakt</a></li>';
    echo '<li><a href="' . esc_url(home_url('/anfahrt')) . '" class="block text-white/80 hover:text-white transition-colors duration-200">Anfahrt</a></li>';
    echo '<li><a href="' . esc_url(home_url('/datenschutz')) . '" class="block text-white/80 hover:text-white transition-colors duration-200">Datenschutzerklärung</a></li>';
    echo '<li><a href="' . esc_url(home_url('/impressum')) . '" class="block text-white/80 hover:text-white transition-colors duration-200">Impressum</a></li>';
    echo '</ul>';
}

/**
 * Custom Footer Menu Walker
 * 
 * Customizes the output of footer menu items
 */
class LE_Custom_Footer_Menu_Walker extends Walker_Nav_Menu
{
    /**
     * Start the element output
     */
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $output .= '<li>';
        $output .= '<a href="' . esc_url($item->url) . '" class="block text-white/80 hover:text-white transition-colors duration-200">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }

    /**
     * End the element output
     */
    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}

/**
 * Debug function for footer menu troubleshooting
 * 
 * Outputs debug information for footer menu assignment (only in development)
 */
function debug_footer_menu()
{
    if (is_admin()) return;

    echo '<div style="background: orange; padding: 10px; margin: 10px; position: fixed; top: 0; right: 0; z-index: 9999; max-width: 400px;">';
    echo '<strong>Footer Menu Debug:</strong><br>';
    
    $current_lang = le_custom_get_current_language();
    echo 'Current Language: ' . $current_lang . '<br>';
    
    $footer_menu_location = le_custom_get_navigation_menu('footer');
    echo 'Footer Menu Location: ' . ($footer_menu_location ?: 'fallback to default') . '<br>';
    
    if ($footer_menu_location) {
        $menu = wp_get_nav_menu_object($footer_menu_location);
        if ($menu) {
            echo 'Menu Found: ' . $menu->name . ' (ID: ' . $menu->term_id . ')<br>';
        } else {
            echo 'Menu Not Found for location: ' . $footer_menu_location . '<br>';
        }
    }
    
    echo 'Has Footer Menu (default): ' . (has_nav_menu('footer') ? 'YES' : 'NO') . '<br>';
    echo 'Has Footer Menu (German): ' . (has_nav_menu('footer-de') ? 'YES' : 'NO') . '<br>';
    echo 'Has Footer Menu (English): ' . (has_nav_menu('footer-en') ? 'YES' : 'NO') . '<br>';
    
    echo '<small>Current URL: ' . $_SERVER['REQUEST_URI'] . '</small>';
    echo '</div>';
}
// Uncomment the line below to enable footer menu debugging
// add_action('wp_head', 'debug_footer_menu');