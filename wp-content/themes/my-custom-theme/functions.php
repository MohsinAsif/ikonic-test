<?php
// Theme setup
function my_custom_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus([
        'primary' => __('Primary Menu', 'my-custom-theme'),
    ]);
}
add_action('after_setup_theme', 'my_custom_theme_setup');

// Enqueue styles and scripts
function my_custom_theme_scripts()
{
    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_script('menu-toggle', get_template_directory_uri() . '/js/menu-toggle.js', [], null, true);
}

add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');

// Register Custom Post Type: Projects
function register_projects_post_type()
{
    $labels = [
        'name' => _x('Projects', 'Post Type General Name', 'my-custom-theme'),
        'singular_name' => _x('Project', 'Post Type Singular Name', 'my-custom-theme'),
        'menu_name' => __('Projects', 'my-custom-theme'),
        'name_admin_bar' => __('Project', 'my-custom-theme'),
        'add_new_item' => __('Add New Project', 'my-custom-theme'),
        'edit_item' => __('Edit Project', 'my-custom-theme'),
        'new_item' => __('New Project', 'my-custom-theme'),
        'view_item' => __('View Project', 'my-custom-theme'),
        'all_items' => __('All Projects', 'my-custom-theme'),
        'search_items' => __('Search Projects', 'my-custom-theme'),
        'not_found' => __('No Projects Found', 'my-custom-theme'),
        'not_found_in_trash' => __('No Projects Found in Trash', 'my-custom-theme'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'show_in_rest' => true, // Enables Gutenberg editor
        'menu_icon' => 'dashicons-portfolio',
    ];

    register_post_type('projects', $args);
}
add_action('init', 'register_projects_post_type');

function register_custom_taxonomy()
{
    $args = array(
        'label' => 'Project Categories',
        'hierarchical' => true,  // Set to true for categories (hierarchical), false for tags
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'project-category'),
    );
    register_taxonomy('project_category', array('projects'), $args);
}
add_action('init', 'register_custom_taxonomy');

function register_projects_api_endpoint()
{
    register_rest_route('custom-api/v1', '/projects', array(
        'methods' => 'GET',
        'callback' => 'get_projects_data',
        'permission_callback' => '__return_true', // Public access
    ));
}
add_action('rest_api_init', 'register_projects_api_endpoint');

function get_projects_data()
{
    $projects = new WP_Query(array(
        'post_type' => 'projects',
        'posts_per_page' => -1, // Retrieve all projects
        'post_status' => 'publish',
    ));

    $response = array();

    if ($projects->have_posts()) {
        while ($projects->have_posts()) {
            $projects->the_post();

            $response[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'start_date' => get_field('project_start_date'), // ACF field
                'end_date' => get_field('project_end_date'),   // ACF field
            );
        }
        wp_reset_postdata();
    }

    return rest_ensure_response($response);
}

function filter_projects_by_date($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('projects')) {
        $meta_query = array('relation' => 'AND');

        // Filter by Start Date
        if (!empty($_GET['start_date'])) {
            $meta_query[] = array(
                'key' => 'project_start_date',
                'value' => sanitize_text_field($_GET['start_date']),
                'compare' => '>=',
                'type' => 'DATE',
            );
        }

        // Filter by End Date
        if (!empty($_GET['end_date'])) {
            $meta_query[] = array(
                'key' => 'project_end_date',
                'value' => sanitize_text_field($_GET['end_date']),
                'compare' => '<=',
                'type' => 'DATE',
            );
        }

        // Apply meta_query to the main query
        if (count($meta_query) > 1) {
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'filter_projects_by_date');

?>