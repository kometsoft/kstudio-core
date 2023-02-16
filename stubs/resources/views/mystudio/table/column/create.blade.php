@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Table : {{ $table->name }} / Create Column</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <x-page-header>
                                <h3>Migration Properties</h3>
                            </x-page-header>
                            <input type="hidden" name="column_id" value="#">

                            <div class="mb-3 row">
                                <label for="column_name" class="col-sm-2 col-form-label">Column Name</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="column_name" value=""> -->
                                    <input class="form-control width-1" type="text" name="column_name">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="column_type" class="col-sm-2 col-form-label">Column Type</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="column_type" value=""> -->
                                    <select class="form-select width-1" name="column_type">
                                        @foreach ($colTypes as $colType)
                                            <option @if ($colType === 'string') selected @endif
                                                value="{{ $colType }}">{{ $colType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="length" class="col-sm-2 col-form-label">Length</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="length" value="">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="index" class="col-sm-2 col-form-label">Index</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="index" value=""> -->
                                    <select class="form-select width-1" name="column_index" id="column_index">
                                        <option value="none">None</option>
                                        <option value="primary">Primary</option>
                                        <option value="unique">Unique</option>
                                        <option value="index">Index</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="nullable" class="col-sm-2 col-form-label">Nullable</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="nullable" value=""> -->
                                    <div class="form-check mt-2">
                                        <input type="hidden" value="No" name="column_nullable">
                                        <input class="form-check-input" type="checkbox" value="Yes"
                                            name="column_nullable" id="nullable" checked>
                                        <label class="form-check-label" for="nullable">
                                            Nullable
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="default_value" class="col-sm-2 col-form-label">Default value</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="default_value" value="">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="comment" class="col-sm-2 col-form-label">Comment</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="comment" value="">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <x-page-header>
                                <h3>HTML Properties</h3>
                            </x-page-header>

                            <div class="mb-3 row">
                                <label for="column name" class="col-sm-2 col-form-label">Input Type</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="column name" value=""> -->
                                    <select class="form-select width-1" name="html_input_type">
                                        @foreach ($fieldTypes as $fieldType)
                                            <option @if ($fieldType === 'text') selected @endif
                                                value="{{ $fieldType }}">{{ $fieldType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Input Label</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        value="">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Default
                                    Value</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        value="">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Placeholder</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        value="">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Required</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="exampleFormControlInput1" value=""> -->
                                    <div class="form-check mt-2">
                                        <input type="text" name="html_required" value="No" hidden>
                                        <input class="form-check-input" type="checkbox" name="html_required"
                                            value="Yes" id="html_required">
                                        <label class="form-check-label" for="html_required">
                                            Required
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Autofocus</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="exampleFormControlInput1" value=""> -->
                                    <div class="form-check mt-2">
                                        <input type="text" name="html_autofocus" value="No" hidden>
                                        <input class="form-check-input" type="checkbox" name="html_autofocus"
                                            value="Yes" id="html_autofocus">
                                        <label class="form-check-label" for="html_autofocus">
                                            Autofocus
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Read-Only</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="exampleFormControlInput1" value=""> -->
                                    <div class="form-check mt-2">
                                        <input type="text" name="html_readonly" value="No" hidden>
                                        <input class="form-check-input" type="checkbox" name="html_readonly"
                                            value="Yes" id="html_readonly">
                                        <label class="form-check-label" for="html_readonly">
                                            Read-Only
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Disabled</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" class="form-control" id="exampleFormControlInput1" value=""> -->
                                    <div class="form-check mt-2">
                                        <input type="text" name="html_disabled" value="No" hidden>
                                        <input class="form-check-input" type="checkbox" name="html_disabled"
                                            value="Yes" id="html_disabled">
                                        <label class="form-check-label" for="html_disabled">
                                            Disabled
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <x-page-header>
                                <h3>Validation Properties</h3>
                                <button class="btn btn-outline-primary"> Add</button>
                            </x-page-header>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Validation
                                    Rule</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        value="">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Error
                                    Message</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        value="">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
