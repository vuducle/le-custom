<?php

/**
 * Test Sitemap Generator
 * 
 * This script tests the sitemap generator functionality.
 * Run this file directly to test the sitemap generation.
 */

// Load WordPress
require_once('../../../wp-load.php');

// Test if sitemap endpoints are registered
echo "Testing Sitemap Generator...\n\n";

// Test 1: Check if rewrite rules are added
$rewrite_rules = get_option('rewrite_rules');
$sitemap_rules = array_filter($rewrite_rules, function ($rule, $pattern) {
    return strpos($pattern, 'sitemap') !== false;
}, ARRAY_FILTER_USE_BOTH);

echo "1. Rewrite Rules Test:\n";
if (!empty($sitemap_rules)) {
    echo "✓ Sitemap rewrite rules found:\n";
    foreach ($sitemap_rules as $pattern => $rule) {
        echo "  - $pattern => $rule\n";
    }
} else {
    echo "✗ No sitemap rewrite rules found\n";
}
echo "\n";

// Test 2: Check if query vars are added
$query_vars = get_query_vars();
echo "2. Query Vars Test:\n";
if (in_array('sitemap', $query_vars)) {
    echo "✓ 'sitemap' query var is registered\n";
} else {
    echo "✗ 'sitemap' query var not found\n";
}
echo "\n";

// Test 3: Test sitemap URLs
$site_url = home_url('/');
echo "3. Sitemap URLs Test:\n";
echo "Main Sitemap: " . $site_url . "sitemap.xml\n";
echo "Pages Sitemap: " . $site_url . "sitemap-pages.xml\n";
echo "Images Sitemap: " . $site_url . "sitemap-images.xml\n\n";

// Test 4: Check if pages exist
$pages = get_pages(['post_status' => 'publish']);
echo "4. Pages Count Test:\n";
echo "Found " . count($pages) . " published pages\n";
foreach ($pages as $page) {
    echo "  - " . $page->post_title . " (" . $page->post_name . ")\n";
}
echo "\n";

// Test 5: Check if images exist
$attachments = get_posts([
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'numberposts' => -1,
    'post_mime_type' => 'image'
]);
echo "5. Images Count Test:\n";
echo "Found " . count($attachments) . " image attachments\n";
foreach (array_slice($attachments, 0, 5) as $attachment) {
    echo "  - " . get_the_title($attachment->ID) . "\n";
}
if (count($attachments) > 5) {
    echo "  ... and " . (count($attachments) - 5) . " more\n";
}
echo "\n";

// Test 6: Test content image extraction
echo "6. Content Image Extraction Test:\n";
$test_content = '<img src="/wp-content/uploads/test.jpg" alt="Test Image">';
$test_content .= '<div style="background-image: url(\'/wp-content/uploads/bg.jpg\')"></div>';
$extracted_images = le_custom_extract_images_from_content($test_content);
echo "Extracted " . count($extracted_images) . " images from test content\n";
foreach ($extracted_images as $image_url) {
    echo "  - $image_url\n";
}
echo "\n";

// Test 7: Check robots.txt integration
echo "7. Robots.txt Integration Test:\n";
$robots_content = "User-agent: *\nDisallow: /wp-admin/";
$robots_with_sitemap = le_custom_add_sitemap_to_robots_txt($robots_content);
if (strpos($robots_with_sitemap, 'Sitemap:') !== false) {
    echo "✓ Sitemap URL added to robots.txt\n";
} else {
    echo "✗ Sitemap URL not added to robots.txt\n";
}
echo "\n";

echo "Sitemap Generator Test Complete!\n";
echo "To view the actual sitemaps, visit:\n";
echo "- " . $site_url . "sitemap.xml\n";
echo "- " . $site_url . "sitemap-pages.xml\n";
echo "- " . $site_url . "sitemap-images.xml\n";
