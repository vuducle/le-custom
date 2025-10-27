<?php

/**
 * Mobile Navigation Template Part
 * 
 * Displays the primary navigation menu for mobile devices
 */

// Get customizer colors
$color_scheme = le_custom_get_color_scheme_data();

// Get contact data for opening hours
$contact_data = le_custom_get_contact_data();
?>

<!-- Mobile menu button -->
<button
    class="lg:hidden p-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-gray-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
    id="mobile-menu-button" aria-label="Toggle mobile menu">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Mobile menu -->
<div class="lg:hidden fixed inset-0 z-50 hidden" id="mobile-menu">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-md" id="mobile-menu-backdrop"></div>

    <!-- Menu content -->
    <div class="fixed top-0 right-0 h-screen w-80 max-w-[85vw] bg-white/95 backdrop-blur-lg shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out border-l border-gray-200 flex flex-col"
        id="mobile-menu-content">
        <!-- Header with close button -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100"
            style="background: linear-gradient(135deg, <?php echo esc_attr($color_scheme['primary_light']); ?> 0%, <?php echo esc_attr($color_scheme['secondary_light']); ?> 100%);">
            <h3 class="text-lg font-semibold text-gray-900">Menu</h3>
            <button
                class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-white/50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                id="mobile-menu-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Language switcher for mobile -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <?php
            // Get current language from URL or set default
            $current_lang = 'de'; // Default to German
            $current_url = $_SERVER['REQUEST_URI'] ?? '';
            if (strpos($current_url, '/en/') !== false || strpos($current_url, '-en') !== false) {
                $current_lang = 'en';
            }

            // Get the current page path without language prefix
            $current_path = $current_url;
            if (strpos($current_path, '/en/') !== false) {
                $current_path = str_replace('/en/', '/de/', $current_path);
            } elseif (strpos($current_path, '/de/') !== false) {
                $current_path = str_replace('/de/', '/en/', $current_path);
            } elseif (strpos($current_path, '-en') !== false) {
                $current_path = str_replace('-en', '-de', $current_path);
            } elseif (strpos($current_path, '-de') !== false) {
                $current_path = str_replace('-de', '-en', $current_path);
            } else {
                // If no language prefix, add appropriate one
                if ($current_lang === 'en') {
                    $current_path = str_replace(home_url(), home_url('/en'), $current_path);
                } else {
                    $current_path = str_replace(home_url(), home_url('/de'), $current_path);
                }
            }

            // Create language URLs
            $german_url = home_url('/de/');
            $english_url = home_url('/en/');

            // If we're on a specific page, try to maintain the page structure
            if ($current_path !== $current_url) {
                $german_url = $current_lang === 'en' ? $current_path : home_url('/de/');
                $english_url = $current_lang === 'de' ? $current_path : home_url('/en/');
            }
            ?>
            <div class="flex items-center space-x-4">
                <span
                    class="text-sm font-medium text-gray-700"><?php echo $current_lang === 'en' ? 'Language:' : 'Sprache:'; ?></span>
                <div class="flex items-center space-x-3">
                    <!-- German Language -->
                    <a href="<?php echo esc_url($german_url); ?>"
                        class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-all duration-200 <?php echo $current_lang === 'de' ? 'bg-white text-gray-900 shadow-sm border border-gray-200 active-language' : 'text-gray-700 hover:text-gray-900 hover:bg-white/70'; ?>">
                        <div class="w-5 h-4 rounded-sm overflow-hidden flex-shrink-0 shadow-sm">
                            <svg viewBox="0 0 640 480" class="w-full h-full">
                                <path fill="#ffce00" d="M0 320h640v160H0z" />
                                <path d="M0 0h640v160H0z" />
                                <path fill="#d00" d="M0 160h640v160H0z" />
                            </svg>
                        </div>
                        <span class="font-medium">DE</span>
                    </a>

                    <!-- English Language -->
                    <a href="<?php echo esc_url($english_url); ?>"
                        class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-all duration-200 <?php echo $current_lang === 'en' ? 'bg-white text-gray-900 shadow-sm border border-gray-200 active-language' : 'text-gray-700 hover:text-gray-900 hover:bg-white/70'; ?>">
                        <div class="w-5 h-4 rounded-sm overflow-hidden flex-shrink-0 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 30" class="w-full h-full">
                                <clipPath id="t">
                                    <path d="M25,15h25v15zv15h-25zh-25v-15zv-15h25z" />
                                </clipPath>
                                <path d="M0,0v30h50v-30z" fill="#012169" />
                                <path d="M0,0 50,30M50,0 0,30" stroke="#fff" stroke-width="6" />
                                <path d="M0,0 50,30M50,0 0,30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4" />
                                <path d="M-1 11h22v-12h8v12h22v8h-22v12h-8v-12h-22z" fill="#C8102E" stroke="#FFF"
                                    stroke-width="2" />
                            </svg>
                        </div>
                        <span class="font-medium">EN</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Menu items -->
        <div class="py-4 overflow-y-auto flex-1 bg-white">
            <?php
            $nav_location = le_custom_get_navigation_menu('primary');
            if ($nav_location) {
                wp_nav_menu([
                    'theme_location' => $nav_location,
                    'menu_class' => 'space-y-1 px-4',
                    'container' => false,
                    'fallback_cb' => false,
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'walker' => new class extends Walker_Nav_Menu {
                        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                        {
                            $classes = empty($item->classes) ? array() : (array) $item->classes;
                            $classes[] = 'menu-item-' . $item->ID;

                            if (in_array('current-menu-item', $classes)) {
                                $classes[] = 'active';
                            }

                            if (in_array('menu-item-has-children', $classes)) {
                                $classes[] = 'has-children';
                            }

                            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
                            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

                            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
                            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

                            $output .= '<li' . $id . $class_names . '>';

                            $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
                            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
                            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
                            $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

                            $item_output = $args->before;

                            // Check if item has children
                            if (in_array('menu-item-has-children', $classes)) {
                                // Just show the main item as a regular link, submenu will be shown below
                                $item_output .= '<a' . $attributes . ' class="block py-3 px-4 text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 rounded-lg font-medium">';
                                $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
                                $item_output .= '</a>';
                            } else {
                                $item_output .= '<a' . $attributes . ' class="block py-3 px-4 text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 rounded-lg font-medium">';
                                $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
                                $item_output .= '</a>';
                            }

                            $item_output .= $args->after;

                            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
                        }

                        public function start_lvl(&$output, $depth = 0, $args = null)
                        {
                            $indent = str_repeat("\t", $depth);
                            $output .= "\n$indent<ul class=\"ml-4 mt-2 space-y-1 border-l-2 border-blue-200 pl-4\">\n";
                        }

                        public function end_lvl(&$output, $depth = 0, $args = null)
                        {
                            $indent = str_repeat("\t", $depth);
                            $output .= "$indent</ul>\n";
                        }

                        public function end_el(&$output, $item, $depth = 0, $args = null)
                        {
                            $output .= "</li>\n";
                        }
                    }
                ]);
            }
            ?>

            <!-- Link Component for Mobile -->
            <?php
            $link_data = le_custom_get_link_component_data();
            if ($link_data['show'] && !empty($link_data['url'])) :
            ?>
                <div class="px-4 pt-4 border-t border-gray-100">
                    <a href="<?php echo esc_url($link_data['url']); ?>" target="_blank" rel="noopener noreferrer"
                        class="w-full flex items-center justify-center px-6 py-4 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg appointment-cta">
                        <?php
                        // Get icon SVG based on selection
                        switch ($link_data['icon']) {
                            case 'phone':
                                echo '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>';
                                break;
                            case 'external':
                                echo '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>';
                                break;
                            case 'heart':
                                echo '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>';
                                break;
                            case 'star':
                                echo '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>';
                                break;
                            case 'calendar':
                            default:
                                echo '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>';
                                break;
                        }
                        ?>
                        <span><?php echo esc_html($link_data['text']); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>