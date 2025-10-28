<?php

/**
 * Dynamic CSS Output
 * 
 * Handles dynamic CSS generation for color scheme customization
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output dynamic CSS for color scheme
 */
function le_custom_output_dynamic_css()
{
    $color_scheme = le_custom_get_color_scheme_data();

    echo '<style type="text/css">';
    echo ':root {';
    echo '--primary-color: ' . esc_attr($color_scheme['primary']) . ';';
    echo '--primary-color-light: ' . esc_attr($color_scheme['primary_light']) . ';';
    echo '--secondary-color: ' . esc_attr($color_scheme['secondary']) . ';';
    echo '--secondary-color-light: ' . esc_attr($color_scheme['secondary_light']) . ';';

    // Gallery-specific color variables with transparency
    $primary_rgb = hex2rgb($color_scheme['primary']);
    $secondary_rgb = hex2rgb($color_scheme['secondary']);
    echo '--primary-color-15: rgba(' . esc_attr($primary_rgb) . ', 0.15);';
    echo '--primary-color-10: rgba(' . esc_attr($primary_rgb) . ', 0.1);';
    echo '--primary-color-90: rgba(' . esc_attr($primary_rgb) . ', 0.9);';
    echo '--primary-color-95: rgba(' . esc_attr($primary_rgb) . ', 0.95);';
    echo '--secondary-color-05: rgba(' . esc_attr($secondary_rgb) . ', 0.05);';
    echo '--secondary-color-20: rgba(' . esc_attr($secondary_rgb) . ', 0.2);';
    echo '--secondary-color-30: rgba(' . esc_attr($secondary_rgb) . ', 0.3);';
    echo '--secondary-color-40: rgba(' . esc_attr($secondary_rgb) . ', 0.4);';

    echo '}';

    // Modern 2025 Header Styles
    echo '.contact-info-bar {';
    echo 'background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary_light']) . ' 0%, ' . esc_attr($color_scheme['secondary_light']) . ' 100%);';
    echo '}';

    echo '.contact-info-bar a:hover {';
    echo 'color: ' . esc_attr($color_scheme['primary']) . ' !important;';
    echo '}';

    echo '.contact-info-bar svg.group-hover\\:text-primary {';
    echo 'color: ' . esc_attr($color_scheme['primary']) . ' !important;';
    echo '}';

    echo '.language-switcher a.active {';
    echo 'background-color: white;';
    echo 'color: #111827;';
    echo 'box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);';
    echo '}';

    echo '.appointment-cta {';
    echo 'background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary']) . ' 0%, ' . esc_attr($color_scheme['secondary']) . ' 100%);';
    echo 'box-shadow: 0 10px 25px -5px rgba(' . esc_attr(hex2rgb($color_scheme['primary'])) . ', 0.25);';
    echo '}';

    echo '.appointment-cta:hover {';
    echo 'background: linear-gradient(135deg, ' . esc_attr(darken_color($color_scheme['primary'], 10)) . ' 0%, ' . esc_attr(darken_color($color_scheme['secondary'], 10)) . ' 100%);';
    echo 'box-shadow: 0 20px 25px -5px rgba(' . esc_attr(hex2rgb($color_scheme['primary'])) . ', 0.4);';
    echo '}';

    echo '.logo-icon {';
    echo 'background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary']) . ' 0%, ' . esc_attr($color_scheme['secondary']) . ' 100%);';
    echo 'box-shadow: 0 10px 25px -5px rgba(' . esc_attr(hex2rgb($color_scheme['primary'])) . ', 0.25);';
    echo '}';

    echo '.logo-icon:hover {';
    echo 'box-shadow: 0 20px 25px -5px rgba(' . esc_attr(hex2rgb($color_scheme['primary'])) . ', 0.4);';
    echo '}';

    // Mobile Navigation Styles
    echo '#mobile-menu-content {';
    echo 'background: rgba(255, 255, 255, 0.95);';
    echo 'backdrop-filter: blur(16px);';
    echo '-webkit-backdrop-filter: blur(16px);';
    echo '}';

    echo '#mobile-menu-backdrop {';
    echo 'background: rgba(0, 0, 0, 0.6);';
    echo 'backdrop-filter: blur(8px);';
    echo '-webkit-backdrop-filter: blur(8px);';
    echo '}';

    echo '.mobile-menu-header {';
    echo 'background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary_light']) . ' 0%, ' . esc_attr($color_scheme['secondary_light']) . ' 100%);';
    echo '}';

    // Ensure mobile menu takes full height
    echo '#mobile-menu {';
    echo 'height: 100vh;';
    echo 'height: 100dvh;';
    echo '}';

    echo '#mobile-menu-content {';
    echo 'height: 100vh;';
    echo 'height: 100dvh;';
    echo 'min-height: 100vh;';
    echo 'min-height: 100dvh;';
    echo '}';

    // Active language state
    echo '.active-language {';
    echo 'background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary']) . ' 0%, ' . esc_attr($color_scheme['secondary']) . ' 100%) !important;';
    echo 'color: white !important;';
    echo 'box-shadow: 0 4px 12px rgba(' . esc_attr(hex2rgb($color_scheme['primary'])) . ', 0.3) !important;';
    echo '}';

    // Footer menu link styles
    echo 'footer nav a {';
    echo 'color: #374151 !important;'; // gray-700
    echo 'transition: all 0.3s ease;';
    echo 'font-weight: 500;';
    echo '}';

    echo 'footer nav a:hover {';
    echo 'color: ' . esc_attr($color_scheme['primary']) . ' !important;';
    echo 'text-decoration: none;';
    echo '}';

    echo '</style>';
}
add_action('wp_head', 'le_custom_output_dynamic_css');

