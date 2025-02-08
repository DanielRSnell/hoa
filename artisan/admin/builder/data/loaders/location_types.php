<?php

function get_location_types() {
    $types = [
        'header'   => 'Header',
        'footer'   => 'Footer',
        'template' => 'Template',
        'block'    => 'Block',
        'admin'    => 'Admin',
    ];

    return apply_filters('wp_handoff_location_types', $types);
}
