<?php
namespace VillaCapriani\Models\Common;

class CustomQuery
{
    public static function getFields($key_prefix = '')
    {
        $showOnCustom = ConditionalBuilder::equals(
            $key_prefix . 'field_query_mode',
            'custom'
        );

        return [
            [
                'key' => $key_prefix . 'field_query_custom_group',
                'label' => 'Custom Query Settings',
                'name' => 'query_custom_group',
                'type' => 'group',
                'layout' => 'block',
                'conditional_logic' => $showOnCustom,
                'wrapper' => [
                    'width' => '100',
                    'class' => '',
                    'id' => '',
                ],
                'sub_fields' => [
                    [
                        'key' => $key_prefix . 'field_query_custom_accordion',
                        'label' => 'Custom Query Configuration',
                        'type' => 'accordion',
                        'open' => 1,
                        'multi_expand' => 1,
                        'endpoint' => 0,
                    ],
                    [
                        'key' => $key_prefix . 'field_query_callback',
                        'label' => 'Callback Function',
                        'name' => 'callback',
                        'type' => 'text',
                        'instructions' => 'Enter the callback function name (e.g., get_featured_posts)',
                        'required' => 1,
                        'placeholder' => 'get_something',
                        'wrapper' => [
                            'width' => '100',
                            'class' => '',
                            'id' => '',
                        ],
                    ],
                    [
                        'key' => $key_prefix . 'field_query_args',
                        'label' => 'Arguments',
                        'name' => 'args',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'button_label' => 'Add Argument',
                        'wrapper' => [
                            'width' => '100',
                            'class' => '',
                            'id' => '',
                        ],
                        'sub_fields' => [
                            [
                                'key' => $key_prefix . 'field_query_arg_key',
                                'label' => 'Key',
                                'name' => 'key',
                                'type' => 'text',
                                'required' => 1,
                                'wrapper' => [
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ],
                            ],
                            [
                                'key' => $key_prefix . 'field_query_arg_value',
                                'label' => 'Value',
                                'name' => 'value',
                                'type' => 'text',
                                'required' => 1,
                                'wrapper' => [
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function execute($custom_config)
    {
        if (empty($custom_config['callback']) || !is_callable($custom_config['callback'])) {
            return false;
        }

        $args = [];
        if (!empty($custom_config['args'])) {
            foreach ($custom_config['args'] as $arg) {
                if (!empty($arg['key']) && isset($arg['value'])) {
                    $args[$arg['key']] = $arg['value'];
                }
            }
        }

        try {
            $result = call_user_func($custom_config['callback'], $args);
            return $result !== false ? $result : [];
        } catch (\Exception $e) {
            error_log('Custom query error: ' . $e->getMessage());
            return [];
        }
    }
}
