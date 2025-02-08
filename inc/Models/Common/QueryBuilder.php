<?php
namespace VillaCapriani\Models\Common;

class QueryBuilder
{
    public static function getFields($key_prefix = '')
    {
        return [
            [
                'key' => $key_prefix . 'field_query_tab',
                'label' => 'Query Settings',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => $key_prefix . 'field_query_mode',
                'label' => 'Query Mode',
                'name' => 'query_mode',
                'type' => 'radio',
                'choices' => [
                    'builder' => 'Query Builder',
                    'custom' => 'Custom Callback',
                ],
                'default_value' => 'builder',
                'layout' => 'horizontal',
                'wrapper' => [
                    'width' => '100',
                    'class' => 'query-mode-selector',
                    'id' => '',
                ],
            ],
            ...CustomQuery::getFields($key_prefix),
            ...StandardQuery::getFields($key_prefix),
        ];
    }

    public static function executeQuery($query_data)
    {
        if (empty($query_data['query_mode'])) {
            return false;
        }

        if ($query_data['query_mode'] === 'custom') {
            $custom_data = [
                'callback' => $query_data['query_custom_callback'],
                'args' => $query_data['query_custom_args'],
            ];
            return CustomQuery::execute($custom_data);
        }

        $builder_data = [
            'post_type' => $query_data['query_builder_post_type'],
            'posts_per_page' => $query_data['query_builder_posts_per_page'],
            'offset' => $query_data['query_builder_offset'],
            'orderby' => $query_data['query_builder_orderby'],
            'order' => $query_data['query_builder_order'],
            'taxonomies' => $query_data['query_builder_taxonomies'],
            'meta' => $query_data['query_builder_meta'],
        ];
        return StandardQuery::execute($builder_data);
    }
}
