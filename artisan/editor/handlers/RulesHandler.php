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

        $type = $rules['layout_type'];
        $context_type = $rules['context_type'] ?? '';

        switch ($type) {
            case 'template':
                return $this->matchesTemplateRules($rules);
            case 'block':
                return $this->matchesBlockRules($rules);
            case 'header':
            case 'footer':
                return $this->matchesHeaderFooterRules($rules);
        }

        return false;
    }

    private function matchesTemplateRules($rules)
    {
        $context_type = $rules['context_type'] ?? '';

        switch ($context_type) {
            case 'post_type':
                return $this->matchesPostType($rules);
            case 'taxonomy':
                return $this->matchesTaxonomy($rules);
            case 'archive':
                return is_archive();
            case 'front_page':
                return is_front_page();
            case 'search':
                return is_search();
            case '404':
                return is_404();
        }

        return false;
    }

    private function matchesPostType($rules)
    {
        $post_type = $rules['post_type'] ?? '';
        $display_context = $rules['display_context'] ?? 'singular';

        if ($display_context === 'archive') {
            return is_post_type_archive($post_type);
        }

        return is_singular($post_type);
    }

    private function matchesTaxonomy($rules)
    {
        $taxonomy = $rules['taxonomy_type'] ?? '';
        $display_context = $rules['taxonomy_display_context'] ?? 'archive';

        if ($display_context === 'archive') {
            return is_tax($taxonomy) || is_category() || is_tag();
        }

        return false;
    }

    private function matchesBlockRules($rules)
    {
        // Implement block matching logic
        return false;
    }

    private function matchesHeaderFooterRules($rules)
    {
        // Implement header/footer matching logic
        return false;
    }
}
