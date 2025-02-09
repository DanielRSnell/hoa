<?php
namespace Artisan\Editor\Handlers;

class ClassesHandler
{
    public function __construct()
    {
        add_action('admin_body_class', [$this, 'addBodyClasses']);
        add_filter('body_class', [$this, 'addFrontendBodyClasses']);
    }

    public function addBodyClasses($classes)
    {
        if ($this->isLayoutScreen()) {
            $classes .= ' wp-handoff-layout';
        }
        if ($this->isEditorMode()) {
            $classes .= ' wp-handoff-editor-mode';
        }
        if ($this->isPreviewMode()) {
            $classes .= ' wp-handoff-preview-mode';
        }
        return $classes;
    }

    public function addFrontendBodyClasses($classes)
    {
        $classes[] = 'wp-handoff-frontend';
        
        if ($this->isEditorMode()) {
            $classes[] = 'wp-handoff-editor-active';
        }
        
        if ($this->isPreviewMode()) {
            $classes[] = 'wp-handoff-preview';
        }
        
        return $classes;
    }

    private function isLayoutScreen()
    {
        $screen = get_current_screen();
        return $screen && $screen->post_type === 'layout';
    }

    private function isEditorMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'true';
    }

    private function isPreviewMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'preview';
    }
}
