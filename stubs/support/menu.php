<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

if (!function_exists('get_menu')) {
    function get_menu($path = '/json/menu.json')
    {
        if (!file_exists(resource_path($path))) {
            return [];
        }

        $tag = str_replace(".json", "", basename($path));

        if (! Cache::get($tag)) {
            Cache::forever($tag, json_decode(file_get_contents(resource_path($path))));
        }

        return Cache::get($tag);
    }
}

if (!function_exists('menu_show')) {
    function menu_show($menu)
    {
        $show          = '';
        $current_route = Route::currentRouteName();

        if (isset($menu) && is_array($menu)) {
            foreach ($menu as $_menu) {
                if (!empty($_menu->route) && $_menu->route == $current_route) {
                    $show = 'show';

                    break;
                }
            }
        }

        return $show;
    }
}
