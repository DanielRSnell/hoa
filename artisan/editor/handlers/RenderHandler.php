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

        // Check if user is logged in
        if (!is_user_logged_in()) {
            return false;
        }

        // Check for matching layout
        return $this->rulesHandler->hasMatchingLayout();
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

        // Render the editor template
        Timber::render('@editor/layout.twig', $mergedContext);
        exit;
    }
}
