<?php

// Register post type first
add_action('init', function () {
    register_post_type('layout', [
        'labels' => [
            'name' => 'Layouts',
            'singular_name' => 'Layout',
            'add_new' => 'Add New Layout',
            'add_new_item' => 'Add New Layout',
            'edit_item' => 'Edit Layout',
            'new_item' => 'New Layout',
            'view_item' => 'View Layout',
            'search_items' => 'Search Layouts',
            'not_found' => 'No layouts found',
            'not_found_in_trash' => 'No layouts found in Trash',
            'all_items' => 'Layouts',
            'menu_name' => 'Layouts',
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => 'builder',
        'supports' => ['title'],
        'has_archive' => false,
        'show_in_rest' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
    ]);
}, 5); // Priority 5 to ensure it runs early

// Then load fields
require_once __DIR__ . '/fields.php';

// Add admin menu
add_action('admin_menu', function () {
    add_menu_page(
        'Builder',
        'Builder',
        'manage_options',
        'builder',
        function () {
            wp_redirect(admin_url('admin.php?page=dynamic-layouts'));
            exit;
        },
        'dashicons-editor-kitchensink',
        2
    );

    add_submenu_page(
        'builder',
        'Dynamic Layouts',
        'Dynamic Layouts',
        'manage_options',
        'dynamic-layouts',
        function () {
            include get_template_directory() . '/includes/admin/builder/views/dynamic-layouts.php';
        }
    );

    remove_submenu_page('builder', 'builder');
}, 9);

add_filter('acf/prepare_field/type=select', function ($field) {
    if (!isset($field['multiple'])) {
        $field['multiple'] = 0;
    }
    return $field;
}, 20);
