@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>{{ __('Calendars') }}</h3>
            <a href="{{ route('calendar.create') }}" class="btn btn-primary"><i
                    class="ti ti-square-plus align-middle"></i><span class="align-middle">Create</span></a>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Calendar Name</th>
                                        <th scope="col">Enabled on Dashboard</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($calendars as $calendar)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $calendar->name }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        @checked($calendar->dashboard_enable) disabled>
                                                </div>
                                            </td>
                                            <td>{{ $calendar->description }}</td>
                                            <td>
                                                <a href="{{ route('calendar.show', $calendar->id) }}"
                                                    class="btn btn-primary btn-sm" title="Show">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('calendar.edit', $calendar->id) }}"
                                                    class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a href="{{ route('calendar.view', $calendar->id) }}"
                                                    class="btn btn-primary btn-sm" title="View Calendar">
                                                    <i class="ti ti-calendar"></i>
                                                </a>
                                                {{-- <a href="#" class="btn btn-primary btn-sm dropdown-toggle" id="dropdownMenuLink"
											data-bs-toggle="dropdown" title="Generate">
											<i class="ti ti-file-plus"></i>
										</a>
										<a href="#" class="btn btn-danger btn-sm" title="Delete">
											<i class="ti ti-trash"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-end">
											<li><a class="dropdown-item"
													href="{{ route('form.file.route.create', $form->id) }}">Generate
										Route File</a></li>
										<li><a class="dropdown-item" href="{{ route('form.file.controller.create', $form->id) }}">Generate
												Controller File</a></li>
										<li><a class="dropdown-item" href="{{ route('form.blade.file', $form->id) }}">Generate
												Blade
												File</a></li>
										<li><a class="dropdown-item" href="{{ route('form.file.data-table.create', $form->id) }}">Generate
												DataTables File</a></li>
										</ul> --}}

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No records found.
                                                <br><br>
                                                <a href="{{ route('calendar.create') }}" class="btn btn-primary"><i
                                                        class="ti ti-square-plus align-middle"></i><span
                                                        class="align-middle">Create Calendar</span></a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
