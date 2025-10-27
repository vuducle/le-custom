<?php get_header(); ?>

<main class="min-h-screen bg-gray-50">
    <div class="container mx-auto py-8">
        <?php while (have_posts()) : the_post(); ?>
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="aspect-video">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                <?php endif; ?>

                <div class="p-8">
                    <header class="mb-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            <?php the_title(); ?>
                        </h1>

                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                            <span>•</span>
                            <span><?php echo get_the_author(); ?></span>
                            <?php if (has_category()) : ?>
                                <span>•</span>
                                <span><?php the_category(', '); ?></span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <div class="prose prose-lg max-w-none text-gray-700">
                        <?php the_content(); ?>
                    </div>

                    <?php if (has_tag()) : ?>
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags:</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php
                                $tags = get_the_tags();
                                foreach ($tags as $tag) : ?>
                                    <a href="<?php echo get_tag_link($tag->term_id); ?>"
                                        class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200 transition-colors duration-200">
                                        <?php echo $tag->name; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Navigation -->
            <nav class="mt-8 flex justify-between">
                <div class="flex-1">
                    <?php
                    $prev_post = get_previous_post();
                    if ($prev_post) : ?>
                        <a href="<?php echo get_permalink($prev_post); ?>"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous Post
                        </a>
                    <?php endif; ?>
                </div>

                <div class="flex-1 text-right">
                    <?php
                    $next_post = get_next_post();
                    if ($next_post) : ?>
                        <a href="<?php echo get_permalink($next_post); ?>"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            Next Post
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>

            <!-- Comments -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>