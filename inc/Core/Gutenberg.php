<?php
namespace VillaCapriani\Core;

class Gutenberg
{
    public static function init()
    {
        add_filter('use_block_editor_for_post_type', [self::class, 'disableGutenberg'], 10, 2);
        add_action('admin_init', [self::class, 'disableGutenbergStyles']);
    }

    public static function disableGutenberg($use_block_editor, $post_type)
    {
        // Only allow Gutenberg for regular posts
        return $post_type === 'post';
    }

    public static function disableGutenbergStyles()
    {
        // Remove Gutenberg styles on non-post pages
        global $pagenow;
        $screen = get_current_screen();

        if ($pagenow === 'post.php' || $pagenow === 'post-new.php') {
            if ($screen && property_exists($screen, 'post_type') && $screen->post_type !== 'post') {
                wp_dequeue_style('wp-block-library');
                wp_dequeue_style('wp-block-library-theme');
            }
        }
    }
}
