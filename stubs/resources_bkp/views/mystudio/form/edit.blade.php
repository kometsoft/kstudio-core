@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Edit Form</h3>
            <!-- <button type="button" class="btn btn-outline-primary" onclick="getContents()">Check</button> -->
        </x-page-header>

        <div class="row">
            <div class="col col-md-8">
                <div class="card">
                    {{-- make a div for drag and drop div for form view --}}
                    <div class="card-body">
                        <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
                            @foreach ($formData as $data)
                                @foreach ($tableDetails as $tableDetail)
                                    @foreach ($tableDetail['htmlField'] as $field)
                                        @if ($data['column_name'] === $field['column_name'])
                                            {{-- for input field - text,email,file,date,number --}}
                                            @if ($field['html_input_type'] == 'text' ||
                                                $field['html_input_type'] == 'email' ||
                                                $field['html_input_type'] == 'file' ||
                                                $field['html_input_type'] == 'date' ||
                                                $field['html_input_type'] == 'number')
                                                <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                    class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                    ondragover="noAllowDrop(event)">

                                                    <div class="icon">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">
                                                                @if ($field['html_input_type'] == 'text')
                                                                    <i class="ti ti-a-b align-middle d-inline"> </i>
                                                                @elseif($field['html_input_type'] == 'email')
                                                                    <i class="ti ti-at align-middle d-inline"> </i>
                                                                @elseif($field['html_input_type'] == 'file')
                                                                    <i class="ti ti-file-upload align-middle d-inline"> </i>
                                                                @elseif($field['html_input_type'] == 'date')
                                                                    <i class="ti ti-calendar align-middle d-inline"> </i>
                                                                @elseif($field['html_input_type'] == 'number')
                                                                    <i class="ti ti-square-1 align-middle d-inline"> </i>
                                                                @else
                                                                    <i class="ti ti-forms align-middle d-inline"> </i>
                                                                @endif
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_input_type'] }}" disabled>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_label'] }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="getContent" data-tablename="{{ $tableDetail['table_name'] }}"
                                                        data-column="{{ $field['column_name'] }}">
                                                        <x-forms.input label="{{ $field['html_label'] }}"
                                                            type="{{ $field['html_input_type'] }}"
                                                            placeholder="{{ $field['html_placeholder'] }}"
                                                            name="{{ $field['column_name'] }}" width="8">
                                                            <div class="float-end button_div mt-1 col-md-1">
                                                                <button type="button" class="btn btn-sm btn-muted"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                        class="ti ti-settings align-middle"></i></button>
                                                            </div>
                                                        </x-forms.input>
                                                    </div>
                                                </div>
                                                {{-- for input field - textarea --}}
                                            @elseif($field['html_input_type'] == 'textarea')
                                                <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                    class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                    ondragover="noAllowDrop(event)">
                                                    <div class="icon">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">
                                                                <i class="ti ti-float-left align-middle d-inline"> </i>
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_input_type'] }}" disabled>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_label'] }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="getContent" data-tablename="{{ $tableDetail['table_name'] }}"
                                                        data-column="{{ $field['column_name'] }}">
                                                        <x-forms.textarea label="{{ $field['html_label'] }}"
                                                            name="{{ $field['column_name'] }}" width="8">
                                                            <div class="float-end mt-1 col-md-1">
                                                                <button type="button" class="btn btn-sm btn-muted"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                        class="ti ti-settings align-middle"></i></button>
                                                            </div>
                                                        </x-forms.textarea>
                                                    </div>
                                                </div>
                                                {{-- for input field - dropdown --}}
                                            @elseif($field['html_input_type'] == 'dropdown')
                                                <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                    class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                    ondragover="noAllowDrop(event)">
                                                    <div class="icon">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">
                                                                <i class="ti ti-caret-down align-middle d-inline"> </i>
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_input_type'] }}" disabled>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_label'] }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="getContent" data-tablename="{{ $tableDetail['table_name'] }}"
                                                        data-column="{{ $field['column_name'] }}">
                                                        <x-forms.dropdown label="{{ $field['html_label'] }}"
                                                            name="{{ $field['column_name'] }}" width="8">
                                                            <x-slot name="option">
                                                                <option value="">Option 1</option>
                                                                <option value="">Option 2</option>
                                                            </x-slot>
                                                            <div class="float-end mt-1 col-md-1">
                                                                <button type="button" class="btn btn-sm btn-muted"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                        class="ti ti-settings align-middle"></i></button>
                                                            </div>
                                                        </x-forms.dropdown>
                                                    </div>
                                                </div>
                                                {{-- for input field - checkbox --}}
                                            @elseif($field['html_input_type'] == 'checkbox')
                                                <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                    class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                    ondragover="noAllowDrop(event)">
                                                    <div class="icon">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">
                                                                <i class="ti ti-checkbox align-middle d-inline"> </i>
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_input_type'] }}" disabled>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_label'] }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="getContent" data-tablename="{{ $tableDetail['table_name'] }}"
                                                        data-column="{{ $field['column_name'] }}">
                                                        <x-forms.checkbox label="{{ $field['html_label'] }}"
                                                            name="{{ $field['column_name'] }}" width="8">
                                                            <x-slot name="option">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Yes" name="">
                                                                    <label class="form-check-label" for="">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="No" name="">
                                                                    <label class="form-check-label" for="">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </x-slot>
                                                            <div class="float-end mt-1 col-md-1">
                                                                <button type="button" class="btn btn-sm btn-muted"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                        class="ti ti-settings align-middle"></i></button>
                                                            </div>
                                                        </x-forms.checkbox>
                                                    </div>
                                                </div>
                                                {{-- for input field - radio --}}
                                            @elseif($field['html_input_type'] == 'radio')
                                                <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                    class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                    ondragover="noAllowDrop(event)">
                                                    <div class="icon">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">
                                                                <i class="ti ti-circle-check align-middle d-inline"> </i>
                                                            </span>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_input_type'] }}" disabled>
                                                            <input type="text" class="form-control"
                                                                value="{{ $field['html_label'] }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="getContent" data-tablename="{{ $tableDetail['table_name'] }}"
                                                        data-column="{{ $field['column_name'] }}">
                                                        <x-forms.radiobutton label="{{ $field['html_label'] }}"
                                                            name="{{ $field['column_name'] }}" width="8">
                                                            <x-slot name="option">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="" value="Yes">
                                                                    <label class="form-check-label" for="">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="" value="No">
                                                                    <label class="form-check-label" for="">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </x-slot>
                                                            <div class="float-end mt-1 col-md-1">
                                                                <button type="button" class="btn btn-sm btn-muted"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                        class="ti ti-settings align-middle"></i></button>
                                                            </div>
                                                        </x-forms.radiobutton>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- for input field - others that not defined yet --}}
                                                <p>Input undefinded</p>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <div class="col col-md-4">
                {{-- make a div for drag and drop div for column based on table design --}}
                <div class="card">
                    <div class="card-body">
                        <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
                            @if (!empty($notinForm))
                                @foreach ($tableDetails as $tableDetail)
                                    <h4 ondragover="noAllowDrop(event)">{{ $tableDetail['table_name'] }}</h4>
                                    @foreach ($tableDetail['htmlField'] as $field)
                                        @foreach ($notinForm as $not)
                                            @if ($not['column_name'] === $field['column_name'])
                                                @if ($field['html_input_type'] == 'text' ||
                                                    $field['html_input_type'] == 'email' ||
                                                    $field['html_input_type'] == 'file' ||
                                                    $field['html_input_type'] == 'date' ||
                                                    $field['html_input_type'] == 'number')
                                                    <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                        class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                        ondragover="noAllowDrop(event)">

                                                        <div class="icon">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    @if ($field['html_input_type'] == 'text')
                                                                        <i class="ti ti-a-b align-middle d-inline"> </i>
                                                                    @elseif($field['html_input_type'] == 'email')
                                                                        <i class="ti ti-at align-middle d-inline"> </i>
                                                                    @elseif($field['html_input_type'] == 'file')
                                                                        <i class="ti ti-file-upload align-middle d-inline">
                                                                        </i>
                                                                    @elseif($field['html_input_type'] == 'date')
                                                                        <i class="ti ti-calendar align-middle d-inline"> </i>
                                                                    @elseif($field['html_input_type'] == 'number')
                                                                        <i class="ti ti-square-1 align-middle d-inline"> </i>
                                                                    @else
                                                                        <i class="ti ti-forms align-middle d-inline"> </i>
                                                                    @endif
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_input_type'] }}" disabled>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_label'] }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="getContent"
                                                            data-tablename="{{ $tableDetail['table_name'] }}"
                                                            data-column="{{ $field['column_name'] }}">
                                                            <x-forms.input label="{{ $field['html_label'] }}"
                                                                type="{{ $field['html_input_type'] }}"
                                                                placeholder="{{ $field['html_placeholder'] }}"
                                                                name="{{ $field['column_name'] }}" width="8">
                                                                <div class="float-end button_div mt-1 col-md-1">
                                                                    <button type="button" class="btn btn-sm btn-muted"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                            class="ti ti-settings align-middle"></i></button>
                                                                </div>
                                                            </x-forms.input>
                                                        </div>
                                                    </div>
                                                @elseif($field['html_input_type'] == 'textarea')
                                                    <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                        class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                        ondragover="noAllowDrop(event)">
                                                        <div class="icon">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="ti ti-float-left align-middle d-inline"> </i>
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_input_type'] }}" disabled>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_label'] }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="getContent"
                                                            data-tablename="{{ $tableDetail['table_name'] }}"
                                                            data-column="{{ $field['column_name'] }}">
                                                            <x-forms.textarea label="{{ $field['html_label'] }}"
                                                                name="{{ $field['column_name'] }}" width="8">
                                                                <div class="float-end mt-1 col-md-1">
                                                                    <button type="button" class="btn btn-sm btn-muted"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                            class="ti ti-settings align-middle"></i></button>
                                                                </div>
                                                            </x-forms.textarea>
                                                        </div>
                                                    </div>
                                                @elseif($field['html_input_type'] == 'dropdown')
                                                    <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                        class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                        ondragover="noAllowDrop(event)">
                                                        <div class="icon">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="ti ti-caret-down align-middle d-inline"> </i>
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_input_type'] }}" disabled>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_label'] }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="getContent"
                                                            data-tablename="{{ $tableDetail['table_name'] }}"
                                                            data-column="{{ $field['column_name'] }}">
                                                            <x-forms.dropdown label="{{ $field['html_label'] }}"
                                                                name="{{ $field['column_name'] }}" width="8">
                                                                <x-slot name="option">
                                                                    <option value="">Option 1</option>
                                                                    <option value="">Option 2</option>
                                                                </x-slot>
                                                                <div class="float-end mt-1 col-md-1">
                                                                    <button type="button" class="btn btn-sm btn-muted"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                            class="ti ti-settings align-middle"></i></button>
                                                                </div>
                                                            </x-forms.dropdown>
                                                        </div>
                                                    </div>
                                                @elseif($field['html_input_type'] == 'checkbox')
                                                    <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                        class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                        ondragover="noAllowDrop(event)">
                                                        <div class="icon">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="ti ti-checkbox align-middle d-inline"> </i>
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_input_type'] }}" disabled>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_label'] }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="getContent"
                                                            data-tablename="{{ $tableDetail['table_name'] }}"
                                                            data-column="{{ $field['column_name'] }}">
                                                            <x-forms.checkbox label="{{ $field['html_label'] }}"
                                                                name="{{ $field['column_name'] }}" width="8">
                                                                <x-slot name="option">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="Yes" name="">
                                                                        <label class="form-check-label" for="">
                                                                            Yes
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="No" name="">
                                                                        <label class="form-check-label" for="">
                                                                            No
                                                                        </label>
                                                                    </div>
                                                                </x-slot>
                                                                <div class="float-end mt-1 col-md-1">
                                                                    <button type="button" class="btn btn-sm btn-muted"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                            class="ti ti-settings align-middle"></i></button>
                                                                </div>
                                                            </x-forms.checkbox>
                                                        </div>
                                                    </div>
                                                @elseif($field['html_input_type'] == 'radio')
                                                    <div id="{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}{{ $loop->iteration }}"
                                                        class="mb-3 hover-test" draggable="true" ondragstart="drag(event)"
                                                        ondragover="noAllowDrop(event)">
                                                        <div class="icon">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">
                                                                    <i class="ti ti-circle-check align-middle d-inline"> </i>
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_input_type'] }}" disabled>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $field['html_label'] }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="getContent"
                                                            data-tablename="{{ $tableDetail['table_name'] }}"
                                                            data-column="{{ $field['column_name'] }}">
                                                            <x-forms.radiobutton label="{{ $field['html_label'] }}"
                                                                name="{{ $field['column_name'] }}" width="8">
                                                                <x-slot name="option">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="" value="Yes">
                                                                        <label class="form-check-label" for="">
                                                                            Yes
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="" value="No">
                                                                        <label class="form-check-label" for="">
                                                                            No
                                                                        </label>
                                                                    </div>
                                                                </x-slot>
                                                                <div class="float-end mt-1 col-md-1">
                                                                    <button type="button" class="btn btn-sm btn-muted"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"><i
                                                                            class="ti ti-settings align-middle"></i></button>
                                                                </div>
                                                            </x-forms.radiobutton>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p>Input undefinded</p>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <form id="create-form" action="{{ route('form.updateForm', $form_id) }}" method="post">
            @csrf

            @foreach ($tableDetails as $tableDetail)
                @foreach ($tableDetail['htmlField'] as $field)
                    <!-- Modal -->
                    <div class="modal fade" id="modal{{ $tableDetail['table_name'] }}{{ $field['column_name'] }}"
                        tabindex="-1" aria-labelledby="propertisModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="propertisModal">Properties
                                        {{ $tableDetail['table_name'] }}-{{ $field['html_label'] }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($formData as $data)
                                        @if ($data['column_name'] === $field['column_name'])
                                            <div class="mb-3 mandatory">
                                                <label for="label" class="form-label">Mandatory</label>
                                                <div class="form-check">
                                                    <input type="hidden"
                                                        name="properties[{{ $loop->iteration }}][mandatory]"
                                                        value="No">
                                                    <input name="properties[{{ $loop->iteration }}][mandatory]"
                                                        class="form-check-input" type="checkbox" value="Yes"
                                                        @if ($data['mandatory'] == 'Yes') checked @endif
                                                        id="mandatoryCheckbox{{ $loop->iteration }}">
                                                </div>
                                                <div id="MandatoryErrorMessage{{ $loop->iteration }}"
                                                    @if ($data['mandatory'] !== 'Yes') style="display:none;" @endif>
                                                    <label for="label" class="form-label">Error Message</label>
                                                    <input
                                                        name="properties[{{ $loop->iteration }}][mandatory_error_message]"
                                                        type="text" class="form-control"
                                                        value="{{ $data['mandatory_error_message'] }}">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="label" class="form-label">Label</label>
                                                <input name="properties[{{ $loop->iteration }}][label]" type="text"
                                                    class="form-control" value="{{ $data['label'] }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="" class="form-label">Place Holder</label>
                                                <input name="properties[{{ $loop->iteration }}][placeholder]"
                                                    type="text" class="form-control"
                                                    value="{{ $data['placeholder'] }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="" class="form-label">Table Name</label>
                                                <input name="properties[{{ $loop->iteration }}][table_name]"
                                                    type="text" class="form-control"
                                                    value="{{ $data['table_name'] }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="" class="form-label">Name</label>
                                                <input name="properties[{{ $loop->iteration }}][column_name]"
                                                    type="text" class="form-control"
                                                    value="{{ $data['column_name'] }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="" class="form-label">Field Type</label>
                                                <input name="properties[{{ $loop->iteration }}][field_type]"
                                                    type="text" class="form-control" value="{{ $data['type'] }}"
                                                    readonly>
                                            </div>

                                            @if ($data['type'] == 'radio' ||
                                                $data['type'] == 'dropdown' ||
                                                $data['type'] == 'checkbox')
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Option type</label>
                                                    <select name="properties[{{ $loop->iteration }}][option_type]"
                                                        data-target=".select-option{{ $field['column_id'] }}"
                                                        class="form-select" id="opt-type{{ $field['column_id'] }}">
                                                        <option value="manual" @if(data_get($data, 'option_type') == 'manual') selected @endif data-show=".manual{{ $field['column_id'] }}">
                                                            Manual Input
                                                        </option>
                                                        <option value="table" @if(data_get($data, 'option_type') == 'table') selected @endif data-show=".ref_table{{ $field['column_id'] }}">
                                                            Reference Table
                                                        </option>
                                                        <option value="data-dictionary" @if(data_get($data, 'option_type') == 'data-dictionary') selected @endif data-show=".data-dictionary{{ $field['column_id'] }}">
                                                            Data Dictionary
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="select-option{{ $field['column_id'] }}">
                                                    <div class="manual{{ $field['column_id'] }} mb-3 @if(data_get($data, 'option_type') == 'manual') show @else hide @endif">
                                                        <label for="" class="form-label">Option</label>
                                                        <div class="float-end">
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                id="add-value{{ $field['column_id'] }}"><i
                                                                    class="ti ti-plus align-middle"></i></button>
                                                        </div>
                                                        <div class="row" id="put-value{{ $field['column_id'] }}">
                                                            <input type="hidden"
                                                                name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][column_name]"
                                                                value="{{ $field['column_name'] }}">
                                                            <div class="col-md-6">
                                                                <small><label for=""
                                                                        class="form-label">Description</label></small>
                                                                <input
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][description]"
                                                                    type="text" class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <small><label for=""
                                                                        class="form-label">Value</label></small>
                                                                <input
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][value]"
                                                                    type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="ref_table{{ $field['column_id'] }} mb-3 @if(data_get($data, 'option_type') == 'table') show @else hide @endif">
                                                        <label for="" class="form-label">Option</label>
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">Reference Table</label>
                                                            <select
                                                                name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][table_reference]"
                                                                id="ref_table{{ $field['column_id'] }}" class="form-select">
                                                                <option value="">Choose Table ..</option>
                                                                @foreach ($tables as $table)
                                                                    <option value="{{ $table->id }}" @if(data_get($data, 'value.reference_table') == $table->name) selected @endif>{{ $table->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <input type="hidden"
                                                                name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][column_name]"
                                                                value="{{ $field['column_name'] }}">
                                                            <div class="col-md-6">
                                                                <small><label for="" class="form-label">Column Name(Description)</label></small>
                                                                <select
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][description_column]"
                                                                    id=""
                                                                    class="form-select column{{ $field['column_id'] }}">

                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <small><label for="" class="form-label">Column Name(Value)</label></small>
                                                                <select
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][value_column]"
                                                                    id=""
                                                                    class="form-select column{{ $field['column_id'] }}">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="data-dictionary{{ $field['column_id'] }} mb-3 @if(data_get($data, 'option_type') == 'data-dictionary')) show @else hide @endif">
                                                        <label for="" class="form-label">Option</label>
                                                        <div class="float-end">
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                id="add-value{{ $field['column_id'] }}"><i
                                                                    class="ti ti-plus align-middle"></i></button>
                                                        </div>
                                                        <div class="row">
                                                            <input type="hidden"
                                                                name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][column_name]"
                                                                value="{{ $field['column_name'] }}">
                                                            <div class="col-md-4">
                                                                <small><label for=""
                                                                        class="form-label">Type</label></small>
                                                                <select
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][lookup_type]"
                                                                    id="" class="form-select">
                                                                    @foreach ($lookup_keys as $key)
                                                                        <option value="{{ $key->key }}" @if(data_get($data, 'value.lookup_type') == $key->key) selected @endif>{{ $key->key }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <small><label for=""
                                                                        class="form-label">Filter</label></small>
                                                                <select
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][lookup_filter]"
                                                                    id="" class="form-select" multiple>
                                                                    @foreach ($lookup_columns as $data)
                                                                        <option value="{{ $data }}">{{ $data }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mb-3">
                                                    <input type="hidden"
                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][column_name]"
                                                        value="{{ $field['column_name'] }}">
                                                    <label for="" class="form-label">Value</label>
                                                    <input type="hidden"
                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][description]">
                                                    <input
                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][value]"
                                                        type="text" class="form-control" value="">
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                    @if (!empty($notinForm))
                                        @foreach ($notinForm as $not)
                                            @if ($not['column_name'] === $field['column_name'])
                                                <div class="mb-3 mandatory">
                                                    <label for="label" class="form-label">Mandatory</label>
                                                    <div class="form-check">
                                                        <input type="hidden"
                                                            name="properties[{{ $loop->iteration + $countData }}][mandatory]"
                                                            value="No">
                                                        <input
                                                            name="properties[{{ $loop->iteration + $countData }}][mandatory]"
                                                            class="form-check-input" type="checkbox" value="Yes"
                                                            @if ($field['html_required'] == 'Yes') checked @endif
                                                            id="mandatoryCheckbox{{ $loop->iteration + $countData }}">
                                                    </div>
                                                    <div id="MandatoryErrorMessage{{ $loop->iteration + $countData }}"
                                                        @if ($field['html_required'] !== 'Yes') style="display:none;" @endif>
                                                        <label for="label" class="form-label">Error Message</label>
                                                        <input
                                                            name="properties[{{ $loop->iteration + $countData }}][mandatory_error_message]"
                                                            type="text" class="form-control"
                                                            value="Medan input ini wajib diisi.">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="label" class="form-label">Label</label>
                                                    <input name="properties[{{ $loop->iteration + $countData }}][label]"
                                                        type="text" class="form-control"
                                                        value="{{ $field['html_label'] }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Place Holder</label>
                                                    <input
                                                        name="properties[{{ $loop->iteration + $countData }}][placeholder]"
                                                        type="text" class="form-control"
                                                        value="{{ $field['html_placeholder'] }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Table Name</label>
                                                    <input
                                                        name="properties[{{ $loop->iteration + $countData }}][table_name]"
                                                        type="text" class="form-control"
                                                        value="{{ $tableDetail['table_name'] }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Name</label>
                                                    <input
                                                        name="properties[{{ $loop->iteration + $countData }}][column_name]"
                                                        type="text" class="form-control"
                                                        value="{{ $field['column_name'] }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Field Type</label>
                                                    <input
                                                        name="properties[{{ $loop->iteration + $countData }}][field_type]"
                                                        type="text" class="form-control"
                                                        value="{{ $field['html_input_type'] }}" readonly>
                                                </div>

                                                @if ($field['html_input_type'] == 'radio' ||
                                                    $field['html_input_type'] == 'dropdown' ||
                                                    $field['html_input_type'] == 'checkbox')
                                                    <div class="mb-3">
                                                        <label for="" class="form-label">Option type</label>
                                                        <select name="properties[{{ $loop->iteration }}][option_type]"
                                                            data-target=".select-option{{ $field['column_id'] }}"
                                                            class="form-select" id="opt-type{{ $field['column_id'] }}">
                                                            <option value="manual" data-show=".manual{{ $field['column_id'] }}">
                                                                Manual Input</option>
                                                            <option value="table" data-show=".ref_table{{ $field['column_id'] }}">
                                                                Reference Table</option>
                                                            <option value="data-dictionary"
                                                                data-show=".data-dictionary{{ $field['column_id'] }}">Data Dictionary
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="select-option{{ $field['column_id'] }}">
                                                        <div class="manual{{ $field['column_id'] }} mb-3">
                                                            <label for="" class="form-label">Option</label>
                                                            <div class="float-end">
                                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                                    id="add-value{{ $field['column_id'] }}"><i
                                                                        class="ti ti-plus align-middle"></i></button>
                                                            </div>
                                                            <div class="row" id="put-value{{ $field['column_id'] }}">
                                                                <input type="hidden"
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][column_name]"
                                                                    value="{{ $field['column_name'] }}">
                                                                <div class="col-md-6">
                                                                    <small><label for=""
                                                                            class="form-label">Description</label></small>
                                                                    <input
                                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][description]"
                                                                        type="text" class="form-control">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <small><label for=""
                                                                            class="form-label">Value</label></small>
                                                                    <input
                                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][value]"
                                                                        type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="ref_table{{ $field['column_id'] }} mb-3 hide">
                                                            <label for="" class="form-label">Option</label>
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Reference Table</label>
                                                                <select
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][table_reference]"
                                                                    id="ref_table{{ $field['column_id'] }}" class="form-select">
                                                                    <option value="">Choose Table ..</option>
                                                                    @foreach ($tables as $table)
                                                                        <option value="{{ $table->id }}">{{ $table->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="row">
                                                                <input type="hidden"
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][column_name]"
                                                                    value="{{ $field['column_name'] }}">
                                                                <div class="col-md-6">
                                                                    <small><label for="" class="form-label">Column Name
                                                                            (Description)</label></small>
                                                                    <select
                                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][description_column]"
                                                                        id=""
                                                                        class="form-select column{{ $field['column_id'] }}">

                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <small><label for="" class="form-label">Column Name
                                                                            (Value)</label></small>
                                                                    <select
                                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][value_column]"
                                                                        id=""
                                                                        class="form-select column{{ $field['column_id'] }}">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="data-dictionary{{ $field['column_id'] }} mb-3 hide">
                                                            <label for="" class="form-label">Option</label>
                                                            <div class="float-end">
                                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                                    id="add-value{{ $field['column_id'] }}"><i
                                                                        class="ti ti-plus align-middle"></i></button>
                                                            </div>
                                                            <div class="row">
                                                                <input type="hidden"
                                                                    name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][column_name]"
                                                                    value="{{ $field['column_name'] }}">
                                                                <div class="col-md-4">
                                                                    <small><label for=""
                                                                            class="form-label">Type</label></small>
                                                                    <select
                                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][lookup_type]"
                                                                        id="" class="form-select">
                                                                        @foreach ($lookup_keys as $key)
                                                                            <option value="{{ $key->key }}">{{ $key->key }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <small><label for=""
                                                                            class="form-label">Filter</label></small>
                                                                    <select
                                                                        name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}][lookup_filter]"
                                                                        id="" class="form-select" multiple>
                                                                        @foreach ($lookup_columns as $data)
                                                                            <option value="{{ $data }}">{{ $data }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <input type="hidden"
                                                            name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][column_name]"
                                                            value="{{ $field['column_name'] }}">
                                                        <label for="" class="form-label">Value</label>
                                                        <input type="hidden"
                                                            name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][description]">
                                                        <input
                                                            name="properties_value[{{ $tableDetail['table_name'] }}-{{ $field['column_name'] }}-0][value]"
                                                            type="text" class="form-control" value="">
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                    <input name="htmlStructure[table][{{ $loop->iteration }}]" type="hidden"
                                        class="htmlStructuretable">
                                    <input name="htmlStructure[column][{{ $loop->iteration }}]" type="hidden"
                                        class="htmlStructurecolumn">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach



        </form>

        <div class="float-end">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
            <button type="submit" onclick="getContents()" form="create-form" class="btn btn-primary">Update</button>
        </div>

    </div>




