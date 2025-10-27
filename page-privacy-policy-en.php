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

                        <h2>4. Data Collection on This Website</h2>

                        <h3>Contact Form</h3>
                        <p>If you send us inquiries via the contact form, your information from the inquiry form, including the contact details you provided there, will be stored by us for the purpose of processing the inquiry and in case of follow-up questions. We do not pass on this data without your consent.</p>

                        <h3>Storage Period</h3>
                        <p>Your data will be deleted as soon as it is no longer required for the purpose of processing or statutory retention periods have expired.</p>

                        <h2>5. Your Rights</h2>
                        <p>You have the right to information, correction, deletion, and restriction of processing of your personal data. You also have the right to lodge a complaint with the competent supervisory authority.</p>

                        <h2>6. Changes</h2>
                        <p>We reserve the right to adapt this privacy policy so that it always complies with current legal requirements or to implement changes to our services in the privacy policy, e.g., when introducing new services.</p>

                        <p><em>Last updated: <?php echo date('F j, Y'); ?></em></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>