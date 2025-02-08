<?php
namespace VillaCapriani\Models\Components\Testimonials\Variants;

class Carousel
{
    public static function getId()
    {
        return 'carousel';
    }

    public static function getLabel()
    {
        return 'Carousel';
    }

    public static function getFields()
    {
        return [
            [
                'key' => 'field_testimonials_carousel_content',
                'label' => 'Content',
                'name' => 'content',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_testimonials_carousel_heading',
                        'label' => 'Heading',
                        'name' => 'heading',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_testimonials_carousel_description',
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
