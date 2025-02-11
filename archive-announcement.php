<?php
use Artisan\Editor\Editor;
use Timber\Timber;

// Initialize context in the controller
$context = Timber::context();
$context['posts'] = Timber::get_posts();
$context['title'] = get_the_archive_title();

// Get editor instance
$editor = Editor::getInstance(); // Init Editor Instance for Live Editing

// Try to render editor first
if ($editor->render($context)) {
    return; // Editor was rendered, stop execution
}

// If editor wasn't rendered, proceed with normal template
echo 'Editor not rendered';
