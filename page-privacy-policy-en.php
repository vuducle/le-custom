<?php

/**
 * Template Name: Privacy Policy - English
 * 
 * Custom page template for English privacy policy
 */

// Get meta description and structured data
$meta_description = le_custom_get_meta_description();
$contact_data = le_custom_get_contact_data();

// Add SEO meta tags
add_action('wp_head', function () use ($meta_description, $contact_data) {
    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:title" content="Privacy Policy - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:locale" content="en_US" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="Privacy Policy - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '" />' . "\n";
});

// Output structured data
le_custom_output_subpage_structured_data();

get_header();

// Get customizer data
$contact_data = le_custom_get_contact_data();
$legal_data = $contact_data['legal'];
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 lg:py-20">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12 lg:mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Privacy Policy
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Information about the protection of your personal data
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                <?php if (!empty($legal_data['privacy_policy_en'])) : ?>
                    <div class="prose prose-lg max-w-none">
                        <?php echo wp_kses_post($legal_data['privacy_policy_en']); ?>
                    </div>
                <?php else : ?>
                    <!-- Default Privacy Policy Content -->
                    <div class="prose prose-lg max-w-none">
                        <h2>1. Privacy at a Glance</h2>

                        <h3>General Information</h3>
                        <p>The following information provides a simple overview of what happens to your personal data when you visit this website. Personal data is any data with which you can be personally identified. Detailed information on the subject of data protection can be found in our privacy policy below this text.</p>

                        <h3>Data Collection on This Website</h3>
                        <p><strong>Who is responsible for data collection on this website?</strong></p>
                        <p>Data processing on this website is carried out by the website operator. You can find their contact details in the "Information on the Responsible Party" section of this privacy policy.</p>

                        <h3>How Do We Collect Your Data?</h3>
                        <p>Your data is collected on the one hand by you providing it to us. This can be, for example, data that you enter in a contact form.</p>
                        <p>Other data is collected automatically or with your consent when you visit the website by our IT systems. These are mainly technical data (e.g., internet browser, operating system, or time of page access). The collection of this data takes place automatically as soon as you enter this website.</p>

                        <h3>What Do We Use Your Data For?</h3>
                        <p>Some of the data is collected to ensure error-free provision of the website. Other data may be used to analyze your user behavior.</p>

                        <h3>What Rights Do You Have Regarding Your Data?</h3>
                        <p>You have the right to receive information free of charge at any time about the origin, recipient, and purpose of your stored personal data. You also have the right to request the correction or deletion of this data. If you have given consent to data processing, you can revoke this consent at any time for the future. You also have the right to request the restriction of processing of your personal data under certain circumstances. Furthermore, you have the right to lodge a complaint with the competent supervisory authority.</p>

                        <h2>2. Hosting</h2>
                        <p>We host our website with a professional hosting provider who provides the technical infrastructure for our website.</p>

                        <h2>3. General Information and Mandatory Information</h2>

                        <h3>Data Protection</h3>
                        <p>The operators of these pages take the protection of your personal data very seriously. We treat your personal data confidentially and in accordance with the statutory data protection regulations and this privacy policy.</p>

                        <h3>Information on the Responsible Party</h3>
                        <p>The party responsible for data processing on this website is:</p>
                        <p>
                            <strong><?php echo esc_html($contact_data['practice_name']); ?></strong><br>
                            <?php echo esc_html($contact_data['address']['street']); ?><br>
                            <?php echo esc_html($contact_data['address']['city']); ?><br>
                            <?php echo esc_html($contact_data['address']['country']); ?>
                        </p>
                        <p>
                            Phone: <a href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"><?php echo esc_html($contact_data['phone']['display']); ?></a><br>
                            Email: <a href="mailto:<?php echo esc_attr($contact_data['email']); ?>"><?php echo esc_html($contact_data['email']); ?></a>
                        </p>

                        <h2>4. Purpose and Legal Basis for Processing Your Data</h2>

                        <p>When you use our website to find out information about our practice, we do not generally collect
                            personal data. However, our service provider collects certain technical data that is required to
                            deliver the website and to ensure stability and security. The legal basis for this processing is
                            Art. 6(1)(f) GDPR (legitimate interest):</p>

                        <ul>
                            <li>IP address</li>
                            <li>Date and time of the request</li>
                            <li>Time zone difference to Greenwich Mean Time (GMT)</li>
                            <li>Content of the request (specific page)</li>
                            <li>Access status / HTTP status code</li>
                            <li>Amount of data transferred</li>
                            <li>Website from which the request originates (referrer)</li>
                            <li>Browser</li>
                            <li>Operating system and its interface</li>
                            <li>Language and version of the browser software</li>
                        </ul>

                        <p>We do not store any cookies on your device when you use our website.</p>

                        <h2>5. What Rights Do You Have in Relation to Data Protection?</h2>

                        <p>You have the rights listed below. Since no personal data is collected during a purely informational
                            visit to our website (see above), these rights are generally not applicable in that context. For
                            data collected in the context of a telephone call or e‑mail contact, however, the following rights
                            apply:</p>

                        <ul>
                            <li>Right to information</li>
                            <li>Right to correction or deletion</li>
                            <li>Right to restriction of processing</li>
                            <li>Right to object to processing</li>
                            <li>Right to data portability</li>
                        </ul>

                        <h2>6. External Data</h2>

                        <p>We generally avoid relying on external service providers for individual functions of our website.
                            Where external content is embedded, this is primarily through links (e.g. Google Maps). We have
                            no control over the content of these external providers; responsibility lies with the
                            respective providers.</p>

                        <h2>7. How Can You Lodge a Complaint?</h2>

                        <p>You have the option to raise a complaint regarding data processing with the competent data
                            protection supervisory authority:</p>

                        <p>
                            Ms.<br>
                            Maja Smoltczyk<br>
                            Friedrichstr. 219<br>
                            10969 Berlin<br>
                            Phone: 030/13889-0
                        </p>

                        <h2>8. Changes</h2>
                        <p>We reserve the right to adapt this privacy policy so that it always complies with current legal
                            requirements or to implement changes to our services in the privacy policy, e.g. when
                            introducing new services.</p>

                        <h2>9. Use of Google reCAPTCHA</h2>
                        <p>To protect our contact forms from spam and abuse we use Google reCAPTCHA by Google LLC. In
                            connection with reCAPTCHA, personal data such as IP addresses and certain browser data may be
                            transmitted to and processed by Google servers in the United States. The purpose of this
                            processing is to distinguish between human users and automated accesses. The legal basis is
                            Art. 6(1)(f) GDPR (legitimate interests), unless consent has been obtained beforehand.</p>

                        <p>Further information about Google reCAPTCHA and Google's data processing can be found here:
                            <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">https://policies.google.com/privacy</a>
                            and the reCAPTCHA documentation: <a href="https://developers.google.com/recaptcha" target="_blank" rel="noopener">https://developers.google.com/recaptcha</a>.
                        </p>

                        <h2>10. Use of WordPress</h2>
                        <p>This website is built on the WordPress content management system. WordPress may store technical
                            data, user account information (e.g. for logins) and, if enabled, comment data in our
                            database. In addition, WordPress may set functional cookies for logged‑in users. The purpose
                            and scope of data collection depend on the features used (e.g. login/administration or
                            commenting).</p>

                        <p>For more information on WordPress and privacy see:
                            <a href="https://wordpress.org/about/privacy/" target="_blank" rel="noopener">https://wordpress.org/about/privacy/</a>.
                        </p>

                        <p><em>Last updated: <?php echo date('F j, Y'); ?></em></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>