<?php

namespace Artisan\Editor;

class EditorHelper {
    public static function shouldRenderEditor() {
        // Check if editor flag is present
        if (!isset($_GET['editor']) || $_GET['editor'] !== 'true') {
            return false;
        }

        // Check if user is logged in
        if (!is_user_logged_in()) {
            return false;
        }

        // Check for matching layout
        return self::hasMatchingLayout();
    }

    private static function hasMatchingLayout() {
        $layouts = get_posts([
            'post_type' => 'layout',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ]);

        foreach ($layouts as $layout) {
            $rules = get_field('location_rules', $layout->ID);
            if (self::layoutMatchesCurrentContext($rules)) {
                return true;
            }
        }

        return false;
    }

    private static function layoutMatchesCurrentContext($rules) {
        if (!$rules || empty($rules['layout_type'])) {
            return false;
        }

        $type = $rules['layout_type'];
        $context_type = $rules['context_type'] ?? '';

        // Check template rules
        if ($type === 'template') {
            switch ($context_type) {
                case 'post_type':
                    return self::matchesPostType($rules);
                case 'taxonomy':
                    return self::matchesTaxonomy($rules);
                case 'archive':
                    return is_archive();
                // Add other context types as needed
            }
        }

        return false;
    }

    private static function matchesPostType($rules) {
        $post_type = $rules['post_type'] ?? '';
        $display_context = $rules['display_context'] ?? 'singular';

        if ($display_context === 'archive') {
            return is_post_type_archive($post_type);
        }

        return is_singular($post_type);
    }

    private static function matchesTaxonomy($rules) {
        $taxonomy = $rules['taxonomy_type'] ?? '';
        $display_context = $rules['taxonomy_display_context'] ?? 'archive';

        if ($display_context === 'archive') {
            return is_tax($taxonomy) || is_category() || is_tag();
        }

        return false;
    }
}
