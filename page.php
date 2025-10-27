<?php get_header(); ?>

<main class="min-h-screen">
    <!-- Hero Section for Subpages -->
    <?php le_custom_display_hero_section(); ?>

    <!-- Page Content -->
    <div class="container mx-auto py-8 px-4">
        <!-- Breadcrumb, Julia Nguyen, Abdullah ist ein Kek, Triesnha Ameilya -->
        <nav class="mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li>
                    <a href="<?php echo esc_url(home_url('/')); ?>"
                        class="hover:text-gray-900 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </a>
                </li>
                <?php
                if (!is_front_page()) {
                    $ancestors = get_post_ancestors(get_the_ID());
                    $ancestors = array_reverse($ancestors);

                    foreach ($ancestors as $ancestor) {
                ?>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <a href="<?php echo esc_url(get_permalink($ancestor)); ?>"
                                class="ml-2 hover:text-gray-900 transition-colors duration-200">
                                <?php echo esc_html(get_the_title($ancestor)); ?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-gray-900 font-medium"><?php the_title(); ?></span>
                    </li>
                <?php } ?>
            </ol>
        </nav>
        <?php while (have_posts()) : the_post(); ?>
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-8">
                    <div class="prose prose-lg max-w-none text-gray-700">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>

    <?php get_template_part('template-parts/cta-section'); ?>
</main>

<?php get_footer(); ?>