@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>{{ __('Tables') }}</h3>
            <a href="{{ route('table.create') }}" class="btn btn-primary"> <i class="ti ti-square-plus align-middle"></i><span
                    class="align-middle">Create</span></a>
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
                                        <th scope="col">Table</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tables as $table)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td> <a href="{{ route('table.show', $table->id) }}"
                                                    class="fw-bold">{{ $table->name }}</a> </td>
                                            <td>{{ $table->description }}</td>
                                            <td>
                                                @if ($table->settings === null)
                                                    <a href="{{ route('table.edit', $table->id) }}"
                                                        class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('table.show', $table->id) }}"
                                                        class="btn btn-primary btn-sm" title="Show">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @endif

                                                @if ($table->settings === null)
                                                    <a href="{{ route('table.edit', $table->id) }}"
                                                        class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('table.edit.table-column', $table->id) }}"
                                                        class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                @endif

                                                <a href="#" class="btn btn-primary btn-sm dropdown-toggle"
                                                    id="dropdownMenuLink" data-bs-toggle="dropdown" title="Generate">
                                                    <i class="ti ti-file-plus"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Delete" data-bs-toggle="modal" data-bs-target="#delete-modal" onclick="btn_delete_click('{{ $table->id }}')">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <input type="hidden" id="table_id{{ $loop->iteration }}"
                                                            value="{{ $table->id }}">
                                                        <a class="dropdown-item"
                                                            id="table_check{{ $loop->iteration }}">Generate
                                                            Migration File</a>
                                                    </li>
                                                    {{-- <li><a class="dropdown-item"
													href="{{ route('table.file.migration.create', $table->id) }}">Generate
													Migration File</a></li> --}}
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('table.file.model.create', $table->id) }}">Generate
                                                            Model File</a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="table-modal{{ $loop->iteration }}" tabindex="-1"
                                            aria-labelledby="advanceSettingModal" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="advanceSettingModal">
                                                            {{ Str::ucfirst($table->name) }} Migration File already exists.
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <hr>
                                                    <div class="modal-body">
                                                        <p class="fw-bold text-secondary">
                                                            All data in {{ $table->name }} table will be lost. Are you
                                                            sure want to overwrite the file and regenarate table?
                                                        </p>
                                                    </div>
                                                    <hr>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <a href="{{ route('table.file.migration.create', $table->id) }}"
                                                            class="btn btn-danger">Confirm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                    @empty
                                        <tr>
                                            <td colspan="4">No records found.
                                                <br><br>
                                                <a href="{{ route('table.create') }}" class="btn btn-primary"> <i
                                                        class="ti ti-square-plus align-middle"></i><span
                                                        class="align-middle">Create Table</span></a>
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

    <form id="deleted-form" action="" method="POST">
        @csrf
        @method('DELETE')

        <input type="hidden" id="deleted-id">
    </form>

    <!-- Modal Delete -->
    <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="resetAllLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetAllLabel">{{ __('Delete Table') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <hr>
                <div class="modal-body">
                    <p class="fw-bold text-secondary">
                        {{ __('This will also delete all forms, lists and calendars related to this table. Are you sure want to delete this record?') }}
                    </p>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button id="confirm-delete" type="button" class="btn btn-danger">{{ __('Confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var total_tables = @json($tables);
            var id = 0;

            total_tables.forEach(function(total_table, ) {
                id++;
                var button = `#table_check${id}`;
                var table_id = `#table_id${id}`;
                var modal = `#table-modal${id}`;

                $(button).on('click', function() {
                    var table = $(table_id).val();

                    $.ajax({
                        url: "/table/file/migration/is_exist/" + table + "",
                        type: 'GET',
                        data: {
                            table: table
                        },
                        success: function(data) {
                            console.log(data.is_exist);
                            if (data.is_exist == true) {
                                $(modal).modal('toggle');
                            } else {
                                window.location = "/table/file/migration/create/" + table + "";
                            }
                        }
                    });
                });
            });
        });

        function btn_delete_click(value) {
            $('#deleted-id').val(value);
        }

        $(document).on('click', '#confirm-delete', function() {
            var id = $('#deleted-id').val();
            var url = '{{ route('table.destroy', 0) }}';

            if (id) {
                $('#deleted-form').attr('action', url.replace('0', id)).submit();
            }
        });
    </script>
@endpush
