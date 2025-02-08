<?php
$context = Timber::context();
$context['posts'] = Timber::get_posts();
$context['is_user_logged_in'] = is_user_logged_in();
Timber::render('archive/roadmap.twig', $context);
