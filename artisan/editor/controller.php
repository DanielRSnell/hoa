<?php
namespace Artisan\Editor;

class Editor
{
    private $version = '1.0.0';
    private $styles_path;
    private $scripts_path;

    public function __construct()
    {
        $this->styles_path = get_template_directory() . '/artisan/editor/assets/styles';
        $this->scripts_path = get_template_directory() . '/artisan/editor/assets/scripts';

        add_action('init', [$this, 'init']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('admin_head', [$this, 'addInlineStyles']);
        add_action('admin_body_class', [$this, 'addBodyClasses']);
        add_filter('admin_footer_text', [$this, 'customFooterText']);
    }

    public function init()
    {
        if ($this->isEditorMode()) {
            add_filter('show_admin_bar', '__return_false');
            add_filter('template_include', [$this, 'loadEditorTemplate']);
            add_filter('body_class', [$this, 'addFrontendBodyClasses']);
        }

        if ($this->isPreviewMode()) {
            add_filter('show_admin_bar', '__return_false');
            add_filter('body_class', [$this, 'addPreviewBodyClasses']);
        }

        $this->registerEditorSettings();
    }

    public function enqueueAssets($hook)
    {
        wp_enqueue_style(
            'wp-handoff-admin',
            get_template_directory_uri() . '/artisan/editor/assets/styles/admin.css',
            [],
            $this->version
        );

        // Enqueue on all admin pages
        $this->enqueueEditorAssets();
        $this->enqueueLayoutAssets();

// Keep media and editor enqueuing for layout screen
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
        return $classes;
    }

    public function addPreviewBodyClasses($classes)
    {
        $classes[] = 'wp-handoff-preview';
        return $classes;
    }

    public function loadEditorTemplate($template)
    {
        return get_template_directory() . '/artisan/editor/views/render-editor.php';
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

    private function registerEditorSettings()
    {
        register_setting('wp_handoff_editor', 'wp_handoff_editor_settings', [
            'type' => 'object',
            'default' => $this->getDefaultEditorSettings(),
            'sanitize_callback' => [$this, 'sanitizeEditorSettings'],
        ]);
    }

    private function getDefaultEditorSettings()
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

    public function sanitizeEditorSettings($settings)
    {
        $defaults = $this->getDefaultEditorSettings();
        $sanitized = [];

        foreach ($defaults as $key => $default) {
            if (isset($settings[$key])) {
                $sanitized[$key] = $this->sanitizeSettingValue($settings[$key], $default);
            } else {
                $sanitized[$key] = $default;
            }
        }

        return $sanitized;
    }

    private function sanitizeSettingValue($value, $default)
    {
        switch (gettype($default)) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'string':
                return sanitize_text_field($value);
            default:
                return $default;
        }
    }

    public function getEditorSettings()
    {
        $settings = get_option('wp_handoff_editor_settings', $this->getDefaultEditorSettings());
        return wp_parse_args($settings, $this->getDefaultEditorSettings());
    }

    public function customFooterText($text)
    {
        if ($this->isLayoutScreen()) {
            return 'Built with WP Handoff Editor';
        }
        return $text;
    }

    public function isEditorMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'true';
    }

    public function isPreviewMode()
    {
        return isset($_GET['editor']) && $_GET['editor'] === 'preview';
    }

    public function isLayoutScreen()
    {
        $screen = get_current_screen();
        return $screen && $screen->post_type === 'layout';
    }
}

return new Editor();
