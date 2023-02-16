<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\Calendar;
use App\Models\MyStudio\MyStudio;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forms = MyStudio::where('type', 'form')->get();
        // get list of calendar to pass route on blade
        $calendars = Calendar::all();

        // initiate route name based on form created on mystudio table
        foreach ($forms as $form) {
            $nameRoute = Str::of($form->name)->singular()->kebab();

            // name and route based on form & route generated file - index
            $formRoute[] =
                [
                'name'  => $form->name . '-List',
                'route' => 'mystudio.' . $nameRoute . '.index',
            ];

            // name and route based on form & route generated file - create
            $formRoute[] =
                [
                'name'  => $form->name . '-Create',
                'route' => 'mystudio.' . $nameRoute . '.create',
            ];
        }

        return view('mystudio.menu.create', [
            'permissions' => Permission::all(),
            'formRoutes'  => $formRoute,
            'calendars'   => $calendars,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if request menu not empty
        if (!empty($request->menu)) {
            // store only input that has enough array of input
            foreach ($request->menu as $menu) {
                if (count($menu) > 2) {
                    $menuData[] = $menu;
                }
            }

            MyStudio::create([
                'name'        => 'Menu',
                'type'        => 'menu',
                'description' => 'Menu Management',
                'settings'    => $menuData,
            ]);

            return redirect()->route('menu.show')->with('success', 'Menu created successfully');
        } else {
            return redirect()->back()->with('failed', 'Please add menu structure before save.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (MyStudio::where('type', 'menu')->exists()) {
            $menus   = MyStudio::where('type', 'menu')->first();
            $menus   = collect($menus->settings);
            $menu    = $menus->where('type', 'menu');
            $submenu = $menus->where('type', 'submenu');
            return view('mystudio.menu.show', [
                'menus'    => $menu,
                'submenus' => $submenu,
                'check'    => $menus,
            ]);
        } else {

            $forms     = MyStudio::where('type', 'form')->get();
            $calendars = Calendar::all();
            foreach ($forms as $form) {
                $nameRoute = Str::of($form->name)->singular()->kebab();

                $formRoute[] =
                    [
                    'name'  => $form->name . '-List',
                    'route' => 'mystudio.' . $nameRoute . '.index',
                ];

                $formRoute[] =
                    [
                    'name'  => $form->name . '-Create',
                    'route' => 'mystudio.' . $nameRoute . '.create',
                ];
            }

            return view('mystudio.menu.create', [
                'permissions' => Permission::all(),
                'formRoutes'  => $formRoute ?? '',
                'calendars'   => $calendars,
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $menuManagement = MyStudio::where('type', 'menu')->first();
        $menuManagement = $menuManagement->settings;
        $colectionmenu  = collect($menuManagement);
        $menu           = $colectionmenu->where('type', 'menu');
        $submenu        = $colectionmenu->where('type', 'submenu');
        $countMenu      = $colectionmenu->where('type', 'menu')->count();
        $countSubMenu   = $colectionmenu->where('type', 'submenu')->count();
        $calendars      = Calendar::all();

        $forms = MyStudio::where('type', 'form')->get();
        foreach ($forms as $form) {
            $nameRoute = Str::of($form->name)->singular()->kebab();

            $formRoute[] =
                [
                'name'  => $form->name . '-List',
                'route' => 'mystudio.' . $nameRoute . '.index',
            ];

            $formRoute[] =
                [
                'name'  => $form->name . '-Create',
                'route' => 'mystudio.' . $nameRoute . '.create',
            ];
        }

        return view('mystudio.menu.edit', [
            'menuData'     => $menuManagement,
            'menus'        => $menu,
            'submenus'     => $submenu,
            'countMenu'    => $countMenu,
            'countSubMenu' => $countSubMenu,
            'permissions'  => Permission::all(),
            'formRoutes'   => $formRoute ?? '',
            'calendars'    => $calendars,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $menu    = MyStudio::where('type', 'menu')->first();
        $menu_id = $menu->id;

        foreach ($request->menu as $menu) {
            if (count($menu) > 2) {
                $menuData[] = $menu;
            }
        }

        $menus = MyStudio::find($menu_id);
        $menus->update([
            'settings' => $menuData,
        ]);

        return redirect()->route('menu.show')->with('success', 'Menu updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
