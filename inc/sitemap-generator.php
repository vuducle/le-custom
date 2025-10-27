<?php

/**
 * Sitemap Generator
 * 
 * Generates XML sitemaps for pages and images with multilingual support.
 * Includes proper WordPress integration and SEO optimization.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register sitemap endpoints
 */
function le_custom_register_sitemap_endpoints()
{
    add_rewrite_rule(
        '^sitemap\.xml$',
        'index.php?sitemap=main',
        'top'
    );

    add_rewrite_rule(
        '^sitemap-images\.xml$',
        'index.php?sitemap=images',
        'top'
    );

    add_rewrite_rule(
        '^sitemap-pages\.xml$',
        'index.php?sitemap=pages',
        'top'
    );
}
add_action('init', 'le_custom_register_sitemap_endpoints');

/**
 * Add sitemap query vars
 */
function le_custom_add_sitemap_query_vars($vars)
{
    $vars[] = 'sitemap';
    return $vars;
}
add_filter('query_vars', 'le_custom_add_sitemap_query_vars');

/**
 * Handle sitemap requests
 */
function le_custom_handle_sitemap_requests()
{
    $sitemap_type = get_query_var('sitemap');

    if (!$sitemap_type) {
        return;
    }

    // Completely disable output buffering and clear everything
    while (ob_get_level()) {
        ob_end_clean();
    }

    // Disable error reporting completely
    error_reporting(0);
    ini_set('display_errors', 0);

    // Set proper headers
    header('Content-Type: application/xml; charset=utf-8');
    header('X-Robots-Tag: noindex');
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

    switch ($sitemap_type) {
        case 'main':
            le_custom_generate_main_sitemap();
            break;
        case 'pages':
            le_custom_generate_pages_sitemap();
            break;
        case 'images':
            le_custom_generate_images_sitemap();
            break;
    }

    exit;
}
add_action('template_redirect', 'le_custom_handle_sitemap_requests');

/**
 * Generate main sitemap index
 */
function le_custom_generate_main_sitemap()
{
    $site_url = home_url('/');
    $last_modified = date('c');

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Pages sitemap
    echo "\t" . '<sitemap>' . "\n";
    echo "\t\t" . '<loc>' . esc_url($site_url . 'sitemap-pages.xml') . '</loc>' . "\n";
    echo "\t\t" . '<lastmod>' . esc_html($last_modified) . '</lastmod>' . "\n";
    echo "\t" . '</sitemap>' . "\n";

    // Images sitemap
    echo "\t" . '<sitemap>' . "\n";
    echo "\t\t" . '<loc>' . esc_url($site_url . 'sitemap-images.xml') . '</loc>' . "\n";
    echo "\t\t" . '<lastmod>' . esc_html($last_modified) . '</lastmod>' . "\n";
    echo "\t" . '</sitemap>' . "\n";

    echo '</sitemapindex>';
}

/**
 * Generate pages sitemap
 */
