<?php
namespace VillaCapriani\Fields\Components\Hero\Variants;

class Tile {
  public static function getId() {
    return 'tile';
  }

  public static function getLabel() {
    return 'Tile';
  }

  public static function getFields() {
    return [
      [
        'key' => 'field_hero_tile_layout',
        'label' => 'Layout Options',
        'name' => 'layout',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_hero_tile_layout_direction',
            'label' => 'Content Direction',
            'name' => 'direction',
            'type' => 'select',
            'choices' => [
              'ltr' => 'Content Left, Image Right',
              'rtl' => 'Content Right, Image Left'
            ],
            'default_value' => 'ltr'
          ],
          [
            'key' => 'field_hero_tile_layout_spacing',
            'label' => 'Content Spacing',
            'name' => 'spacing',
            'type' => 'group',
            'sub_fields' => [
              [
                'key' => 'field_hero_tile_layout_spacing_top',
                'label' => 'Top Padding',
                'name' => 'top',
                'type' => 'select',
                'choices' => [
                  'pt-10' => 'Small',
                  'pt-16' => 'Medium',
                  'pt-24' => 'Large'
                ],
                'default_value' => 'pt-10'
              ],
              [
                'key' => 'field_hero_tile_layout_spacing_bottom',
                'label' => 'Bottom Padding',
                'name' => 'bottom',
                'type' => 'select',
                'choices' => [
                  'pb-24' => 'Small',
                  'pb-32' => 'Medium',
                  'pb-40' => 'Large'
                ],
                'default_value' => 'pb-24'
              ]
            ]
          ]
        ]
      ],
      [
        'key' => 'field_hero_tile_style',
        'label' => 'Style Options',
        'name' => 'style',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_hero_tile_background',
            'label' => 'Background',
            'name' => 'background',
            'type' => 'group',
            'sub_fields' => [
              [
                'key' => 'field_hero_tile_background_type',
                'label' => 'Background Type',
                'name' => 'type',
                'type' => 'select',
                'choices' => [
                  'color' => 'Solid Color',
                  'gradient' => 'Gradient'
                ],
                'default_value' => 'color'
              ],
              [
                'key' => 'field_hero_tile_background_color',
                'label' => 'Background Color',
                'name' => 'color',
                'type' => 'color_picker',
                'default_value' => '#f3f4f6',
                'conditional_logic' => [
                  [
                    [
                      'field' => 'field_hero_tile_background_type',
                      'operator' => '==',
                      'value' => 'color'
                    ]
                  ]
                ]
              ],
              [
                'key' => 'field_hero_tile_gradient_start',
                'label' => 'Gradient Start Color',
                'name' => 'gradient_start',
                'type' => 'color_picker',
                'default_value' => '#f3f4f6',
                'conditional_logic' => [
                  [
                    [
                      'field' => 'field_hero_tile_background_type',
                      'operator' => '==',
                      'value' => 'gradient'
                    ]
                  ]
                ]
              ],
              [
                'key' => 'field_hero_tile_gradient_end',
                'label' => 'Gradient End Color',
                'name' => 'gradient_end',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
                'conditional_logic' => [
                  [
                    [
                      'field' => 'field_hero_tile_background_type',
                      'operator' => '==',
                      'value' => 'gradient'
                    ]
                  ]
                ]
              ]
            ]
          ],
          [
            'key' => 'field_hero_tile_colors',
            'label' => 'Colors',
            'name' => 'colors',
            'type' => 'group',
            'sub_fields' => [
              [
                'key' => 'field_hero_tile_accent_color',
                'label' => 'Accent Color',
                'name' => 'accent',
                'type' => 'color_picker',
                'default_value' => '#4f46e5'
              ],
              [
                'key' => 'field_hero_tile_text_color',
                'label' => 'Text Color',
                'name' => 'text',
                'type' => 'color_picker',
                'default_value' => '#111827'
              ],
              [
                'key' => 'field_hero_tile_content_color',
                'label' => 'Content Color',
                'name' => 'content',
                'type' => 'color_picker',
                'default_value' => '#4b5563'
              ]
            ]
          ]
        ]
      ],
      [
        'key' => 'field_hero_tile_image',
        'label' => 'Image Settings',
        'name' => 'image',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_hero_tile_image_file',
            'label' => 'Image',
            'name' => 'file',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'required' => 1,
            'instructions' => 'Recommended size: 1824x1080px',
            'min_width' => 1200,
            'min_height' => 800
          ],
          [
            'key' => 'field_hero_tile_image_effects',
            'label' => 'Image Effects',
            'name' => 'effects',
            'type' => 'group',
            'sub_fields' => [
              [
                'key' => 'field_hero_tile_image_shadow',
                'label' => 'Shadow Intensity',
                'name' => 'shadow',
                'type' => 'select',
                'choices' => [
                  'shadow-sm' => 'Light',
                  'shadow' => 'Medium',
                  'shadow-md' => 'Strong',
                  'shadow-lg' => 'Extra Strong'
                ],
                'default_value' => 'shadow-lg'
              ],
              [
                'key' => 'field_hero_tile_image_border',
                'label' => 'Border Style',
                'name' => 'border',
                'type' => 'select',
                'choices' => [
                  'ring-1' => 'Thin',
                  'ring-2' => 'Medium',
                  'ring-4' => 'Thick'
                ],
                'default_value' => 'ring-1'
              ]
            ]
          ]
        ]
      ]
    ];
  }
}