/**
 * Output dynamic CSS for customizer preview
 */
function le_custom_customizer_dynamic_css()
{
    $color_scheme = le_custom_get_color_scheme_data();

    echo '<style type="text/css">';
    echo ':root {';
    echo '--primary-color: ' . esc_attr($color_scheme['primary']) . ';';
    echo '--primary-color-light: ' . esc_attr($color_scheme['primary_light']) . ';';
    echo '--secondary-color: ' . esc_attr($color_scheme['secondary']) . ';';
    echo '--secondary-color-light: ' . esc_attr($color_scheme['secondary_light']) . ';';
    echo '}';

    // Additional styles for customizer preview
    echo '.services-section { background-color: var(--primary-color-light) !important; }';
    echo '.service-card { border-color: var(--primary-color)20 !important; }';
    echo '.service-icon { background-color: var(--primary-color-light) !important; }';
    echo '.service-button { background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; }';

    // Header preview styles
    echo '.contact-info-bar { background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary_light']) . ' 0%, ' . esc_attr($color_scheme['secondary_light']) . ' 100%) !important; }';
    echo '.appointment-cta { background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary']) . ' 0%, ' . esc_attr($color_scheme['secondary']) . ' 100%) !important; }';
    echo '.logo-icon { background: linear-gradient(135deg, ' . esc_attr($color_scheme['primary']) . ' 0%, ' . esc_attr($color_scheme['secondary']) . ' 100%) !important; }';
    echo '</style>';
}
add_action('customize_preview_init', 'le_custom_customizer_dynamic_css');

/**
 * Helper function to convert hex to RGB
 */
function hex2rgb($hex)
{
    $hex = str_replace('#', '', $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }

    return $r . ', ' . $g . ', ' . $b;
}

/**
 * Helper function to darken a color
 */
function darken_color($hex, $percent)
{
    $hex = str_replace('#', '', $hex);

    if (strlen($hex) == 3) {
        $hex = substr($hex, 0, 1) . substr($hex, 0, 1) . substr($hex, 1, 1) . substr($hex, 1, 1) . substr($hex, 2, 1) . substr($hex, 2, 1);
    }

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = max(0, min(255, $r - ($r * $percent / 100)));
    $g = max(0, min(255, $g - ($g * $percent / 100)));
    $b = max(0, min(255, $b - ($b * $percent / 100)));

    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}
