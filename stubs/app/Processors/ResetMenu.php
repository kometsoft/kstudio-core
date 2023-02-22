<?php

namespace App\Processors;

use App\Contracts\Processor;
use App\Models\MyStudio\MyStudio;
use Illuminate\Support\Facades\Route;

class ResetMenu implements Processor
{
    private $menu;

    public function __construct()
    {
        $this->menu = MyStudio::where('type', 'menu')->first();
    }

    public static function make()
    {
        return new self();
    }

    public function process()
    {
        try {
            if ($this->menu instanceof MyStudio) {
                $menus = $this->menu->settings;

                if (collect($menus)->count() > 0) {
                    $settings = [];

                    foreach ($menus as $menu) {
                        if (!empty($menu['url']) || (empty($menu['url']) && Route::has($menu['url']))) {
                            array_push($settings, $menu);
                        }
                    }
                    
                    if (collect($settings)->count() > 0) {
                        $this->menu->update([
                            'settings' => $settings,
                        ]);
                    }
                }

                GenerateMenu::make()->process();

                logger()->info('Menu has been successfully reset by ' . auth()->user()->name . '.');
            }
        } catch (\Throwable$th) {
            logger()->error($th->getMessage());
        }
    }
}
