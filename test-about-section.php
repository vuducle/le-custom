<?php

/**
 * Test About Section Functionality
 * 
 * This file demonstrates the about section with rich text editor and vanilla JavaScript
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add this to your functions.php or include it in your theme
add_action('admin_menu', function () {
    add_management_page(
        'Test About Section',
        'Test About Section',
        'manage_options',
        'test-about-section',
        'test_about_section_page'
    );
});

function test_about_section_page()
{
?>
    <div class="wrap">
        <h1>Test About Section Functionality</h1>

        <div class="notice notice-info">
            <p><strong>Rich Text Editor Features:</strong></p>
            <ul>
                <li>✓ WordPress TinyMCE editor integration</li>
                <li>✓ Bold, italic, underline formatting</li>
                <li>✓ Lists (bulleted and numbered)</li>
                <li>✓ Links and media insertion</li>
                <li>✓ Text alignment options</li>
                <li>✓ Color and background color</li>
                <li>✓ HTML source editing</li>
            </ul>
        </div>

        <div class="notice notice-success">
            <p><strong>Vanilla JavaScript Features:</strong></p>
            <ul>
                <li>✓ No jQuery dependency</li>
                <li>✓ Modern ES6+ syntax</li>
                <li>✓ Event delegation for dynamic content</li>
                <li>✓ WordPress media uploader integration</li>
                <li>✓ Dynamic block addition/removal</li>
                <li>✓ Feature list management</li>
            </ul>
        </div>

        <div class="notice notice-warning">
            <p><strong>To test the functionality:</strong></p>
            <ol>
                <li>Go to any page in the WordPress admin</li>
                <li>Look for the "About Section Settings" meta box</li>
                <li>Try adding new blocks with the "Add New About Block" button</li>
                <li>Use the rich text editor to format content</li>
                <li>Upload images using the media uploader</li>
                <li>Add and remove features</li>
                <li>Save the page and view it on the frontend</li>
            </ol>
        </div>

        <h2>Code Changes Made:</h2>
        <h3>1. Rich Text Editor Integration</h3>
        <pre><code>// Replaced simple textarea with WordPress editor
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
wp_editor($content, $editor_id, $editor_settings);</code></pre>

        <h3>2. Vanilla JavaScript Conversion</h3>
        <pre><code>// Before (jQuery):
$('#add_about_block').click(function() {
    const blockHtml = generateAboutBlockHtml(blockCounter);
    $('#about_blocks_container').append(blockHtml);
    blockCounter++;
});

// After (Vanilla JS):
const addBlockBtn = document.getElementById('add_about_block');
if (addBlockBtn) {
    addBlockBtn.addEventListener('click', function() {
        const blockHtml = generateAboutBlockHtml(blockCounter);
        document.getElementById('about_blocks_container').insertAdjacentHTML('beforeend', blockHtml);
        blockCounter++;
    });
}</code></pre>

        <h3>3. Frontend Display</h3>
        <pre><code>// Updated template to use wp_kses_post for rich content
&lt;div class="text-lg text-gray-600 mb-6 prose prose-lg max-w-none"&gt;
    &lt;?php echo wp_kses_post($block['content']); ?&gt;
&lt;/div&gt;</code></pre>

        <h2>Benefits:</h2>
        <ul>
            <li><strong>Better User Experience:</strong> Rich text editor provides familiar formatting tools</li>
            <li><strong>No jQuery Dependency:</strong> Faster loading and smaller bundle size</li>
            <li><strong>Modern JavaScript:</strong> Better performance and maintainability</li>
            <li><strong>WordPress Integration:</strong> Seamless media uploader and editor integration</li>
            <li><strong>HTML Output:</strong> Properly formatted content with semantic HTML</li>
        </ul>
    </div>
<?php
}
?>