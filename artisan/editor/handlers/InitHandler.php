<?php
namespace Artisan\Editor\Handlers;

class InitHandler
{
    public function __construct()
    {
        add_action('init', [$this, 'init']);
        add_filter('admin_footer_text', [$this, 'customFooterText']);
    }

    public function init()
    {
        if ($this->isEditorMode()) {
            add_filter('show_admin_bar', '__return_false');
        }

        if ($this->isPreviewMode()) {
            add_filter('show_admin_bar', '__return_false');
        }
    }

    public function customFooterText($text)
    {
        if ($this->isLayoutScreen()) {
            return 'Built with WP Handoff Editor';
        }
        return $text;
    }

    private function isEditorMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'true';
    }

    private function isPreviewMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'preview';
    }

    private function isLayoutScreen()
    {
        $screen = get_current_screen();
        return $screen && $screen->post_type === 'layout';
    }
}