function le_custom_generate_pages_sitemap()
{
    $site_url = home_url('/');

    echo '
<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Homepage
    echo "\t" . '<url>' . "\n";
    echo "\t\t" . '<loc>' . esc_url($site_url) . '</loc>' . "\n";
    echo "\t\t" . '<lastmod>' . esc_html(date('c')) . '</lastmod>' . "\n";
    echo "\t\t" . '<changefreq>weekly</changefreq>' . "\n";
    echo "\t\t" . '<priority>1.0</priority>' . "\n";
    echo "\t" . '</url>' . "\n";

    // Get all published pages
    $pages = get_pages([
        'post_status' => 'publish',
        'sort_column' => 'menu_order,post_title',
        'hierarchical' => 0
    ]);

    foreach ($pages as $page) {
        $page_url = get_permalink($page->ID);
        $last_modified = get_the_modified_date('c', $page->ID);

        // Determine priority based on page type
        $priority = '0.8';
        $changefreq = 'monthly';

        // Higher priority for important pages
        if (in_array($page->post_name, [
            'kontakt',
            'contact',
            'anfahrt',
            'directions',
            'impressum',
            'imprint',
            'datenschutz',
            'privacy-policy'
        ])) {
            $priority = '0.9';
            $changefreq = 'monthly';
        }

        // Landing pages
        if (strpos($page->post_name, 'landing') !== false) {
            $priority = '0.9';
            $changefreq = 'weekly';
        }

        echo "\t" . '<url>' . "\n";
        echo "\t\t" . '<loc>' . esc_url($page_url) . '</loc>' . "\n";
        echo "\t\t" . '<lastmod>' . esc_html($last_modified) . '</lastmod>' . "\n";
        echo "\t\t" . '<changefreq>' . esc_html($changefreq) . '</changefreq>' . "\n";
        echo "\t\t" . '<priority>' . esc_html($priority) . '</priority>' . "\n";
        echo "\t" . '</url>' . "\n";
    }

    // Add any custom post types if they exist
    $custom_post_types = get_post_types(['public' => true, '_builtin' => false]);

    foreach ($custom_post_types as $post_type) {
        $posts = get_posts([
            'post_type' => $post_type,
            'post_status' => 'publish',
            'numberposts' => -1
        ]);

        foreach ($posts as $post) {
            $post_url = get_permalink($post->ID);
            $last_modified = get_the_modified_date('c', $post->ID);

            echo "\t" . '<url>' . "\n";
            echo "\t\t" . '<loc>' . esc_url($post_url) . '</loc>' . "\n";
            echo "\t\t" . '<lastmod>' . esc_html($last_modified) . '</lastmod>' . "\n";
            echo "\t\t" . '<changefreq>monthly</changefreq>' . "\n";
            echo "\t\t" . '<priority>0.7</priority>' . "\n";
            echo "\t" . '</url>' . "\n";
        }
    }

    echo '</urlset>';
}

/**
 * Generate images sitemap
 */
function le_custom_generate_images_sitemap()
{
    $site_url = home_url('/');

    echo '
<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

    // Get all published pages and posts with images
    $posts = get_posts([
        'post_type' => ['page', 'post'],
        'post_status' => 'publish',
        'numberposts' => -1
    ]);

    foreach ($posts as $post) {
        $post_url = get_permalink($post->ID);
        $last_modified = get_the_modified_date('c', $post->ID);

        // Get featured image
        $featured_image_id = get_post_thumbnail_id($post->ID);
        if ($featured_image_id) {
            $featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full');
            $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);
            $featured_image_title = get_the_title($featured_image_id);

            echo "\t" . '<url>' . "\n";
            echo "\t\t" . '<loc>' . esc_url($post_url) . '</loc>' . "\n";
            echo "\t\t" . '<lastmod>' . esc_html($last_modified) . '</lastmod>' . "\n";
            echo "\t\t" . '<image:image>' . "\n";
            echo "\t\t\t" . '<image:loc>' . esc_url($featured_image_url) . '</image:loc>' . "\n";
            if ($featured_image_title) {
                echo "\t\t\t" . '<image:title>' . esc_html($featured_image_title) . '</image:title>' . "\n";
            }
            if ($featured_image_alt) {
                echo "\t\t\t" . '<image:caption>' . esc_html($featured_image_alt) . '</image:caption>' . "\n";
            }
            echo "\t\t" . '</image:image>' . "\n";
            echo "\t" . '</url>' . "\n";
        }

        // Get images from post content
        $content_images = le_custom_extract_images_from_content($post->post_content);
        foreach ($content_images as $image_url) {
            echo "\t" . '<url>' . "\n";
            echo "\t\t" . '<loc>' . esc_url($post_url) . '</loc>' . "\n";
            echo "\t\t" . '<lastmod>' . esc_html($last_modified) . '</lastmod>' . "\n";
            echo "\t\t" . '<image:image>' . "\n";
            echo "\t\t\t" . '<image:loc>' . esc_url($image_url) . '</image:loc>' . "\n";
            echo "\t\t" . '</image:image>' . "\n";
            echo "\t" . '</url>' . "\n";
        }
    }

    // Get all media attachments
    $attachments = get_posts([
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'numberposts' => -1,
        'post_mime_type' => 'image'
    ]);

    foreach ($attachments as $attachment) {
        $attachment_url = wp_get_attachment_url($attachment->ID);
        $attachment_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        $attachment_title = get_the_title($attachment->ID);
        $attachment_page_url = get_attachment_link($attachment->ID);
        $last_modified = get_the_modified_date('c', $attachment->ID);

        echo "\t" . '<url>' . "\n";
        echo "\t\t" . '<loc>' . esc_url($attachment_page_url) . '</loc>' . "\n";
        echo "\t\t" . '<lastmod>' . esc_html($last_modified) . '</lastmod>' . "\n";
        echo "\t\t" . '<image:image>' . "\n";
        echo "\t\t\t" . '<image:loc>' . esc_url($attachment_url) . '</image:loc>' . "\n";
        if ($attachment_title) {
            echo "\t\t\t" . '<image:title>' . esc_html($attachment_title) . '</image:title>' . "\n";
        }
        if ($attachment_alt) {
            echo "\t\t\t" . '<image:caption>' . esc_html($attachment_alt) . '</image:caption>' . "\n";
        }
        echo "\t\t" . '</image:image>' . "\n";
        echo "\t" . '</url>' . "\n";
    }

    echo '</urlset>';
}

