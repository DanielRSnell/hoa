<?php
namespace VillaCapriani\PostTypes;

class Announcement
{
    public static function register()
    {
        register_post_type('announcement', [
            'labels' => [
                'name' => 'Announcements',
                'singular_name' => 'Announcement',
            ],
            'public' => true,
            'has_archive' => 'announcements',
            'menu_icon' => 'dashicons-megaphone',
            'supports' => ['title', 'editor', 'thumbnail'],
        ]);
    }
}
