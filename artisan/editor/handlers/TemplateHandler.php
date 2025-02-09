<?php
namespace Artisan\Editor\Handlers;

use Timber\Timber;

class TemplateHandler
{
    public function __construct()
    {
        add_action('init', [$this, 'init']);

        // Handle template loading for editor mode
        add_filter('template_include', [$this, 'maybeLoadEditor'], 999);
    }

    public function init()
    {
        // Add editor-specific Timber locations
        add_filter('timber/locations', [$this, 'addEditorLocations']);
    }

    public function addEditorLocations($paths)
    {
        $paths['editor'] = [
            get_template_directory() . '/artisan/editor/views/editor',
        ];
        return $paths;
    }

    public function maybeLoadEditor($template)
    {
        if (isset($_GET['editor']) && $_GET['editor'] === 'true') {
            // Ensure ACF form head is included
            if (function_exists('acf_form_head')) {
                acf_form_head();
            }

            // Get the current context
            $context = Timber::context();

            // Add editor-specific context
            $context['editor'] = [
                'post_id' => get_the_ID(),
                'form' => [
                    'post_id' => get_the_ID(),
                    'post_title' => false,
                    'post_content' => false,
                    'submit_value' => 'Update Page',
                    'return' => add_query_arg('editor', 'true', get_permalink()),
                ],
            ];

            // Render the editor template
            Timber::render('@editor/layout.twig', $context);
            exit;
        }

        return $template;
    }
}
