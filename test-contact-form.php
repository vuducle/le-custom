<?php

/**
 * Test Contact Form Page
 * 
 * This page helps test the contact form functionality
 * Access it directly: /wp-content/themes/le-custom/test-contact-form.php
 */

// Load WordPress
require_once('../../../wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('Access denied. Admin privileges required.');
}

// Test email functionality
function test_email_functionality()
{
    $test_email = get_option('admin_email');
    $subject = 'Test Email from Contact Form Handler';
    $message = 'This is a test email to verify that the contact form email functionality is working properly.';
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    $result = wp_mail($test_email, $subject, $message, $headers);

    return [
        'success' => $result,
        'recipient' => $test_email,
        'subject' => $subject
    ];
}

// Test contact data retrieval
function test_contact_data()
{
    if (function_exists('le_custom_get_contact_data')) {
        return le_custom_get_contact_data();
    }
    return 'Function le_custom_get_contact_data not found';
}

// Test form handler
function test_form_handler()
{
    if (function_exists('le_custom_handle_contact_form')) {
        return 'Function le_custom_handle_contact_form exists';
    }
    return 'Function le_custom_handle_contact_form not found';
}

// Run tests
$email_test = test_email_functionality();
$contact_data = test_contact_data();
$form_handler = test_form_handler();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .test-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .success {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .info {
            background: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        h1 {
            color: #333;
            border-bottom: 2px solid #059669;
            padding-bottom: 10px;
        }

        h2 {
            color: #059669;
            margin-top: 0;
        }

        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #059669;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }

        .button:hover {
            background: #047857;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Contact Form Test Page</h1>

        <div class="test-section info">
            <h2>Test Information</h2>
            <p>This page helps you test the contact form functionality. Use the buttons below to run various tests.</p>
            <p><strong>Current Time:</strong> <?php echo current_time('Y-m-d H:i:s'); ?></p>
            <p><strong>WordPress Version:</strong> <?php echo get_bloginfo('version'); ?></p>
        </div>

        <div class="test-section <?php echo $email_test['success'] ? 'success' : 'error'; ?>">
            <h2>Email Functionality Test</h2>
            <p><strong>Status:</strong> <?php echo $email_test['success'] ? 'SUCCESS' : 'FAILED'; ?></p>
            <p><strong>Test Email Sent To:</strong> <?php echo $email_test['recipient']; ?></p>
            <p><strong>Subject:</strong> <?php echo $email_test['subject']; ?></p>
            <?php if (!$email_test['success']): ?>
                <p><strong>Note:</strong> If email test failed, check your WordPress email configuration. You may need to install an SMTP plugin like WP Mail SMTP.</p>
            <?php endif; ?>
        </div>

        <div class="test-section info">
            <h2>Contact Data Test</h2>
            <p><strong>Status:</strong> <?php echo is_array($contact_data) ? 'SUCCESS' : 'FAILED'; ?></p>
            <?php if (is_array($contact_data)): ?>
                <pre><?php print_r($contact_data); ?></pre>
            <?php else: ?>
                <p><?php echo $contact_data; ?></p>
            <?php endif; ?>
        </div>

        <div class="test-section info">
            <h2>Form Handler Test</h2>
            <p><strong>Status:</strong> <?php echo strpos($form_handler, 'exists') !== false ? 'SUCCESS' : 'FAILED'; ?></p>
            <p><?php echo $form_handler; ?></p>
        </div>

        <div class="test-section info">
            <h2>Quick Actions</h2>
            <a href="<?php echo home_url('/kontakt/'); ?>" class="button">Go to German Contact Page</a>
            <a href="<?php echo home_url('/contact/'); ?>" class="button">Go to English Contact Page</a>
            <a href="<?php echo admin_url(); ?>" class="button">Go to WordPress Admin</a>
            <a href="<?php echo home_url(); ?>" class="button">Go to Homepage</a>
        </div>

        <div class="test-section info">
            <h2>Testing Instructions</h2>
            <ol>
                <li><strong>Email Test:</strong> Check if the test email was received at <?php echo $email_test['recipient']; ?></li>
                <li><strong>Contact Form:</strong> Go to the contact page and submit a test form</li>
                <li><strong>Check Emails:</strong> Verify that both the admin and user receive emails</li>
                <li><strong>Error Handling:</strong> Try submitting the form with missing fields to test validation</li>
            </ol>

            <h3>Common Issues & Solutions:</h3>
            <ul>
                <li><strong>Emails not sending:</strong> Install WP Mail SMTP plugin and configure SMTP settings</li>
                <li><strong>Form not submitting:</strong> Check browser console for JavaScript errors</li>
                <li><strong>AJAX errors:</strong> Verify that the contact-form-handler.php file is loaded</li>
                <li><strong>Permission errors:</strong> Ensure proper file permissions (644 for files, 755 for directories)</li>
            </ul>
        </div>

        <div class="test-section info">
            <h2>Debug Information</h2>
            <p><strong>Theme Directory:</strong> <?php echo get_template_directory(); ?></p>
            <p><strong>Contact Handler File:</strong> <?php echo get_template_directory() . '/inc/contact-form-handler.php'; ?></p>
            <p><strong>File Exists:</strong> <?php echo file_exists(get_template_directory() . '/inc/contact-form-handler.php') ? 'YES' : 'NO'; ?></p>
            <p><strong>AJAX URL:</strong> <?php echo admin_url('admin-ajax.php'); ?></p>
            <p><strong>Nonce Verification:</strong> <?php echo wp_verify_nonce(wp_create_nonce('contact_form_nonce'), 'contact_form_nonce') ? 'Working' : 'Failed'; ?></p>
        </div>
    </div>
</body>

</html>