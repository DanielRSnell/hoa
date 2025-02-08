<?php

require_once dirname(__FILE__) . '/../../data/controller.php';
$data = get_all_location_data();

return [
    'key' => 'field_layout_type',
    'label' => 'Layout Type',
    'name' => 'layout_type',
    'type' => 'select',
    'required' => 1,
    'choices' => $data['location_types']
];
