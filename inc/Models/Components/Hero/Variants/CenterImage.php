<?php
namespace VillaCapriani\Models\Components\Hero\Variants;

class CenterImage
{
    public static function getId()
    {
        return 'center-image';
    }

    public static function getLabel()
    {
        return 'Center Image';
    }

    public static function getFields()
    {
        return [
            [
                'key' => 'field_hero_center_image_content',
                'label' => 'Content',
                'name' => 'content',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_center_image_heading',
                        'label' => 'Heading',
                        'name' => 'heading',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_hero_center_image_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'required' => 1,
                    ],
                ],
            ],
            [
                'key' => 'field_hero_center_image_background',
                'label' => 'Background Image',
                'name' => 'background',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'required' => 1,
            ],
            [
                'key' => 'field_hero_center_image_cta',
                'label' => 'Call to Actions',
                'name' => 'cta',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_center_image_primary_cta',
                        'label' => 'Primary Button',
                        'name' => 'primary',
                        'type' => 'group',
                        'sub_fields' => [
                            [
                                'key' => 'field_hero_center_image_primary_cta_text',
                                'label' => 'Text',
                                'name' => 'text',
                                'type' => 'text',
                                'required' => 1,
                            ],
                            [
                                'key' => 'field_hero_center_image_primary_cta_url',
                                'label' => 'URL',
                                'name' => 'url',
                                'type' => 'url',
                                'required' => 1,
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_hero_center_image_secondary_cta',
                        'label' => 'Secondary Button',
                        'name' => 'secondary',
                        'type' => 'group',
                        'sub_fields' => [
                            [
                                'key' => 'field_hero_center_image_secondary_cta_text',
                                'label' => 'Text',
                                'name' => 'text',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_hero_center_image_secondary_cta_url',
                                'label' => 'URL',
                                'name' => 'url',
                                'type' => 'url',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_hero_center_image_announcement',
                'label' => 'Announcement',
                'name' => 'announcement',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_center_image_announcement_text',
                        'label' => 'Text',
                        'name' => 'text',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_hero_center_image_announcement_link',
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'group',
                        'sub_fields' => [
                            [
                                'key' => 'field_hero_center_image_announcement_link_text',
                                'label' => 'Text',
                                'name' => 'text',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_hero_center_image_announcement_link_url',
                                'label' => 'URL',
                                'name' => 'url',
                                'type' => 'url',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
