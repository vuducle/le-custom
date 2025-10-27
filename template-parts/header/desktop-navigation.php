<?php

/**
 * Desktop Navigation Template Part
 * 
 * Displays the primary navigation menu for desktop devices
 */
?>

<div class="hidden lg:flex items-center space-x-6">
    <?php
    $nav_location = le_custom_get_navigation_menu('primary');
    if ($nav_location) {
        wp_nav_menu([
            'theme_location' => $nav_location,
            'menu_class' => 'flex items-center space-x-6',
            'container' => false,
            'fallback_cb' => false,
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'walker' => new class extends Walker_Nav_Menu {
                public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                {
                    $classes = empty($item->classes) ? array() : (array) $item->classes;
                    $classes[] = 'menu-item-' . $item->ID;

                    // Add active class
                    if (in_array('current-menu-item', $classes)) {
                        $classes[] = 'active';
                    }

                    // Add has-children class if item has children
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

                    // Base classes for all nav items
                    $link_classes = 'nav-link px-6 py-3 text-gray-700 font-medium hover:text-blue-600 hover:bg-gray-50 rounded-lg transition-all duration-200 relative group';

                    // Add active state styling
                    if (in_array('current-menu-item', $classes)) {
                        $link_classes .= ' text-blue-600 bg-blue-50';
                    }

                    $item_output .= '<a' . $attributes . ' class="' . $link_classes . '">';
                    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

                    // Add dropdown arrow for items with children
                    if (in_array('menu-item-has-children', $classes)) {
                        $item_output .= '<svg class="inline-block w-4 h-4 ml-2 transform group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                        $item_output .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
                        $item_output .= '</svg>';
                    }

                    $item_output .= '</a>';
                    $item_output .= $args->after;

                    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
                }

                public function start_lvl(&$output, $depth = 0, $args = null)
                {
                    $indent = str_repeat("\t", $depth);
                    $submenu_class = ($depth > 0) ? 'sub-submenu' : 'submenu';
                    $output .= "\n$indent<ul class=\"$submenu_class absolute left-0 top-full bg-white shadow-xl border border-gray-100 rounded-xl py-3 min-w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50 backdrop-blur-sm\">\n";
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
</div>