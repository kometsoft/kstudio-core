@foreach (get_menu('/json/mystudio-menu.json') as $menu)
    @isset($menu->submenu)
        @php
            $_show = menu_show($menu->submenu);
        @endphp
        <li class="sidebar-item">
            <a data-bs-target="#multi-{{ \Str::of($menu->label ?? '')->lower()->kebab() }}" data-bs-toggle="collapse" class="sidebar-link" aria-expanded="true">
                @isset($menu->icon)
                    <i class="{{ $menu->icon ?? '' }} align-middle"></i>
                @endisset
                <span class="align-middle">{{ $menu->label ?? '' }}</span>
            </a>

            @foreach ($menu->submenu as $submenu)
            <ul id="multi-{{ \Str::of($menu->label ?? '')->lower()->kebab() }}" class="ps-2 sidebar-dropdown list-unstyled collapse {{ $_show }}" data-bs-parent="#sidebar">
                <li class="sidebar-item {{ (strpos(Route::currentRouteName(), $submenu->slug) === 0) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route($submenu->route, $submenu->route_id) }}">
                        <i class="{{ $submenu->icon ?? 'ti ti-circle' }} align-middle ms-2"></i>
                        <span class="align-middle fw-light">{{ $submenu->label ?? '' }}</span> 
                    </a>
                </li>
            </ul>
            @endforeach 
        </li>
    @else
        @php
            $is_allow_menu = true;

            if (! empty($menu->role)) {
                $is_allow_menu = auth()->user()->hasRole($menu->role);
            }

            if (! empty($menu->permission)) {
                $is_allow_menu = $is_allow_menu && auth()->user()->can($menu->permission);
            }
        @endphp
        @if($is_allow_menu)
            <li class="sidebar-item {{ (strpos(Route::currentRouteName(), $menu->slug) === 0) ? 'active' : '' }}">
                <a class="sidebar-link" href="@if(\Route::has($menu->route)) {{ route($menu->route, $menu->route_id) }} @else {{ $menu->route }} @endif"><i class="{{ $menu->icon ?? '' }} align-middle"></i> <span class="align-middle">{{ $menu->label ?? '' }}</span> </a>
            </li>
        @endif
    @endisset
@endforeach