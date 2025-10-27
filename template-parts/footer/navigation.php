<?php

/**
 * Template part for footer navigation section
 */
?>
<div class="footer-navigation">
    <div class="navigation-links">
        <?php
        // Get the appropriate footer menu location based on current language
        $footer_menu_location = le_custom_get_navigation_menu('footer');

        wp_nav_menu([
            'theme_location' => $footer_menu_location ?: 'footer',
            'menu_class' => 'space-y-2',
            'container' => false,
            'fallback_cb' => 'le_custom_footer_menu_fallback',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'walker' => new class extends Walker_Nav_Menu {
                public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                {
                    $output .= '<li class="' . implode(' ', $item->classes) . '">';
                    $output .= '<a href="' . $item->url . '" class="block text-white hover:text-gray-300 transition-colors">' . $item->title . '</a>';
                }
            }
        ]);
        ?>
    </div>
</div>