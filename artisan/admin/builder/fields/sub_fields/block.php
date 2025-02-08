<?php

return [
    [
        'key' => 'field_block_hook',
        'label' => 'Block Hook',
        'name' => 'hook_name',
        'type' => 'text',
        'instructions' => 'Enter the action hook name where this block should render (e.g., "woocommerce_before_single_product", "genesis_before_content")',
        'placeholder' => 'enter_hook_name_here',
        'required' => 1,
        'conditional_logic' => [
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'block'
                ]
            ]
        ]
    ],
    [
        'key' => 'field_block_hook_examples',
        'label' => 'Common Hooks',
        'name' => 'block_hook_examples',
        'type' => 'message',
        'message' => "Common WordPress hooks:
• wp_head - Header
• wp_footer - Footer
• the_content - Main content
• loop_start - Before post loop
• loop_end - After post loop
• genesis_before_content - Genesis theme
• genesis_after_content - Genesis theme
• woocommerce_before_main_content - WooCommerce
• woocommerce_after_main_content - WooCommerce",
        'conditional_logic' => [
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'block'
                ]
            ]
        ]
    ]
];
