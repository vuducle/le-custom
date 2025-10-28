<?php

/**
 * Main footer template part
 */

// Get contact data using the centralized function
$contact_data = le_custom_get_contact_data();

// Get color scheme data
$color_scheme = le_custom_get_color_scheme_data();

// Get footer-specific customizer values
$footer_bg_image = get_theme_mod('footer_background_image', '');

// Footer navigation - using WordPress menu system
$footer_menu_location = le_custom_get_navigation_menu('footer') ?: 'footer';

// Detect current language
$current_language = le_custom_detect_language();

// Language-specific opening hours labels
$opening_hours_labels = [
    'de' => [
        'title' => 'Öffnungszeiten',
        'monday' => 'Montag',
        'tuesday' => 'Dienstag',
        'wednesday' => 'Mittwoch',
        'thursday' => 'Donnerstag',
        'friday' => 'Freitag',
        'address' => 'Adresse',
        'phone' => 'Telefon',
        'email' => 'E-Mail',
        'languages' => 'Sprachen',
        'navigation' => 'Navigation'
    ],
    'en' => [
        'title' => 'Opening Hours',
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'address' => 'Address',
        'phone' => 'Phone',
        'email' => 'Email',
        'languages' => 'Languages',
        'navigation' => 'Navigation'
    ]
];

$labels = $opening_hours_labels[$current_language] ?? $opening_hours_labels['de'];

// Prepare footer background style
$footer_style = '';
if (!empty($footer_bg_image)) {
    $footer_style = 'background-image: url(' . esc_url($footer_bg_image) . '); background-size: cover; background-position: center; background-repeat: no-repeat;';
}

// Determine text color based on background
$text_color_class = !empty($footer_bg_image) ? 'text-white' : 'text-gray-900';
?>
<footer class="<?php echo esc_attr($text_color_class); ?> relative overflow-hidden"
    style="<?php echo $footer_style; ?>">
    <?php if (!empty($footer_bg_image)): ?>
    <!-- Background overlay for better text readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-gray-900/70 to-gray-800/90"></div>
    <?php else: ?>
    <!-- Default gradient background using Primary Color Light -->
    <div class="absolute inset-0"
        style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary_light']); ?> 0%, <?php echo esc_attr($color_scheme['secondary_light']); ?> 100%);">
    </div>
    <?php endif; ?>

    <div class="relative z-10 py-16 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Main footer content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12 mb-12">

                <!-- Column 1: Contact Information -->
                <div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm h-full">
                        <div class="flex items-center mb-6">
                            <?php if (has_custom_logo()) : ?>
                            <!-- Use custom logo if available -->
                            <div class="mr-4 flex-shrink-0">
                                <?php 
                                    $custom_logo_id = get_theme_mod('custom_logo');
                                    $logo_url = wp_get_attachment_image_url($custom_logo_id, 'medium');
                                    if ($logo_url) :
                                    ?>
                                <img src="<?php echo esc_url($logo_url); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="h-12 w-auto">
                                <?php endif; ?>
                            </div>
                            <?php else : ?>
                            <!-- Fallback icon if no custom logo -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 flex-shrink-0"
                                style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                            <?php endif; ?>
                            <h2 class="text-2xl font-bold text-gray-900">
                                <?php echo esc_html($contact_data['practice_name']); ?>
                            </h2>
                        </div>

                        <!-- Address -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0"
                                    style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1 text-gray-900">
                                        <?php echo esc_html($labels['address']); ?></p>
                                    <p class="text-gray-700">
                                        <?php echo esc_html($contact_data['address']['street']); ?></p>
                                    <p class="text-gray-700">
                                        <?php echo esc_html($contact_data['address']['city']); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0"
                                    style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1 text-gray-900">
                                        <?php echo esc_html($labels['phone']); ?></p>
                                    <a href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"
                                        class="text-lg font-medium hover:underline"
                                        style="color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                        <?php echo esc_html($contact_data['phone']['display']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0"
                                    style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1 text-gray-900">
                                        <?php echo esc_html($labels['email']); ?></p>
                                    <a href="mailto:<?php echo esc_attr($contact_data['email']); ?>"
                                        class="font-medium hover:underline"
                                        style="color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                        <?php echo esc_html($contact_data['email']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Languages -->
                        <div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0"
                                    style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1 text-gray-900">
                                        <?php echo esc_html($labels['languages']); ?></p>
                                    <p class="text-gray-700"><?php echo esc_html($contact_data['languages']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Opening Hours -->
                <div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm h-full">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4"
                                style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                <?php echo esc_html($labels['title']); ?>
                            </h3>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full mr-3"
                                        style="background-color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-800"><?php echo esc_html($labels['monday']); ?></span>
                                </div>
                                <span
                                    class="text-sm text-gray-900"><?php echo esc_html($contact_data['opening_hours']['monday']); ?></span>
                            </div>

                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full mr-3"
                                        style="background-color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-800"><?php echo esc_html($labels['tuesday']); ?></span>
                                </div>
                                <span
                                    class="text-sm text-gray-900"><?php echo esc_html($contact_data['opening_hours']['tuesday']); ?></span>
                            </div>

                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full mr-3"
                                        style="background-color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-800"><?php echo esc_html($labels['wednesday']); ?></span>
                                </div>
                                <span
                                    class="text-sm text-gray-900"><?php echo esc_html($contact_data['opening_hours']['wednesday']); ?></span>
                            </div>

                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full mr-3"
                                        style="background-color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-800"><?php echo esc_html($labels['thursday']); ?></span>
                                </div>
                                <span
                                    class="text-sm  text-gray-900"><?php echo esc_html($contact_data['opening_hours']['thursday']); ?></span>
                            </div>

                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full mr-3"
                                        style="background-color: <?php echo esc_attr($color_scheme['primary']); ?>;">
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-800"><?php echo esc_html($labels['friday']); ?></span>
                                </div>
                                <span
                                    class="text-sm text-gray-900"><?php echo esc_html($contact_data['opening_hours']['friday']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Google Maps -->
                <div>
                    <?php if ($contact_data['maps']['show']): ?>
                    <?php
                        // Generate dynamic Google Maps URL based on current address
                        $google_maps_url = le_custom_generate_google_maps_url();
                        ?>
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm h-full">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4"
                                style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Standort</h3>
                        </div>
                        <div class="relative overflow-hidden rounded-xl">
                            <iframe src="<?php echo esc_url($google_maps_url); ?>" width="100%" height="300"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                    <?php else: ?>
                    <div
                        class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4"
                                style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-lg text-gray-700">
                                <?php echo esc_html($current_language === 'en' ? 'Google Maps will be displayed here' : 'Google Maps wird hier angezeigt'); ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Navigation Section -->
            <div>
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4"
                            style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary']); ?> 0%, <?php echo esc_attr($color_scheme['secondary']); ?> 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">
                            <?php echo esc_html($labels['navigation']); ?>
                        </h3>
                    </div>

                    <nav class="relative">
                        <div class="relative">
                            <?php
                            wp_nav_menu([
                                'theme_location' => $footer_menu_location,
                                'menu_class'     => 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4',
                                'container'      => false,
                                'fallback_cb'    => 'le_custom_footer_menu_fallback',
                                'walker'         => new LE_Custom_Footer_Menu_Walker(),
                            ]);
                            ?>
                        </div>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer bottom -->
    <div class="relative z-10 border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 md:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-sm mb-4 md:mb-0 text-gray-600">
                    © <?php echo date('Y'); ?> <?php echo esc_html($contact_data['practice_name']); ?>.
                </div>
            </div>
        </div>
    </div>
</footer>