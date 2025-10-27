<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="author" content="Vu Minh Le, Vu Duc Le, Armin Dorri, Denis Kunz">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- Minh denkt sehr viel an sein Waifu Chi -->
    <!-- Modern 2025 Header Design -->
    <header
        class="relative bg-white/95 backdrop-blur-md shadow-lg shadow-gray-200/50 sticky top-0 z-50 border-b border-gray-100">
        <!-- Enhanced Contact Information Bar -->
        <?php get_template_part('template-parts/contact-info'); ?>

        <!-- Main Navigation with Modern Design -->
        <div class="container mx-auto px-4 lg:px-8">
            <nav class="flex items-center justify-between py-4 lg:py-6">
                <!-- Enhanced Logo Section -->
                <div class="flex items-center">
                    <?php get_template_part('template-parts/header/logo'); ?>

                    <!-- Trust Indicators for Patients -->
                    <!-- <div class="hidden lg:flex items-center ml-8 space-x-4">
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Familienfreundlich</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Termine online</span>
                        </div>
                    </div> -->
                </div>

                <!-- Desktop Navigation -->
                <?php get_template_part('template-parts/header/desktop-navigation'); ?>

                <!-- Enhanced Language Switcher and Mobile Menu -->
                <div class="flex items-center space-x-4 lg:space-x-6">
                    <!-- Modern Language Switcher -->
                    <div class="hidden sm:flex items-center bg-gray-50 rounded-full p-1 language-switcher">
                        <?php
                        // Get current language from URL or set default
                        $current_lang = 'de'; // Default to German
                        $current_url = $_SERVER['REQUEST_URI'] ?? '';
                        if (strpos($current_url, '/en/') !== false) {
                            $current_lang = 'en';
                        }
                        ?>

                        <!-- German Language -->
                        <a href="<?php echo home_url('/de/'); ?>"
                            class="flex items-center space-x-2 px-4 py-2 rounded-full transition-all duration-300 text-sm font-medium <?php echo $current_lang === 'de' ? 'active bg-white text-gray-900 shadow-sm active-language' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50'; ?>">
                            <div class="w-4 h-3 rounded-sm overflow-hidden flex-shrink-0 shadow-sm">
                                <svg viewBox="0 0 640 480" class="w-full h-full">
                                    <path fill="#ffce00" d="M0 320h640v160H0z" />
                                    <path d="M0 0h640v160H0z" />
                                    <path fill="#d00" d="M0 160h640v160H0z" />
                                </svg>
                            </div>
                            <span>DE</span>
                        </a>

                        <!-- English Language -->
                        <a href="<?php echo home_url('/en/'); ?>"
                            class="flex items-center space-x-2 px-4 py-2 rounded-full transition-all duration-300 text-sm font-medium <?php echo $current_lang === 'en' ? 'active bg-white text-gray-900 shadow-sm active-language' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50'; ?>">
                            <div class="w-4 h-3 rounded-sm overflow-hidden flex-shrink-0 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 30" class="w-full h-full">
                                    <clipPath id="t">
                                        <path d="M25,15h25v15zv15h-25zh-25v-15zv-15h25z" />
                                    </clipPath>
                                    <path d="M0,0v30h50v-30z" fill="#012169" />
                                    <path d="M0,0 50,30M50,0 0,30" stroke="#fff" stroke-width="6" />
                                    <path d="M0,0 50,30M50,0 0,30" clip-path="url(#t)" stroke="#C8102E"
                                        stroke-width="4" />
                                    <path d="M-1 11h22v-12h8v12h22v8h-22v12h-8v-12h-22z" fill="#C8102E" stroke="#FFF"
                                        stroke-width="2" />
                                </svg>
                            </div>
                            <span>EN</span>
                        </a>
                    </div>

                    <!-- Link Component -->
                    <?php get_template_part('template-parts/header/link-component'); ?>

                    <!-- Mobile Navigation -->
                    <?php get_template_part('template-parts/header/mobile-navigation'); ?>
                </div>
            </nav>
        </div>

        <!-- Subtle gradient overlay for modern feel -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent pointer-events-none">
        </div>
    </header>