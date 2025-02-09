<?php
namespace Artisan\Editor\Handlers;

class RulesHandler
{
    public function hasMatchingLayout()
    {
        $layouts = get_posts([
            'post_type' => 'layout',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ]);

        foreach ($layouts as $layout) {
            $rules = get_field('location_rules', $layout->ID);
            if ($this->layoutMatchesCurrentContext($rules)) {
                return true;
            }
        }

        return false;
    }

    public function layoutMatchesCurrentContext($rules)
    {
        if (!$rules || empty($rules['layout_type'])) {
            return false;
        }

        if ($rules['layout_type'] !== 'template') {
            return false;
        }

        // Check context type matches
        if ($rules['context_type'] === 'post_type') {
            $post_type = $rules['post_type'] ?? '';
            $display_context = $rules['display_context'] ?? 'singular';

            // Check for archive context
            if ($display_context === 'archive') {
                return is_post_type_archive($post_type);
            }

            // Check for singular context
            return is_singular($post_type);
        }

        return false;
    }
}
