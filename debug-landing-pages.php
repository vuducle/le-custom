<?php

/**
 * Debug script for landing page redirects
 * 
 * Add this to your theme's functions.php temporarily to debug the issue
 */

// Add this to your functions.php to debug
function debug_landing_pages()
{
    if (is_admin()) {
        return;
    }

    $current_url = $_SERVER['REQUEST_URI'];
    echo '<div style="background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;">';
    echo '<strong>Debug Info:</strong><br>';
    echo 'Current URL: ' . $current_url . '<br>';
    echo 'Is /de/: ' . (preg_match('#^/de/?$#', $current_url) ? 'YES' : 'NO') . '<br>';
    echo 'Is /en/: ' . (preg_match('#^/en/?$#', $current_url) ? 'YES' : 'NO') . '<br>';

    // Check if pages exist
    $german_page = get_page_by_path('de');
    $english_page = get_page_by_path('en');

    echo 'German page exists: ' . ($german_page ? 'YES (ID: ' . $german_page->ID . ')' : 'NO') . '<br>';
    echo 'English page exists: ' . ($english_page ? 'YES (ID: ' . $english_page->ID . ')' : 'NO') . '<br>';

    if ($german_page) {
        echo 'German page permalink: ' . get_permalink($german_page->ID) . '<br>';
        echo 'German page template: ' . get_page_template_slug($german_page->ID) . '<br>';
    }

    if ($english_page) {
        echo 'English page permalink: ' . get_permalink($english_page->ID) . '<br>';
        echo 'English page template: ' . get_page_template_slug($english_page->ID) . '<br>';
    }

    echo '</div>';
}

// Uncomment the line below to enable debugging
// add_action('wp_head', 'debug_landing_pages');

/**
 * Alternative approach: Use template_include filter
 */
function le_custom_template_redirect($template)
{
    $current_url = $_SERVER['REQUEST_URI'];

    // Check for /de/ URL
    if (preg_match('#^/de/?$#', $current_url)) {
        $german_page = get_page_by_path('de');
        if ($german_page) {
            // Set up the post data
            global $post;
            $post = $german_page;
            setup_postdata($post);

            // Return the German template
            return get_template_directory() . '/page-landing-de.php';
        }
    }

    // Check for /en/ URL
    if (preg_match('#^/en/?$#', $current_url)) {
        $english_page = get_page_by_path('en');
        if ($english_page) {
            // Set up the post data
            global $post;
            $post = $english_page;
            setup_postdata($post);

            // Return the English template
            return get_template_directory() . '/page-landing-en.php';
        }
    }

    return $template;
}

// Uncomment the line below to use template_include approach
// add_filter('template_include', 'le_custom_template_redirect', 99);

/**
 * Simple test function to check if pages exist
 */
function test_landing_pages()
{
    echo '<div style="background: #e8f5e8; padding: 10px; margin: 10px; border: 1px solid #4caf50;">';
    echo '<strong>Landing Pages Test:</strong><br>';

    $pages = get_pages();
    foreach ($pages as $page) {
        if ($page->post_name === 'de' || $page->post_name === 'en') {
            echo 'Found page: ' . $page->post_title . ' (slug: ' . $page->post_name . ', ID: ' . $page->ID . ')<br>';
            echo 'Template: ' . get_page_template_slug($page->ID) . '<br>';
            echo 'Status: ' . $page->post_status . '<br><br>';
        }
    }

    echo '</div>';
}

// Uncomment the line below to test pages
//add_action('wp_footer', 'test_landing_pages');