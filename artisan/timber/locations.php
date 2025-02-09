<?php

namespace Artisan\Timber;

class Locations
{
    public function __construct()
    {
        add_filter('timber/locations', [$this, 'addLocations']);
    }

    public function addLocations($paths)
    {

        $paths['editor'] = [
            get_stylesheet_directory() . '/artisan/editor/views/editor',
        ];

        return $paths;
    }
}

return new Locations();
