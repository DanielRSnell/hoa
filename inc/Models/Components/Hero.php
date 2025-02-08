<?php
namespace VillaCapriani\Models\Components;

class Hero
{
    public static function getLayout()
    {
        return [
            'key' => 'layout_hero',
            'name' => 'hero',
            'label' => 'Hero',
            'sub_fields' => [
                [
                    'key' => 'field_hero_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                    'required' => 1,
                    'default_value' => 'Data to enrich your online business',
                ],
                [
                    'key' => 'field_hero_content',
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'wysiwyg',
                    'tabs' => 'visual',
                    'toolbar' => 'full',
                    'media_upload' => 1,
                    'required' => 1,
                    'default_value' => 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat.',
                ],
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
                                'gradient' => 'Gradient',
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
                                    ],
                                ],
                            ],
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
                                    ],
                                ],
                            ],
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
                                    ],
                                ],
                            ],
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
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'field_hero_image',
                    'label' => 'Featured Image',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'instructions' => 'Recommended size: 1920x1080px. Default will be used if none provided.',
                ],
                [
                    'key' => 'field_hero_cta_primary',
                    'label' => 'Primary CTA',
                    'name' => 'cta_primary',
                    'type' => 'group',
                    'sub_fields' => [
                        [
                            'key' => 'field_hero_cta_primary_text',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'text',
                            'default_value' => 'Get started',
                        ],
                        [
                            'key' => 'field_hero_cta_primary_url',
                            'label' => 'URL',
                            'name' => 'url',
                            'type' => 'url',
                            'default_value' => '#',
                        ],
                    ],
                ],
                [
                    'key' => 'field_hero_cta_secondary',
                    'label' => 'Secondary CTA',
                    'name' => 'cta_secondary',
                    'type' => 'group',
                    'sub_fields' => [
                        [
                            'key' => 'field_hero_cta_secondary_text',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'text',
                            'default_value' => 'Learn more',
                        ],
                        [
                            'key' => 'field_hero_cta_secondary_url',
                            'label' => 'URL',
                            'name' => 'url',
                            'type' => 'url',
                            'default_value' => '#',
                        ],
                    ],
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
                                    ],
                                ],
                            ],
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
                                    ],
                                ],
                            ],
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
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
