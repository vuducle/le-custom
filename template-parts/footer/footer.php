<?php

/**
 * Main footer template part
 */

// Get contact data using the centralized function
$contact_data = le_custom_get_contact_data();

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
?>
<footer class="text-white relative overflow-hidden" style="<?php echo $footer_style; ?>">
    <?php if (!empty($footer_bg_image)): ?>
        <!-- Background overlay for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-gray-900/70 to-gray-800/90"></div>
    <?php else: ?>
        <!-- Default gradient background -->
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900"></div>
    <?php endif; ?>

    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-400/10 rounded-full blur-3xl animate-pulse delay-1000">
        </div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/5 rounded-full blur-3xl animate-pulse delay-500">
        </div>
    </div>

    <div class="relative z-10 py-16 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Main footer content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12 mb-12">

                <!-- Column 1: Contact Information -->
                <div class="group">
                    <div
                        class="backdrop-blur-xl bg-white/5 border border-white/20 rounded-3xl p-8 shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 hover:scale-105 hover:bg-white/10">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <h2
                                class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white via-emerald-100 to-teal-100 bg-clip-text text-transparent">
                                <?php echo esc_html($contact_data['practice_name']); ?>
                            </h2>
                        </div>

                        <!-- Address -->
                        <div class="mb-6 group/item">
                            <div class="flex items-start mb-3">
                                <div
                                    class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-emerald-500/30 transition-colors">
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-white/90 mb-1">
                                        <?php echo esc_html($labels['address']); ?></p>
                                    <div
                                        class="pl-2 border-l-2 border-emerald-400/30 group-hover/item:border-emerald-400/50 transition-colors">
                                        <p class="text-white/80">
                                            <?php echo esc_html($contact_data['address']['street']); ?></p>
                                        <p class="text-white/80">
                                            <?php echo esc_html($contact_data['address']['city']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-6 group/item">
                            <div class="flex items-start mb-3">
                                <div
                                    class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-emerald-500/30 transition-colors">
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-white/90 mb-1">
                                        <?php echo esc_html($labels['phone']); ?></p>
                                    <div
                                        class="pl-2 border-l-2 border-emerald-400/30 group-hover/item:border-emerald-400/50 transition-colors">
                                        <a href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"
                                            class="text-emerald-300 hover:text-emerald-200 transition-colors font-medium">
                                            <?php echo esc_html($contact_data['phone']['display']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-8 group/item">
                            <div class="flex items-start mb-3">
                                <div
                                    class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-emerald-500/30 transition-colors">
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-white/90 mb-1">
                                        <?php echo esc_html($labels['email']); ?></p>
                                    <div
                                        class="pl-2 border-l-2 border-emerald-400/30 group-hover/item:border-emerald-400/50 transition-colors">
                                        <a href="mailto:<?php echo esc_attr($contact_data['email']); ?>"
                                            class="text-emerald-300 hover:text-emerald-200 transition-colors font-medium">
                                            <?php echo esc_html($contact_data['email']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Languages -->
                        <div class="group/item">
                            <div class="flex items-start">
                                <div
                                    class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-emerald-500/30 transition-colors">
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-white/90 mb-1">
                                        <?php echo esc_html($labels['languages']); ?></p>
                                    <div
                                        class="pl-2 border-l-2 border-emerald-400/30 group-hover/item:border-emerald-400/50 transition-colors">
                                        <p class="text-white/80"><?php echo esc_html($contact_data['languages']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Opening Hours -->
                <div class="group">
                    <div
                        class="backdrop-blur-xl bg-white/5 border border-white/20 rounded-3xl p-8 shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 hover:scale-105 hover:bg-white/10 h-full">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3
                                class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white via-blue-100 to-indigo-100 bg-clip-text text-transparent">
                                <?php echo esc_html($labels['title']); ?>
                            </h3>
                        </div>

                        <div class="space-y-2">
                            <div
                                class="flex items-center justify-between py-2 px-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="flex items-center pr-2">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></div>
                                    <span
                                        class="text-white/70 text-sm"><?php echo esc_html($labels['monday']); ?></span>
                                </div>
                                <span
                                    class="text-white/90 text-sm font-medium"><?php echo esc_html($contact_data['opening_hours']['monday']); ?></span>
                            </div>

                            <div
                                class="flex items-center justify-between py-2 px-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                    <span
                                        class="text-white/70 text-sm"><?php echo esc_html($labels['tuesday']); ?></span>
                                </div>
                                <span
                                    class="text-white/90 text-sm font-medium"><?php echo esc_html($contact_data['opening_hours']['tuesday']); ?></span>
                            </div>

                            <div
                                class="flex items-center justify-between py-2 px-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                                    <span
                                        class="text-white/70 text-sm"><?php echo esc_html($labels['wednesday']); ?></span>
                                </div>
                                <span
                                    class="text-white/90 text-sm font-medium"><?php echo esc_html($contact_data['opening_hours']['wednesday']); ?></span>
                            </div>

                            <div
                                class="flex items-center justify-between py-2 px-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-orange-400 rounded-full mr-2"></div>
                                    <span
                                        class="text-white/70 text-sm"><?php echo esc_html($labels['thursday']); ?></span>
                                </div>
                                <span
                                    class="text-white/90 text-sm font-medium"><?php echo esc_html($contact_data['opening_hours']['thursday']); ?></span>
                            </div>

                            <div
                                class="flex items-center justify-between py-2 px-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                    <span
                                        class="text-white/70 text-sm"><?php echo esc_html($labels['friday']); ?></span>
                                </div>
                                <span
                                    class="text-white/90 text-sm font-medium"><?php echo esc_html($contact_data['opening_hours']['friday']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Google Maps -->
                <div class="group">
                    <?php if ($contact_data['maps']['show']): ?>
                        <?php
                        // Generate dynamic Google Maps URL based on current address
                        $google_maps_url = le_custom_generate_google_maps_url();
                        ?>
                        <div
                            class="backdrop-blur-xl bg-white/5 border border-white/20 rounded-3xl p-4 shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 hover:scale-105 hover:bg-white/10 h-full">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-red-400 to-pink-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">Location</h3>
                            </div>
                            <div class="relative overflow-hidden rounded-2xl">
                                <iframe src="<?php echo esc_url($google_maps_url); ?>" width="100%" height="300"
                                    style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    <?php else: ?>
                        <div
                            class="backdrop-blur-xl bg-white/5 border border-white/20 rounded-3xl p-8 shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 hover:scale-105 hover:bg-white/10 h-full flex items-center justify-center">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-red-400 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-white/80 text-lg">
                                    <?php echo esc_html($current_language === 'en' ? 'Google Maps will be displayed here' : 'Google Maps wird hier angezeigt'); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Navigation Section -->
            <div class="group">
                <div
                    class="backdrop-blur-xl bg-white/5 border border-white/20 rounded-3xl p-8 shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 hover:scale-105 hover:bg-white/10">
                    <div class="flex items-center mb-8">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </div>
                        <h3
                            class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white via-indigo-100 to-purple-100 bg-clip-text text-transparent">
                            <?php echo esc_html($labels['navigation']); ?>
                        </h3>
                    </div>

                    <nav class="relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-emerald-400/10 to-transparent rounded-2xl blur-2xl">
                        </div>
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
    <div class="relative z-10 border-t border-white/10">
        <div class="max-w-7xl mx-auto py-6 px-4 md:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-white/60 text-sm mb-4 md:mb-0">
                    © <?php echo date('Y'); ?> <?php echo esc_html($contact_data['practice_name']); ?>.
                </div>
                <!-- <div class="flex items-center space-x-6">
                    <a href="#" class="text-white/60 hover:text-emerald-300 transition-colors">
                        <span class="sr-only">Privacy Policy</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-white/60 hover:text-emerald-300 transition-colors">
                        <span class="sr-only">Terms of Service</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div> -->
            </div>
        </div>
    </div>
</footer>