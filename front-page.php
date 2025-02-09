<?php
use Timber\Timber;
use Artisan\Editor\Editor;

// Initialize context in the controller
$context = Timber::context();
$context['post'] = Timber::get_post();

// Get editor instance
$editor = Editor::getInstance();

// Try to render editor first
if ($editor->render($context)) {
    return; // Editor was rendered, stop execution
}

// If editor wasn't rendered, proceed with normal template
Timber::render('front-page.twig', $context);
