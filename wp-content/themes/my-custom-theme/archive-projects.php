<?php get_header(); ?>

<main class="archive-projects">
    <header class="archive-header">
        <h1><?php post_type_archive_title(); ?></h1>
    </header>
    <form method="GET" class="project-filter-form">
    <label for="start_date" style="font-size: 13px;font-weight: bold;">Start Date:</label>
    <input type="date" name="start_date" id="start_date" style="max-width: 300px;" value="<?php echo esc_attr($_GET['start_date'] ?? ''); ?>">

    <label for="end_date" style="font-size: 13px;font-weight: bold;">End Date:</label>
    <input type="date" name="end_date" id="end_date" style="max-width: 300px;" value="<?php echo esc_attr($_GET['end_date'] ?? ''); ?>">

    <button type="submit" style="font-size: 13px;margin-bottom: 10px;">Filter</button>
</form>

    <?php if (have_posts()): ?>
        <div class="project-list">
            <?php while (have_posts()):
                the_post(); ?>
                <article class="project-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="project-thumbnail">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                        <h2 class="project-title"><?php the_title(); ?></h2>
                    </a>
                    <p class="project-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </article>
            <?php endwhile; ?>
        </div>
        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else: ?>
        <p><?php _e('No projects found.', 'my-custom-theme'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>