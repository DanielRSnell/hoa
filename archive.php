<?php
$context = Timber::context();
$context['posts'] = Timber::get_posts();
$context['title'] = get_the_archive_title();
Timber::render('archive/index.twig', $context);
