<?php

/**
 * Template Name: Contact Form - English
 * 
 * Custom page template for English contact form
 */

// Get meta description and structured data
$meta_description = le_custom_get_meta_description();
$contact_data = le_custom_get_contact_data();

// Add SEO meta tags
add_action('wp_head', function () use ($meta_description, $contact_data) {
    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:title" content="Contact - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:locale" content="en_US" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="Contact - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '" />' . "\n";
});

// Output structured data
le_custom_output_subpage_structured_data();

get_header();

// Get customizer colors
$color_scheme = le_custom_get_color_scheme_data();
$contact_data = le_custom_get_contact_data();
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 lg:py-20">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12 lg:mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Contact Us
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Have questions or want to schedule an appointment? We're here to help.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 max-w-7xl mx-auto">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Send Message</h2>

                <form id="contact-form-en" class="space-y-6">
                    <input type="hidden" name="language" value="en">
                    <!-- Name Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700 mb-2">
                                First Name *
                            </label>
                            <input type="text" id="first-name" name="first_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700 mb-2">
                                Last Name *
                            </label>
                            <input type="text" id="last-name" name="last_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>

                    <!-- Email and Phone -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email *
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone
                            </label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subject *
                        </label>
                        <select id="subject" name="subject" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">Please select a subject</option>
                            <option value="appointment">Appointment Booking</option>
                            <option value="question">General Question</option>
                            <option value="emergency">Emergency</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message *
                        </label>
                        <textarea id="message" name="message" rows="6" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                            placeholder="Please describe your inquiry..."></textarea>
                    </div>

                    <!-- Privacy Policy -->
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="privacy" name="privacy" required
                            class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="privacy" class="text-sm text-gray-600">
                            I agree to the <a href="/privacy-policy" class="text-blue-600 hover:text-blue-700 underline">Privacy Policy</a>. *
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <span>Send Message</span>
                        </span>
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Practice Info -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Our Practice</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Address</h4>
                                <p class="text-gray-600"><?php echo esc_html($contact_data['address']['street']); ?><br><?php echo esc_html($contact_data['address']['city']); ?></p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Phone</h4>
                                <a href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>" class="text-blue-600 hover:text-blue-700">
                                    <?php echo esc_html($contact_data['phone']['display']); ?>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Email</h4>
                                <a href="mailto:<?php echo esc_attr($contact_data['email']); ?>" class="text-blue-600 hover:text-blue-700">
                                    <?php echo esc_html($contact_data['email']); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Opening Hours -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Opening Hours</h3>
                    <div class="space-y-3">
                        <?php if (!empty($contact_data['opening_hours']['monday'])) : ?>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">Monday</span>
                                <span class="text-gray-600"><?php echo esc_html($contact_data['opening_hours']['monday']); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact_data['opening_hours']['tuesday'])) : ?>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">Tuesday</span>
                                <span class="text-gray-600"><?php echo esc_html($contact_data['opening_hours']['tuesday']); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact_data['opening_hours']['wednesday'])) : ?>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">Wednesday</span>
                                <span class="text-gray-600"><?php echo esc_html($contact_data['opening_hours']['wednesday']); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact_data['opening_hours']['thursday'])) : ?>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">Thursday</span>
                                <span class="text-gray-600"><?php echo esc_html($contact_data['opening_hours']['thursday']); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact_data['opening_hours']['friday'])) : ?>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">Friday</span>
                                <span class="text-gray-600"><?php echo esc_html($contact_data['opening_hours']['friday']); ?></span>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-900 mb-2">Emergency?</h4>
                            <p class="text-red-700 text-sm mb-3">
                                For tooth pain or emergencies, please call us immediately.
                            </p>
                            <a href="tel:<?php echo esc_attr($contact_data['phone']['link']); ?>"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Call Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>