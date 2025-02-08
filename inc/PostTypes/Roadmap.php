<?php
namespace VillaCapriani\PostTypes;

class Roadmap {
  public static function register() {
    register_post_type('roadmap', [
      'labels' => [
        'name' => 'Roadmap',
        'singular_name' => 'Roadmap Item'
      ],
      'public' => true,
      'has_archive' => true,
      'menu_icon' => 'dashicons-calendar-alt',
      'supports' => ['title', 'thumbnail']
    ]);

    // Register Status Taxonomy
    register_taxonomy('roadmap_status', 'roadmap', [
      'labels' => [
        'name' => 'Status',
        'singular_name' => 'Status'
      ],
      'hierarchical' => true,
      'show_admin_column' => true
    ]);

    self::register_fields();
  }

  private static function register_fields() {
    if(!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
      'key' => 'group_roadmap',
      'title' => 'Roadmap Details',
      'fields' => [
        [
          'key' => 'field_visibility',
          'label' => 'Visibility',
          'name' => 'visibility',
          'type' => 'select',
          'choices' => [
            'public' => 'Public',
            'private' => 'Private'
          ]
        ],
        [
          'key' => 'field_internal_group',
          'label' => 'Internal',
          'name' => 'internal',
          'type' => 'group',
          'sub_fields' => [
            [
              'key' => 'field_internal_notes',
              'label' => 'Internal Notes',
              'name' => 'notes',
              'type' => 'wysiwyg'
            ],
            [
              'key' => 'field_internal_meta',
              'label' => 'Internal Meta',
              'name' => 'meta',
              'type' => 'textarea'
            ]
          ]
        ],
        [
          'key' => 'field_external_group',
          'label' => 'External',
          'name' => 'external',
          'type' => 'group',
          'sub_fields' => [
            [
              'key' => 'field_external_notes',
              'label' => 'External Notes',
              'name' => 'notes',
              'type' => 'wysiwyg'
            ],
            [
              'key' => 'field_external_meta',
              'label' => 'External Meta',
              'name' => 'meta',
              'type' => 'textarea'
            ]
          ]
        ]
      ],
      'location' => [
        [
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'roadmap'
          ]
        ]
      ]
    ]);
  }
}
