<?php

function get_context_post_types() {
    $post_types = get_post_types([
        'public' => true,
    ], 'objects');

    $formatted = [];
    foreach ($post_types as $post_type) {
        $formatted[$post_type->name] = [
            'label'        => $post_type->label,
            'singular'     => $post_type->labels->singular_name,
            'has_archive'  => $post_type->has_archive,
            'hierarchical' => $post_type->hierarchical,
            'supports'     => get_all_post_type_supports($post_type->name),
        ];
    }

    return apply_filters('wp_handoff_post_types', $formatted);
}
