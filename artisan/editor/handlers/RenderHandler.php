<?php
namespace Artisan\Editor\Handlers;

use Timber\Timber;

class RenderHandler
{
    private $contextHandler;
    private $rulesHandler;

    public function __construct(ContextHandler $contextHandler, RulesHandler $rulesHandler)
    {
        $this->contextHandler = $contextHandler;
        $this->rulesHandler = $rulesHandler;
    }

    public function shouldRender()
    {
        // Check if editor flag is present
        if (!isset($_GET['editor']) || $_GET['editor'] !== 'true') {
            return false;
        }

        // Check if user is logged in and can edit
        if (!current_user_can('edit_posts')) {
            return false;
        }

        // For pages, check if components field exists
        if (is_page()) {
            return $this->hasComponentField();
        }

        // For other contexts, check for matching layout
        return $this->rulesHandler->hasMatchingLayout();
    }

    private function hasComponentField()
    {
        if (!function_exists('get_field')) {
            return false;
        }

        // Check if the components field exists for this page
        $components = get_field('components');
        return $components !== null; // Returns true even if empty array, false if field doesn't exist
    }

    public function render($context = [])
    {
        if (!$this->shouldRender()) {
            return false;
        }

        // Ensure ACF form head is included
        if (function_exists('acf_form_head')) {
            acf_form_head();
        }

        // Merge contexts
        $mergedContext = $this->contextHandler->mergeContext($context);

        // Add editor-specific data
        $mergedContext['editor'] = [
            'post_id' => get_the_ID(),
            'form' => [
                'post_id' => get_the_ID(),
                'post_title' => false,
                'post_content' => false,
                'submit_value' => 'Update',
                'return' => add_query_arg('editor', 'true', get_permalink()),
            ],
        ];

        echo 'Editor Rendered';

        // Render the editor template
        Timber::render('@editor/layout.twig', $mergedContext);
        exit;
    }
}
