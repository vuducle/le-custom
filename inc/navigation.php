<?php

/**
 * Navigation and Routing
 * 
 * Handles navigation menus, routing for landing pages, and language detection.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Template-based approach for /de and /en landing pages
 * 
 * @param string $template The template file path
 * @return string Modified template path
 */
function le_custom_template_redirect($template)
{
    if (is_admin()) {
        return $template;
    }

    $url = $_SERVER['REQUEST_URI'];

    // Check for /de/ URL
    if ($url === '/de/' || $url === '/de') {
        $page = get_page_by_path('de');
        if ($page) {
            global $post;
            $post = $page;
            setup_postdata($post);
            return get_template_directory() . '/page-landing-de.php';
        }
    }

    // Check for /en/ URL
    if ($url === '/en/' || $url === '/en') {
        $page = get_page_by_path('en');
        if ($page) {
            global $post;
            $post = $page;
            setup_postdata($post);
            return get_template_directory() . '/page-landing-en.php';
        }
    }

    return $template;
}
add_filter('template_include', 'le_custom_template_redirect', 99);

/**
 * Add custom rewrite rules for landing pages
 */
function le_custom_add_rewrite_rules()
{
    add_rewrite_rule(
        '^de/?$',
        'index.php?pagename=de',
        'top'
    );

    add_rewrite_rule(
        '^en/?$',
        'index.php?pagename=en',
        'top'
    );

    // Add query vars
    add_rewrite_tag('%landing_lang%', '([^&]+)');
}
add_action('init', 'le_custom_add_rewrite_rules');

/**
 * Flush rewrite rules on theme activation
 */
function le_custom_flush_rewrite_rules()
{
    le_custom_add_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'le_custom_flush_rewrite_rules');

/**
 * Detect current language based on URL
 * 
 * @return string Current language code (de, en, or default)
 */
function le_custom_get_current_language()
{
    $url = $_SERVER['REQUEST_URI'];

    if (strpos($url, '/de/') === 0 || $url === '/de') {
        return 'de';
    } elseif (strpos($url, '/en/') === 0 || $url === '/en') {
        return 'en';
    }

    return 'default'; // Default language
}

/**
 * Get the appropriate navigation menu based on current language
 * 
 * @param string $location Menu location (primary, footer, etc.)
 * @return string|false Menu location name or false if not found
 */
function le_custom_get_navigation_menu($location = 'primary')
{
    $language = le_custom_get_current_language();

    // Try language-specific menu first
    $menu_location = $location . '-' . $language;
    if (has_nav_menu($menu_location)) {
        return $menu_location;
    }

    // Fall back to default menu
    if (has_nav_menu($location)) {
        return $location;
    }

    return false;
}