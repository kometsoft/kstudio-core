@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3> <a href="{{ route('table.index') }}">{{ __('Table') }}</a> : <a
                    href="{{ route('table.show', $table->id) }}">{{ $table->name }}</a> / {{ __('Column') }} :
                {{ $column['column_name'] }}</h3>

            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('Columns') }} <i class="ti ti-list align-middle"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($data['migrationProperties'] as $col)
                        <li><a class="dropdown-item  @if ($col['column_name'] == $column['column_name']) active @endif"
                                href="{{ route('column.show', [$table->id, $col['column_id']]) }}">{{ $col['column_name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="column-tab" data-bs-toggle="tab"
                                    data-bs-target="#column" type="button" role="tab" aria-controls="column"
                                    aria-selected="true">Column Properties</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="relation-tab" data-bs-toggle="tab" data-bs-target="#relation"
                                    type="button" role="tab" aria-controls="relation" aria-selected="false">HTML
                                    Properties</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="operation-tab" data-bs-toggle="tab" data-bs-target="#operation"
                                    type="button" role="tab" aria-controls="operation" aria-selected="false">Validation
                                    Properties</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="column" role="tabpanel"
                                aria-labelledby="column-tab">
                                <div class="mt-3 ms-3">
                                    <div class="mb-3 row">
                                        <label for="column_name" class="col-sm-2 col-form-label">Column Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="column_name"
                                                value="{{ $column['column_name'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="column_type" class="col-sm-2 col-form-label">Column Type</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="column_type"
                                                value="{{ $column['column_type'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="length" class="col-sm-2 col-form-label">Length</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="length"
                                                value="{{ $column['column_length'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="index" class="col-sm-2 col-form-label">Index</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="index"
                                                value="{{ $column['column_index'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="nullable" class="col-sm-2 col-form-label">Nullable</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="nullable"
                                                value="{{ $column['column_nullable'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="default_value" class="col-sm-2 col-form-label">Default value</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="default_value"
                                                value="{{ $column['column_default_value'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="comment" class="col-sm-2 col-form-label">Comment</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="comment"
                                                value="{{ $column['column_comment'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="relation" role="tabpanel" aria-labelledby="relation-tab">
                                <div class="mt-3 ms-3">
                                    <div class="mb-3 row">
                                        <label for="column name" class="col-sm-2 col-form-label">Input Type</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control" id="column name"
                                                value="{{ $html['html_input_type'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Input
                                            Label</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control"
                                                id="exampleFormControlInput1" value="{{ $html['html_label'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Default
                                            Value</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control"
                                                id="exampleFormControlInput1" value="{{ $html['html_value'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1"
                                            class="col-sm-2 col-form-label">Placeholder</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control"
                                                id="exampleFormControlInput1" value="{{ $html['html_placeholder'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1"
                                            class="col-sm-2 col-form-label">Required</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control"
                                                id="exampleFormControlInput1" value="{{ $html['html_required'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1"
                                            class="col-sm-2 col-form-label">Autofocus</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control"
                                                id="exampleFormControlInput1" value="{{ $html['html_autofocus'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1"
                                            class="col-sm-2 col-form-label">Read-Only</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control"
                                                id="exampleFormControlInput1" value="{{ $html['html_readonly'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1"
                                            class="col-sm-2 col-form-label">Disabled</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control"
                                                id="exampleFormControlInput1" value="{{ $html['html_disabled'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="operation" role="tabpanel" aria-labelledby="operation-tab">
                                <div class="ms-3 mt-3">
                                    @foreach ($validation as $val)
                                        <div class="mb-3 row">
                                            <label for="exampleFormControlInput1"
                                                class="col-sm-2 col-form-label">{{ $loop->iteration }}. Validation
                                                Rule</label>
                                            <div class="col-sm-10">
                                                <input type="text" readonly class="form-control"
                                                    id="exampleFormControlInput1" value="{{ $val['validation_rule'] }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Error
                                                Message</label>
                                            <div class="col-sm-10">
                                                <input type="text" readonly class="form-control"
                                                    id="exampleFormControlInput1"
                                                    value="{{ $val['validation_error_message'] }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer justify-content-center">
                        <a href="{{ route('column.edit', [$table->id, $column['column_id']]) }}"
                            class="btn btn-warning">Edit Column<i class="ti ti-pencil align-middle"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
