<?php

/**
 * reCAPTCHA Test Page
 * 
 * Simple test page to verify reCAPTCHA integration
 * Access via: yoursite.com/test-recaptcha.php
 */

// Include WordPress
require_once(__DIR__ . '/../../../wp-load.php');

// Get reCAPTCHA settings
$recaptcha_settings = le_custom_get_recaptcha_settings();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>reCAPTCHA Test - <?php bloginfo('name'); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .test-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        input,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        button {
            background: #007cba;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #005a87;
        }

        pre {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
    <?php if ($recaptcha_settings['enabled']): ?>
        <script
            src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr($recaptcha_settings['site_key']); ?>">
        </script>
    <?php endif; ?>
</head>

<body>
    <h1>reCAPTCHA v3 Integration Test</h1>

    <div class="status <?php echo $recaptcha_settings['enabled'] ? 'success' : 'error'; ?>">
        <strong>Status:</strong>
        <?php if ($recaptcha_settings['enabled']): ?>
            ✅ reCAPTCHA is configured and enabled
        <?php else: ?>
            ❌ reCAPTCHA is not configured. Please add your keys in Appearance → Customize → Contact Information
        <?php endif; ?>
    </div>

    <h2>Configuration</h2>
    <pre><?php
            echo "Site Key: " . (empty($recaptcha_settings['site_key']) ? 'Not set' : substr($recaptcha_settings['site_key'], 0, 20) . '...') . "\n";
            echo "Secret Key: " . (empty($recaptcha_settings['secret_key']) ? 'Not set' : 'Set (hidden for security)') . "\n";
            echo "Score Threshold: " . $recaptcha_settings['score_threshold'] . "\n";
            echo "Enabled: " . ($recaptcha_settings['enabled'] ? 'Yes' : 'No') . "\n";
            ?></pre>

    <?php if ($recaptcha_settings['enabled']): ?>
        <h2>Test Form</h2>
        <div class="test-form">
            <form id="test-form">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Test message" rows="4" required></textarea>
                <button type="submit">Test reCAPTCHA</button>
            </form>
            <div id="test-result"></div>
        </div>

        <script>
            document.getElementById('test-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const resultDiv = document.getElementById('test-result');
                resultDiv.innerHTML = '<div class="info">Testing reCAPTCHA...</div>';

                grecaptcha.ready(function() {
                    grecaptcha.execute('<?php echo esc_js($recaptcha_settings['site_key']); ?>', {
                            action: 'test_form'
                        })
                        .then(function(token) {
                            // Test the token with our verification function
                            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: 'action=test_recaptcha&token=' + token +
                                        '&nonce=<?php echo wp_create_nonce('test_recaptcha'); ?>'
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        resultDiv.innerHTML = `
                            <div class="success">
                                <strong>✅ Success!</strong><br>
                                Score: ${data.data.score}<br>
                                Status: ${data.data.reason}
                            </div>
                        `;
                                    } else {
                                        resultDiv.innerHTML = `
                            <div class="error">
                                <strong>❌ Failed!</strong><br>
                                Reason: ${data.data.reason}<br>
                                Score: ${data.data.score || 'N/A'}
                            </div>
                        `;
                                    }
                                })
                                .catch(error => {
                                    resultDiv.innerHTML = '<div class="error">Network error: ' + error +
                                        '</div>';
                                });
                        });
                });
            });
        </script>
    <?php else: ?>
        <div class="info">
            <strong>Setup Instructions:</strong><br>
            1. Go to <a href="https://www.google.com/recaptcha/admin" target="_blank">Google reCAPTCHA</a><br>
            2. Create a new reCAPTCHA v3 site<br>
            3. Add your domain<br>
            4. Copy the Site Key and Secret Key<br>
            5. Go to Appearance → Customize → Contact Information<br>
            6. Enter your keys and save
        </div>
    <?php endif; ?>

    <h2>Integration Status</h2>
    <div class="info">
        <strong>Functions Available:</strong><br>
        • le_custom_get_recaptcha_settings():
        <?php echo function_exists('le_custom_get_recaptcha_settings') ? '✅' : '❌'; ?><br>
        • le_custom_verify_recaptcha(): <?php echo function_exists('le_custom_verify_recaptcha') ? '✅' : '❌'; ?><br>

        <br><strong>Contact Forms:</strong><br>
        • German: <?php echo file_exists(get_template_directory() . '/page-contact-de.php') ? '✅' : '❌'; ?><br>
        • English: <?php echo file_exists(get_template_directory() . '/page-contact-en.php') ? '✅' : '❌'; ?><br>
    </div>

    <p><a href="<?php echo home_url(); ?>">← Back to Site</a></p>
</body>

</html>

<?php
// Add AJAX handler for testing
add_action('wp_ajax_test_recaptcha', 'handle_test_recaptcha');
add_action('wp_ajax_nopriv_test_recaptcha', 'handle_test_recaptcha');

function handle_test_recaptcha()
{
    if (!wp_verify_nonce($_POST['nonce'], 'test_recaptcha')) {
        wp_send_json_error(['reason' => 'Invalid nonce', 'score' => 0]);
    }

    $token = sanitize_text_field($_POST['token']);
    $result = le_custom_verify_recaptcha($token, 'test_form');

    if ($result['success']) {
        wp_send_json_success($result);
    } else {
        wp_send_json_error($result);
    }
}
?>