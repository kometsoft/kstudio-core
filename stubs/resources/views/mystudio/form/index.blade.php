@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>{{ __('Forms') }}</h3>
            <a href="{{ route('form.create') }}" class="btn btn-primary"><i class="ti ti-square-plus align-middle"></i><span
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
                                        <th scope="col">Form Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($forms as $form)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $form->name }}</td>
                                            <td>{{ $form->description }}</td>
                                            <td>
                                                <a href="{{ route('form.showForm', $form->id) }}"
                                                    class="btn btn-primary btn-sm" title="Show">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('form.editForm', $form->id) }}"
                                                    class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-primary btn-sm dropdown-toggle"
                                                    id="dropdownMenuLink" data-bs-toggle="dropdown" title="Generate">
                                                    <i class="ti ti-file-plus"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Delete" data-bs-toggle="modal" data-bs-target="#delete-modal" onclick="btn_delete_click('{{ $form->id }}')">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('form.file.route.create', $form->id) }}">Generate
                                                            Route File</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('form.file.controller.create', $form->id) }}">Generate
                                                            Controller File</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('form.blade.file', $form->id) }}">Generate
                                                            Blade
                                                            File</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('form.file.data-table.create', $form->id) }}">Generate
                                                            DataTables File</a></li>
                                                </ul>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No records found.
                                                <br><br>
                                                <a href="{{ route('form.create') }}" class="btn btn-primary"><i
                                                        class="ti ti-square-plus align-middle"></i><span
                                                        class="align-middle">Create Form</span></a>
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
                    <h5 class="modal-title" id="resetAllLabel">{{ __('Delete Form') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <hr>
                <div class="modal-body">
                    <p class="fw-bold text-secondary">
                        {{ __('Are you sure want to delete this record?') }}
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
        function btn_delete_click(value) {
            $('#deleted-id').val(value);
        }

        $(document).on('click', '#confirm-delete', function() {
            var id = $('#deleted-id').val();
            var url = '{{ route('form.destroy', 0) }}';

            if (id) {
                $('#deleted-form').attr('action', url.replace('0', id)).submit();
            }
        });
    </script>
@endpush
