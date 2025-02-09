<?php
use Timber\Timber;
use Artisan\Editor\Editor;

// Initialize context in the controller
$context = Timber::context();
$context['posts'] = Timber::get_posts();
$context['title'] = get_the_archive_title();

// Get editor instance
$editor = Editor::getInstance();

// Try to render editor first
if ($editor->render($context)) {
    return; // Editor was rendered, stop execution
}

// If editor wasn't rendered, proceed with normal template
Timber::render('archive/index.twig', $context);
