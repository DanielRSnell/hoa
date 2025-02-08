<?php

require_once __DIR__ . '/loaders/post-types.php';
require_once __DIR__ . '/loaders/taxonomies.php';
require_once __DIR__ . '/loaders/location_types.php';
require_once __DIR__ . '/loaders/context_types.php';

function get_all_location_data()
{

    $data = [
        'location_types' => get_location_types(),
        'context_types'  => get_context_types(),
        'post_types'     => get_context_post_types(),
        'taxonomies'     => get_context_taxonomies(),
    ];

    // Filter the data to allow for modifications
    $data = apply_filters('get_all_location_data', $data);

    return $data;
}
