<?php
use Artisan\Editor\Editor;
use Timber\Timber;

// Initialize context in the controller
$context = Timber::context();
$context['post'] = Timber::get_post();

// Get editor instance
$editor = Editor::getInstance();

// Try to render editor first
if ($editor->render($context)) {
    return; // Editor was rendered, stop execution
}

/* TODO: UPDATE CONTROLLERS TO USE FLEXIBLE LAYOUTS INCLUDING RENDERER FOR PREVIEWS
 * Connect the controllers to flexible render to allow dynamic output of the components.
 * Fallabck should only occur if the compoennts array is empty, then look for /{type}.twig
 * Otherwise fallback to 404.
 * REASON FOR INDIVIDUAL CONTROLLERS:
 * - Allows for {type} logic specific to whats being rendered (example archives, products, etc.)
 * - Keeps code base modular and friendly
 * - WordPress Common core Standards
 */

// If editor wasn't rendered, proceed with normal template
Timber::render('page.twig', $context);
