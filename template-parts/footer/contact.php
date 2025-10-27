<?php

/**
 * Template part for footer contact section
 */
?>
<div class="footer-contact">
    <div class="contact-info space-y-3">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                </path>
            </svg>
            <span class="text-white"><?php echo get_theme_mod('footer_phone', '+49 123 456 789'); ?></span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                </path>
            </svg>
            <a href="mailto:<?php echo get_theme_mod('footer_email', 'test@test.de'); ?>"
                class="text-white underline hover:text-gray-300 transition-colors">
                <?php echo get_theme_mod('footer_email', 'test@test.de'); ?>
            </a>
        </div>
    </div>
</div>