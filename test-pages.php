<?php

/**
 * Quick test to check if pages exist
 * Add this to your functions.php temporarily
 */

function test_pages_exist()
{
    if (is_admin()) return;

    echo '<div style="background: #ffeb3b; padding: 10px; margin: 10px; border: 2px solid #f57f17;">';
    echo '<h3>Page Test Results:</h3>';

    // Test German page
    $de_page = get_page_by_path('de');
    echo 'German page (de): ' . ($de_page ? 'EXISTS (ID: ' . $de_page->ID . ', Status: ' . $de_page->post_status . ')' : 'NOT FOUND') . '<br>';

    // Test English page
    $en_page = get_page_by_path('en');
    echo 'English page (en): ' . ($en_page ? 'EXISTS (ID: ' . $en_page->ID . ', Status: ' . $en_page->post_status . ')' : 'NOT FOUND') . '<br>';

    // List all pages with their slugs
    echo '<br><strong>All pages:</strong><br>';
    $all_pages = get_pages();
    foreach ($all_pages as $page) {
        echo '- ' . $page->post_title . ' (slug: ' . $page->post_name . ', status: ' . $page->post_status . ')<br>';
    }

    echo '</div>';
}

// Uncomment the line below to enable this test
// add_action('wp_head', 'test_pages_exist'); 