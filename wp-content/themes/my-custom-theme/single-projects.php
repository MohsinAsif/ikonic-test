<?php get_header(); ?>

<main class="single-project">
    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="project-header">
                    <h1 class="project-title"><?php the_title(); ?></h1>
                </header>

                <?php if (has_post_thumbnail()): ?>
                    <div class="project-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <!-- Back to Projects Button -->
                <div class="back-to-projects">
                    <a href="<?php echo get_post_type_archive_link('projects'); ?>" class="back-button">Back to Projects</a>
                </div>

                <div class="project-details">
                    <!-- Project Name -->
                    <p><strong>Project Name:</strong> <?php echo esc_html(get_field('project_name')); ?></p>

                    <!-- Project Description -->
                    <p><strong>Project Description:</strong> <?php echo esc_html(get_field('project_description')); ?></p>

                    <!-- Start Date -->
                    <?php
                    $start_date = get_field('project_start_date');
                    if ($start_date) {
                        echo '<p><strong>Start Date:</strong> ' . date('F j, Y', strtotime($start_date)) . '</p>';
                    } else {
                        echo '<p><strong>Start Date:</strong> Not available</p>';
                    }
                    ?>

                    <!-- End Date -->
                    <?php
                    $end_date = get_field('project_end_date');
                    if ($end_date) {
                        echo '<p><strong>End Date:</strong> ' . date('F j, Y', strtotime($end_date)) . '</p>';
                    } else {
                        echo '<p><strong>End Date:</strong> Not available</p>';
                    }
                    ?>

                    <!-- Project URL -->
                    <p><strong>Project URL:</strong> <a href="<?php echo esc_url(get_field('project_url')); ?>"
                            target="_blank"><?php echo esc_html(get_field('project_url')); ?></a></p>
                </div>

                <div class="project-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; else: ?>
        <p><?php _e('No project found.', 'my-custom-theme'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>