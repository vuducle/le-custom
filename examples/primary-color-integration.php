<?php

/**
 * Primary Color Integration Example
 * 
 * This file demonstrates how the cookie consent system
 * automatically uses the primary color from WordPress Customizer.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Example: Show how primary color is used in cookie consent
 */
function example_primary_color_integration()
{
    // Get the primary color from customizer
    $primary_color = get_theme_mod('primary_color', '#059669');

?>
    <div class="primary-color-demo">
        <h2>Cookie Consent Primary Color Integration</h2>

        <div class="color-info">
            <h3>Current Primary Color</h3>
            <div class="color-preview" style="background: <?php echo esc_attr($primary_color); ?>; width: 50px; height: 50px; border-radius: 8px; margin: 10px 0;"></div>
            <p><strong>Hex Value:</strong> <?php echo esc_html($primary_color); ?></p>
            <p><strong>Source:</strong> WordPress Customizer → Color Scheme → Primary Color</p>
        </div>

        <div class="usage-info">
            <h3>Where the Primary Color is Used</h3>
            <ul>
                <li><strong>Primary Buttons:</strong> Accept button background and hover states</li>
                <li><strong>Toggle Switches:</strong> Checked state background</li>
                <li><strong>Focus Indicators:</strong> Outline color for keyboard navigation</li>
                <li><strong>Loading Spinner:</strong> Border color during consent saving</li>
            </ul>
        </div>

        <div class="customization-info">
            <h3>How to Customize</h3>
            <p>To change the primary color used in the cookie consent overlay:</p>
            <ol>
                <li>Go to <strong>Appearance → Customize</strong></li>
                <li>Navigate to <strong>Color Scheme</strong></li>
                <li>Change the <strong>Primary Color</strong></li>
                <li>Save changes</li>
            </ol>
            <p>The cookie consent overlay will automatically use the new primary color.</p>
        </div>

        <div class="css-variables-info">
            <h3>CSS Custom Properties Generated</h3>
            <p>The system automatically generates these CSS variables:</p>
            <pre><code>:root {
    --cookie-consent-primary-color: <?php echo esc_html($primary_color); ?>;
    --cookie-consent-primary-hover: <?php echo esc_html(adjust_brightness($primary_color, -10)); ?>;
    --cookie-consent-primary-focus: <?php echo esc_html(adjust_brightness($primary_color, -20)); ?>;
}</code></pre>
        </div>
    </div>

    <style>
        .primary-color-demo {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .primary-color-demo h2 {
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .primary-color-demo h3 {
            color: #374151;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .color-info,
        .usage-info,
        .customization-info,
        .css-variables-info {
            background: white;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border-left: 4px solid <?php echo esc_attr($primary_color); ?>;
        }

        .color-preview {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .usage-info ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .usage-info li {
            margin: 5px 0;
        }

        .customization-info ol {
            margin: 10px 0;
            padding-left: 20px;
        }

        .customization-info li {
            margin: 5px 0;
        }

        pre {
            background: #1f2937;
            color: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
            font-size: 14px;
        }

        code {
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        }
    </style>
<?php
}

/**
 * Helper function to adjust color brightness
 */
function adjust_brightness($hex, $percent)
{
    // Remove # if present
    $hex = str_replace('#', '', $hex);

    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Adjust brightness
    $r = max(0, min(255, $r + ($r * $percent / 100)));
    $g = max(0, min(255, $g + ($g * $percent / 100)));
    $b = max(0, min(255, $b + ($b * $percent / 100)));

    // Convert back to hex
    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}

/**
 * Example: Add custom CSS to override primary color
 */
function example_custom_primary_color_override()
{
?>
    <style>
        /* Example: Override primary color for cookie consent */
        :root {
            --cookie-consent-primary-color: #dc2626;
            /* Red */
            --cookie-consent-primary-hover: #b91c1c;
            --cookie-consent-primary-focus: #991b1b;
        }

        /* This would make the cookie consent use red instead of the customizer primary color */
    </style>
    <?php
}

/**
 * Example: Show cookie consent with current primary color
 */
function example_show_cookie_consent_demo()
{
    // Only show if user hasn't given consent
    $cookie_consent = new LE_Cookie_Consent();

    if (!$cookie_consent->has_consent()) {
    ?>
        <div class="cookie-consent-demo">
            <h3>Cookie Consent Demo</h3>
            <p>This shows how the cookie consent overlay looks with your current primary color:</p>

            <button type="button" class="cookie-consent-btn cookie-consent-btn-primary" onclick="showCookieConsentDemo()">
                Show Cookie Consent Overlay
            </button>
        </div>

        <script>
            function showCookieConsentDemo() {
                // Clear any existing consent to show the overlay
                document.cookie = 'le_cookie_consent=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                location.reload();
            }
        </script>

        <style>
            .cookie-consent-demo {
                background: white;
                padding: 20px;
                border-radius: 8px;
                margin: 20px 0;
                text-align: center;
                border: 2px dashed #e5e7eb;
            }

            .cookie-consent-demo h3 {
                margin-top: 0;
                color: #374151;
            }

            .cookie-consent-demo p {
                color: #6b7280;
                margin-bottom: 15px;
            }
        </style>
<?php
    }
}

// Add the examples to a demo page
add_action('wp_footer', function () {
    if (is_page('cookie-consent-demo')) {
        example_primary_color_integration();
        example_show_cookie_consent_demo();
    }
});
