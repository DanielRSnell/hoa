<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

// Enqueue scripts
add_action('acf/input/admin_enqueue_scripts', function () {
    wp_enqueue_script(
        'preview-controls',
        get_template_directory_uri() . '/artisan/admin/builder/assets/js/preview-controls.js',
        ['jquery', 'acf-input'],
        '1.0.0',
        true
    );
});

// Register field group after init and post types are registered
add_action('acf/init', function () {
    // Wait for post types to be registered
    add_action('wp_loaded', function () {
        // Load data controller
        require_once __DIR__ . '/data/controller.php';

        // Load field definitions
        $location_fields = require __DIR__ . '/fields/location.php';
        $preview_fields = require __DIR__ . '/fields/preview.php';

        acf_add_local_field_group([
            'key' => 'group_template_settings',
            'title' => 'Template Settings',
            'fields' => [
                [
                    'key' => 'field_template_tabs',
                    'label' => 'Template Settings',
                    'name' => 'template_tabs',
                    'type' => 'tabs',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key' => 'field_location_tab',
                    'label' => 'Location',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                $location_fields,
                [
                    'key' => 'field_preview_tab',
                    'label' => 'Preview',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                $preview_fields,
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'layout',
                    ],
                ],
            ],
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
        ]);
    }, 20); // Priority 20 to ensure it runs after post types are registered
}, 20); // Priority 20 to ensure it runs after ACF is fully initialized
