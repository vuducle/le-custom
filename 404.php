<?php get_header(); ?>

<main class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="container mx-auto text-center py-12">
        <div class="max-w-md mx-auto">
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
            <p class="text-gray-600 mb-8">
                The page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
            </p>

            <div class="space-y-4">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors duration-200">
                    Go Home
                </a>

                <div class="text-sm text-gray-500">
                    <p>Or try searching for what you're looking for:</p>
                </div>

                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>