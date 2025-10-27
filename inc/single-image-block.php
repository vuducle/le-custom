<?php

/**
 * Single Image Block with Lightbox and Lazy Loading
 * 
 * Provides a custom block pattern for single images with lightbox functionality
 * and lazy loading, specifically designed for dental practices.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register single image block pattern
 */
function le_custom_register_single_image_block_pattern()
{
    register_block_pattern(
        'le-custom/single-image-with-lightbox',
        [
            'title' => __('Professional Single Image', 'le-custom'),
            'description' => __('A professional single image with lightbox and lazy loading, perfect for dental practices.', 'le-custom'),
            'categories' => ['media', 'le-custom'],
            'content' => '<!-- wp:group {"className":"single-image-block-container","layout":{"type":"constrained"}} -->
<div class="wp-block-group single-image-block-container">
    <!-- wp:heading {"level":3,"className":"single-image-title"} -->
    <h3 class="wp-block-heading single-image-title">Treatment Result</h3>
    <!-- /wp:heading -->
    
    <!-- wp:image {"id":123,"sizeSlug":"large","linkDestination":"none","className":"single-image-with-lightbox lazy-image","style":{"border":{"radius":"12px"}}} -->
    <figure class="wp-block-image size-large single-image-with-lightbox lazy-image" style="border-radius:12px">
        <img src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 800 600\'%3E%3Crect width=\'800\' height=\'600\' fill=\'%23f8fafc\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%2364748b\' font-family=\'system-ui\' font-size=\'16\'%3ELoading...%3C/text%3E%3C/svg%3E" alt="Treatment Result" data-src="' . get_template_directory_uri() . '/assets/img/placeholder.jpg" class="wp-image-123" style="border-radius:12px"/>
    </figure>
    <!-- /wp:image -->
    
    <!-- wp:paragraph {"className":"single-image-caption"} -->
    <p class="single-image-caption">Professional dental treatment result showcasing our expertise and care.</p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
        ]
    );
}
add_action('init', 'le_custom_register_single_image_block_pattern');

/**
 * Enqueue single image specific scripts and styles
 */
function le_custom_enqueue_single_image_assets()
{
    // Only enqueue if we're on a page with single image blocks
    if (has_block('core/image') || has_block('le-custom/single-image-with-lightbox')) {

        // Enqueue SimpleLightbox CSS and JS (if not already loaded)
        if (!wp_style_is('simplelightbox-css', 'enqueued')) {
            wp_enqueue_style(
                'simplelightbox-css',
                'https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css',
                [],
                '2.14.2'
            );
        }

        if (!wp_script_is('simplelightbox-js', 'enqueued')) {
            wp_enqueue_script(
                'simplelightbox-js',
                'https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js',
                [],
                '2.14.2',
                true
            );
        }

        // Enqueue single image specific JavaScript
        wp_enqueue_script(
            'le-custom-single-image',
            get_template_directory_uri() . '/assets/js/single-image-block.js',
            ['simplelightbox-js'],
            wp_get_theme()->get('Version'),
            true
        );

        // Enqueue single image specific CSS
        wp_enqueue_style(
            'le-custom-single-image-css',
            get_template_directory_uri() . '/assets/css/single-image-block.css',
            [],
            wp_get_theme()->get('Version')
        );
    }
}
add_action('wp_enqueue_scripts', 'le_custom_enqueue_single_image_assets');

/**
 * Filter single image HTML to add lightbox functionality
 * 
 * @param string $block_content The block content
 * @param array $block The block data
 * @return string Modified block content
 */
function le_custom_filter_single_image_block($block_content, $block)
{
    // Only process image blocks
    if ($block['blockName'] !== 'core/image') {
        return $block_content;
    }

    // Add single image wrapper and lightbox classes
    $block_content = str_replace(
        'class="wp-block-image',
        'class="wp-block-image single-image-with-lightbox',
        $block_content
    );

    // Add lazy loading to images
    $block_content = preg_replace(
        '/<img([^>]*)src="([^"]*)"([^>]*)>/',
        '<img$1src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 800 600\'%3E%3Crect width=\'800\' height=\'600\' fill=\'%23f8fafc\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%2364748b\' font-family=\'system-ui\' font-size=\'16\'%3ELoading...%3C/text%3E%3C/svg%3E" data-src="$2" class="lazy-image$3">',
        $block_content
    );

    // Wrap images in lightbox links
    $block_content = preg_replace(
        '/<figure([^>]*)class="([^"]*)"([^>]*)>([^<]*)<img([^>]*)src="([^"]*)"([^>]*)alt="([^"]*)"([^>]*)>/',
        '<figure$1class="$2"$3>$4<a href="$6" data-lightbox="single-image" title="$8"><img$5src="$6"$7alt="$8"$9></a>',
        $block_content
    );

    return $block_content;
}
add_filter('render_block', 'le_custom_filter_single_image_block', 10, 2);

/**
 * Add single image block inserter button to editor
 */
function le_custom_add_single_image_block_inserter()
{
    wp_enqueue_script(
        'le-custom-single-image-inserter',
        get_template_directory_uri() . '/assets/js/single-image-inserter.js',
        ['wp-blocks', 'wp-element', 'wp-editor'],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('enqueue_block_editor_assets', 'le_custom_add_single_image_block_inserter');

/**
 * Register single image block category (if not already registered)
 */
function le_custom_add_single_image_block_category($categories)
{
    // Check if le-custom category already exists
    $le_custom_exists = false;
    foreach ($categories as $category) {
        if ($category['slug'] === 'le-custom') {
            $le_custom_exists = true;
            break;
        }
    }

    if (!$le_custom_exists) {
        return array_merge(
            $categories,
            [
                [
                    'slug' => 'le-custom',
                    'title' => __('LE Custom Blocks', 'le-custom'),
                    'icon' => 'format-image',
                ],
            ]
        );
    }

    return $categories;
}
add_filter('block_categories_all', 'le_custom_add_single_image_block_category');
