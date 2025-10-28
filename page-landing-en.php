<?php

/**
 * Template Name: Landing Page - English
 * 
 * This is a custom template for English landing pages
 */

// SEO Meta Tags
$hero_data = le_custom_get_hero_data();
$about_data = le_custom_get_about_data();
$services_data = le_custom_get_services_data();
$contact_data = le_custom_get_contact_data();

// Generate meta description using the new function
$meta_description = le_custom_get_meta_description();

// Generate page title using the new function
$page_title = le_custom_generate_page_title();

// Add SEO meta tags
add_action('wp_head', function () use ($meta_description, $page_title, $contact_data) {
    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta name="keywords" content="dentist, dental care, dental treatment, dental practice, oral health" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($page_title) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:locale" content="en_US" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($page_title) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '" />' . "\n";

    // Add structured data
    echo '<script type="application/ld+json">' . "\n";
    echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Dentist',
        'name' => $contact_data['practice_name'],
        'description' => $meta_description,
        'url' => get_permalink(),
        'telephone' => $contact_data['phone']['link'],
        'email' => $contact_data['email'],
        'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => $contact_data['address']['country'],
            'addressLocality' => $contact_data['address']['city'],
            'streetAddress' => $contact_data['address']['street']
        ],
        'openingHours' => [
            $contact_data['opening_hours']['monday'],
            $contact_data['opening_hours']['tuesday'],
            $contact_data['opening_hours']['wednesday'],
            $contact_data['opening_hours']['thursday'],
            $contact_data['opening_hours']['friday']
        ],
        'sameAs' => [
            'https://www.facebook.com/zahnarztpraxis',
            'https://www.instagram.com/zahnarztpraxis'
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
    echo '</script>' . "\n";
});

get_header(); ?>

