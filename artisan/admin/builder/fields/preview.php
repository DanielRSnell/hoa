<?php

/**
 * Preview Field Group
 * The Goal is to use information from Location Rules to determine which page to preview the layout on.
 * or to use a custom page to preview the layout.
 * There should be an input that gets populated with the url of the page to preview the layout on.
 */

return [
    'key'           => 'field_preview_select',
    'label'         => 'Preview Page',
    'name'          => 'preview_select',
    'type'          => 'select',
    'instructions'  => 'Select a page to preview this layout',
    'required'      => 0,
    'choices'       => [],
    'ui'            => 1,
    'ajax'          => 0,
    'return_format' => 'array',
    'placeholder'   => '- Select Preview Page -',
    'wrapper'       => [
        'class' => 'preview-select-wrapper',
    ],
];
