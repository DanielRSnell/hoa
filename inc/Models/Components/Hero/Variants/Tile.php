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
        'key' => 'field_hero_tile_content',
        'label' => 'Content',
        'name' => 'content',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_hero_tile_heading',
            'label' => 'Heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1
          ],
          [
            'key' => 'field_hero_tile_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'required' => 1
          ]
        ]
      ],
      [
        'key' => 'field_hero_tile_cta',
        'label' => 'Call to Actions',
        'name' => 'cta',
        'type' => 'group',
        'sub_fields' => [
          [
            'key' => 'field_hero_tile_primary_cta',
            'label' => 'Primary Button',
            'name' => 'primary',
            'type' => 'group',
            'sub_fields' => [
              [
                'key' => 'field_hero_tile_primary_cta_text',
                'label' => 'Text',
                'name' => 'text',
                'type' => 'text',
                'required' => 1
              ],
              [
                'key' => 'field_hero_tile_primary_cta_url',
                'label' => 'URL',
                'name' => 'url',
                'type' => 'url',
                'required' => 1
              ]
            ]
          ],
          [
            'key' => 'field_hero_tile_secondary_cta',
            'label' => 'Secondary Button',
            'name' => 'secondary',
            'type' => 'group',
            'sub_fields' => [
              [
                'key' => 'field_hero_tile_secondary_cta_text',
                'label' => 'Text',
                'name' => 'text',
                'type' => 'text'
              ],
              [
                'key' => 'field_hero_tile_secondary_cta_url',
                'label' => 'URL',
                'name' => 'url',
                'type' => 'url'
              ]
            ]
          ]
        ]
      ],
      [
        'key' => 'field_hero_tile_featured_image',
        'label' => 'Featured Image',
        'name' => 'featured_image',
        'type' => 'image',
        'return_format' => 'array',
        'preview_size' => 'medium',
        'library' => 'all',
        'required' => 1
      ]
    ];
  }
}
