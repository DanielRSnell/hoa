<?php
namespace VillaCapriani\Fields\Components\Hero;

class Controller {
  public static function getLayout() {
    return [
      'key' => 'layout_hero',
      'name' => 'hero',
      'label' => 'Hero',
      'sub_fields' => array_merge(
        self::getCommonFields(),
        self::getVariantFields()
      )
    ];
  }

  private static function getCommonFields() {
    return [
      [
        'key' => 'field_hero_variant',
        'label' => 'Variant',
        'name' => 'variant',
        'type' => 'select',
        'choices' => self::getVariantOptions(),
        'required' => 1,
      ],
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
          ]
        ]
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
          ]
        ]
      ],
    ];
  }

  private static function getVariantFields() {
    $fields = [];
    $variants = self::getVariants();
    
    foreach ($variants as $variant) {
      if (method_exists($variant, 'getFields')) {
        $variantFields = $variant::getFields();
        foreach ($variantFields as $field) {
          $field['conditional_logic'] = [
            [
              [
                'field' => 'field_hero_variant',
                'operator' => '==',
                'value' => $variant::getId(),
              ]
            ]
          ];
          $fields[] = $field;
        }
      }
    }
    
    return $fields;
  }

  private static function getVariants() {
    return [
      Variants\CenterImage::class,
      Variants\Tile::class,
    ];
  }

  private static function getVariantOptions() {
    $options = [];
    foreach (self::getVariants() as $variant) {
      $options[$variant::getId()] = $variant::getLabel();
    }
    return $options;
  }
}
