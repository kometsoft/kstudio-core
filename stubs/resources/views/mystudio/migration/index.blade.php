@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
    <x-page-header>
        <h3>{{ __('Migrations') }}</h3>
        <div>
            <a href="{{ route('migration.migrate.all') }}" class="btn btn-primary btn-md" title="Migrate all migration file">
                {{ __('Migrate All') }}
                <i class="ti ti-file-plus"></i>
            </a>
            <a type="button" class="btn btn-primary btn-md" title="Migrate:refresh all migration file" data-bs-toggle="modal" data-bs-target="#refresh-all">
                {{ __('Remigrate All') }}
                <i class="ti ti-file-plus"></i>
            </a>
            <a type="button" class="btn btn-danger btn-md" title="Migrate:refresh all migration file" data-bs-toggle="modal" data-bs-target="#reset-all">
                {{ __('Reset All') }}
                <i class="ti ti-file-plus"></i>
            </a>
        </div>
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
                                    <th scope="col">Table Id</th>
                                    <th scope="col">Table Name</th>
                                    <th scope="col">Migration File Name</th>
                                    <th scope="col" class="text-center">Migrated</th>
                                    <th scope="col" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($migrations as $migration)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $migration->settings['table_id'] }}</td>
                                    <td>{{ $migration->settings['table_name'] }}</td>
                                    <td>{{ $migration->name }}</td>
                                    <td class="text-center">
                                        @if (in_array($migration->name, $migrated))
                                        <i class="ti ti-check text-success"></i>
                                        @else
                                        <i class="ti ti-x text-danger"></i>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" title="Migrate Action">
                                            <i class="ti ti-file-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if (! in_array($migration->name, $migrated))
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('migration.migrate', $migration->name) }}">{{ __('Migrate') }}
                                                    </a>
                                                </li>
                                            @else
                                                <li><a class="dropdown-item" href="{{ route('migration.migrate.fresh', $migration->name) }}">{{ __('Remigrate') }}
                                                    </a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('migration.migrate.rollback', $migration->name) }}">{{ __('Reset') }}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No records found.
                                        {{-- <br><br>
										<a href="{{route('calendar.create')}}" class="btn btn-primary"><i class="ti ti-square-plus align-middle"></i><span class="align-middle">Create Calendar</span></a> --}}
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

<!-- Modal Refresh All-->
<div class="modal fade" id="refresh-all" tabindex="-1" aria-labelledby="refreshAllLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refreshAllLabel">Refresh All Migration File.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <p class="fw-bold text-secondary">
                    All table will be drop and data will be lost. Are you sure want to re-migrate all migration file?
                </p>
            </div>
            <hr>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('migration.migrate.refresh.all') }}" class="btn btn-danger">Confirm</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset All-->
<div class="modal fade" id="reset-all" tabindex="-1" aria-labelledby="resetAllLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetAllLabel">Reset All Migration.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <p class="fw-bold text-secondary">
                    All table will be drop and data will be lost. Are you sure want to reset all migration file?
                </p>
            </div>
            <hr>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('migration.migrate.reset.all') }}" class="btn btn-danger">Confirm</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush