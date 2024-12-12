<?php
/* Template Name: Home Page */
get_header();
?>
<main>
    <h1>Welcome to the Home Page</h1>
    <p>This is the custom home page template.</p>
    <!-- Link to Projects Page -->
    <p>
        <a href="<?php echo esc_url(get_post_type_archive_link('projects')); ?>">
            View All Projects
        </a>
    </p>
</main>

<?php get_footer(); ?>