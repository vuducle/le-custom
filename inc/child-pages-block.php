<?php

/**
 * Child Pages Block
 * 
 * A custom Gutenberg block that displays child pages with title, featured image,
 * excerpt, and link. Can be dragged and dropped into any page.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Child Pages Block
 */
function le_custom_register_child_pages_block()
{
    // Register the block
    register_block_type('le-custom/child-pages', [
        'render_callback' => 'le_custom_render_child_pages_block',
        'attributes' => [
            'layout' => [
                'type' => 'string',
                'default' => 'grid'
            ],
            'columns' => [
                'type' => 'number',
                'default' => 3
            ],
            'showImage' => [
                'type' => 'boolean',
                'default' => true
            ],
            'showExcerpt' => [
                'type' => 'boolean',
                'default' => true
            ],
            'excerptLength' => [
                'type' => 'number',
                'default' => 20
            ],
            'orderBy' => [
                'type' => 'string',
                'default' => 'menu_order'
            ],
            'order' => [
                'type' => 'string',
                'default' => 'ASC'
            ]
        ]
    ]);
}
add_action('init', 'le_custom_register_child_pages_block');

/**
 * Render Child Pages Block
 */
function le_custom_render_child_pages_block($attributes)
{
    // Get current page ID
    $current_page_id = get_the_ID();

    // Get attributes with defaults
    $layout = isset($attributes['layout']) ? $attributes['layout'] : 'grid';
    $columns = isset($attributes['columns']) ? intval($attributes['columns']) : 3;
    $show_image = isset($attributes['showImage']) ? $attributes['showImage'] : true;
    $show_excerpt = isset($attributes['showExcerpt']) ? $attributes['showExcerpt'] : true;
    $excerpt_length = isset($attributes['excerptLength']) ? intval($attributes['excerptLength']) : 20;
    $order_by = isset($attributes['orderBy']) ? $attributes['orderBy'] : 'menu_order';
    $order = isset($attributes['order']) ? $attributes['order'] : 'ASC';

    // Query child pages
    $child_pages = new WP_Query([
        'post_type' => 'page',
        'post_parent' => $current_page_id,
        'posts_per_page' => -1,
        'orderby' => $order_by,
        'order' => $order,
        'post_status' => 'publish'
    ]);

    // Return early if no child pages
    if (!$child_pages->have_posts()) {
        return '<div class="child-pages-block no-children"><p class="text-gray-500 text-center py-8">' . __('No child pages found.', 'le-custom') . '</p></div>';
    }

    // Get color scheme
    $color_scheme = le_custom_get_color_scheme_data();

    // Start output buffering
    ob_start();

    // Layout classes
    $layout_class = $layout === 'list' ? 'child-pages-list' : 'child-pages-grid';
    $grid_cols = 'grid-cols-1 md:grid-cols-2 lg:grid-cols-' . $columns;
?>

    <div class="child-pages-block <?php echo esc_attr($layout_class); ?> my-12">
        <div class="<?php echo $layout === 'grid' ? 'grid ' . esc_attr($grid_cols) . ' gap-6' : 'space-y-6'; ?>">
            <?php while ($child_pages->have_posts()) : $child_pages->the_post(); ?>
                <article class="child-page-card group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <a href="<?php the_permalink(); ?>" class="block">
                        <?php if ($show_image && has_post_thumbnail()) : ?>
                            <div class="child-page-image relative overflow-hidden aspect-video">
                                <?php the_post_thumbnail('medium_large', [
                                    'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500',
                                    'loading' => 'lazy'
                                ]); ?>
                                <!-- Gradient overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        <?php endif; ?>

                        <div class="child-page-content p-6">
                            <h3 class="child-page-title text-xl lg:text-2xl font-bold mb-3 text-gray-900 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r transition-all duration-300"
                                style="--tw-gradient-from: <?php echo esc_attr($color_scheme['primary']); ?>; --tw-gradient-to: <?php echo esc_attr($color_scheme['secondary']); ?>;">
                                <?php the_title(); ?>
                            </h3>

                            <?php if ($show_excerpt) : ?>
                                <div class="child-page-excerpt text-gray-600 mb-4 line-clamp-3">
                                    <?php
                                    $excerpt = get_the_excerpt();
                                    if ($excerpt) {
                                        echo wp_trim_words($excerpt, $excerpt_length, '...');
                                    } else {
                                        echo wp_trim_words(get_the_content(), $excerpt_length, '...');
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="child-page-link inline-flex items-center text-sm font-semibold group-hover:translate-x-2 transition-transform duration-300"
                                style="color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                
                            </div>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
    </div>

<?php
    wp_reset_postdata();
    return ob_get_clean();
}

/**
 * Enqueue block editor assets
 */
function le_custom_enqueue_child_pages_block_editor_assets()
{
    wp_enqueue_script(
        'le-custom-child-pages-block',
        get_template_directory_uri() . '/assets/js/child-pages-block.js',
        ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('enqueue_block_editor_assets', 'le_custom_enqueue_child_pages_block_editor_assets');

/**
 * Enqueue block styles
 */
function le_custom_enqueue_child_pages_block_styles()
{
    if (has_block('le-custom/child-pages')) {
        wp_enqueue_style(
            'le-custom-child-pages-block',
            get_template_directory_uri() . '/assets/css/child-pages-block.css',
            [],
            wp_get_theme()->get('Version')
        );
    }
}
add_action('wp_enqueue_scripts', 'le_custom_enqueue_child_pages_block_styles');
