<?php

$context = Timber::context();
$context['posts'] = Timber::get_posts();
$context['title'] = get_the_archive_title();

// The TemplateHandler will automatically handle editor rendering if needed
Timber::render('archive/index.twig', $context);
