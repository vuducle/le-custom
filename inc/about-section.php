<?php

/**
 * About Section Management
 * 
 * Handles custom meta boxes and functionality for editable about sections
 * on landing pages with PhotoSwipe integration.
 * Now supports multiple content blocks with positioning options and rich text editing.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add custom meta boxes for landing page about sections
 */
function le_custom_add_about_meta_boxes()
{
    add_meta_box(
        'about_section_settings',
        __('About Section Settings', 'le-custom'),
        'le_custom_about_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'le_custom_add_about_meta_boxes');

/**
 * About meta box callback function
 * 
 * Renders the about section settings form in the WordPress admin
 * 
 * @param WP_Post $post The post object being edited
 */
function le_custom_about_meta_box_callback($post)
{
    // Add nonce for security
    wp_nonce_field('le_custom_about_meta_box', 'le_custom_about_meta_box_nonce');

    // Get current values
    $about_data = le_custom_get_about_data($post->ID);

    // Set default values based on page slug
    $about_data = le_custom_set_about_defaults($about_data, $post->post_name);

    // Enqueue WordPress media uploader
    wp_enqueue_media();

?>
    <div class="about-settings-container" style="margin: 20px 0;">
        <h3 style="margin-bottom: 15px;"><?php _e('About Section Content', 'le-custom'); ?></h3>

        <!-- About Blocks Container -->
        <div id="about_blocks_container">
            <?php
            if (!empty($about_data['blocks'])) {
                foreach ($about_data['blocks'] as $block_index => $block) {
                    le_custom_render_about_block($block_index, $block);
                }
            } else {
                // Render at least one default block
                le_custom_render_about_block(0, []);
            }
            ?>
        </div>

        <button type="button" id="add_about_block" class="button button-primary" style="margin-top: 15px;">
            <?php _e('Add New About Block', 'le-custom'); ?>
        </button>

        <!-- Legacy single block fields (hidden by default, shown only if no blocks exist) -->
        <div id="legacy_about_fields" style="display: none;">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="about_title"><?php _e('Section Title', 'le-custom'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="about_title" name="about_title"
                            value="<?php echo esc_attr($about_data['title'] ?? ''); ?>" class="regular-text" />
                        <p class="description"><?php _e('Main heading for the about section', 'le-custom'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="about_description"><?php _e('Description', 'le-custom'); ?></label>
                    </th>
                    <td>
                        <textarea id="about_description" name="about_description" rows="4"
                            class="large-text"><?php echo esc_textarea($about_data['description'] ?? ''); ?></textarea>
                        <p class="description"><?php _e('Main description text for the about section', 'le-custom'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="about_image"><?php _e('About Image', 'le-custom'); ?></label>
                    </th>
                    <td>
                        <input type="hidden" id="about_image" name="about_image"
                            value="<?php echo esc_attr($about_data['image'] ?? ''); ?>" />
                        <div id="about_image_preview" style="margin-bottom: 10px;">
                            <?php if (!empty($about_data['image'])): ?>
                                <img src="<?php echo esc_url($about_data['image']); ?>"
                                    style="max-width: 200px; height: auto;" />
                            <?php endif; ?>
                        </div>
                        <button type="button" id="about_image_button"
                            class="button"><?php _e('Choose Image', 'le-custom'); ?></button>
                        <button type="button" id="about_image_remove" class="button"
                            <?php echo empty($about_data['image']) ? 'style="display:none;"' : ''; ?>><?php _e('Remove Image', 'le-custom'); ?></button>
                        <p class="description">
                            <?php _e('Professional image for the about section (recommended: 600x400px)', 'le-custom'); ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="about_features"><?php _e('Features List', 'le-custom'); ?></label>
                    </th>
                    <td>
                        <div id="about_features_container">
                            <?php
                            if (!empty($about_data['features'])) {
                                foreach ($about_data['features'] as $index => $feature) {
                                    echo '<div class="about-feature-item" style="margin-bottom: 10px;">';
                                    echo '<input type="text" name="about_features[]" value="' . esc_attr($feature) . '" class="regular-text" style="width: 80%;" />';
                                    echo '<button type="button" class="button remove-feature" style="margin-left: 10px;">Remove</button>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        <button type="button" id="add_about_feature"
                            class="button"><?php _e('Add Feature', 'le-custom'); ?></button>
                        <p class="description"><?php _e('List of features/benefits to display', 'le-custom'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="about_emergency_note"><?php _e('Emergency Note', 'le-custom'); ?></label>
                    </th>
                    <td>
                        <textarea id="about_emergency_note" name="about_emergency_note" rows="2"
                            class="large-text"><?php echo esc_textarea($about_data['emergency_note'] ?? ''); ?></textarea>
                        <p class="description">
                            <?php _e('Note about emergency appointments (opening hours are managed globally in the customizer)', 'le-custom'); ?>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        (function() {
            'use strict';

            // Wait for DOM to be ready
            document.addEventListener('DOMContentLoaded', function() {
                initAboutSectionAdmin();
            });

            /**
             * Initialize about section admin functionality
             */
            function initAboutSectionAdmin() {
                let blockCounter = <?php echo !empty($about_data['blocks']) ? count($about_data['blocks']) : 1; ?>;

                // Add new about block
                const addBlockBtn = document.getElementById('add_about_block');
                if (addBlockBtn) {
                    addBlockBtn.addEventListener('click', function() {
                        const blockHtml = generateAboutBlockHtml(blockCounter);
                        document.getElementById('about_blocks_container').insertAdjacentHTML('beforeend',
                            blockHtml);

                        // Initialize the new editor
                        const newEditorId = 'about_content_' + blockCounter;
                        if (typeof wp !== 'undefined' && wp.editor) {
                            wp.editor.initialize(newEditorId, {
                                tinymce: {
                                    height: 200,
                                    menubar: false,
                                    plugins: 'lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                                },
                                quicktags: true,
                                mediaButtons: true
                            });
                        }

                        blockCounter++;
                    });
                }

                // Remove about block
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-about-block')) {
                        const aboutBlocks = document.querySelectorAll('.about-block');
                        if (aboutBlocks.length > 1) {
                            const block = e.target.closest('.about-block');
                            const editorId = block.querySelector('textarea').id;

                            // Remove the editor instance
                            if (typeof wp !== 'undefined' && wp.editor) {
                                wp.editor.remove(editorId);
                            }

                            block.remove();
                        } else {
                            alert('<?php _e('You must have at least one about block.', 'le-custom'); ?>');
                        }
                    }
                });

                // Image upload functionality for blocks
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('about-image-button')) {
                        e.preventDefault();
                        const button = e.target;
                        const block = button.closest('.about-block');
                        const imageInput = block.querySelector('.about-image-input');
                        const imagePreview = block.querySelector('.about-image-preview');
                        const removeButton = block.querySelector('.about-image-remove');

                        if (typeof wp !== 'undefined' && wp.media) {
                            const image = wp.media({
                                title: '<?php _e('Choose About Image', 'le-custom'); ?>',
                                multiple: false
                            }).open().on('select', function() {
                                const uploaded_image = image.state().get('selection').first();
                                const image_url = uploaded_image.toJSON().url;
                                imageInput.value = image_url;
                                imagePreview.innerHTML = '<img src="' + image_url +
                                    '" style="max-width: 200px; height: auto;" />';
                                removeButton.style.display = 'inline-block';
                            });
                        }
                    }
                });

                // Remove image for blocks
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('about-image-remove')) {
                        const block = e.target.closest('.about-block');
                        const imageInput = block.querySelector('.about-image-input');
                        const imagePreview = block.querySelector('.about-image-preview');

                        imageInput.value = '';
                        imagePreview.innerHTML = '';
                        e.target.style.display = 'none';
                    }
                });

                // Add feature functionality for blocks
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('add-about-feature')) {
                        const block = e.target.closest('.about-block');
                        const container = block.querySelector('.about-features-container');
                        const blockIndex = block.dataset.index;
                        const featureHtml = '<div class="about-feature-item" style="margin-bottom: 10px;">' +
                            '<input type="text" name="about_blocks[' + blockIndex +
                            '][features][]" value="" class="regular-text" style="width: 80%;" />' +
                            '<button type="button" class="button remove-feature" style="margin-left: 10px;">Remove</button>' +
                            '</div>';
                        container.insertAdjacentHTML('beforeend', featureHtml);
                    }
                });

                // Remove feature functionality
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-feature')) {
                        e.target.parentElement.remove();
                    }
                });

                // Legacy image upload functionality (for backward compatibility)
                const legacyImageBtn = document.getElementById('about_image_button');
                const legacyImageRemove = document.getElementById('about_image_remove');
                const legacyImageInput = document.getElementById('about_image');
                const legacyImagePreview = document.getElementById('about_image_preview');

                if (legacyImageBtn) {
                    legacyImageBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (typeof wp !== 'undefined' && wp.media) {
                            const image = wp.media({
                                title: '<?php _e('Choose About Image', 'le-custom'); ?>',
                                multiple: false
                            }).open().on('select', function() {
                                const uploaded_image = image.state().get('selection').first();
                                const image_url = uploaded_image.toJSON().url;
                                legacyImageInput.value = image_url;
                                legacyImagePreview.innerHTML = '<img src="' + image_url +
                                    '" style="max-width: 200px; height: auto;" />';
                                legacyImageRemove.style.display = 'inline-block';
                            });
                        }
                    });
                }

                if (legacyImageRemove) {
                    legacyImageRemove.addEventListener('click', function() {
                        legacyImageInput.value = '';
                        legacyImagePreview.innerHTML = '';
                        this.style.display = 'none';
                    });
                }

                // Legacy add feature functionality
                const legacyAddFeature = document.getElementById('add_about_feature');
                if (legacyAddFeature) {
                    legacyAddFeature.addEventListener('click', function() {
                        const featureHtml = '<div class="about-feature-item" style="margin-bottom: 10px;">' +
                            '<input type="text" name="about_features[]" value="" class="regular-text" style="width: 80%;" />' +
                            '<button type="button" class="button remove-feature" style="margin-left: 10px;">Remove</button>' +
                            '</div>';
                        document.getElementById('about_features_container').insertAdjacentHTML('beforeend',
                            featureHtml);
                    });
                }

                /**
                 * Generate HTML for a new about block
                 */
                function generateAboutBlockHtml(index) {
                    return `
                        <div class="about-block" data-index="${index}" style="border: 2px solid #ddd; padding: 20px; margin-bottom: 20px; background: #f9f9f9;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                <h4 style="margin: 0;">About Block ${index + 1}</h4>
                                <button type="button" class="button remove-about-block" style="background: #dc3232; color: white; border-color: #dc3232;">
                                    Remove Block
                                </button>
                            </div>
                            
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label>Block Title</label>
                                    </th>
                                    <td>
                                        <input type="text" name="about_blocks[${index}][title]" value="" class="regular-text" />
                                        <p class="description">Title for this content block</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label>Content</label>
                                    </th>
                                    <td>
                                        <textarea name="about_blocks[${index}][content]" id="about_content_${index}" style="display: none;"></textarea>
                                        <p class="description">
                                            Main content text for this block. Use the rich text editor above for formatting.
                                        </p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label>Image</label>
                                    </th>
                                    <td>
                                        <input type="hidden" class="about-image-input" name="about_blocks[${index}][image]" value="" />
                                        <div class="about-image-preview" style="margin-bottom: 10px;"></div>
                                        <button type="button" class="button about-image-button">Choose Image</button>
                                        <button type="button" class="button about-image-remove" style="display:none;">Remove Image</button>
                                        <p class="description">Optional image for this block (recommended: 600x400px)</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label>Layout Position</label>
                                    </th>
                                    <td>
                                        <select name="about_blocks[${index}][position]" class="regular-text">
                                            <option value="left">Text Left, Image Right</option>
                                            <option value="right">Image Left, Text Right</option>
                                            <option value="text-only">Text Only (No Image)</option>
                                            <option value="image-only">Image Only (No Text)</option>
                                        </select>
                                        <p class="description">How this block should be positioned on desktop</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label>Features List</label>
                                    </th>
                                    <td>
                                        <div class="about-features-container"></div>
                                        <button type="button" class="button add-about-feature">Add Feature</button>
                                        <p class="description">Optional list of features/benefits for this block</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    `;
                }
            }
        })();
    </script>
