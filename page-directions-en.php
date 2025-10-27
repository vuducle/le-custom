<?php

/**
 * Template Name: Directions - English
 * 
 * Custom page template for English directions with Google Maps
 */

// Get meta description and structured data
$meta_description = le_custom_get_meta_description();
$contact_data = le_custom_get_contact_data();

// Add SEO meta tags
add_action('wp_head', function () use ($meta_description, $contact_data) {
    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:title" content="Directions - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
    echo '<meta property="og:type" content="website" />' . "\n";
    echo '<meta property="og:locale" content="en_US" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="Directions - ' . esc_attr($contact_data['practice_name']) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '" />' . "\n";
});

// Output structured data
le_custom_output_subpage_structured_data();

get_header();

// Get customizer colors and contact data
$color_scheme = le_custom_get_color_scheme_data();
$contact_data = le_custom_get_contact_data();

// Get the full address for Google Maps
$full_address = le_custom_get_formatted_address();
$google_maps_url = 'https://www.google.com/maps/search/' . urlencode($full_address);
$google_maps_directions_url = 'https://www.google.com/maps/dir//' . urlencode($full_address);
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 lg:py-20">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12 lg:mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Directions & Route
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Find your way to our dental practice. We are easily accessible and offer various transportation options.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 max-w-7xl mx-auto">
            <!-- Map and Address Section -->
            <div class="space-y-8">
                <!-- Interactive Map -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Our Location</h2>
                        <p class="text-gray-600">Click on the map for a larger view</p>
                    </div>
                    <div class="relative">
                        <?php if ($contact_data['maps']['show']) : ?>
                            <?php
                            // Generate dynamic Google Maps URL based on current address and Google My Business name
                            $google_maps_url = le_custom_generate_google_maps_url();
                            ?>
                            <iframe
                                src="<?php echo esc_url($google_maps_url); ?>"
                                width="100%"
                                height="400"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full h-96">
                            </iframe>
                        <?php else : ?>
                            <!-- Fallback map placeholder -->
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-gray-500">Loading map...</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <div class="flex flex-wrap gap-4">
                            <a href="<?php echo esc_url($google_maps_url); ?>" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Open in Google Maps
                            </a>
                            <a href="<?php echo esc_url($google_maps_directions_url); ?>" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"></path>
                                </svg>
                                Get Directions
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Address Details -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Our Address</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900"><?php echo esc_html($contact_data['practice_name']); ?></h4>
                                <p class="text-gray-600">
                                    <?php echo esc_html($contact_data['address']['street']); ?><br>
                                    <?php echo esc_html($contact_data['address']['city']); ?><br>
                                    <?php echo esc_html($contact_data['address']['country']); ?>
                                </p>
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
                    </div>
                </div>
            </div>

            <!-- Directions and Transportation -->
            <div class="space-y-8">
                <!-- Route Calculator -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Calculate Route</h2>

                    <form id="route-form" class="space-y-6">
                        <div>
                            <label for="start-address" class="block text-sm font-medium text-gray-700 mb-2">
                                Starting Address *
                            </label>
                            <input type="text" id="start-address" name="start_address" required
                                placeholder="Enter your address..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>

                        <div>
                            <label for="transport-mode" class="block text-sm font-medium text-gray-700 mb-2">
                                Transportation Mode
                            </label>
                            <select id="transport-mode" name="transport_mode"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="driving">Car</option>
                                <option value="walking">Walking</option>
                                <option value="bicycling">Bicycle</option>
                                <option value="transit">Public Transport</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"></path>
                                </svg>
                                <span>Calculate Route</span>
                            </span>
                        </button>
                    </form>

                    <div id="route-result" class="mt-6 hidden">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-medium text-blue-900 mb-2">Route Found</h4>
                            <div id="route-details" class="text-blue-800"></div>
                            <a id="open-in-maps" href="#" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center mt-3 text-blue-600 hover:text-blue-700 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Open in Google Maps
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Transportation Options -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Transportation Options</h3>

                    <div class="space-y-6">
                        <!-- Public Transport -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Public Transportation</h4>
                                <p class="text-gray-600 text-sm mt-1">
                                    We are easily accessible by bus and train. The nearest stops are located in close proximity.
                                </p>
                            </div>
                        </div>

                        <!-- Car -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">By Car</h4>
                                <p class="text-gray-600 text-sm mt-1">
                                    Parking spaces are available nearby. Please observe the parking regulations in the area.
                                </p>
                            </div>
                        </div>

                        <!-- Bicycle -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">By Bicycle</h4>
                                <p class="text-gray-600 text-sm mt-1">
                                    Bicycle parking spaces are available in front of the practice. Please secure your bicycle properly.
                                </p>
                            </div>
                        </div>

                        <!-- Walking -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Walking</h4>
                                <p class="text-gray-600 text-sm mt-1">
                                    The practice is easily accessible on foot and is located in a traffic-calmed zone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accessibility -->
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-blue-900 mb-2">Accessible Access</h4>
                            <p class="text-blue-700 text-sm mb-3">
                                Our practice is wheelchair accessible. An elevator and accessible restrooms are available.
                            </p>
                            <p class="text-blue-700 text-sm">
                                For questions about accessibility, please contact us by phone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const routeForm = document.getElementById('route-form');
        const routeResult = document.getElementById('route-result');
        const routeDetails = document.getElementById('route-details');
        const openInMaps = document.getElementById('open-in-maps');

        routeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const startAddress = document.getElementById('start-address').value;
            const transportMode = document.getElementById('transport-mode').value;
            const destinationAddress = '<?php echo esc_js($full_address); ?>';

            if (!startAddress) {
                alert('Please enter a starting address.');
                return;
            }

            // Create Google Maps directions URL
            const directionsUrl = `https://www.google.com/maps/dir/${encodeURIComponent(startAddress)}/${encodeURIComponent(destinationAddress)}/data=!3m1!4b1!4m2!4m1!3e${transportMode === 'driving' ? '0' : transportMode === 'walking' ? '2' : transportMode === 'bicycling' ? '1' : '3'}`;

            // Show result
            routeDetails.innerHTML = `
            <p><strong>From:</strong> ${startAddress}</p>
            <p><strong>To:</strong> ${destinationAddress}</p>
            <p><strong>Transportation:</strong> ${document.getElementById('transport-mode').options[document.getElementById('transport-mode').selectedIndex].text}</p>
        `;

            openInMaps.href = directionsUrl;
            routeResult.classList.remove('hidden');

            // Scroll to result
            routeResult.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        });
    });
</script>

<?php get_footer(); ?>