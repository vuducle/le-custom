<?php

/**
 * Contact Form Handler
 * 
 * Handles contact form submissions and sends emails
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize contact form functionality
 */
function le_custom_init_contact_form()
{
    // Add AJAX handlers for both logged in and non-logged in users
    add_action('wp_ajax_contact_form_submit', 'le_custom_handle_contact_form');
    add_action('wp_ajax_nopriv_contact_form_submit', 'le_custom_handle_contact_form');
}

/**
 * Get localized notification messages
 * 
 * @param string $language Language code ('de' or 'en')
 * @return array Localized messages
 */
function le_custom_get_notification_messages($language = 'de')
{
    $messages = [
        'de' => [
            'success' => 'Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet. Wir werden uns bald bei Ihnen melden.',
            'error' => 'Entschuldigung, beim Senden Ihrer Nachricht ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut oder kontaktieren Sie uns direkt.',
            'validation' => 'Bitte füllen Sie alle erforderlichen Felder aus.',
            'security_failed' => 'Sicherheitsüberprüfung fehlgeschlagen.',
            'invalid_email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
            'privacy_required' => 'Bitte akzeptieren Sie die Datenschutzerklärung.',
            'sending' => 'Wird gesendet...',
            'close' => 'Schließen'
        ],
        'en' => [
            'success' => 'Thank you! Your message has been sent successfully. We will get back to you soon.',
            'error' => 'Sorry, there was an error sending your message. Please try again or contact us directly.',
            'validation' => 'Please fill in all required fields.',
            'security_failed' => 'Security check failed.',
            'invalid_email' => 'Please enter a valid email address.',
            'privacy_required' => 'Please accept the privacy policy.',
            'sending' => 'Sending...',
            'close' => 'Close'
        ]
    ];

    return $messages[$language] ?? $messages['de'];
}

/**
 * Enqueue contact form scripts
 */
function le_custom_contact_form_scripts()
{
    // Script localization is now handled in functions.php
    // This function is kept for backward compatibility
}

/**
 * Handle contact form submission
 */
function le_custom_handle_contact_form()
{
    // Detect language from form data or referrer
    $language = 'de'; // Default to German
    if (isset($_POST['language'])) {
        $language = sanitize_text_field($_POST['language']);
    } elseif (isset($_SERVER['HTTP_REFERER'])) {
        $referrer = $_SERVER['HTTP_REFERER'];
        if (strpos($referrer, '-en') !== false || strpos($referrer, '/en/') !== false) {
            $language = 'en';
        }
    }

    // Get localized messages
    $messages = le_custom_get_notification_messages($language);

    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'contact_form_nonce')) {
        wp_send_json_error(['message' => $messages['security_failed']]);
    }

    // Verify reCAPTCHA if enabled
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha_result = le_custom_verify_recaptcha($_POST['g-recaptcha-response'], 'contact_form');
        if (!$recaptcha_result['success']) {
            wp_send_json_error(['message' => $messages['security_failed']]);
        }
    }

    // Validate required fields
    $required_fields = ['first_name', 'last_name', 'email', 'subject', 'message'];
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        wp_send_json_error(['message' => $messages['validation']]);
    }

    // Sanitize form data
    $form_data = [
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field($_POST['last_name']),
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone'] ?? ''),
        'subject' => sanitize_text_field($_POST['subject']),
        'message' => sanitize_textarea_field($_POST['message']),
        'privacy' => isset($_POST['privacy']) ? true : false
    ];

    // Validate email
    if (!is_email($form_data['email'])) {
        wp_send_json_error(['message' => $messages['invalid_email']]);
    }

    // Check privacy policy
    if (!$form_data['privacy']) {
        wp_send_json_error(['message' => $messages['privacy_required']]);
    }

    // Get contact data for recipient email
    $contact_data = le_custom_get_contact_data();
    $recipient_email = $contact_data['email'] ?? get_option('admin_email');

    // Prepare email content
    $email_subject = sprintf(
        __('New Contact Form Submission: %s', 'le-custom'),
        $form_data['subject']
    );

    $email_body = le_custom_build_contact_email($form_data);

    // Email headers
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . $form_data['email'] . '>',
        'Reply-To: ' . $form_data['first_name'] . ' ' . $form_data['last_name'] . ' <' . $form_data['email'] . '>'
    ];

    // Send email
    $email_sent = wp_mail($recipient_email, $email_subject, $email_body, $headers);

    if ($email_sent) {
        // Send confirmation email to user
        le_custom_send_confirmation_email($form_data);

        wp_send_json_success([
            'message' => $messages['success']
        ]);
    } else {
        wp_send_json_error([
            'message' => $messages['error']
        ]);
    }
}