<?php
}

/**
 * Render individual about block in admin
 * 
 * @param int $index Block index
 * @param array $block Block data
 */
function le_custom_render_about_block($index, $block)
{
    $title = $block['title'] ?? '';
    $content = $block['content'] ?? '';
    $image = $block['image'] ?? '';
    $position = $block['position'] ?? 'left';
    $features = $block['features'] ?? [];
?>
    <div class="about-block" data-index="<?php echo $index; ?>"
        style="border: 2px solid #ddd; padding: 20px; margin-bottom: 20px; background: #f9f9f9;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 style="margin: 0;">About Block <?php echo $index + 1; ?></h4>
            <button type="button" class="button remove-about-block"
                style="background: #dc3232; color: white; border-color: #dc3232;">
                Remove Block
            </button>
        </div>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label>Block Title</label>
                </th>
                <td>
                    <input type="text" name="about_blocks[<?php echo $index; ?>][title]"
                        value="<?php echo esc_attr($title); ?>" class="regular-text" />
                    <p class="description">Title for this content block</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label>Content</label>
                </th>
                <td>
                    <?php
                    // Use WordPress rich text editor
                    $editor_id = 'about_content_' . $index;
                    $editor_settings = [
                        'textarea_name' => 'about_blocks[' . $index . '][content]',
                        'textarea_rows' => 8,
                        'media_buttons' => true,
                        'tinymce' => [
                            'height' => 200,
                            'menubar' => false,
                            'plugins' => 'lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                            'toolbar' => 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                            'content_css' => '//www.tiny.cloud/css/codepen.min.css'
                        ],
                        'quicktags' => true,
                        'drag_drop_upload' => true
                    ];
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                    <p class="description">
                        Main content text for this block. Use the rich text editor above for formatting.
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label>Image</label>
                </th>
                <td>
                    <input type="hidden" class="about-image-input" name="about_blocks[<?php echo $index; ?>][image]"
                        value="<?php echo esc_attr($image); ?>" />
                    <div class="about-image-preview" style="margin-bottom: 10px;">
                        <?php if ($image): ?>
                            <img src="<?php echo esc_url($image); ?>" style="max-width: 200px; height: auto;" />
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button about-image-button">Choose Image</button>
                    <button type="button" class="button about-image-remove"
                        <?php echo empty($image) ? 'style="display:none;"' : ''; ?>>Remove Image</button>
                    <p class="description">Optional image for this block (recommended: 600x400px)</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label>Layout Position</label>
                </th>
                <td>
                    <select name="about_blocks[<?php echo $index; ?>][position]" class="regular-text">
                        <option value="left" <?php selected($position, 'left'); ?>>Text Left, Image Right</option>
                        <option value="right" <?php selected($position, 'right'); ?>>Image Left, Text Right</option>
                        <option value="text-only" <?php selected($position, 'text-only'); ?>>Text Only (No Image)</option>
                        <option value="image-only" <?php selected($position, 'image-only'); ?>>Image Only (No Text)</option>
                    </select>
                    <p class="description">How this block should be positioned on desktop</p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label>Features List</label>
                </th>
                <td>
                    <div class="about-features-container">
                        <?php
                        if (!empty($features)) {
                            foreach ($features as $feature_index => $feature) {
                                echo '<div class="about-feature-item" style="margin-bottom: 10px;">';
                                echo '<input type="text" name="about_blocks[' . $index . '][features][]" value="' . esc_attr($feature) . '" class="regular-text" style="width: 80%;" />';
                                echo '<button type="button" class="button remove-feature" style="margin-left: 10px;">Remove</button>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <button type="button" class="button add-about-feature">Add Feature</button>
                    <p class="description">Optional list of features/benefits for this block</p>
                </td>
            </tr>
        </table>
    </div>
<?php
}

/**
 * Set default values for about section based on page slug
 * 
 * @param array $about_data Current about data
 * @param string $page_slug Page slug
 * @return array Modified about data
 */
function le_custom_set_about_defaults($about_data, $page_slug)
{
    $defaults = [
        'title' => 'Über unsere Praxis',
        'description' => 'Seit über 20 Jahren sind wir Ihre vertrauensvollen Partner für alle Fragen rund um die Zahngesundheit. Unser Team aus erfahrenen Zahnärzten und freundlichem Personal kümmert sich um Ihr Wohlbefinden.',
        'image' => '',
        'features' => [
            'Moderne Behandlungsmethoden',
            'Schmerzfreie Behandlungen',
            'Persönliche Betreuung'
        ],
        'emergency_note' => 'Notfalltermine außerhalb der Öffnungszeiten sind nach Vereinbarung möglich.',
        'blocks' => [
            [
                'title' => 'Über unsere Praxis',
                'content' => 'Seit über 20 Jahren sind wir Ihre vertrauensvollen Partner für alle Fragen rund um die Zahngesundheit. Unser Team aus erfahrenen Zahnärzten und freundlichem Personal kümmert sich um Ihr Wohlbefinden.',
                'image' => '',
                'position' => 'left',
                'features' => [
                    'Moderne Behandlungsmethoden',
                    'Schmerzfreie Behandlungen',
                    'Persönliche Betreuung'
                ]
            ]
        ]
    ];

    if ($page_slug === 'landing-en') {
        $defaults['title'] = 'About Our Practice';
        $defaults['description'] = 'For over 20 years, we have been your trusted partners for all questions regarding dental health. Our team of experienced dentists and friendly staff takes care of your well-being.';
        $defaults['features'] = [
            'Modern Treatment Methods',
            'Pain-Free Treatments',
            'Personal Care'
        ];
        $defaults['emergency_note'] = 'Emergency appointments outside of opening hours are available by arrangement.';
        $defaults['blocks'][0]['title'] = 'About Our Practice';
        $defaults['blocks'][0]['content'] = 'For over 20 years, we have been your trusted partners for all questions regarding dental health. Our team of experienced dentists and friendly staff takes care of your well-being.';
        $defaults['blocks'][0]['features'] = [
            'Modern Treatment Methods',
            'Pain-Free Treatments',
            'Personal Care'
        ];
    }

    return wp_parse_args($about_data, $defaults);
}

/**
 * Save about section meta box data
 * 
 * @param int $post_id The post ID
 */
function le_custom_save_about_meta_box($post_id)
{
    // Check if nonce is valid
    if (!isset($_POST['le_custom_about_meta_box_nonce']) || !wp_verify_nonce($_POST['le_custom_about_meta_box_nonce'], 'le_custom_about_meta_box')) {
        return;
    }

    // Check if user has permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save about section data
    $about_data = [];

    // Handle new block-based structure
    if (isset($_POST['about_blocks']) && is_array($_POST['about_blocks'])) {
        $blocks = [];
        foreach ($_POST['about_blocks'] as $block_index => $block_data) {
            $blocks[] = [
                'title' => sanitize_text_field($block_data['title'] ?? ''),
                'content' => wp_kses_post($block_data['content'] ?? ''), // Allow safe HTML
                'image' => esc_url_raw($block_data['image'] ?? ''),
                'position' => sanitize_text_field($block_data['position'] ?? 'left'),
                'features' => array_filter(array_map('sanitize_text_field', $block_data['features'] ?? []))
            ];
        }
        $about_data['blocks'] = $blocks;
    }

    // Handle legacy single block structure for backward compatibility
    if (isset($_POST['about_title'])) {
        $about_data['title'] = sanitize_text_field($_POST['about_title'] ?? '');
        $about_data['description'] = sanitize_textarea_field($_POST['about_description'] ?? '');
        $about_data['image'] = esc_url_raw($_POST['about_image'] ?? '');
        $about_data['features'] = array_filter(array_map('sanitize_text_field', $_POST['about_features'] ?? []));
        $about_data['emergency_note'] = sanitize_textarea_field($_POST['about_emergency_note'] ?? '');
    }

    update_post_meta($post_id, '_about_section_data', $about_data);
}
add_action('save_post', 'le_custom_save_about_meta_box');

/**
 * Get about section data for a specific post
 * 
 * @param int|null $post_id Post ID (defaults to current post)
 * @return array About section data
 */
function le_custom_get_about_data($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $about_data = get_post_meta($post_id, '_about_section_data', true);

    if (!is_array($about_data)) {
        $about_data = [];
    }

    return $about_data;
}

/**
 * Enqueue PhotoSwipe scripts and styles
 */
function le_custom_enqueue_photoswipe()
{
    // Only enqueue on pages that might have the about section
    if (is_page_template('page-landing-de.php') || is_page_template('page-landing-en.php')) {
        // About section rich text styling
        wp_enqueue_style(
            'about-section-rich-text',
            get_template_directory_uri() . '/assets/css/about-section-rich-text.css',
            [],
            '1.0.0'
        );

        // Simple Lightbox CSS
        wp_enqueue_style(
            'simple-lightbox',
            'https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.css',
            [],
            '2.14.2'
        );

        // Simple Lightbox JS
        wp_enqueue_script(
            'simple-lightbox',
            'https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.2/simple-lightbox.min.js',
            [],
            '2.14.2',
            true
        );

        // Custom lightbox initialization
        wp_enqueue_script(
            'lightbox-init',
            get_template_directory_uri() . '/assets/js/lightbox-init.js',
            ['simple-lightbox'],
            '1.0.0',
            true
        );

        // Lazy loading script
        wp_enqueue_script(
            'lazy-loading',
            get_template_directory_uri() . '/assets/js/lazy-loading.js',
            [],
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'le_custom_enqueue_photoswipe');
