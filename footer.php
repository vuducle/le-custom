<?php get_template_part('template-parts/footer/footer'); ?>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>

<?php wp_footer(); ?>
</body>

</html>