/**
 * Extract image URLs from post content
 */
function le_custom_extract_images_from_content($content)
{
    $images = [];

    // Match img tags
    preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $image_url) {
            // Convert relative URLs to absolute
            if (strpos($image_url, 'http') !== 0) {
                $image_url = home_url($image_url);
            }
            $images[] = $image_url;
        }
    }

    // Match background images in inline styles
    preg_match_all('/background-image:\s*url\([\'"]?([^\'")\s]+)[\'"]?\)/i', $content, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[1] as $image_url) {
            if (strpos($image_url, 'http') !== 0) {
                $image_url = home_url($image_url);
            }
            $images[] = $image_url;
        }
    }

    return array_unique($images);
}

/**
 * Add sitemap to robots.txt
 */
function le_custom_add_sitemap_to_robots_txt($output)
{
    $sitemap_url = home_url('/sitemap.xml');
    $output .= "\nSitemap: " . $sitemap_url . "\n";
    return $output;
}
add_filter('robots_txt', 'le_custom_add_sitemap_to_robots_txt', 10, 1);

/**
 * Flush rewrite rules on theme activation
 */
function le_custom_sitemap_flush_rewrite_rules()
{
    le_custom_register_sitemap_endpoints();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'le_custom_sitemap_flush_rewrite_rules');

/**
 * Admin notice for sitemap URLs
 */
function le_custom_sitemap_admin_notice()
{
    if (isset($_GET['page']) && $_GET['page'] === 'tools.php') {
        echo '<div class="notice notice-info is-dismissible">';
        echo '<p><strong>Sitemap URLs:</strong></p>';
        echo '<ul>';
        echo '<li>Main Sitemap: <a href="' . home_url('/sitemap.xml') . '" target="_blank">' .
            home_url('/sitemap.xml') . '</a></li>';
        echo '<li>Pages Sitemap: <a href="' . home_url('/sitemap-pages.xml') . '" target="_blank">' .
            home_url('/sitemap-pages.xml') . '</a></li>';
        echo '<li>Images Sitemap: <a href="' . home_url('/sitemap-images.xml') . '" target="_blank">' .
            home_url('/sitemap-images.xml') . '</a></li>';
        echo '</ul>';
        echo '</div>';
    }
}
add_action('admin_notices', 'le_custom_sitemap_admin_notice');

/**
 * Add sitemap links to admin bar
 */
function le_custom_add_sitemap_to_admin_bar($wp_admin_bar)
{
    if (current_user_can('manage_options')) {
        $wp_admin_bar->add_menu([
            'id' => 'sitemap',
            'title' => 'Sitemaps',
            'href' => '#',
        ]);

        $wp_admin_bar->add_menu([
            'parent' => 'sitemap',
            'id' => 'sitemap-main',
            'title' => 'Main Sitemap',
            'href' => home_url('/sitemap.xml'),
            'meta' => ['target' => '_blank']
        ]);

        $wp_admin_bar->add_menu([
            'parent' => 'sitemap',
            'id' => 'sitemap-pages',
            'title' => 'Pages Sitemap',
            'href' => home_url('/sitemap-pages.xml'),
            'meta' => ['target' => '_blank']
        ]);

        $wp_admin_bar->add_menu([
            'parent' => 'sitemap',
            'id' => 'sitemap-images',
            'title' => 'Images Sitemap',
            'href' => home_url('/sitemap-images.xml'),
            'meta' => ['target' => '_blank']
        ]);
    }
}
add_action('admin_bar_menu', 'le_custom_add_sitemap_to_admin_bar', 100);
