<?php
namespace VillaCapriani\Fields\Common;

class StandardQuery {
  public static function getFields($key_prefix = '') {
    $showOnBuilder = ConditionalBuilder::equals(
      $key_prefix . 'field_query_mode',
      'builder'
    );

    return [
      [
        'key' => $key_prefix . 'field_query_builder_group',
        'label' => 'Query Builder Settings',
        'name' => 'query_builder_group',
        'type' => 'group',
        'layout' => 'block',
        'conditional_logic' => $showOnBuilder,
        'wrapper' => [
          'width' => '100',
          'class' => '',
          'id' => ''
        ],
        'sub_fields' => [
          [
            'key' => $key_prefix . 'field_query_builder_accordion',
            'label' => 'Query Builder Configuration',
            'type' => 'accordion',
            'open' => 1,
            'multi_expand' => 1,
            'endpoint' => 0
          ],
          [
            'key' => $key_prefix . 'field_query_post_type',
            'label' => 'Content Type',
            'name' => 'post_type',
            'type' => 'select',
            'choices' => self::getPostTypes(),
            'required' => 1,
            'multiple' => 0,
            'ui' => 1,
            'ajax' => 0,
            'return_format' => 'value',
            'wrapper' => [
              'width' => '50',
              'class' => '',
              'id' => ''
            ]
          ],
          [
            'key' => $key_prefix . 'field_query_posts_per_page',
            'label' => 'Items Per Page',
            'name' => 'posts_per_page',
            'type' => 'number',
            'default_value' => 10,
            'min' => -1,
            'max' => 100,
            'step' => 1,
            'wrapper' => [
              'width' => '25',
              'class' => '',
              'id' => ''
            ]
          ],
          [
            'key' => $key_prefix . 'field_query_offset',
            'label' => 'Offset',
            'name' => 'offset',
            'type' => 'number',
            'default_value' => 0,
            'min' => 0,
            'step' => 1,
            'wrapper' => [
              'width' => '25',
              'class' => '',
              'id' => ''
            ]
          ],
          [
            'key' => $key_prefix . 'field_query_orderby',
            'label' => 'Order By',
            'name' => 'orderby',
            'type' => 'select',
            'choices' => [
              'date' => 'Date',
              'modified' => 'Last Modified',
              'title' => 'Title',
              'menu_order' => 'Menu Order',
              'comment_count' => 'Comment Count',
              'rand' => 'Random'
            ],
            'default_value' => 'date',
            'ui' => 1,
            'wrapper' => [
              'width' => '50',
              'class' => '',
              'id' => ''
            ]
          ],
          [
            'key' => $key_prefix . 'field_query_order',
            'label' => 'Sort Order',
            'name' => 'order',
            'type' => 'select',
            'choices' => [
              'DESC' => 'Descending',
              'ASC' => 'Ascending'
            ],
            'default_value' => 'DESC',
            'ui' => 1,
            'wrapper' => [
              'width' => '50',
              'class' => '',
              'id' => ''
            ]
          ],
          [
            'key' => $key_prefix . 'field_query_taxonomies_accordion',
            'label' => 'Taxonomy Filters',
            'type' => 'accordion',
            'open' => 0,
            'multi_expand' => 1,
            'endpoint' => 0
          ],
          [
            'key' => $key_prefix . 'field_query_taxonomies',
            'label' => 'Taxonomy Filters',
            'name' => 'taxonomies',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Taxonomy Filter',
            'sub_fields' => [
              [
                'key' => $key_prefix . 'field_query_taxonomy',
                'label' => 'Taxonomy',
                'name' => 'taxonomy',
                'type' => 'select',
                'choices' => self::getTaxonomies(),
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value',
                'wrapper' => [
                  'width' => '40',
                  'class' => '',
                  'id' => ''
                ]
              ],
              [
                'key' => $key_prefix . 'field_query_terms',
                'label' => 'Terms',
                'name' => 'terms',
                'type' => 'taxonomy',
                'field_type' => 'multi_select',
                'return_format' => 'id',
                'ui' => 1,
                'wrapper' => [
                  'width' => '40',
                  'class' => '',
                  'id' => ''
                ]
              ],
              [
                'key' => $key_prefix . 'field_query_tax_operator',
                'label' => 'Operator',
                'name' => 'operator',
                'type' => 'select',
                'choices' => [
                  'IN' => 'Include any',
                  'AND' => 'Include all',
                  'NOT IN' => 'Exclude'
                ],
                'default_value' => 'IN',
                'ui' => 1,
                'wrapper' => [
                  'width' => '20',
                  'class' => '',
                  'id' => ''
                ]
              ]
            ]
          ],
          [
            'key' => $key_prefix . 'field_query_meta_accordion',
            'label' => 'Meta Filters',
            'type' => 'accordion',
            'open' => 0,
            'multi_expand' => 1,
            'endpoint' => 0
          ],
          [
            'key' => $key_prefix . 'field_query_meta',
            'label' => 'Meta Filters',
            'name' => 'meta',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Meta Filter',
            'sub_fields' => [
              [
                'key' => $key_prefix . 'field_query_meta_key',
                'label' => 'Meta Key',
                'name' => 'key',
                'type' => 'text',
                'required' => 1,
                'wrapper' => [
                  'width' => '30',
                  'class' => '',
                  'id' => ''
                ]
              ],
              [
                'key' => $key_prefix . 'field_query_meta_value',
                'label' => 'Meta Value',
                'name' => 'value',
                'type' => 'text',
                'required' => 1,
                'wrapper' => [
                  'width' => '30',
                  'class' => '',
                  'id' => ''
                ]
              ],
              [
                'key' => $key_prefix . 'field_query_meta_type',
                'label' => 'Type',
                'name' => 'type',
                'type' => 'select',
                'choices' => [
                  'CHAR' => 'Text',
                  'NUMERIC' => 'Number',
                  'DECIMAL' => 'Decimal',
                  'DATE' => 'Date',
                  'DATETIME' => 'DateTime',
                  'TIME' => 'Time'
                ],
                'default_value' => 'CHAR',
                'ui' => 1,
                'wrapper' => [
                  'width' => '20',
                  'class' => '',
                  'id' => ''
                ]
              ],
              [
                'key' => $key_prefix . 'field_query_meta_compare',
                'label' => 'Compare',
                'name' => 'compare',
                'type' => 'select',
                'choices' => [
                  '=' => 'Equals',
                  '!=' => 'Not Equals',
                  '>' => 'Greater Than',
                  '>=' => 'Greater or Equal',
                  '<' => 'Less Than',
                  '<=' => 'Less or Equal',
                  'LIKE' => 'Contains',
                  'NOT LIKE' => 'Not Contains',
                  'IN' => 'In List',
                  'NOT IN' => 'Not In List',
                  'BETWEEN' => 'Between',
                  'NOT BETWEEN' => 'Not Between',
                  'EXISTS' => 'Exists',
                  'NOT EXISTS' => 'Not Exists'
                ],
                'default_value' => '=',
                'ui' => 1,
                'wrapper' => [
                  'width' => '20',
                  'class' => '',
                  'id' => ''
                ]
              ]
            ]
          ]
        ]
      ]
    ];
  }

