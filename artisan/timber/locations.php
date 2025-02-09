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
        $paths['template'] = [
            get_stylesheet_directory() . '/src/views',
        ];

        $paths['block'] = [
            get_stylesheet_directory() . '/src/blocks',
        ];

        $paths['core'] = [
            get_stylesheet_directory() . '/views/core',
        ];

        $paths['editor'] = [
            get_stylesheet_directory() . '/artisan/editor',
        ];

        return $paths;
    }
}

return new Locations();
