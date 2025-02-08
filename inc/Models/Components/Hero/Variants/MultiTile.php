<?php
namespace VillaCapriani\Models\Components\Hero\Variants;

class MultiTile
{
    public static function getId()
    {
        return 'multi-tile';
    }

    public static function getLabel()
    {
        return 'Multi Tile';
    }

    public static function getFields()
    {
        return [
            [
                'key' => 'field_hero_multi_tile_content',
                'label' => 'Content',
                'name' => 'content',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_multi_tile_heading',
                        'label' => 'Heading',
                        'name' => 'heading',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_hero_multi_tile_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'required' => 1,
                    ],
                ],
            ],
            [
                'key' => 'field_hero_multi_tile_cta',
                'label' => 'Call to Actions',
                'name' => 'cta',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_multi_tile_primary_cta',
                        'label' => 'Primary Button',
                        'name' => 'primary',
                        'type' => 'group',
                        'sub_fields' => [
                            [
                                'key' => 'field_hero_multi_tile_primary_cta_text',
                                'label' => 'Text',
                                'name' => 'text',
                                'type' => 'text',
                                'required' => 1,
                            ],
                            [
                                'key' => 'field_hero_multi_tile_primary_cta_url',
                                'label' => 'URL',
                                'name' => 'url',
                                'type' => 'url',
                                'required' => 1,
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_hero_multi_tile_secondary_cta',
                        'label' => 'Secondary Button',
                        'name' => 'secondary',
                        'type' => 'group',
                        'sub_fields' => [
                            [
                                'key' => 'field_hero_multi_tile_secondary_cta_text',
                                'label' => 'Text',
                                'name' => 'text',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_hero_multi_tile_secondary_cta_url',
                                'label' => 'URL',
                                'name' => 'url',
                                'type' => 'url',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_hero_multi_tile_images',
                'label' => 'Gallery Images',
                'name' => 'images',
                'type' => 'gallery',
                'min' => 4,
                'max' => 6,
                'insert' => 'append',
                'library' => 'all',
                'return_format' => 'array',
            ],
        ];
    }
}
