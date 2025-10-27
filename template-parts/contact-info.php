<?php

/**
 * Contact Information Template Part
 * 
 * This template part displays the contact information bar
 * and can be selectively refreshed via the WordPress Customizer
 */

// Get contact data using the centralized function
$contact_data = le_custom_get_contact_data();

// Don't display if contact bar is hidden
if (!$contact_data['contact_bar']['show']) {
    return;
}

// Get customizer colors
$color_scheme = le_custom_get_color_scheme_data();
?>

<div class="contact-info-bar relative overflow-hidden"
    style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary_light']); ?> 0%, <?php echo esc_attr($color_scheme['secondary_light']); ?> 100%);">

    <!-- Modern background pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 1px 1px, <?php echo esc_attr($color_scheme['primary']); ?> 1px, transparent 0); background-size: 20px 20px;">
        </div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex justify-between items-center py-3 text-sm">
            <!-- Contact Information -->
            <div class="flex flex-col md:flex-row md:items-center md:space-x-6 text-gray-700">
                <?php if (!empty($contact_data['address']['street'])) : ?>
                    <div class="flex items-center space-x-2 mb-2 md:mb-0">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">
                            <?php echo esc_html($contact_data['address']['street'] . ', ' . $contact_data['address']['city']); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($contact_data['phone']['display']) && !empty($contact_data['phone']['link'])) : ?>
                    <a href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"
                        class="flex items-center space-x-2 hover:text-<?php echo esc_attr($color_scheme['primary']); ?> transition-all duration-300 group">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-<?php echo esc_attr($color_scheme['primary']); ?> transition-colors duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span class="font-medium"><?php echo esc_html($contact_data['phone']['display']); ?></span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($contact_data['email'])) : ?>
                    <a href="mailto:<?php echo esc_attr($contact_data['email']); ?>"
                        class="flex items-center space-x-2 hover:text-<?php echo esc_attr($color_scheme['primary']); ?> transition-all duration-300 group">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-<?php echo esc_attr($color_scheme['primary']); ?> transition-colors duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="font-medium"><?php echo esc_html($contact_data['email']); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Quick Actions for Patients -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Opening hours removed -->
            </div>
        </div>
    </div>
</div>