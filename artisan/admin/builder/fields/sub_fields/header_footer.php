<?php

return [
    [
        'key' => 'field_header_footer_scope',
        'label' => 'Scope',
        'name' => 'scope',
        'type' => 'select',
        'required' => 1,
        'choices' => [
            'entire_site' => 'Entire Site',
            'route_contains' => 'Route Contains'
        ],
        'conditional_logic' => [
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'header'
                ]
            ],
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'footer'
                ]
            ]
        ]
    ],
    [
        'key' => 'field_route_pattern',
        'label' => 'Route Pattern',
        'name' => 'route_pattern',
        'type' => 'text',
        'instructions' => 'Enter the route pattern to match (e.g., "movies", "products")',
        'placeholder' => 'movies',
        'conditional_logic' => [
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'header'
                ],
                [
                    'field' => 'field_header_footer_scope',
                    'operator' => '==',
                    'value' => 'route_contains'
                ]
            ],
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'footer'
                ],
                [
                    'field' => 'field_header_footer_scope',
                    'operator' => '==',
                    'value' => 'route_contains'
                ]
            ]
        ]
    ]
];
