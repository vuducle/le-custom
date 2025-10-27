<?php get_header(); ?>

<main class="min-h-screen bg-gray-50">
    <div class="container mx-auto py-8">
        <?php if (have_posts()) : ?>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php while (have_posts()) : the_post(); ?>
            <article
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <?php if (has_post_thumbnail()) : ?>
                <div class="aspect-video">
                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                </div>
                <?php endif; ?>

                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors duration-200">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <div class="text-sm text-gray-500 mb-3">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                        <span class="mx-2">•</span>
                        <span><?php echo get_the_author(); ?></span>
                    </div>

                    <div class="text-gray-700 mb-4">
                        <?php the_excerpt(); ?>
                    </div>

                    <a href="<?php the_permalink(); ?>"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                        Read More
                    </a>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <div class="mt-8 flex justify-center">
            <?php
                echo paginate_links([
                    'prev_text' => '<span class="px-4 py-2 bg-gray-200 text-gray-700 rounded-l-md hover:bg-gray-300">← Previous</span>',
                    'next_text' => '<span class="px-4 py-2 bg-gray-200 text-gray-700 rounded-r-md hover:bg-gray-300">Next →</span>',
                    'class' => 'flex space-x-1'
                ]);
                ?>
        </div>
        <?php else : ?>
        <div class="text-center py-12">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">No posts found</h2>
            <p class="text-gray-600">It looks like there are no posts yet.</p>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>