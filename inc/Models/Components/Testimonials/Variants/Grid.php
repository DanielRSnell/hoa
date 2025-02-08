<?php
namespace VillaCapriani\Models\Components\Testimonials\Variants;

class Grid
{
    public static function getId()
    {
        return 'grid';
    }

    public static function getLabel()
    {
        return 'Grid';
    }

    public static function getFields()
    {
        return [
            [
                'key' => 'field_testimonials_grid_content',
                'label' => 'Content',
                'name' => 'content',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_testimonials_grid_heading',
                        'label' => 'Heading',
                        'name' => 'heading',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_testimonials_grid_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'required' => 1,
                    ],
                ],
            ],
        ];
    }
}
