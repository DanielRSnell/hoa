<?php
namespace VillaCapriani\Models;

class Components
{
    protected static $componentNamespace = 'VillaCapriani\\Models\\Components\\';
    protected static $componentDirectory;

    public static function register()
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        self::$componentDirectory = __DIR__ . '/Components';

        acf_add_local_field_group([
            'key' => 'group_components',
            'title' => 'Page Components',
            'fields' => [
                [
                    'key' => 'field_components',
                    'label' => 'Components',
                    'name' => 'components',
                    'type' => 'flexible_content',
                    'layouts' => self::getComponentLayouts(),
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'layout',
                    ],
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ],
                ],
            ],
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ]);
    }

    protected static function getComponentLayouts()
    {
        $layouts = [];

        foreach (self::getComponentDirectories() as $componentName => $componentPath) {
            $variantLayouts = self::getVariantFields($componentName, $componentPath);
            if (!empty($variantLayouts)) {
                $layouts[$componentName] = [
                    'key' => 'layout_' . $componentName,
                    'name' => $componentName,
                    'label' => self::formatLabel($componentName),
                    'display' => 'block',
                    'sub_fields' => array_merge(
                        [
                            [
                                'key' => 'field_' . $componentName . '_variant',
                                'label' => 'Variant',
                                'name' => 'variant',
                                'type' => 'select',
                                'choices' => self::getVariantChoices($componentName, $componentPath),
                                'required' => 1,
                                'wrapper' => [
                                    'width' => '100',
                                    'class' => '',
                                    'id' => '',
                                ],
                            ],
                        ],
                        $variantLayouts
                    ),
                ];
            }
        }

        return $layouts;
    }

    protected static function getComponentDirectories()
    {
        $components = [];

        if (!is_dir(self::$componentDirectory)) {
            return $components;
        }

        $iterator = new \DirectoryIterator(self::$componentDirectory);

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                $componentName = $fileInfo->getFilename();
                $components[$componentName] = $fileInfo->getPathname();
            }
        }

        return $components;
    }

    protected static function getVariantFields($componentName, $componentPath)
    {
        $fields = [];
        $variantsPath = $componentPath . '/Variants';

        if (!is_dir($variantsPath)) {
            return $fields;
        }

        $variants = self::getVariantClasses($componentName);

        foreach ($variants as $variantClass) {
            if (method_exists($variantClass, 'getFields')) {
                $variantFields = $variantClass::getFields();
                foreach ($variantFields as $field) {
                    $field['conditional_logic'] = [
                        [
                            [
                                'field' => 'field_' . $componentName . '_variant',
                                'operator' => '==',
                                'value' => $variantClass::getId(),
                            ],
                        ],
                    ];
                    $fields[] = $field;
                }
            }
        }

        return $fields;
    }

    protected static function getVariantClasses($componentName)
    {
        $variants = [];
        $variantsNamespace = self::$componentNamespace . $componentName . '\\Variants\\';
        $variantsPath = self::$componentDirectory . '/' . $componentName . '/Variants';

        if (!is_dir($variantsPath)) {
            return $variants;
        }

        $iterator = new \DirectoryIterator($variantsPath);

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
                $className = $fileInfo->getBasename('.php');
                $fullClassName = $variantsNamespace . $className;

                if (class_exists($fullClassName)) {
                    $variants[] = $fullClassName;
                }
            }
        }

        return $variants;
    }

    protected static function getVariantChoices($componentName, $componentPath)
    {
        $choices = [];
        $variants = self::getVariantClasses($componentName);

        foreach ($variants as $variantClass) {
            if (method_exists($variantClass, 'getId') && method_exists($variantClass, 'getLabel')) {
                $choices[$variantClass::getId()] = $variantClass::getLabel();
            }
        }

        return $choices;
    }

    protected static function formatLabel($string)
    {
        $label = str_replace('_', ' ', $string);
        $label = str_replace('-', ' ', $label);
        return ucwords($label);
    }

    protected static function validateComponentStructure($componentPath)
    {
        if (!is_dir($componentPath)) {
            return false;
        }

        if (!is_dir($componentPath . '/Variants')) {
            return false;
        }

        $variantFiles = glob($componentPath . '/Variants/*.php');
        if (empty($variantFiles)) {
            return false;
        }

        return true;
    }

    protected static function getComponentConfig($componentName)
    {
        $configFile = self::$componentDirectory . '/' . $componentName . '/config.php';

        if (file_exists($configFile)) {
            return include $configFile;
        }

        return [
            'label' => self::formatLabel($componentName),
            'category' => 'Content',
            'icon' => 'admin-generic',
            'keywords' => [$componentName],
        ];
    }
}
