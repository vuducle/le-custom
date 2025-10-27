<?php

/**
 * Header Logo Template Part
 * 
 * Displays the site logo or site name as a fallback
 */

// Get customizer colors
$color_scheme = le_custom_get_color_scheme_data();
?>

<div class="flex items-center">
    <?php if (has_custom_logo()) : ?>
        <div class="flex items-center space-x-3">
            <div class="mr-2 lg:mr-3">
                <?php the_custom_logo(); ?>
            </div>
            <!-- Company name next to custom logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>"
                class="group text-lg lg:text-xl font-bold transition-all duration-300 hover:scale-105">
                <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent group-hover:from-emerald-600 group-hover:to-emerald-800 transition-all duration-300">
                    <?php bloginfo('name'); ?>
                </span>
            </a>
        </div>
    <?php else : ?>
        <a href="<?php echo esc_url(home_url('/')); ?>"
            class="group flex items-center space-x-3 text-xl lg:text-2xl font-bold transition-all duration-300 hover:scale-105">
            <!-- Modern logo icon -->
            <div class="logo-icon flex items-center justify-center w-10 h-10 rounded-xl transition-all duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <!-- Site name with gradient text -->
            <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent group-hover:from-emerald-600 group-hover:to-emerald-800 transition-all duration-300">
                <?php bloginfo('name'); ?>
            </span>
        </a>
    <?php endif; ?>
</div>