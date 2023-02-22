@props(['collapsed' => null])

<nav id="sidebar" class="sidebar js-sidebar @isset($collapsed) collapsed @endisset">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="{{ route('home.index') }}">
			<span class="align-middle">{{ config('app.name', 'HelpDesk') }}</span>
		</a>

        <ul class="sidebar-nav">
            <li class="sidebar-item {{ (strpos(Route::currentRouteName(), 'home') === 0) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('home.index') }}"><i class="ti ti-dashboard align-middle"></i> <span class="align-middle">{{ __('Dashboard') }}</span> </a>
            </li>

            @include('components.mystudio-sidebar')

            @if (auth()->user()->isAdmin())
            <hr>
            
            @foreach (get_menu() as $menu)
                @isset($menu->submenu)
                    <li class="sidebar-header">{{ $menu->label ?? '' }}</li>
                    @foreach ($menu->submenu as $submenu)
                        @php
                            $is_allow_submenu = true;

                            if (! empty($submenu->role)) {
                                $is_allow_submenu = auth()->user()->hasRole($submenu->role);
                            }

                            if (! empty($submenu->permission)) {
                                $is_allow_submenu = $is_allow_submenu && auth()->user()->can($submenu->permission);
                            }
                        @endphp
                        @if($is_allow_submenu)
                            <li class="sidebar-item {{ (strpos(Route::currentRouteName(), $submenu->slug) === 0) ? 'active' : '' }}">
                                <a class="sidebar-link" href="{{ route($submenu->route) }}"><i class="{{ $submenu->icon ?? '' }} align-middle"></i> <span class="align-middle">{{ $submenu->label ?? '' }}</span> </a>
                            </li>
                        @endif
                    @endforeach 
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
                            <a class="sidebar-link" href="@if(\Route::has($menu->route)) {{ route($menu->route) }} @else {{ $menu->route }} @endif"><i class="{{ $menu->icon ?? '' }} align-middle"></i> <span class="align-middle">{{ $menu->label ?? '' }}</span> </a>
                        </li>
                    @endif
                @endisset
            @endforeach
            @endif
		</ul>
	</div>
</nav>
