<?php
namespace VillaCapriani\Fields\Components\Hero\Variants;

class CenterImage {
  public static function getId() {
    return 'center-image';
  }

  public static function getLabel() {
    return 'Center Image';
  }

  public static function getFields() {
    return [
      [
        'key' => 'field_hero_background',
        'label' => 'Background Options',
        'name' => 'background',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_hero_background_type',
            'label' => 'Background Type',
            'name' => 'type',
            'type' => 'select',
            'choices' => [
              'image' => 'Image',
              'color' => 'Color',
              'gradient' => 'Gradient'
            ],
            'default_value' => 'image',
          ],
          [
            'key' => 'field_hero_background_image',
            'label' => 'Background Image',
            'name' => 'image',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'conditional_logic' => [
              [
                [
                  'field' => 'field_hero_background_type',
                  'operator' => '==',
                  'value' => 'image',
                ]
              ]
            ]
          ],
          [
            'key' => 'field_hero_background_color',
            'label' => 'Background Color',
            'name' => 'color',
            'type' => 'color_picker',
            'default_value' => '#111827',
            'conditional_logic' => [
              [
                [
                  'field' => 'field_hero_background_type',
                  'operator' => '==',
                  'value' => 'color',
                ]
              ]
            ]
          ],
          [
            'key' => 'field_hero_background_overlay',
            'label' => 'Image Overlay',
            'name' => 'overlay',
            'type' => 'true_false',
            'ui' => true,
            'default_value' => 1,
            'conditional_logic' => [
              [
                [
                  'field' => 'field_hero_background_type',
                  'operator' => '==',
                  'value' => 'image',
                ]
              ]
            ]
          ],
          [
            'key' => 'field_hero_background_overlay_opacity',
            'label' => 'Overlay Opacity',
            'name' => 'overlay_opacity',
            'type' => 'range',
            'min' => 0,
            'max' => 100,
            'step' => 5,
            'default_value' => 40,
            'conditional_logic' => [
              [
                [
                  'field' => 'field_hero_background_type',
                  'operator' => '==',
                  'value' => 'image',
                ],
                [
                  'field' => 'field_hero_background_overlay',
                  'operator' => '==',
                  'value' => 1,
                ]
              ]
            ]
          ]
        ]
      ],
      [
        'key' => 'field_hero_announcement',
        'label' => 'Announcement Banner',
        'name' => 'announcement',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_hero_announcement_enabled',
            'label' => 'Enable Announcement',
            'name' => 'enabled',
            'type' => 'true_false',
            'ui' => true,
            'default_value' => 1,
          ],
          [
            'key' => 'field_hero_announcement_text',
            'label' => 'Text',
            'name' => 'text',
            'type' => 'text',
            'default_value' => 'Announcing our next round of funding.',
            'conditional_logic' => [
              [
                [
                  'field' => 'field_hero_announcement_enabled',
                  'operator' => '==',
                  'value' => 1,
                ]
              ]
            ]
          ],
          [
            'key' => 'field_hero_announcement_link_text',
            'label' => 'Link Text',
            'name' => 'link_text',
            'type' => 'text',
            'default_value' => 'Read more',
            'conditional_logic' => [
              [
                [
                  'field' => 'field_hero_announcement_enabled',
                  'operator' => '==',
                  'value' => 1,
                ]
              ]
            ]
          ],
          [
            'key' => 'field_hero_announcement_url',
            'label' => 'URL',
            'name' => 'url',
            'type' => 'url',
            'default_value' => '#',
            'conditional_logic' => [
              [
                [
                  'field' => 'field_hero_announcement_enabled',
                  'operator' => '==',
                  'value' => 1,
                ]
              ]
            ]
          ]
        ]
      ]
    ];
  }
}