<main class="min-h-screen">
    <!-- Hero Section -->
    <?php le_custom_display_hero_section(); ?>

    <!-- Services Section -->
    <?php get_template_part('template-parts/services-section'); ?>

    <!-- About Section -->
    <?php
    $about_data = le_custom_get_about_data();
    $contact_data = le_custom_get_contact_data();
    ?>
    <section class="about-section py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <?php if (!empty($about_data['blocks'])): ?>
                <?php foreach ($about_data['blocks'] as $block_index => $block): ?>
                    <div class="mb-20 last:mb-0" data-aos="fade-up" data-aos-delay="<?php echo $block_index * 200; ?>"
                        data-aos-duration="800">
                        <?php if ($block['position'] === 'text-only'): ?>
                            <!-- Text Only Layout -->
                            <div class="max-w-4xl mx-auto text-center">
                                <?php if (!empty($block['title'])): ?>
                                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                                        <?php echo esc_html($block['title']); ?>
                                    </h2>
                                <?php endif; ?>
                                <?php if (!empty($block['content'])): ?>
                                    <div class="text-lg text-gray-600 mb-6 prose prose-lg max-w-none">
                                        <?php echo wp_kses_post($block['content']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($block['features'])): ?>
                                    <ul class="space-y-3 max-w-2xl mx-auto">
                                        <?php foreach ($block['features'] as $feature): ?>
                                            <li class="flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-700"><?php echo esc_html($feature); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php elseif ($block['position'] === 'image-only'): ?>
                            <!-- Image Only Layout -->
                            <?php if (!empty($block['image'])): ?>
                                <div class="max-w-4xl mx-auto">
                                    <a href="<?php echo esc_url($block['image']); ?>" class="image-only-container">
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E"
                                            data-src="<?php echo esc_url($block['image']); ?>"
                                            alt="<?php echo esc_attr($block['title'] ?? 'About Image'); ?>" class="lazy-image"
                                            loading="lazy" decoding="async" />
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Text and Image Layout -->
                            <div class="grid lg:grid-cols-2 gap-12 items-center">
                                <?php if ($block['position'] === 'right'): ?>
                                    <!-- Image Left, Text Right -->
                                    <div class="about-image-gallery">
                                        <?php if (!empty($block['image'])): ?>
                                            <a href="<?php echo esc_url($block['image']); ?>">
                                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E"
                                                    data-src="<?php echo esc_url($block['image']); ?>"
                                                    alt="<?php echo esc_attr($block['title'] ?? 'About Image'); ?>" class="lazy-image"
                                                    loading="lazy" decoding="async" />
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php if (!empty($block['title'])): ?>
                                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                                                <?php echo esc_html($block['title']); ?>
                                            </h2>
                                        <?php endif; ?>
                                        <?php if (!empty($block['content'])): ?>
                                            <div class="text-lg text-gray-600 mb-6 prose prose-lg max-w-none">
                                                <?php echo wp_kses_post($block['content']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($block['features'])): ?>
                                            <ul class="space-y-3">
                                                <?php foreach ($block['features'] as $feature): ?>
                                                    <li class="flex items-center">
                                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-gray-700"><?php echo esc_html($feature); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <!-- Text Left, Image Right (default) -->
                                    <div>
                                        <?php if (!empty($block['title'])): ?>
                                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                                                <?php echo esc_html($block['title']); ?>
                                            </h2>
                                        <?php endif; ?>
                                        <?php if (!empty($block['content'])): ?>
                                            <div class="text-lg text-gray-600 mb-6 prose prose-lg max-w-none">
                                                <?php echo wp_kses_post($block['content']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($block['features'])): ?>
                                            <ul class="space-y-3">
                                                <?php foreach ($block['features'] as $feature): ?>
                                                    <li class="flex items-center">
                                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-gray-700"><?php echo esc_html($feature); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div class="about-image-gallery">
                                        <?php if (!empty($block['image'])): ?>
                                            <a href="<?php echo esc_url($block['image']); ?>">
                                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E"
                                                    data-src="<?php echo esc_url($block['image']); ?>"
                                                    alt="<?php echo esc_attr($block['title'] ?? 'About Image'); ?>" class="lazy-image"
                                                    loading="lazy" decoding="async" />
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback to legacy single block structure -->
                <div class="grid lg:grid-cols-2 gap-12 items-center" data-aos="fade-up" data-aos-delay="100"
                    data-aos-duration="800">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            <?php echo esc_html(isset($about_data['title']) && $about_data['title'] ? $about_data['title'] : 'About Our Practice'); ?>
                        </h2>
                        <p class="text-lg text-gray-600 mb-6">
                            <?php echo esc_html(isset($about_data['description']) && $about_data['description'] ? $about_data['description'] : 'For over 20 years, we have been your trusted partners for all questions regarding oral health. Our team of experienced dentists and friendly staff takes care of your well-being.'); ?>
                        </p>
                        <?php if (!empty($about_data['features'])): ?>
                            <ul class="space-y-3">
                                <?php foreach ($about_data['features'] as $feature): ?>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-700"><?php echo esc_html($feature); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="about-image-gallery">
                        <?php if (isset($about_data['image']) && $about_data['image']): ?>
                            <a href="<?php echo esc_url($about_data['image']); ?>">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E"
                                    data-src="<?php echo esc_url($about_data['image']); ?>"
                                    alt="<?php echo esc_attr(isset($about_data['title']) ? $about_data['title'] : 'About Our Practice'); ?>"
                                    class="lazy-image" loading="lazy" decoding="async" />
                                <div class="mt-4 opening-hours-glass">
                                    <h3 class="text-2xl font-semibold text-gray-900 mb-6">
                                        Opening Hours
                                    </h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Monday</span>
                                            <span
                                                class="font-medium"><?php echo esc_html($contact_data['opening_hours']['monday']); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Tuesday, Thursday</span>
                                            <span
                                                class="font-medium"><?php echo esc_html($contact_data['opening_hours']['tuesday_thursday']); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Wednesday, Friday</span>
                                            <span
                                                class="font-medium"><?php echo esc_html($contact_data['opening_hours']['wednesday_friday']); ?></span>
                                        </div>
                                        <?php if (!empty($contact_data['opening_hours']['saturday'])): ?>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Saturday</span>
                                                <span
                                                    class="font-medium"><?php echo esc_html($contact_data['opening_hours']['saturday']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($contact_data['opening_hours']['sunday'])): ?>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Sunday</span>
                                                <span
                                                    class="font-medium"><?php echo esc_html($contact_data['opening_hours']['sunday']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (isset($about_data['emergency_note']) && $about_data['emergency_note']): ?>
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <p class="text-sm text-gray-600">
                                                <?php echo esc_html($about_data['emergency_note']); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php else: ?>
                            <div class="opening-hours-glass">
                                <h3 class="text-2xl font-semibold text-gray-900 mb-6">
                                    Opening Hours
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Monday</span>
                                        <span
                                            class="font-medium"><?php echo esc_html($contact_data['opening_hours']['monday']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tuesday</span>
                                        <span
                                            class="font-medium"><?php echo esc_html($contact_data['opening_hours']['tuesday']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Wednesday</span>
                                        <span
                                            class="font-medium"><?php echo esc_html($contact_data['opening_hours']['wednesday']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Thursday</span>
                                        <span
                                            class="font-medium"><?php echo esc_html($contact_data['opening_hours']['thursday']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Friday</span>
                                        <span
                                            class="font-medium"><?php echo esc_html($contact_data['opening_hours']['friday']); ?></span>
                                    </div>
                                </div>
                                <?php if (isset($about_data['emergency_note']) && $about_data['emergency_note']): ?>
                                    <div class="mt-6 pt-6 border-t border-gray-200">
                                        <p class="text-sm text-gray-600">
                                            <?php echo esc_html($about_data['emergency_note']); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <?php
    // Set custom English content for the CTA
    $cta_title = 'Ready for Your Appointment?';
    $cta_description = 'Book an appointment today for a free initial consultation and let us take care of your oral health together.';
    $cta_primary_button_text = 'Call Now';
    $cta_secondary_button_text = 'Send Email';
    $cta_section_id = 'appointment';
    get_template_part('template-parts/cta-section');
    ?>

    <?php while (have_posts()) : the_post(); ?>
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="prose prose-lg max-w-none text-gray-700">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>