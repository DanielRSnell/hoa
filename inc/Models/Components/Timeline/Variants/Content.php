<?php
namespace VillaCapriani\Fields\Components\Timeline\Variants;

use VillaCapriani\Fields\Common\QueryBuilder;

class Content {
  public static function getId() {
    return 'content';
  }

  public static function getLabel() {
    return 'Content Timeline';
  }

  public static function getFields() {
    return array_merge(
      [
        [
          'key' => 'field_timeline_content_settings',
          'label' => 'Display Settings',
          'type' => 'tab',
          'placement' => 'top'
        ],
        [
          'key' => 'field_timeline_content_settings_group',
          'label' => 'Timeline Settings',
          'name' => 'settings',
          'type' => 'group',
          'sub_fields' => [
            [
              'key' => 'field_timeline_date_format',
              'label' => 'Date Format',
              'name' => 'date_format',
              'type' => 'select',
              'choices' => [
                'F j, Y' => 'January 1, 2024',
                'M j, Y' => 'Jan 1, 2024',
                'Y-m-d' => '2024-01-01',
                'd/m/Y' => '01/01/2024'
              ],
              'default_value' => 'F j, Y'
            ],
            [
              'key' => 'field_timeline_show_images',
              'label' => 'Show Featured Images',
              'name' => 'show_images',
              'type' => 'true_false',
              'ui' => true,
              'default_value' => 1
            ],
            [
              'key' => 'field_timeline_excerpt_length',
              'label' => 'Excerpt Length',
              'name' => 'excerpt_length',
              'type' => 'number',
              'default_value' => 150,
              'min' => 50,
              'max' => 500
            ]
          ]
        ]
      ],
      QueryBuilder::getFields('timeline_content_')
    );
  }
}
