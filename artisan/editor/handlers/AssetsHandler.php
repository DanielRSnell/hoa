<?php
namespace Artisan\Editor\Handlers;

class AssetsHandler
{
    private $version;
    private $styles_path;
    private $scripts_path;

    public function __construct($version)
    {
        $this->version = $version;
        $this->styles_path = get_template_directory() . '/artisan/editor/assets/styles';
        $this->scripts_path = get_template_directory() . '/artisan/editor/assets/scripts';
        
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('admin_head', [$this, 'addInlineStyles']);
    }

    public function enqueueAssets($hook)
    {
        wp_enqueue_style(
            'wp-handoff-admin',
            get_template_directory_uri() . '/artisan/editor/assets/styles/admin.css',
            [],
            $this->version
        );

        $this->enqueueEditorAssets();
        $this->enqueueLayoutAssets();

        if ($this->isLayoutScreen()) {
            wp_enqueue_media();
            wp_enqueue_editor();
        }
    }

    private function enqueueEditorAssets()
    {
        wp_enqueue_style(
            'wp-handoff-editor',
            get_template_directory_uri() . '/artisan/editor/assets/styles/editor.css',
            [],
            $this->version
        );

        wp_enqueue_script(
            'wp-handoff-editor',
            get_template_directory_uri() . '/artisan/editor/assets/scripts/editor.js',
            ['jquery', 'acf-input'],
            $this->version,
            true
        );

        wp_localize_script('wp-handoff-editor', 'wpHandoff', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_handoff_nonce'),
            'isEditor' => $this->isEditorMode(),
            'isPreview' => $this->isPreviewMode(),
            'currentScreen' => get_current_screen()->id,
            'editorSettings' => $this->getEditorSettings(),
        ]);

        add_filter('script_loader_tag', function ($tag, $handle, $src) {
            if ($handle === 'wp-handoff-editor') {
                return '<script type="module" src="' . esc_url($src) . '"></script>';
            }
            return $tag;
        }, 10, 3);
    }

    private function enqueueLayoutAssets()
    {
        wp_enqueue_style(
            'wp-handoff-layout',
            get_template_directory_uri() . '/artisan/editor/assets/styles/layout.css',
            [],
            $this->version
        );

        wp_enqueue_script(
            'wp-handoff-layout',
            get_template_directory_uri() . '/artisan/editor/assets/scripts/layout.js',
            ['jquery', 'acf-input', 'wp-handoff-editor'],
            $this->version,
            true
        );
    }

    public function addInlineStyles()
    {
        if ($this->isLayoutScreen() || $this->isEditorMode()) {
            echo '<style>' . $this->getEditorStyles() . '</style>';
        }
    }

    public function getEditorStyles()
    {
        return $this->concatenateStyles([
            $this->styles_path . '/base/*.css',
            $this->styles_path . '/layout/*.css',
            $this->styles_path . '/fields/*.css',
            $this->styles_path . '/components/*.css',
        ]);
    }

    private function concatenateStyles($patterns)
    {
        $styles = '';
        foreach ($patterns as $pattern) {
            $files = glob($pattern);
            foreach ($files as $file) {
                $styles .= file_get_contents($file) . "\n";
            }
        }
        return $styles;
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

    private function getEditorSettings()
    {
        return [
            'previewMode' => 'desktop',
            'showGrid' => true,
            'gridColumns' => 12,
            'gridGutter' => 20,
            'snapToGrid' => true,
            'showOutlines' => true,
            'showInspector' => true,
            'autoSave' => true,
            'autoSaveInterval' => 60,
            'theme' => 'system',
        ];
    }
}