@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        // get and pass innerHtml structure to input
        function getContents() {
            var elts = document.getElementById("div1").getElementsByClassName("getContent");
            // var html = [];
            for (var i = 0; i < elts.length; ++i) {

                // var html = elts[i].innerHTML;      
                var table = $(elts[i]).data('tablename');
                var column = $(elts[i]).data('column');

                // console.log(table);

                document.getElementsByClassName('htmlStructuretable')[i].value = table;
                document.getElementsByClassName('htmlStructurecolumn')[i].value = column;
            }
        }

        // Hide/Show function for mandatory and error message for each modal

        $(document).ready(function() {
            var columns = @json($tableDetails);
            columns.forEach(function(column) {
                var htmls = Object.values(column.htmlField);
                htmls.forEach(function(html) {
                    var clickname = "#mandatoryCheckbox" + html.column_id + "";
                    var divname1 = "mandatoryCheckbox" + html.column_id + "";
                    var divname2 = "MandatoryErrorMessage" + html.column_id + "";
                    $(clickname).click(function() {
                        // Get the checkbox
                        var checkBox = document.getElementById(divname1);
                        // Get the output text
                        var div = document.getElementById(divname2);
                        // If the checkbox is checked, display the output text
                        if (checkBox.checked == true) {
                            div.style.display = "block";
                        } else {
                            div.style.display = "none";
                        }
                    });

                    // append option input
                    var clickname = "#add-value" + html.column_id + "";
                    var divname = "#put-value" + html.column_id + "";
                    var j = 0;
                    $(document).on('click', clickname, function() {
                        j++;

                        $(divname).append('<input type="hidden" name="properties_value[' +
                            column.table_name + '-' + html.column_name + '-' + j +
                            '][column_name]" value="' + html.column_name +
                            '"><div class="col-md-6"><small><label for="" class="form-label">Description</label></small><input name="properties_value[' +
                            column.table_name + '-' + html.column_name + '-' + j +
                            '][description]" type="text" class="form-control"></div><div class="col-md-6"><small><label for="" class="form-label">Value</label></small><input name="properties_value[' +
                            column.table_name + '-' + html.column_name + '-' + j +
                            '][value]" type="text" class="form-control"></div>');
                    });

                    var ref_table = `#ref_table${html.column_id}`;
                    var column = `.column${html.column_id}`;
                    // Reaference Table
                    $(ref_table).change(function(e) {
                        e.preventDefault();

                        var table = $(ref_table).val();

                        $.ajax({
                            url: "/form/getData/" + table + "",
                            type: 'GET',
                            data: {
                                table: table
                            },
                            success: function(data) {
                                var selected = '';
                                
                                $(column).empty();

                                $.each(data.column, function(index,
                                    value) {
                                    var _selected = '';
                                    $(column).append(
                                        '<option ' + selected + ' value="' +
                                        value
                                        .column_name +
                                        '">' + value
                                        .column_name +
                                        '</option>');
                                });
                            }
                        });
                    });

                    $(document).ready(function (e) {
                        $(`#ref_table${html.column_id}`).trigger('change');
                    });

                    var option = `#opt-type${html.column_id}`;
                    // hide and show div based on option type choosen
                    $(document).on('change', option, function() {
                        var target = $(this).data('target');
                        var show = $("option:selected", this).data('show');
                        $(target).children().addClass('hide');
                        $(show).removeClass('hide');

                        $(option).trigger('change');

                    });

                });
            });
        });

        // DRAG AND DROP
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));

        }

        function noAllowDrop(ev) {
            ev.stopPropagation();
        }

        // DRAG AND DROP
    </script>
    <script>
        $(function() {
            $("#div1").sortable();
        });
    </script>
@endpush

@push('styles')
    <style>
        #div1 {
            min-height: 500px;
            outline: 2px dashed #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
        }

        #div2 {
            min-height: 500px;
            outline: 2px dashed #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
        }

        #div1 .hover-test {
            cursor: move;
            padding: 0.5rem 1rem;
            color: #111827;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding-bottom: -1rem;
        }

        #div1 .getContent>div {
            margin-bottom: 0px !important;
        }

        #div1 .hover-test:hover {
            background: #f3f4f6;
        }

        #div2 .hover-test {
            background: rgba(238, 238, 238, 0.7);
            cursor: move;
        }

        #div2 .icon {
            background: rgba(238, 238, 238, 0.7);
        }

        #div2 .icon input {
            text-align: center;
            font-weight: bold;
        }

        #div1 .icon {
            display: none;
        }

        #div2 .input-field {
            display: none;
        }

        .hide {
            display: none;
        }
    </style>
@endpush
