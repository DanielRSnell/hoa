<?php
namespace VillaCapriani\Fields\Components;

class Hero {
  public static function getLayout() {
    return [
      'key' => 'layout_hero',
      'name' => 'hero',
      'label' => 'Hero',
      'sub_fields' => [
        [
          'key' => 'field_hero_title',
          'label' => 'Title',
          'name' => 'title',
          'type' => 'text'
        ],
        [
          'key' => 'field_hero_content',
          'label' => 'Content',
          'name' => 'content',
          'type' => 'wysiwyg',
          'tabs' => 'visual',
          'toolbar' => 'full',
          'media_upload' => 1
        ],
        [
          'key' => 'field_hero_image',
          'label' => 'Background Image',
          'name' => 'image',
          'type' => 'image',
          'return_format' => 'array',
          'preview_size' => 'medium',
          'library' => 'all'
        ]
      ]
    ];
  }
}
