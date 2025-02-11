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
        $this->scripts_path = get_template_directory_uri() . '/artisan/editor/assets/scripts';
        
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendAssets']);
        
        add_action('admin_head', [$this, 'addInlineStyles']);
        add_action('wp_head', [$this, 'addEditorInlineStyles']);
    }

    public function enqueueAdminAssets($hook)
    {
        // Always load admin styles in admin
        wp_enqueue_style(
            'wp-handoff-admin',
            get_template_directory_uri() . '/artisan/editor/assets/styles/admin.css',
            [],
            $this->version
        );

        // Always load editor styles in admin
        wp_enqueue_style(
            'wp-handoff-editor',
            get_template_directory_uri() . '/artisan/editor/assets/styles/editor.css',
            [],
            $this->version
        );

        // Always load editor script in admin
        wp_enqueue_script(
            'wp-handoff-editor',
            $this->scripts_path . '/editor.js',
            ['jquery', 'acf-input'],
            $this->version,
            true
        );

        $current_screen = function_exists('\get_current_screen') ? \get_current_screen() : null;
        $screen_id = $current_screen ? $current_screen->id : '';

        wp_localize_script('wp-handoff-editor', 'wpHandoff', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_handoff_nonce'),
            'isEditor' => true,
            'isPreview' => $this->isPreviewMode(),
            'currentScreen' => $screen_id,
            'editorSettings' => $this->getEditorSettings(),
        ]);

        // Make editor.js load as a module
        add_filter('script_loader_tag', function ($tag, $handle, $src) {
            if ($handle === 'wp-handoff-editor') {
                return '<script type="module" src="' . esc_url($src) . '"></script>';
            }
            return $tag;
        }, 10, 3);

        // If we're on a layout screen, ensure media and editor are available
        if ($this->isLayoutScreen()) {
            wp_enqueue_media();
            wp_enqueue_editor();
        }
    }

    public function enqueueFrontendAssets()
    {
        // Only load editor assets if editor mode is active
        if (!$this->isEditorMode()) {
            return;
        }

        wp_enqueue_style(
            'wp-handoff-editor',
            get_template_directory_uri() . '/artisan/editor/assets/styles/editor.css',
            [],
            $this->version
        );

        wp_enqueue_script(
            'wp-handoff-editor',
            $this->scripts_path . '/editor.js',
            ['jquery', 'acf-input'],
            $this->version,
            true
        );

        $current_screen = function_exists('\get_current_screen') ? \get_current_screen() : null;
        $screen_id = $current_screen ? $current_screen->id : '';

        wp_localize_script('wp-handoff-editor', 'wpHandoff', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_handoff_nonce'),
            'isEditor' => true,
            'isPreview' => $this->isPreviewMode(),
            'currentScreen' => $screen_id,
            'editorSettings' => $this->getEditorSettings(),
        ]);

        // Make editor.js load as a module
        add_filter('script_loader_tag', function ($tag, $handle, $src) {
            if ($handle === 'wp-handoff-editor') {
                return '<script type="module" src="' . esc_url($src) . '"></script>';
            }
            return $tag;
        }, 10, 3);
    }

    public function addInlineStyles()
    {
        if ($this->isLayoutScreen()) {
            echo '<style>' . $this->getEditorStyles() . '</style>';
        }
    }

    public function addEditorInlineStyles()
    {
        if ($this->isEditorMode()) {
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
        $screen = function_exists('\get_current_screen') ? \get_current_screen() : null;
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
