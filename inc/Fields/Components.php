<?php
namespace VillaCapriani\Fields;

class Components {
  public static function register() {
    if(!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
      'key' => 'group_components',
      'title' => 'Page Components',
      'fields' => [
        [
          'key' => 'field_components',
          'label' => 'Components',
          'name' => 'components',
          'type' => 'flexible_content',
          'layouts' => self::getComponentLayouts()
        ]
      ],
      'location' => [
        [
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page'
          ]
        ]
      ]
    ]);
  }

  private static function getComponentLayouts() {
    $layouts = [];
    $componentsDir = __DIR__ . '/Components';
    
    if (!is_dir($componentsDir)) {
      return $layouts;
    }

    // Get all PHP files in the Components directory
    $files = array_filter(scandir($componentsDir), function($file) {
      return pathinfo($file, PATHINFO_EXTENSION) === 'php';
    });

    foreach ($files as $file) {
      $className = pathinfo($file, PATHINFO_FILENAME);
      $fullClassName = "VillaCapriani\\Fields\\Components\\{$className}";
      
      if (class_exists($fullClassName) && method_exists($fullClassName, 'getLayout')) {
        $layout = $fullClassName::getLayout();
        if (isset($layout['name'])) {
          // Get available variants
          $variants = self::getVariants($layout['name']);
          
          // Add variant field if variants exist
          if (!empty($variants)) {
            array_unshift($layout['sub_fields'], [
              'key' => "field_{$layout['name']}_variant",
              'label' => 'Variant',
              'name' => 'variant',
              'type' => 'select',
              'choices' => $variants,
              'required' => 1
            ]);
          }
          
          $layouts[$layout['name']] = $layout;
        }
      }
    }

    return $layouts;
  }

  private static function getVariants($componentName) {
    $variants = [];
    $viewsPath = get_template_directory() . '/views/components/' . $componentName;
    
    if (!is_dir($viewsPath)) {
      return $variants;
    }

    $files = glob($viewsPath . '/*.twig');
    foreach ($files as $file) {
      $filename = pathinfo($file, PATHINFO_FILENAME);
      $variants[$filename] = $filename;
    }

    return $variants;
  }
}
