<?php

if (! function_exists('acf_add_local_field_group')) {
    return;
}

// Load sub fields
$layout_type          = require __DIR__ . '/sub_fields/layout_type.php';
$admin_fields         = require __DIR__ . '/sub_fields/admin.php';
$block_fields         = require __DIR__ . '/sub_fields/block.php';
$header_footer_fields = require __DIR__ . '/sub_fields/header_footer.php';
$context_fields       = require __DIR__ . '/sub_fields/context.php';

return [
    'key'          => 'field_location_rules',
    'label'        => 'Location Rules',
    'name'         => 'location_rules',
    'type'         => 'group',
    'instructions' => 'Configure where this layout will be used.',
    'required'     => 1,
    'layout'       => 'block',
    'sub_fields'   => array_merge(
        [$layout_type],
        $admin_fields,
        $block_fields,
        $header_footer_fields,
        $context_fields
    ),

];
