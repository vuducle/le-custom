<?php

/**
 * CTA Section Component
 * 
 * A reusable call-to-action section that uses configured colors from the customizer.
 * Can be included in any page using: get_template_part('template-parts/cta-section');
 */

// Get CTA data from customizer
$cta_data = le_custom_get_cta_data();

// Use customizer data or fallback to passed variables
$cta_title = isset($cta_title) ? $cta_title : $cta_data['title'];
$cta_description = isset($cta_description) ? $cta_description : $cta_data['description'];
$cta_primary_button_text = isset($cta_primary_button_text) ? $cta_primary_button_text : $cta_data['primary_button_text'];
$cta_secondary_button_text = isset($cta_secondary_button_text) ? $cta_secondary_button_text : $cta_data['secondary_button_text'];
$cta_primary_button_url = isset($cta_primary_button_url) ? $cta_primary_button_url : $cta_data['primary_button_url'];
$cta_secondary_button_url = isset($cta_secondary_button_url) ? $cta_secondary_button_url : $cta_data['secondary_button_url'];
$cta_section_id = isset($cta_section_id) ? $cta_section_id : $cta_data['section_id'];
$cta_background_color = isset($cta_background_color) ? $cta_background_color : $cta_data['background_color'];

// Check if CTA section should be shown
if (!$cta_data['show']) {
    return;
}
?>

<section id="<?php echo esc_attr($cta_section_id); ?>" class="py-20 relative overflow-hidden"
    style="background-color: <?php echo esc_attr($cta_background_color); ?>">
    <!-- Background Shield Icon -->
    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 opacity-10 pointer-events-none" data-aos="fade-left"
        data-aos-delay="300" data-aos-duration="1000">
        <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" fill="currentColor" viewBox="0 0 256 256"
            class="text-white">
            <path
                d="M171,71.42,149.54,80,171,88.57A8,8,0,1,1,165,103.42L128,88.61,91,103.42A8,8,0,1,1,85,88.57L106.46,80,85,71.42A8,8,0,1,1,91,56.57l37,14.81,37-14.81A8,8,0,1,1,171,71.42Zm53,8.33c0,42.72-8,75.4-14.69,95.28-8.73,25.8-20.63,45.49-32.65,54a15.69,15.69,0,0,1-15.95,1.41,16.09,16.09,0,0,1-9.18-13.36C150.68,205.58,146.48,168,128,168s-22.68,37.59-23.53,49.11a16.09,16.09,0,0,1-16,14.9,15.67,15.67,0,0,1-9.13-2.95c-12-8.53-23.92-28.22-32.65-54C40,155.15,32,122.47,32,79.75A56,56,0,0,1,88,24h80A56,56,0,0,1,224,79.75Zm-16,0A40,40,0,0,0,168,40H88A40,40,0,0,0,48,79.76c0,40.55,7.51,71.4,13.85,90.14,11.05,32.66,23,43.37,26.61,46C91.57,174.67,105.59,152,128,152s36.45,22.71,39.49,63.94h0c3.6-2.59,15.57-13.26,26.66-46C200.49,151.16,208,120.31,208,79.76Z">
            </path>
        </svg>
    </div>
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6" data-aos="fade-up" data-aos-delay="100"
            data-aos-duration="800">
            <?php echo esc_html($cta_title); ?>
        </h2>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200"
            data-aos-duration="800">
            <?php echo esc_html($cta_description); ?>
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400"
            data-aos-duration="800">
            <?php if ($cta_primary_button_text): ?>
                <a href="<?php echo esc_url($cta_primary_button_url); ?>"
                    class="bg-white text-gray-900 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 transform"
                    style="color: <?php echo esc_attr($cta_background_color); ?>;">
                    <?php echo esc_html($cta_primary_button_text); ?>
                </a>
            <?php endif; ?>
            <?php if ($cta_secondary_button_text): ?>
                <a href="<?php echo esc_url($cta_secondary_button_url); ?>"
                    class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 transform"
                    style="border-color: white; color: white;"
                    onmouseover="this.style.color='<?php echo esc_attr($cta_background_color); ?>'"
                    onmouseout="this.style.color='white'">
                    <?php echo esc_html($cta_secondary_button_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>