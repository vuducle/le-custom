<?php

/**
 * Gallery Block with Lightbox and Lazy Loading
 * 
 * Provides a custom block pattern for galleries with lightbox functionality
 * and lazy loading for optimal performance.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register gallery block pattern
 */
function le_custom_register_gallery_block_pattern()
{
    register_block_pattern(
        'le-custom/gallery-with-lightbox',
        [
            'title' => __('Gallery with Lightbox', 'le-custom'),
            'description' => __('A responsive gallery with lightbox functionality and lazy loading.', 'le-custom'),
            'categories' => ['media', 'le-custom'],
            'content' => '<!-- wp:group {"className":"gallery-block-container","layout":{"type":"constrained"}} -->
<div class="wp-block-group gallery-block-container">
    <!-- wp:heading {"level":2,"className":"gallery-title"} -->
    <h2 class="wp-block-heading gallery-title">Gallery</h2>
    <!-- /wp:heading -->
    
    <!-- wp:gallery {"linkTo":"none","className":"gallery-with-lightbox","style":{"spacing":{"blockGap":{"top":"1rem","left":"1rem"}}}} -->
    <figure class="wp-block-gallery has-nested-images columns-default is-cropped gallery-with-lightbox">
        <!-- wp:image {"id":123,"sizeSlug":"medium","linkDestination":"none","className":"gallery-image lazy-image"} -->
        <figure class="wp-block-image size-medium gallery-image lazy-image">
            <img src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 300 200\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'system-ui\' font-size=\'14\'%3ELoading...%3C/text%3E%3C/svg%3E" alt="Gallery Image" data-src="' . get_template_directory_uri() . '/assets/img/placeholder.jpg" class="wp-image-123"/>
        </figure>
        <!-- /wp:image -->
        
        <!-- wp:image {"id":124,"sizeSlug":"medium","linkDestination":"none","className":"gallery-image lazy-image"} -->
        <figure class="wp-block-image size-medium gallery-image lazy-image">
            <img src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 300 200\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'system-ui\' font-size=\'14\'%3ELoading...%3C/text%3E%3C/svg%3E" alt="Gallery Image" data-src="' . get_template_directory_uri() . '/assets/img/placeholder.jpg" class="wp-image-124"/>
        </figure>
        <!-- /wp:image -->
        
        <!-- wp:image {"id":125,"sizeSlug":"medium","linkDestination":"none","className":"gallery-image lazy-image"} -->
        <figure class="wp-block-image size-medium gallery-image lazy-image">
            <img src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 300 200\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'system-ui\' font-size=\'14\'%3ELoading...%3C/text%3E%3C/svg%3E" alt="Gallery Image" data-src="' . get_template_directory_uri() . '/assets/img/placeholder.jpg" class="wp-image-125"/>
        </figure>
        <!-- /wp:image -->
    </figure>
    <!-- /wp:gallery -->
</div>
<!-- /wp:group -->',
        ]
    );
}
add_action('init', 'le_custom_register_gallery_block_pattern');

/**
 * Enqueue gallery-specific scripts and styles
 */
function le_custom_enqueue_gallery_assets()
{
    // Only enqueue if we're on a page with gallery blocks
    if (has_block('core/gallery') || has_block('le-custom/gallery-with-lightbox')) {

        // Enqueue SimpleLightbox CSS and JS
        wp_enqueue_style(
            'simplelightbox-css',
            'https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css',
            [],
            '2.14.2'
        );

        wp_enqueue_script(
            'simplelightbox-js',
            'https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js',
            [],
            '2.14.2',
            true
        );

        // Enqueue gallery-specific JavaScript
        wp_enqueue_script(
            'le-custom-gallery',
            get_template_directory_uri() . '/assets/js/gallery-block.js',
            ['simplelightbox-js'],
            wp_get_theme()->get('Version'),
            true
        );

        // Enqueue gallery-specific CSS
        wp_enqueue_style(
            'le-custom-gallery-css',
            get_template_directory_uri() . '/assets/css/gallery-block.css',
            [],
            wp_get_theme()->get('Version')
        );
    }
}
add_action('wp_enqueue_scripts', 'le_custom_enqueue_gallery_assets');

/**
 * Filter gallery HTML to add lightbox functionality
 * 
 * @param string $block_content The block content
 * @param array $block The block data
 * @return string Modified block content
 */
function le_custom_filter_gallery_block($block_content, $block)
{
    // Only process gallery blocks
    if ($block['blockName'] !== 'core/gallery') {
        return $block_content;
    }

    // Add gallery wrapper and lightbox classes
    $block_content = str_replace(
        'class="wp-block-gallery',
        'class="wp-block-gallery gallery-with-lightbox',
        $block_content
    );

    // Add lazy loading to images
    $block_content = preg_replace(
        '/<img([^>]*)src="([^"]*)"([^>]*)>/',
        '<img$1src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 300 200\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'system-ui\' font-size=\'14\'%3ELoading...%3C/text%3E%3C/svg%3E" data-src="$2" class="lazy-image$3">',
        $block_content
    );

    // Wrap images in lightbox links
    $block_content = preg_replace(
        '/<figure([^>]*)class="([^"]*)"([^>]*)>([^<]*)<img([^>]*)src="([^"]*)"([^>]*)alt="([^"]*)"([^>]*)>/',
        '<figure$1class="$2"$3>$4<a href="$6" data-lightbox="gallery" title="$8"><img$5src="$6"$7alt="$8"$9></a>',
        $block_content
    );

    return $block_content;
}
add_filter('render_block', 'le_custom_filter_gallery_block', 10, 2);

/**
 * Add gallery block inserter to editor
 */
function le_custom_add_gallery_block_inserter()
{
    wp_enqueue_script(
        'le-custom-gallery-inserter',
        get_template_directory_uri() . '/assets/js/gallery-inserter.js',
        ['wp-blocks', 'wp-element', 'wp-editor'],
        wp_get_theme()->get('Version'),
        true
    );

    // Enqueue editor-specific CSS for gallery controls
    wp_enqueue_style(
        'le-custom-gallery-editor-css',
        get_template_directory_uri() . '/assets/css/gallery-block-editor.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('enqueue_block_editor_assets', 'le_custom_add_gallery_block_inserter');

/**
 * Register gallery block category
 */
function le_custom_add_gallery_block_category($categories)
{
    return array_merge(
        $categories,
        [
            [
                'slug' => 'le-custom',
                'title' => __('LE Custom Blocks', 'le-custom'),
                'icon' => 'format-gallery',
            ],
        ]
    );
}
add_filter('block_categories_all', 'le_custom_add_gallery_block_category');
