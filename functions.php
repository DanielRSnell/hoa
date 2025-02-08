<?php
require_once __DIR__ . '/vendor/autoload.php';

use Timber\Timber;
use VillaCapriani\PostTypes\Roadmap;
use VillaCapriani\PostTypes\Announcement;
use VillaCapriani\Fields\Components;
use VillaCapriani\Core\Gutenberg;
use VillaCapriani\Core\Editor;

// Set custom views path
Timber::$dirname = ['views'];

Timber::init();

// Theme Support
add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('menus');

// Register Post Types and Fields
add_action('init', function() {
  Roadmap::register();
  Announcement::register();
  Components::register();
});

// Initialize Core Features
Gutenberg::init();
Editor::init();

// Add to Timber Context
add_filter('timber/context', function($context) {
  $context['menu'] = Timber::get_menu('primary-menu');
  return $context;
});
