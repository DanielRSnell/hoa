<?php
namespace VillaCapriani\Models\Components\Testimonials;

use VillaCapriani\Models\Components\Testimonials\Variants\Carousel;
use VillaCapriani\Models\Components\Testimonials\Variants\Grid;
use VillaCapriani\Models\Components\Testimonials\Variants\Slider;

class Controller
{
    public static function getLayout()
    {
        return [
            'key' => 'layout_testimonials',
            'name' => 'testimonials',
            'label' => 'Testimonials',
            'sub_fields' => array_merge(
                self::getCommonFields(),
                self::getVariantFields()
            ),
        ];
    }

    private static function getCommonFields()
    {
        return [
            [
                'key' => 'field_testimonials_variant',
                'label' => 'Variant',
                'name' => 'variant',
                'type' => 'select',
                'choices' => self::getVariantOptions(),
                'required' => 1,
            ],
        ];
    }

    private static function getVariantFields()
    {
        $fields = [];
        $variants = self::getVariants();

        foreach ($variants as $variant) {
            if (method_exists($variant, 'getFields')) {
                $variantFields = $variant::getFields();
                foreach ($variantFields as $field) {
                    $field['conditional_logic'] = [
                        [
                            [
                                'field' => 'field_testimonials_variant',
                                'operator' => '==',
                                'value' => $variant::getId(),
                            ],
                        ],
                    ];
                    $fields[] = $field;
                }
            }
        }

        return $fields;
    }

    private static function getVariants()
    {
        return [
            Grid::class,
            Carousel::class,
            Slider::class,
        ];
    }

    private static function getVariantOptions()
    {
        $options = [];
        foreach (self::getVariants() as $variant) {
            $options[$variant::getId()] = $variant::getLabel();
        }
        return $options;
    }
}
