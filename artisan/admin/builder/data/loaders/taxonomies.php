<?php

function get_context_taxonomies() {
    $taxonomies = get_taxonomies([
        'public' => true,
    ], 'objects');

    $formatted = [];
    foreach ($taxonomies as $taxonomy) {
        $formatted[$taxonomy->name] = [
            'label'        => $taxonomy->label,
            'singular'     => $taxonomy->labels->singular_name,
            'hierarchical' => $taxonomy->hierarchical,
            'post_types'   => $taxonomy->object_type,
        ];
    }

    return apply_filters('wp_handoff_taxonomies', $formatted);
}
