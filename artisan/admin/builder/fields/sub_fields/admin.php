<?php

return [
    [
        'key' => 'field_admin_path',
        'label' => 'Admin Path',
        'name' => 'admin_path',
        'type' => 'text',
        'instructions' => 'Enter the path after /wp-admin/ (e.g., "edit.php" for Posts, "post-new.php?post_type=page" for New Page)',
        'placeholder' => 'edit.php',
        'required' => 1,
        'conditional_logic' => [
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'admin'
                ]
            ]
        ]
    ],
    [
        'key' => 'field_admin_path_examples',
        'label' => 'Common Paths',
        'name' => 'admin_path_examples',
        'type' => 'message',
        'message' => "Common admin paths:
• edit.php - Posts List
• post-new.php - New Post
• edit.php?post_type=page - Pages List
• post-new.php?post_type=page - New Page
• upload.php - Media Library
• edit-tags.php?taxonomy=category - Categories
• users.php - Users List
• options-general.php - Settings",
        'conditional_logic' => [
            [
                [
                    'field' => 'field_layout_type',
                    'operator' => '==',
                    'value' => 'admin'
                ]
            ]
        ]
    ]
];
