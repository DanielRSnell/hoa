<?php
namespace Artisan\Editor;

class Router
{
    private static $instance = null;
    private $layouts = [];

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        add_action('template_redirect', [$this, 'handleEditorRedirect']);
        add_filter('template_include', [$this, 'maybeLoadEditor'], 99);
    }

    public function handleEditorRedirect()
    {
        // Only process if we're not already in editor mode
        if (!isset($_GET['editor'])) {
            $current_url = $this->getCurrentUrl();
            
            if ($this->hasMatchingLayout()) {
                // Add editor query parameter while preserving existing ones
                $redirect_url = add_query_arg([
                    'editor' => 'true',
                    'route' => urlencode($current_url)
                ], $current_url);
                
                if (isset($_GET['preview'])) {
                    wp_redirect($redirect_url);
                    exit;
                }
            }
        }
    }

    public function maybeLoadEditor($template)
    {
        if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
            if ($this->hasMatchingLayout()) {
                return get_template_directory() . '/artisan/editor/views/render-editor.php';
            }
        }
        return $template;
    }

    private function hasMatchingLayout()
    {
        $layouts = $this->getLayoutsWithRules();
        
        foreach ($layouts as $layout) {
            if ($this->layoutMatchesCurrentContext($layout)) {
                return true;
            }
        }
        
        return false;
    }

    private function layoutMatchesCurrentContext($layout)
    {
        $rules = get_field('location_rules', $layout->ID);
        
        if (!$rules) {
            return false;
        }

        $type = $rules['layout_type'] ?? '';
        
        switch ($type) {
            case 'template':
                return $this->matchesTemplateRules($rules);
            
            case 'block':
                return $this->matchesBlockRules($rules);
            
            case 'header':
            case 'footer':
                return $this->matchesGlobalRules($rules);
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
            
            case 'front_page':
                return is_front_page();
            
            case 'blog_index':
                return is_home();
            
            case '404':
                return is_404();
            
            case 'search':
                return is_search();
            
            case 'author_archive':
                return is_author();
            
            case 'date_archive':
                return is_date();
        }

        return false;
    }

    private function matchesPostType($rules)
    {
        $post_type = $rules['post_type'] ?? '';
        $display_context = $rules['display_context'] ?? 'singular';

        if ($display_context === 'singular') {
            return is_singular($post_type);
        } else {
            return is_post_type_archive($post_type);
        }
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
        // For future block-specific rules
        return false;
    }

    private function matchesGlobalRules($rules)
    {
        $scope = $rules['scope'] ?? '';
        
        if ($scope === 'entire_site') {
            return true;
        }

        if ($scope === 'route_contains') {
            $pattern = $rules['route_pattern'] ?? '';
            return $pattern && strpos($this->getCurrentUrl(), $pattern) !== false;
        }

        return false;
    }

    private function getLayoutsWithRules()
    {
        if (empty($this->layouts)) {
            $this->layouts = get_posts([
                'post_type' => 'layout',
                'posts_per_page' => -1,
                'post_status' => 'publish'
            ]);
        }
        
        return $this->layouts;
    }

    private function getCurrentUrl()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
               "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}