/**
 * Build contact form email content
 */
function le_custom_build_contact_email($form_data)
{
    $subject_labels = [
        'termin' => __('Appointment Request', 'le-custom'),
        'frage' => __('General Question', 'le-custom'),
        'notfall' => __('Emergency', 'le-custom'),
        'feedback' => __('Feedback', 'le-custom'),
        'sonstiges' => __('Other', 'le-custom')
    ];

    $subject_label = $subject_labels[$form_data['subject']] ?? $form_data['subject'];

    ob_start();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }

            .header {
                background: #059669;
                color: white;
                padding: 20px;
                text-align: center;
            }

            .content {
                padding: 20px;
                background: #f9f9f9;
            }

            .field {
                margin-bottom: 15px;
            }

            .label {
                font-weight: bold;
                color: #555;
            }

            .value {
                margin-top: 5px;
            }

            .footer {
                text-align: center;
                padding: 20px;
                color: #666;
                font-size: 12px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1><?php echo get_bloginfo('name'); ?></h1>
                <p><?php _e('New Contact Form Submission', 'le-custom'); ?></p>
            </div>

            <div class="content">
                <div class="field">
                    <div class="label"><?php _e('Name:', 'le-custom'); ?></div>
                    <div class="value"><?php echo esc_html($form_data['first_name'] . ' ' . $form_data['last_name']); ?>
                    </div>
                </div>

                <div class="field">
                    <div class="label"><?php _e('Email:', 'le-custom'); ?></div>
                    <div class="value"><?php echo esc_html($form_data['email']); ?></div>
                </div>

                <?php if (!empty($form_data['phone'])): ?>
                    <div class="field">
                        <div class="label"><?php _e('Phone:', 'le-custom'); ?></div>
                        <div class="value"><?php echo esc_html($form_data['phone']); ?></div>
                    </div>
                <?php endif; ?>

                <div class="field">
                    <div class="label"><?php _e('Subject:', 'le-custom'); ?></div>
                    <div class="value"><?php echo esc_html($subject_label); ?></div>
                </div>

                <div class="field">
                    <div class="label"><?php _e('Message:', 'le-custom'); ?></div>
                    <div class="value"><?php echo nl2br(esc_html($form_data['message'])); ?></div>
                </div>

                <div class="field">
                    <div class="label"><?php _e('Submitted:', 'le-custom'); ?></div>
                    <div class="value"><?php echo current_time('F j, Y \a\t g:i a'); ?></div>
                </div>
            </div>

            <div class="footer">
                <p><?php _e('This message was sent from the contact form on', 'le-custom'); ?>
                    <?php echo get_bloginfo('name'); ?></p>
            </div>
        </div>
    </body>

    </html>
<?php
    return ob_get_clean();
}

/**
 * Send confirmation email to user
 */
function le_custom_send_confirmation_email($form_data)
{
    $subject = sprintf(
        __('Thank you for contacting %s', 'le-custom'),
        get_bloginfo('name')
    );

    ob_start();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }

            .header {
                background: #059669;
                color: white;
                padding: 20px;
                text-align: center;
            }

            .content {
                padding: 20px;
                background: #f9f9f9;
            }

            .footer {
                text-align: center;
                padding: 20px;
                color: #666;
                font-size: 12px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1><?php echo get_bloginfo('name'); ?></h1>
            </div>

            <div class="content">
                <p><?php _e('Dear', 'le-custom'); ?> <?php echo esc_html($form_data['first_name']); ?>,</p>

                <p><?php _e('Thank you for contacting us. We have received your message and will get back to you as soon as possible.', 'le-custom'); ?>
                </p>

                <p><?php _e('For your reference, here are the details of your message:', 'le-custom'); ?></p>

                <ul>
                    <li><strong><?php _e('Subject:', 'le-custom'); ?></strong>
                        <?php echo esc_html($form_data['subject']); ?></li>
                    <li><strong><?php _e('Message:', 'le-custom'); ?></strong>
                        <?php echo esc_html($form_data['message']); ?></li>
                </ul>

                <p><?php _e('If you have any urgent questions, please don\'t hesitate to call us directly.', 'le-custom'); ?>
                </p>

                <p><?php _e('Best regards,', 'le-custom'); ?><br>
                    <?php echo get_bloginfo('name'); ?></p>
            </div>

            <div class="footer">
                <p><?php _e('This is an automated confirmation email. Please do not reply to this message.', 'le-custom'); ?>
                </p>
            </div>
        </div>
    </body>

    </html>
<?php
    $email_body = ob_get_clean();

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    ];

    wp_mail($form_data['email'], $subject, $email_body, $headers);
}

// Initialize contact form functionality
add_action('init', 'le_custom_init_contact_form');
