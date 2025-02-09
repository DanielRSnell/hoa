<?php
require_once __DIR__ . '/vendor/autoload.php';

use Timber\Timber;
use VillaCapriani\Core\Editor;
use VillaCapriani\Core\Gutenberg;
use VillaCapriani\Models\Components;
use VillaCapriani\PostTypes\Announcement;
use VillaCapriani\PostTypes\Roadmap;

// Initialize Timber
Timber::$dirname = ['views'];
Timber::init();

// Theme Support
add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('menus');

// Initialize Builder
$builder = require_once __DIR__ . '/artisan/admin/builder/init.php';

// Register Post Types and Fields
add_action('init', function () {
    Roadmap::register();
    Announcement::register();
    Components::register();
}, 10);

// Initialize Core Features
Gutenberg::init();
Editor::init();

// Add to Timber Context
add_filter('timber/context', function ($context) use ($builder) {
    $context['menu'] = Timber::get_menu('primary-menu');
    $context['builder'] = $builder;
    return $context;
});

// Enqueue Styles
function enqueue_custom_styles()
{
    wp_enqueue_style(
        'custom-tailwind',
        get_stylesheet_directory_uri() . '/styles/output/_compiled.css',
        [],
        filemtime(get_stylesheet_directory() . '/styles/output/_compiled.css'),
        'all'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
