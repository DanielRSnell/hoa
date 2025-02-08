<?php

namespace Artisan\Editor\Admin\Configure;

class Pages
{
    public function __construct()
    {
        add_filter('use_block_editor_for_post_type', [$this, 'disableGutenberg'], 10, 2);
        add_action('admin_init', [$this, 'removeContentEditor']);
    }

    public function disableGutenberg($use_block_editor, $post_type)
    {
        if ($post_type === 'page') {
            return false;
        }
        return $use_block_editor;
    }

    public function removeContentEditor()
    {
        remove_post_type_support('page', 'editor');
    }
}

return new Pages();
