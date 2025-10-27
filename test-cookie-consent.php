<?php

/**
 * Cookie Consent Test Page
 * 
 * This file helps test and debug the cookie consent system.
 * Access it via: /wp-content/themes/le-custom/test-cookie-consent.php
 */

// Prevent direct access in production
if (!defined('ABSPATH') && !isset($_GET['test'])) {
    exit('Direct access not allowed');
}

// Include WordPress
if (!defined('ABSPATH')) {
    require_once('../../../wp-load.php');
}

// Include cookie consent class
require_once get_template_directory() . '/inc/cookie-consent.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Consent Test</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }

        .test-section {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #007cba;
        }

        .test-result {
            background: #e8f5e8;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border-left: 4px solid #28a745;
        }

        .test-error {
            background: #f8d7da;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border-left: 4px solid #dc3545;
        }

        .test-warning {
            background: #fff3cd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border-left: 4px solid #ffc107;
        }

        .button {
            background: #007cba;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }

        .button:hover {
            background: #005a87;
        }

        .button.secondary {
            background: #6c757d;
        }

        .button.secondary:hover {
            background: #545b62;
        }

        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }

        .language-switcher {
            margin-bottom: 20px;
        }

        .language-switcher a {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 5px;
            background: #e9ecef;
            color: #495057;
            text-decoration: none;
            border-radius: 4px;
        }

        .language-switcher a.active {
            background: #007cba;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Cookie Consent System Test</h1>

    <div class="language-switcher">
        <a href="?test=1&lang=de" <?php echo ($_GET['lang'] ?? 'de') === 'de' ? 'class="active"' : ''; ?>>Deutsch</a>
        <a href="?test=1&lang=en" <?php echo ($_GET['lang'] ?? 'de') === 'en' ? 'class="active"' : ''; ?>>English</a>
    </div>

    <div class="test-section">
        <h2>PHP Tests</h2>

        <?php
        try {
            $cookie_consent = new LE_Cookie_Consent();

            echo '<div class="test-result">✅ Cookie consent class instantiated successfully</div>';

            // Test language detection
            $current_lang = $_GET['lang'] ?? 'de';
            echo '<div class="test-result">🌐 Current language: ' . htmlspecialchars($current_lang) . '</div>';

            // Test consent status
            $has_consent = $cookie_consent->has_consent();
            echo '<div class="test-result">🍪 Has consent: ' . ($has_consent ? 'Yes' : 'No') . '</div>';

            // Test specific consent types
            $necessary_consent = $cookie_consent->has_consent('necessary');

            echo '<div class="test-result">🔒 Necessary consent: ' . ($necessary_consent ? 'Yes' : 'No') . '</div>';

            // Test settings (using reflection to access private method)
            $reflection = new ReflectionClass($cookie_consent);
            $get_settings_method = $reflection->getMethod('get_settings');
            $get_settings_method->setAccessible(true);
            $settings = $get_settings_method->invoke($cookie_consent);
            echo '<div class="test-result">⚙️ Settings loaded successfully</div>';
            echo '<div class="test-result">🎨 Primary color: ' . htmlspecialchars($settings['primaryColor']) . '</div>';
        } catch (Exception $e) {
            echo '<div class="test-error">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
    </div>

    <div class="test-section">
        <h2>JavaScript Tests</h2>

        <div id="js-test-results">
            <div class="test-warning">⏳ JavaScript tests will run after page load...</div>
        </div>

        <button class="button" onclick="testConsentFunctions()">Run JavaScript Tests</button>
        <button class="button secondary" onclick="clearConsent()">Clear Consent</button>
        <button class="button secondary" onclick="showConsent()">Show Consent Overlay</button>
    </div>

    <div class="test-section">
        <h2>Cookie Information</h2>

        <?php
        $cookie_name = 'cookie_consent_julia_nguyen';
        $cookie_value = $_COOKIE[$cookie_name] ?? null;

        if ($cookie_value) {
            echo '<div class="test-result">🍪 Cookie found: ' . htmlspecialchars($cookie_name) . '</div>';

            try {
                $decoded = json_decode(stripslashes($cookie_value), true);
                if ($decoded) {
                    echo '<pre>' . htmlspecialchars(json_encode($decoded, JSON_PRETTY_PRINT)) . '</pre>';
                } else {
                    echo '<div class="test-error">❌ Failed to decode cookie value</div>';
                }
            } catch (Exception $e) {
                echo '<div class="test-error">❌ Error decoding cookie: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        } else {
            echo '<div class="test-warning">⚠️ No consent cookie found</div>';
        }
        ?>
    </div>

    <div class="test-section">
        <h2>Asset Loading Test</h2>

        <?php
        $css_file = get_template_directory() . '/assets/css/cookie-consent.css';
        $js_file = get_template_directory() . '/assets/js/cookie-consent.js';

        echo '<div class="test-result">📁 CSS file: ' . (file_exists($css_file) ? '✅ Found' : '❌ Missing') . '</div>';
        echo '<div class="test-result">📁 JS file: ' . (file_exists($js_file) ? '✅ Found' : '❌ Missing') . '</div>';

        if (file_exists($css_file)) {
            echo '<div class="test-result">📏 CSS file size: ' . number_format(filesize($css_file)) . ' bytes</div>';
        }

        if (file_exists($js_file)) {
            echo '<div class="test-result">📏 JS file size: ' . number_format(filesize($js_file)) . ' bytes</div>';
        }
        ?>
    </div>

    <div class="test-section">
        <h2>WordPress Integration Test</h2>

        <?php
        // Test if hooks are registered
        global $wp_filter;

        $has_footer_hook = isset($wp_filter['wp_footer']);
        $has_enqueue_hook = isset($wp_filter['wp_enqueue_scripts']);
        $has_customizer_hook = isset($wp_filter['customize_register']);

        echo '<div class="test-result">🎣 Footer hook: ' . ($has_footer_hook ? '✅ Registered' : '❌ Not found') . '</div>';
        echo '<div class="test-result">🎣 Enqueue hook: ' . ($has_enqueue_hook ? '✅ Registered' : '❌ Not found') . '</div>';
        echo '<div class="test-result">🎣 Customizer hook: ' . ($has_customizer_hook ? '✅ Registered' : '❌ Not found') . '</div>';
        ?>
    </div>

    <script>
        // Test JavaScript functionality
        function testConsentFunctions() {
            const results = document.getElementById('js-test-results');
            results.innerHTML = '';

            // Test if global object exists
            if (typeof LE_Cookie_Consent !== 'undefined') {
                addResult('✅ LE_Cookie_Consent global object found', 'success');

                // Test static methods
                if (typeof LE_Cookie_Consent.hasConsent === 'function') {
                    addResult('✅ hasConsent method available', 'success');

                    const hasConsent = LE_Cookie_Consent.hasConsent();
                    addResult('🍪 Has consent: ' + (hasConsent ? 'Yes' : 'No'), 'info');

                    const necessaryConsent = LE_Cookie_Consent.hasConsent('necessary');
                    addResult('🔒 Necessary consent: ' + (necessaryConsent ? 'Yes' : 'No'), 'info');
                } else {
                    addResult('❌ hasConsent method not found', 'error');
                }

                if (typeof LE_Cookie_Consent.getConsentData === 'function') {
                    addResult('✅ getConsentData method available', 'success');

                    const consentData = LE_Cookie_Consent.getConsentData();
                    if (consentData) {
                        addResult('📋 Consent data: ' + JSON.stringify(consentData, null, 2), 'info');
                    } else {
                        addResult('📋 No consent data found', 'warning');
                    }
                } else {
                    addResult('❌ getConsentData method not found', 'error');
                }

            } else {
                addResult('❌ LE_Cookie_Consent global object not found', 'error');
            }

            // Test if overlay exists
            const overlay = document.getElementById('cookie-consent-overlay');
            if (overlay) {
                addResult('✅ Cookie consent overlay found in DOM', 'success');
            } else {
                addResult('⚠️ Cookie consent overlay not found in DOM', 'warning');
            }

            // Test if settings are available
            if (typeof leCookieConsent !== 'undefined') {
                addResult('✅ leCookieConsent settings available', 'success');
                addResult('⚙️ Settings: ' + JSON.stringify(leCookieConsent, null, 2), 'info');
            } else {
                addResult('❌ leCookieConsent settings not found', 'error');
            }
        }

        function addResult(message, type) {
            const results = document.getElementById('js-test-results');
            const div = document.createElement('div');
            div.className = 'test-result';

            if (type === 'error') div.className = 'test-error';
            if (type === 'warning') div.className = 'test-warning';
            if (type === 'info') {
                div.className = 'test-result';
                div.style.fontFamily = 'monospace';
                div.style.fontSize = '12px';
            }

            div.innerHTML = message;
            results.appendChild(div);
        }

        function clearConsent() {
            document.cookie = 'cookie_consent_julia_nguyen=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            location.reload();
        }

        function showConsent() {
            if (typeof LE_Cookie_Consent !== 'undefined' && LE_Cookie_Consent.showOverlay) {
                LE_Cookie_Consent.showOverlay();
            } else {
                alert('Consent overlay not available');
            }
        }

        // Run tests on page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(testConsentFunctions, 1000);
        });
    </script>
</body>

</html>