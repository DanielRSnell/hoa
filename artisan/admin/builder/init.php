<?php
namespace Artisan\Admin\Builder;

if (!defined('ABSPATH')) {
    exit;
}

class Controller
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        // Register post type first
        add_action('init', [$this, 'registerPostType'], 5);

        // Then load fields
        require_once __DIR__ . '/fields.php';

        // Add admin menu
        add_action('admin_menu', [$this, 'registerAdminMenu'], 9);
    }

    public function registerPostType()
    {
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
            'public' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => 'builder',
            'supports' => ['title'],
            'has_archive' => false,
            'show_in_rest' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
        ]);
    }

    public function registerAdminMenu()
    {
        add_menu_page(
            'Builder',
            'Builder',
            'manage_options',
            'builder',
            function () {
                wp_redirect(admin_url('edit.php?post_type=layout'));
                exit;
            },
            'dashicons-editor-kitchensink',
            2
        );

        add_submenu_page(
            'builder',
            'Get Started',
            'Get Started',
            'manage_options',
            'get-started',
            function () {
                include __DIR__ . '/views/dynamic-layouts.php';
            }
        );

        remove_submenu_page('builder', 'builder');
    }
}

// Return the instance
return Controller::getInstance();
