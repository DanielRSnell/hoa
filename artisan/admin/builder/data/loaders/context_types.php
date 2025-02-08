<?php

function get_context_types() {
    $types = [
        'front_page'     => 'Front Page',
        'blog_index'     => 'Blog Index',
        '404'            => '404 Page',
        'search'         => 'Search Results',
        'date_archive'   => 'Date Archive',
        'author_archive' => 'Author Archive',
        'post_type'      => 'Post Type',
        'taxonomy'       => 'Taxonomy',
        'hook'           => 'Custom Hook',
        'route'          => 'Custom Route',
    ];

    return apply_filters('wp_handoff_context_types', $types);
}
