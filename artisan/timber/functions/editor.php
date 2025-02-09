<?php
/**
 * Twig functions for the editor.
 */

// Define the ACF form function
function create_editor_form($form)
{
    $settings = [
        'post_id' => $form['post_id'] ?? '',
        'post_title' => $form['post_title'] ?? '',
        'post_content' => $form['post_content'] ?? '',
        'submit_value' => $form['submit_value'] ?? '',
        'return' => $form['return'] ?? '',
        'html_submit_button' => $form['html_submit_button'] ?? '',
        'html_submit_spinner' => $form['html_submit_spinner'] ?? '',
        'form_attributes' => $form['form_attributes'] ?? '',
    ];

    // Remove empty settings
    $settings = array_filter($settings);

    // Call ACF form function directly
    return acf_form($settings);
}

// Register the function with Timber/Twig
add_filter('timber/twig/functions', function ($functions) {
    $functions['createEditorForm'] = [
        'callable' => 'create_editor_form',
    ];

    return $functions;
});
