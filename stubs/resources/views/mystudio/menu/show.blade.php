@extends('layouts.dashboard') @section('content')
    @push('styles')
        <style>
            .disabled-link {
                pointer-events: none;
            }
        </style>
    @endpush
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Menu View</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <x-page-header>
                            <h4>Menu Structure</h4>
                        </x-page-header>

                        <div class="d-flex justify-content-center">
                            <nav id="sidebar" class="sidebar js-sidebar">
                                <div class="sidebar-content js-simplebar">
                                    <a class="sidebar-brand" href="#">
                                        <span class="align-middle">{{ config('app.name', '') }}</span>
                                    </a>

                                    <ul class="sidebar-nav">
                                        @foreach ($menus as $menu)
                                            @if ($check->where('type', 'submenu')->where('parent_id', $menu['id'])->count() > 0)
                                                <li class="sidebar-item">
                                                    <a data-bs-target="#multi{{ $menu['id'] }}" data-bs-toggle="collapse"
                                                        class="sidebar-link" aria-expanded="true">
                                                        <i class="{{ $menu['icon'] }} align-middle"></i>
                                                        <span class="align-middle">{{ $menu['menu'] }}</span>
                                                    </a>
                                                    <ul id="multi{{ $menu['id'] }}"
                                                        class="sidebar-dropdown list-unstyled collapse"
                                                        data-bs-parent="#sidebar">
                                                        @foreach ($submenus as $sub)
                                                            @if ($sub['parent_id'] === $menu['id'])
                                                                <li class="sidebar-item ps-2">
                                                                    <a class="sidebar-link" href="javascript:void(0)">
                                                                        <i
                                                                            class="{{ $sub['icon'] ?? 'ti ti-circle' }} align-middle ms-2"></i>
                                                                        <span
                                                                            class="align-middle fw-light">{{ $sub['menu'] }}</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="sidebar-item">
                                                    <a class="sidebar-link" href="javascript:void(0)"><i
                                                            class="{{ $menu['icon'] }} align-middle disabled-link"></i>
                                                        <span class="align-middle">{{ $menu['menu'] }}</span> </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="card-footer justify-content-end">
                        @if (App\Models\MyStudio\MyStudio::where('type', 'menu')->exists())
                            <a href="{{ route('menu.edit') }}" class="btn btn-outline-primary me-2">
                                <i class="ti ti-pencil align-middle"></i><span class="align-middle">Edit</span>
                            </a>
                        @else
                            <a href="{{ route('menu.create') }}" class="btn btn-outline-primary me-2">Create
                                <i class="ti ti-square-plus align-middle"></i><span class="align-middle">Create</span>
                            </a>
                        @endif
                        <a href="{{ route('menu.file.menu.create') }}" class="btn btn-primary me-2">
                            <i class="ti ti-file-plus align-middle"></i><span class="align-middle">Generate</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('belowscripts')
@endpush
