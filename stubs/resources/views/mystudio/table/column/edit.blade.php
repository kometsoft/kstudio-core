@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3><a href="{{ route('table.index') }}">{{ __('Table') }}</a> : <a
                    href="{{ route('table.show', $table->id) }}">{{ $table->name }}</a> / Edit Column :
                {{ $column['column_name'] }}</h3>

            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ __('Columns') }} <i class="ti ti-list align-middle"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($data['migrationProperties'] as $col)
                        <li><a class="dropdown-item  @if ($col['column_name'] == $column['column_name']) active @endif"
                                href="{{ route('column.edit', [$table->id, $col['column_id']]) }}">{{ $col['column_name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="edit-column" action="{{ route('column.update', [$table->id, $column['column_id']]) }}"
                            method="post">
                            @csrf
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="column-tab" data-bs-toggle="tab"
                                        data-bs-target="#column" type="button" role="tab" aria-controls="column"
                                        aria-selected="true">Column Properties</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="relation-tab" data-bs-toggle="tab" data-bs-target="#html"
                                        type="button" role="tab" aria-controls="html" aria-selected="false">HTML
                                        Properties</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="validation-tab" data-bs-toggle="tab"
                                        data-bs-target="#validation" type="button" role="tab"
                                        aria-controls="validation" aria-selected="false">Validation Properties</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <input type="hidden" class="form-control" id="column_id" name="column_id"
                                    value="{{ $column['column_id'] }}">
                                <div class="tab-pane fade show active" id="column" role="tabpanel"
                                    aria-labelledby="column-tab">

                                    <div class="mt-3 ms-3">
                                        <x-page-header>
                                            <h4 class="mb-2">Column Properties</h4>
                                        </x-page-header>
                                        <div class="mb-3 row">
                                            <label for="column_name" class="col-sm-2 col-form-label">Column Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="column_name"
                                                    name="column_name" value="{{ $column['column_name'] }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="column_type" class="col-sm-2 col-form-label">Column Type</label>
                                            <div class="col-sm-10">
                                                <!-- <input type="text" class="form-control" id="column_type" name="column_type" value="{{ $column['column_type'] }}"> -->
                                                <select class="form-select" name="column_type">
                                                    @foreach ($colTypes as $colType)
                                                        <option @if ($column['column_type'] === $colType['type']) selected @endif
                                                            value="{{ $colType['type'] }}">{{ $colType['type'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="column_length" class="col-sm-2 col-form-label">Length</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="column_length"
                                                    name="column_length" value="{{ $column['column_length'] }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="index" class="col-sm-2 col-form-label">Index</label>
                                            <div class="col-sm-10">
                                                <!-- <input type="text" class="form-control" id="index" name="column_index" value="{{ $column['column_index'] }}"> -->
                                                <select class="form-select width-1" name="column_index"
                                                    id="column_index">
                                                    <option @if ($column['column_index'] == 'none') selected @endif
                                                        value="none">None</option>
                                                    <option @if ($column['column_index'] == 'primary') selected @endif
                                                        value="primary">Primary</option>
                                                    <option @if ($column['column_index'] == 'unique') selected @endif
                                                        value="unique">Unique</option>
                                                    <option @if ($column['column_index'] == 'index') selected @endif
                                                        value="index">Index</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="nullable" class="col-sm-2 col-form-label">Nullable</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" name="column_nullable" aria-label="Required">
                                                    <option value="Yes"
                                                        @if ($column['column_nullable'] == 'Yes') selected @endif>Yes</option>
                                                    <option value="No"
                                                        @if ($column['column_nullable'] == 'No') selected @endif>No</option>
                                                </select>
                                                <!-- <input type="text" class="form-control" id="nullable" name="column_nullable" value="{{ $column['column_nullable'] }}"> -->
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="default_value" class="col-sm-2 col-form-label">Default
                                                value</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="default_value"
                                                    name="column_default_value"
                                                    value="{{ $column['column_default_value'] }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="comment" class="col-sm-2 col-form-label">Comment</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="comment"
                                                    name="column_comment" value="{{ $column['column_comment'] }}">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="protected" class="col-sm-2 col-form-label">Protected</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" name="column_protected"
                                                    aria-label="Required">
                                                    <option value="Yes"
                                                        @if ($column['column_protected'] == 'Yes') selected @endif>Yes</option>
                                                    <option value="No"
                                                        @if ($column['column_protected'] == 'No') selected @endif>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="html" role="tabpanel" aria-labelledby="html-tab">
                                    <div class="mt-3 ms-3">
                                        <x-page-header>
                                            <h4 class="mb-2">HTML Properties</h4>
                                        </x-page-header>
                                        <div class="mb-3 row">
                                            <label for="column name" class="col-sm-2 col-form-label">Input Type</label>
                                            <div class="col-sm-10">
                                                <!-- <input type="text" class="form-control" id="column name" name="html_input_type" value="{{ $html['html_input_type'] }}"> -->
                                                <select class="form-select width-1" name="html_input_type">
                                                    @foreach ($fieldTypes as $fieldType)
                                                        <option @if ($html['html_input_type'] === $fieldType['type']) selected @endif
                                                            value="{{ $fieldType['type'] }}">{{ $fieldType['type'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Input Label</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id=""
                                                    name="html_label" value="{{ $html['html_label'] }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Default Value</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id=""
                                                    name="html_value" value="{{ $html['html_value'] }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Placeholder</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id=""
                                                    name="html_placeholder" value="{{ $html['html_placeholder'] }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Required</label>
                                            <div class="col-sm-10">
                                                <!-- <input type="text" class="form-control" id="" value="{{ $html['html_required'] }}"> -->
                                                <select class="form-select" name="html_required" aria-label="Required">
                                                    <option value="Yes"
                                                        @if ($html['html_required'] == 'Yes') selected @endif>Yes</option>
                                                    <option value="No"
                                                        @if ($html['html_required'] == 'No') selected @endif>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Autofocus</label>
                                            <div class="col-sm-10">
                                                <!-- <input type="text" class="form-control" id="" value="{{ $html['html_autofocus'] }}"> -->
                                                <select class="form-select" name="html_autofocus" aria-label="Autofocus">
                                                    <option value="Yes"
                                                        @if ($html['html_autofocus'] == 'Yes') selected @endif>Yes</option>
                                                    <option value="No"
                                                        @if ($html['html_autofocus'] == 'No') selected @endif>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Read-Only</label>
                                            <div class="col-sm-10">
                                                <!-- <input type="text" class="form-control" id="" value="{{ $html['html_readonly'] }}"> -->
                                                <select class="form-select" name="html_readonly" aria-label="Read-Only">
                                                    <option value="Yes"
                                                        @if ($html['html_readonly'] == 'Yes') selected @endif>Yes</option>
                                                    <option value="No"
                                                        @if ($html['html_readonly'] == 'No') selected @endif>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Disabled</label>
                                            <div class="col-sm-10">
                                                <!-- <input type="text" class="form-control" id="" value="{{ $html['html_disabled'] }}"> -->
                                                <select class="form-select" name="html_disabled" aria-label="Disabled">
                                                    <option value="Yes"
                                                        @if ($html['html_disabled'] == 'Yes') selected @endif>Yes</option>
                                                    <option value="No"
                                                        @if ($html['html_disabled'] == 'No') selected @endif>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="validation" role="tabpanel"
                                    aria-labelledby="validation-tab">
                                    <div class="ms-3 mt-3">
                                        <x-page-header>
                                            <h4 class="mb-2">Validation Properties</h4>
                                            <button type="button" class="btn btn-outline-primary"
                                                id="add-validation">Add</button>
                                        </x-page-header>
                                        <table class="table table-bordered" id="validationTable">
                                            <thead>
                                                <tr>
                                                    <th width="10%">No.</th>
                                                    <th width="80%">Validation</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($validation as $val)
                                                    @php
                                                        $iteration = $loop->last + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}.</td>
                                                        <td>
                                                            <div class="mb-3 row">
                                                                <input type="hidden"
                                                                    name="validation[{{ $loop->iteration }}][column_id]"
                                                                    value="{{ $column['column_id'] }}">
                                                                <label for=""
                                                                    class="col-sm-2 col-form-label">Validation Rule</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        name="validation[{{ $loop->iteration }}][validation_rule]"
                                                                        id=""
                                                                        value="{{ $val['validation_rule'] }}">
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <label for=""
                                                                    class="col-sm-2 col-form-label">Error Message</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        name="validation[{{ $loop->iteration }}][validation_error_message]"
                                                                        id=""
                                                                        value="{{ $val['validation_error_message'] }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle text-center"> <button
                                                                class="btn btn-outline-danger remove-input-field"> <i
                                                                    class="ti ti-trash align-middle"></i></button> </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </form>
                        <div class="card-footer justify-content-center">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                            <button type="submit" form="edit-column" class="btn btn-primary">Update</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

@push('belowscripts')
    <script type="text/javascript">
        var i = {{ $iteration }};
        $("#add-validation").click(function() {
            ++i;
            //AddROW
            $("#validationTable").append('<tr><td>' + i +
                '.</td><td><div class="mb-3 row"><input type="hidden" name="validation[' + i +
                '][column_id]" value="{{ $column['column_id'] }}"><label for="" class="col-sm-2 col-form-label">Validation Rule</label><div class="col-sm-10"><input type="text" class="form-control" name="validation[' +
                i +
                '][validation_rule]" id="" value=""></div></div ><div class="mb-3 row"><label for="" class="col-sm-2 col-form-label">Error Message</label><div class="col-sm-10"><input type="text" class="form-control" name="validation[' +
                i +
                '][validation_error_message]" id="" value=""></div></div ></td><td class="align-middle text-center"> <button class="btn btn-outline-danger remove-input-field"> <i class="ti ti-trash align-middle"></i></button> </td></tr>'
                );

        });

        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('tr').remove();
        });
    </script>
@endpush
