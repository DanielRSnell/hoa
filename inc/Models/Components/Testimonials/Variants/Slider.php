<?php
namespace VillaCapriani\Models\Components\Testimonials\Variants;

class Slider
{
    public static function getId()
    {
        return 'slider';
    }

    public static function getLabel()
    {
        return 'Slider';
    }

    public static function getFields()
    {
        return [
            [
                'key' => 'field_testimonials_slider_content',
                'label' => 'Content',
                'name' => 'content',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_testimonials_slider_heading',
                        'label' => 'Heading',
                        'name' => 'heading',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_testimonials_slider_description',
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
