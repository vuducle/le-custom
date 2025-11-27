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
        le_custom_send_confirmation_email($form_data, $language);

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
function le_custom_send_confirmation_email($form_data, $language = 'de')
{
    $is_german = ($language === 'de');

    // --- Get custom data ---
    $color_scheme = le_custom_get_color_scheme_data();
    $contact_data = le_custom_get_contact_data();

    $logo_id = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : null;

    $primary_color = $color_scheme['primary'] ?? '#1e3a8a';
    // --- End custom data ---

    $subject = $is_german ?
        sprintf('Bestätigung Ihrer Kontaktanfrage an %s', get_bloginfo('name')) :
        sprintf('Thank you for contacting %s', get_bloginfo('name'));

    ob_start();
?>
    <!DOCTYPE html>
    <html lang="<?php echo $is_german ? 'de' : 'en'; ?>">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo esc_html($subject); ?></title>
        <style>
            body {
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                background-color: #f0f4f8;
            }

            table {
                border-collapse: collapse;
            }

            .main-table {
                width: 100%;
                background-color: #f0f4f8;
            }

            .content-table {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
            }

            .header-cell {
                padding: 40px;
                text-align: center;
                background-color: <?php echo esc_attr($primary_color);
                                    ?>;
                color: white;
                border-top-left-radius: 16px;
                border-top-right-radius: 16px;
            }

            .header-cell .logo {
                max-width: 150px;
                height: auto;
                margin-bottom: 20px;
            }

            .header-cell h1 {
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-size: 28px;
                font-weight: 700;
                color: white;
                margin: 0;
            }

            .content-cell {
                padding: 20px 40px;
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-size: 16px;
                line-height: 1.6;
                color: #334155;
            }

            .content-cell p {
                margin: 0 0 16px;
            }

            .content-cell strong {
                color: <?php echo esc_attr($primary_color);
                        ?>;
            }

            .details-box {
                background-color: #f8fafc;
                border-radius: 12px;
                padding: 20px;
                margin: 20px 0;
                border: 1px solid #e5e7eb;
            }

            .footer-cell {
                padding: 30px 40px;
                text-align: center;
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-size: 12px;
                color: #475569;
                border-top: 1px solid #e5e7eb;
            }

            .footer-cell a {
                color: <?php echo esc_attr($primary_color);
                        ?>;
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <table class="main-table" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" style="padding: 40px 20px;">
                    <table class="content-table" cellpadding="0" cellspacing="0">
                        <tr>
                            <td
                                style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="header-cell">
                                            <?php if ($logo_url) : ?>
                                                <img src="<?php echo esc_url($logo_url); ?>"
                                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo" class="logo">
                                            <?php else : ?>
                                                <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-cell">
                                            <?php if ($is_german) : ?>
                                                <p>Guten Tag <?php echo esc_html($form_data['first_name']); ?>
                                                    <?php echo esc_html($form_data['last_name']); ?>,</p>
                                                <p>vielen Dank für Ihre Kontaktaufnahme. Wir haben Ihre Nachricht erhalten und
                                                    werden uns so schnell wie möglich bei Ihnen melden.</p>
                                                <p>Zu Ihrer Information finden Sie hier die Details Ihrer Anfrage:</p>
                                                <div class="details-box">
                                                    <p><strong>Betreff:</strong> <?php echo esc_html($form_data['subject']); ?>
                                                    </p>
                                                    <p><strong>Ihre
                                                            Nachricht:</strong><br><?php echo nl2br(esc_html($form_data['message'])); ?>
                                                    </p>
                                                </div>
                                                <p>Bei dringenden Fragen zögern Sie bitte nicht, uns direkt anzurufen.</p>
                                                <p>Mit freundlichen Grüßen,<br>Ihr Team von
                                                    <?php echo esc_html(get_bloginfo('name')); ?></p>
                                            <?php else : ?>
                                                <p>Dear <?php echo esc_html($form_data['first_name']); ?>
                                                    <?php echo esc_html($form_data['last_name']); ?>,</p>
                                                <p>Thank you for contacting us. We have received your message and will get back
                                                    to you as soon as possible.</p>
                                                <p>For your reference, here are the details of your message:</p>
                                                <div class="details-box">
                                                    <p><strong>Subject:</strong> <?php echo esc_html($form_data['subject']); ?>
                                                    </p>
                                                    <p><strong>Your
                                                            Message:</strong><br><?php echo nl2br(esc_html($form_data['message'])); ?>
                                                    </p>
                                                </div>
                                                <p>If you have any urgent questions, please don't hesitate to call us directly.
                                                </p>
                                                <p>Best regards,<br>The <?php echo esc_html(get_bloginfo('name')); ?> Team</p>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="footer-cell">
                                            <p>&copy; <?php echo date('Y'); ?>
                                                <?php echo esc_html(get_bloginfo('name')); ?>. All Rights Reserved.</p>
                                            <?php if (!empty($contact_data['address'])) : ?>
                                                <p>
                                                    <?php echo esc_html($contact_data['address']['street']); ?>,
                                                    <?php echo esc_html($contact_data['address']['city']); ?>
                                                </p>
                                                <p>
                                                    <?php echo esc_html($contact_data['address']['country']); ?>
                                                </p>
                                                <?php if ($is_german) : ?>
                                                    <div class="contact-details julia-nguyen-ist-besser-als-triesnha-ameilya">
                                                        <p>Telefon:
                                                            <a href="tel:<?php echo esc_html($contact_data['phone']['link']); ?>">
                                                                <?php echo esc_html($contact_data['phone']['display']); ?>
                                                            </a>
                                                        </p>
                                                        <p>E-Mail: <a
                                                                href="mailto:<?php echo esc_html($contact_data['email']); ?>"><?php echo esc_html($contact_data['email']); ?></a>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!$is_german) : ?>
                                                    <div class="contact-details julia-nguyen-ist-besser-als-triesnha-ameilya">
                                                        <p>Phone:
                                                            <a href="tel:<?php echo esc_html($contact_data['phone']['link']); ?>">
                                                                <?php echo esc_html($contact_data['phone']['display']); ?>
                                                            </a>
                                                        </p>
                                                        <p>Email: <a
                                                                href="mailto:<?php echo esc_html($contact_data['email']); ?>"><?php echo esc_html($contact_data['email']); ?></a>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- <p><?php echo var_dump($contact_data['address']); ?></p> -->
                                            <?php endif; ?>
                                            <p><?php echo $is_german ? 'Dies ist eine automatische Bestätigungs-E-Mail. Bitte antworten Sie nicht auf diese Nachricht.' : 'This is an automated confirmation email. Please do not reply to this message.'; ?>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
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
