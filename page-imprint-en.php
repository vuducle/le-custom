<?php

/**
 * Template Name: Imprint - English
 * 
 * Custom page template for English imprint
 */

// Get meta description and structured data
$meta_description = le_custom_get_meta_description();
$contact_data = le_custom_get_contact_data();

// Add SEO meta tags
add_action('wp_head', function () use ($meta_description, $contact_data) {
    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:title" content="Imprint - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:locale" content="en_US" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="Imprint - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
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
                Imprint
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Legal information and details according to § 5 TMG
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                <?php if (!empty($legal_data['imprint_en'])) : ?>
                    <div class="prose prose-lg max-w-none">
                        <?php echo wp_kses_post($legal_data['imprint_en']); ?>
                    </div>
                <?php else : ?>
                    <!-- Default Imprint Content -->
                    <div class="prose prose-lg max-w-none">
                        <h2>Information according to § 5 TMG</h2>

                        <h3>Responsible for content according to § 55 Abs. 2 RStV</h3>
                        <p>
                            <strong><?php echo esc_html($contact_data['practice_name']); ?></strong><br>
                            <?php echo esc_html($contact_data['address']['street']); ?><br>
                            <?php echo esc_html($contact_data['address']['city']); ?><br>
                            <?php echo esc_html($contact_data['address']['country']); ?>
                        </p>

                        <h3>Contact</h3>
                        <p>
                            Phone: <a
                                href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"><?php echo esc_html($contact_data['phone']['display']); ?></a><br>
                            Email: <a
                                href="mailto:<?php echo esc_attr($contact_data['email']); ?>"><?php echo esc_html($contact_data['email']); ?></a>
                        </p>

                        <h2>Professional Title and Professional Regulations</h2>
                        <p><strong>Professional Title:</strong> Dentist</p>
                        <p><strong>Responsible Chamber:</strong> Berlin Dental Association</p>
                        <p><strong>Conferred by:</strong> Germany</p>

                        <h2>VAT ID</h2>
                        <p>Value Added Tax Identification Number according to § 27 a Value Added Tax Act:<br>
                            [Insert your VAT ID here]</p>

                        <h2>Editorially Responsible</h2>
                        <p>
                            <?php echo esc_html($contact_data['practice_name']); ?><br>
                            <?php echo esc_html($contact_data['address']['street']); ?><br>
                            <?php echo esc_html($contact_data['address']['city']); ?>
                        </p>

                        <h2>EU Dispute Resolution</h2>
                        <p>The European Commission provides a platform for online dispute resolution (OS): <a
                                href="https://ec.europa.eu/consumers/odr/" target="_blank"
                                rel="noopener">https://ec.europa.eu/consumers/odr/</a>.<br>
                            You can find our email address above in the imprint.</p>

                        <h2>Consumer Dispute Resolution/Universal Dispute Resolution Body</h2>
                        <p>We are not willing or obligated to participate in dispute resolution proceedings before a
                            consumer arbitration board.</p>

                        <h2>Liability for Content</h2>
                        <p>As a service provider, we are responsible for our own content on these pages in accordance with §
                            7 Abs.1 TMG and general laws. However, according to §§ 8 to 10 TMG, we as a service provider are
                            not obligated to monitor transmitted or stored third-party information or to investigate
                            circumstances that indicate illegal activity.</p>

                        <p>Obligations to remove or block the use of information under general law remain unaffected.
                            However, liability in this regard is only possible from the time of knowledge of a specific
                            legal violation. Upon becoming aware of corresponding legal violations, we will remove this
                            content immediately.</p>

                        <h2>Liability for Links</h2>
                        <p>Our offer contains links to external third-party websites over whose content we have no
                            influence. Therefore, we cannot assume any liability for these external contents. The respective
                            provider or operator of the pages is always responsible for the content of the linked pages. The
                            linked pages were checked for possible legal violations at the time of linking. Illegal content
                            was not recognizable at the time of linking.</p>

                        <p>However, permanent content monitoring of the linked pages is not reasonable without concrete
                            evidence of a legal violation. Upon becoming aware of legal violations, we will remove such
                            links immediately.</p>

                        <h2>Copyright</h2>
                        <p>The content and works created by the site operators on these pages are subject to German
                            copyright law. The reproduction, editing, distribution and any kind of exploitation outside the
                            limits of copyright require the written consent of the respective author or creator. Downloads
                            and copies of this page are only permitted for private, non-commercial use.</p>

                        <p>Insofar as the content on this page was not created by the operator, the copyrights of third
                            parties are respected. In particular, third-party content is marked as such. Should you
                            nevertheless become aware of a copyright infringement, we ask for a corresponding notice. Upon
                            becoming aware of legal violations, we will remove such content immediately.</p>

                        <p><em>Last updated: <?php echo date('F j, Y'); ?></em></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>