  private static function getPostTypes() {
    $post_types = get_post_types(['public' => true], 'objects');
    $choices = [];
    foreach ($post_types as $post_type) {
      if ($post_type->name !== 'attachment') {
        $choices[$post_type->name] = $post_type->labels->singular_name;
      }
    }
    return $choices;
  }

  private static function getTaxonomies() {
    $taxonomies = get_taxonomies(['public' => true], 'objects');
    $choices = [];
    foreach ($taxonomies as $taxonomy) {
      $choices[$taxonomy->name] = $taxonomy->labels->singular_name;
    }
    return $choices;
  }

  public static function execute($query_config) {
    if (empty($query_config['post_type'])) {
      return [];
    }

    $args = [
      'post_type' => $query_config['post_type'],
      'posts_per_page' => isset($query_config['posts_per_page']) ? intval($query_config['posts_per_page']) : 10,
      'offset' => isset($query_config['offset']) ? intval($query_config['offset']) : 0,
      'orderby' => isset($query_config['orderby']) ? $query_config['orderby'] : 'date',
      'order' => isset($query_config['order']) ? $query_config['order'] : 'DESC',
      'post_status' => 'publish'
    ];

    if (!empty($query_config['taxonomies'])) {
      $tax_query = ['relation' => 'AND'];
      foreach ($query_config['taxonomies'] as $tax_filter) {
        if (!empty($tax_filter['taxonomy']) && !empty($tax_filter['terms'])) {
          $tax_query[] = [
            'taxonomy' => $tax_filter['taxonomy'],
            'field' => 'term_id',
            'terms' => $tax_filter['terms'],
            'operator' => isset($tax_filter['operator']) ? $tax_filter['operator'] : 'IN'
          ];
        }
      }
      if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
      }
    }

    if (!empty($query_config['meta'])) {
      $meta_query = ['relation' => 'AND'];
      foreach ($query_config['meta'] as $meta_filter) {
        if (!empty($meta_filter['key']) && isset($meta_filter['value'])) {
          $meta_query[] = [
            'key' => $meta_filter['key'],
            'value' => $meta_filter['value'],
            'type' => isset($meta_filter['type']) ? $meta_filter['type'] : 'CHAR',
            'compare' => isset($meta_filter['compare']) ? $meta_filter['compare'] : '='
          ];
        }
      }
      if (count($meta_query) > 1) {
        $args['meta_query'] = $meta_query;
      }
    }

    try {
      return \Timber::get_posts($args);
    } catch (\Exception $e) {
      error_log('Standard query error: ' . $e->getMessage());
      return [];
    }
  }
}
