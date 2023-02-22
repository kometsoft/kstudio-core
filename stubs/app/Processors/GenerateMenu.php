<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class GenerateMenu implements Processor
{
    private $menu;
    private $data;

    public function __construct()
    {
        $this->menu = MyStudio::where('type', 'menu')->first();
        $this->data = [];
    }

    public static function make()
    {
        return new self();
    }

    public function process()
    {
        try {
            if ($this->menu instanceof MyStudio) {
                $settings = $this->menu->settings;

                $menus    = collect($settings)->where('type', 'menu');
                $submenus = collect($settings)->where('type', 'submenu');

                // restructure menu setting data to convert into json (mystudio-menu.json)
                foreach ($menus as $menu) {
                    $route        = explode(",", $menu['url']);
                    $submenu_list = $submenus->where('parent_id', $menu['id']);

                    if ($menu['url'] != null || !empty($submenu_list)) {
                        foreach ($submenu_list as $list) {
                            $checkroute = explode(",", $list['url']);

                            if (count($checkroute) > 1) {
                                $checkroute = $checkroute[0];
                            }

                            if ($list['url'] != null && Route::has($checkroute)) {
                                $routesub = explode(",", $list['url']);

                                if (count($routesub) > 1) {
                                    ${'subs' . $list['parent_id']}[] = [
                                        "label"      => $list['menu'],
                                        "icon"       => $list['icon'],
                                        "slug"       => $routesub[0],
                                        "route"      => $routesub[0],
                                        "route_id"   => $routesub[1],
                                        "permission" => "",
                                    ];
                                } else {
                                    ${'subs' . $list['parent_id']}[] = [
                                        "label"      => $list['menu'],
                                        "icon"       => $list['icon'],
                                        "slug"       => $routesub[0],
                                        "route"      => $list['url'],
                                        "route_id"   => "",
                                        "permission" => "",
                                    ];
                                }

                            }
                        }

                        if (!empty(${'subs' . $menu['id']})) {
                            $this->data[] = [
                                "label"      => $menu['menu'],
                                "icon"       => $menu['icon'],
                                "slug"       => $menu['url'],
                                "route"      => $menu['url'],
                                "route_id"   => "",
                                "permission" => "",
                                "submenu"    => ${'subs' . $menu['id']},
                            ];
                        } else {
                            if (count($route) > 1) {
                                $this->data[] = [
                                    "label"      => $menu['menu'],
                                    "icon"       => $menu['icon'],
                                    "slug"       => $menu['url'],
                                    "route"      => $route[0],
                                    "route_id"   => $route[1],
                                    "permission" => "",
                                ];
                            } else {
                                $this->data[] = [
                                    "label"      => $menu['menu'],
                                    "icon"       => $menu['icon'],
                                    "slug"       => $menu['url'],
                                    "route"      => $menu['url'],
                                    "route_id"   => "",
                                    "permission" => "",
                                ];
                            }
                        }
                    }
                }

                $json_data = json_encode($this->data, JSON_PRETTY_PRINT);

                Storage::disk('menu')->put('mystudio-menu.json', $json_data);

                Cache::forget('mystudio-menu');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }
}
