@extends('layouts.dashboard')
@push('styles')
<style>
    td input.form-control {
        width: auto;
    }

    td select.form-select {
        width: auto;
    }

    td textarea.form-control {
        width: auto;
    }
</style>
@endpush
@section('content')
<div class="container-fluid p-0">
    <x-page-header>
        <h3>Create Table</h3>
    </x-page-header>

    <div class="row">
        <div class="col-md-12">
            <form id="create-table" action="{{route('table.update', $table->id)}}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5>Table</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <x-label for="name" value="Table Name" />
                            <div class="col-md-10">
                                <x-input type="text" name="name" id="name" :value="$table->name" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <x-label for="description" value="Description" />
                            <div class="col-sm-10">
                                <!-- <x-input type="text" name="description" id="description" required /> -->
                                <textarea class="form-control" name="description" id="description" cols="30" rows="3">{{$table->description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- column -->

                <div class="card">
                    <div class="card-body">
                        <x-page-header>
                            <h5>Column</h5>
                            <button type="button" name="add" id="add-column" class="btn btn-outline-primary">Add</button>
                        </x-page-header>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="columnTable">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Name</th>
                                        <th colspan="2" class="text-center">HTML Properties</th>
                                        <th colspan="7" class="text-center">Database Properties</th>
                                        <th rowspan="2">Advance settings</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <!-- <th scope="col" >Name</th> -->
                                        <th scope="col" class="text-center">Input Type</th>
                                        <th scope="col" class="text-center">Input Label</th>
                                        <th scope="col" class="text-center">Column Type</th>
                                        <th scope="col" class="text-center">Length</th>
                                        <th scope="col" class="text-center">Index</th>
                                        <th scope="col" class="text-center">Default</th>
                                        <th scope="col" class="text-center">Nullable</th>
                                        <th scope="col" class="text-center">Comment</th>
                                        <th scope="col" class="text-center">Protected</th>
                                        <!-- <th scope="col" >Advance settings</th>
                                    <th scope="col" >Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="1">
                                            <input class="form-control width-1" type="text" name="defaultMigration[0][column_name]" value="id()" readonly>
                                        </td>
                                        <td colspan="11">
                                            <div class="form-check mt-2">
                                                <input type="hidden" value="No" name="defaultMigration[0][column_enable]">
                                                <input class="form-check-input" type="checkbox" value="Yes" name="defaultMigration[0][column_enable]" id="column_enable" checked>
                                                <label class="form-check-label" for="column_enable">
                                                    Enable
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="migrationProperties[0][column_id]" value="1">
                                            <div class="col-md-12">
                                                <input class="form-control width-1" type="text" name="migrationProperties[0][column_name]" required>
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-select width-1" name="htmlProperties[0][html_input_type]">
                                                @foreach($fieldTypes as $fieldType)
                                                <option @if($fieldType['type']==='text' ) selected @endif value="{{$fieldType['type']}}">{{$fieldType['type']}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control width-1" type="text" name="htmlProperties[0][html_label]">
                                        </td>
                                        <td>
                                            <select class="form-select width-1" name="migrationProperties[0][column_type]">
                                                @foreach($colTypes as $colType)
                                                <option @if($colType['type']==='string' ) selected @endif value="{{$colType['type']}}">
                                                    {{$colType['type']}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" name="migrationProperties[0][column_length]">
                                        </td>
                                        <td>
                                            <div>
                                                <select class="form-select width-1" name="migrationProperties[0][column_index]" id="column_index">
                                                    <option value="none">None</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="unique">Unique</option>
                                                    <option value="index">Index</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="migrationProperties[0][column_default_value]">
                                        </td>
                                        <td>
                                            <div class="form-check mt-2">
                                                <input type="hidden" value="No" name="migrationProperties[0][column_nullable]">
                                                <input class="form-check-input" type="checkbox" value="Yes" name="migrationProperties[0][column_nullable]" id="nullable" checked>
                                                <label class="form-check-label" for="nullable">
                                                    Nullable
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <textarea class="form-control" name="migrationProperties[0][column_comment]" id="column_comment" cols="50" rows="2"></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check mt-2">
                                                <input type="hidden" value="No" name="migrationProperties[0][column_protected]">
                                                <input class="form-check-input" type="checkbox" value="Yes" name="migrationProperties[0][column_protected]" id="protected">
                                                <label class="form-check-label" for="protected">
                                                    Protected
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adv">
                                                <i class="ti ti-settings align-middle"></i> <span class="align-middle">Settings</span>
                                            </button>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td colspan="1"><input class="form-control width-1" type="text" name="defaultMigration[1][column_name]" value="timestamps()" readonly></td>
                                    <td colspan="11">
                                        <div class="form-check mt-2">
                                            <input type="hidden" value="No" name="defaultMigration[1][column_enable]">
                                            <input class="form-check-input" type="checkbox" value="Yes" name="defaultMigration[1][column_enable]" id="column_enable" checked>
                                            <label class="form-check-label" for="column_enable">
                                                Enable
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1"><input class="form-control width-1" type="text" name="defaultMigration[2][column_name]" value="softDeletes()" readonly></td>
                                    <td colspan="11">
                                        <div class="form-check mt-2">
                                            <input type="hidden" value="No" name="defaultMigration[2][column_enable]">
                                            <input class="form-check-input" type="checkbox" value="Yes" name="defaultMigration[2][column_enable]" id="column_enable" checked>
                                            <label class="form-check-label" for="column_enable">
                                                Enable
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                        <button type="submit" form="create-table" class="btn btn-primary">Save</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="adv" tabindex="-1" aria-labelledby="advanceSettingModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="advanceSettingModal">Advance Settings</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <hr>
                            <div class="modal-body">

                                <h5 class="card-title mb-2"> HTML Properties</h5>
                                <div class="mb-3 row">
                                    <input type="hidden" name="htmlProperties[0][column_id]" value="1">
                                    <label for="" class="col-sm-2 col-form-label">Default Value</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="htmlProperties[0][html_value]" id="html_value" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Place Holder</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="htmlProperties[0][html_placeholder]" id="html_placeholder" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="offset-md-2 col-md-4">
                                        <div class="form-check">
                                            <input type="text" name="htmlProperties[0][html_required]" value="No" hidden>
                                            <input class="form-check-input" type="checkbox" name="htmlProperties[0][html_required]" value="Yes" id="html_required">
                                            <label class="form-check-label" for="html_required">
                                                Required
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="text" name="htmlProperties[0][html_autofocus]" value="No" hidden>
                                            <input class="form-check-input" type="checkbox" name="htmlProperties[0][html_autofocus]" value="Yes" id="html_autofocus">
                                            <label class="form-check-label" for="html_autofocus">
                                                Auto-Focus
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="text" name="htmlProperties[0][html_readonly]" value="No" hidden>
                                            <input class="form-check-input" type="checkbox" name="htmlProperties[0][html_readonly]" value="Yes" id="html_readonly">
                                            <label class="form-check-label" for="html_readonly">
                                                Read-Only
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="text" name="htmlProperties[0][html_disabled]" value="No" hidden>
                                            <input class="form-check-input" type="checkbox" name="htmlProperties[0][html_disabled]" value="Yes" id="html_disabled">
                                            <label class="form-check-label" for="html_disabled">
                                                Disabled
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title"> Validation Properties</h5>
                                    <button type="button" name="add-validation" id="add-validation" class="btn btn-outline-primary">Add</button>
                                </div>

                                <div class="mb-1 row">
                                    <input type="hidden" name="validationProperties[1-0][column_id]" value="1">
                                    <label for="" class="col-sm-2 col-form-label">Validation Rule</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" placeholder="required" name="validationProperties[1-0][validation_rule]" id="validation_rule" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Error Message</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="validationProperties[1-0][validation_error_message]" placeholder="This field is required" id="validation_error_message" />
                                    </div>
                                </div>
                                <div class="validation" id="validation">

                                </div>

                            </div>
                            <hr>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->


            </form>
        </div>
    </div>

</div>


@endsection

@push('belowscripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var i = 0;
    var j = 0;
    var id = 1;
    $("#add-column").click(function () {
        ++i;
        ++id;
        //AddROW
        $("#columnTable").append(`<tr id="tr${i}">
            <td>
                <input type="hidden" name="migrationProperties[${i}][column_id]" value="${id}" id=getid${i}>
                <div class="col-md-12"><input class="form-control width-1" type="text" name="migrationProperties[${i}][column_name]" required> </div>
            </td>
            <td> 
                <select class="form-select width-1" name="htmlProperties[${i}][html_input_type]">
                    @foreach($fieldTypes as $fieldType)
                    <option @if($fieldType['type'] === 'text' ) selected @endif value="{{$fieldType['type']}}">{{$fieldType['type']}}
                    </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input class="form-control width-1" type="text" name="htmlProperties[${i}][html_label]"> 
            </td>
            <td>
                <select class="form-select width-1" name="migrationProperties[${i}][column_type]">
                    @foreach($colTypes as $colType)
                    <option @if($colType['type'] === 'string') selected @endif value="{{$colType['type']}}">{{$colType['type']}}
                    </option>
                    @endforeach
                </select>
            </td>
            <td> 
                <input class="form-control" type="number" name="migrationProperties[${i}][column_length]"> 
            </td>
            <td> 
                <div>
                    <select class="form-select width-1" name="migrationProperties[${i}][column_index]" id="column_index">
                        <option value="none">None</option>
                        <option value="primary">Primary</option>
                        <option value="unique">Unique</option>
                        <option value="index">Index</option>
                    </select>
                </div>    
            </td>
            <td>
                <input class="form-control" type="text" name="migrationProperties[${i}][column_default_value]">
            </td>
            <td>
                <div class="form-check mt-2">
                    <input type="hidden" value="No" name="migrationProperties[${i}][column_nullable]">
                    <input class="form-check-input" type="checkbox" value="Yes" name="migrationProperties[${i}][column_nullable]" id="nullable" checked>
                    <label class="form-check-label" for="nullable">Nullable</label>
                </div>        
            </td>
            <td> 
                <div>
                    <textarea class="form-control" name="migrationProperties[${i}][column_comment]" id="column_comment" cols="50" rows="2"></textarea>
                </div>
            </td>
            <td> 
                <div class="form-check mt-2">
                    <input type="hidden" value="No" name="migrationProperties[${i}][column_protected]">
                    <input class="form-check-input" type="checkbox" value="Yes" name="migrationProperties[${i}][column_protected]" id="protected">
                    <label class="form-check-label" for="protected">Protected</label>
                </div>
            </td>
            <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adv${i}">
                    <i class="ti ti-settings align-middle"></i> 
                    <span class="align-middle">Settings</span>
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-outline-danger remove-input-field">
                    <i class="ti ti-trash align-middle"></i>
                </button>
            </td>
        </tr>`);

        var tr = `#tr${i}`;
        // AddModal
        $(tr).append(`<div class="modal fade" id="adv${i}" tabindex="-1" aria-labelledby="advanceSettingModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="advanceSettingModal">Advance Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr>
                    <div class="modal-body">
                        <h5 class="card-title mb-2"> HTML Properties</h5>
                        <div class="mb-3 row">
                                <input type="hidden" name="htmlProperties[${i}][column_id]" value="${id}">
                                <label for="" class="col-sm-2 col-form-label">Default Value</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="htmlProperties[${i}][html_value]" id="html_value" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Place Holder</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="htmlProperties[${i}][html_placeholder]" id="html_placeholder" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="offset-md-2 col-md-4">
                                <div class="form-check">
                                    <input type="text" name="htmlProperties[${i}][html_required]" value="No" hidden>
                                    <input class="form-check-input" type="checkbox" name="htmlProperties[${i}][html_required]" value="Yes" id="html_required">
                                    <label class="form-check-label" for="html_required">Required</label>
                                </div>
                                <div class="form-check">
                                    <input type="text" name="htmlProperties[${i}][html_autofocus]" value="No" hidden>
                                    <input class="form-check-input" type="checkbox" name="htmlProperties[${i}][html_autofocus]" value="Yes" id="html_autofocus" >
                                    <label class="form-check-label" for="html_autofocus">Auto-Focus</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="text" name="htmlProperties[${i}][html_readonly]" value="No" hidden>
                                    <input class="form-check-input" type="checkbox" name="htmlProperties[${i}][html_readonly]" value="Yes" id="html_readonly">
                                    <label class="form-check-label" for="html_readonly">Read-Only</label>
                                </div>
                                <div class="form-check">
                                    <input type="text" name="htmlProperties[${i}][html_disabled]" value="No" hidden>
                                    <input class="form-check-input" type="checkbox" name="htmlProperties[${i}][html_disabled]" value="Yes" id="html_disabled">
                                    <label class="form-check-label" for="html_disabled">Disabled</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title"> Validation Properties</h5>
                            <button type="button" name="add-validation" id="add-validation${i}" class="btn btn-outline-primary add-validation">Add</button>
                        </div>
                        <div class="mb-1 row">
                            <input type="hidden" name="validationProperties[${id}-0][column_id]" value="${id}">
                            <label for="" class="col-sm-2 col-form-label">Validation Rule</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="required" name="validationProperties[${id}-0][validation_rule]" id="validation_rule" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Error Message</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="validationProperties[${id}-0][validation_error_message]" placeholder="This field is required" id="validation_error_message" />
                            </div>
                        </div>
                        <div class="validation" id="validation${i}"></div>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                    </div>
                </div>
            </div>
        </div>`);


        var clickname = `#add-validation${i}`;
        var divname = `#validation${i}`;
        var getid = `getid${i}`;
        var modalid = document.getElementById(getid).value;
        $(document).on('click', clickname, function () {
            j++;
            $(divname).append(`<div class="validation-input row">
                                    <div class="col-md-10">
                                        <div class="mb-1 row">
                                            <input type="hidden" name="validationProperties[${modalid}-${j}][column_id]" value="${modalid}">
                                            <label for="" class="col-sm-2 col-form-label">Validation Rule</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" placeholder="required"
                                                    name="validationProperties[${modalid}-${j}][validation_rule]" id="validation_rule" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Error Message</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                    name="validationProperties[${modalid}-${j}][validation_error_message]"
                                                    placeholder="This field is required" id="validation_error_message" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger remove-validation"><i class="ti ti-trash align-middle"></i></button>
                                    </div>
                                </div>`);
        });

    });

    //addValidation
    $("#add-validation").click(function () {
        j++;
        $("#validation").append(`<div class="validation-input row">
                                    <div class="col-md-10">
                                        <div class="mb-1 row">
                                            <input type="hidden" name="validationProperties[1-${j}][column_id]" value="1">
                                            <label for="" class="col-sm-2 col-form-label">Validation Rule</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" placeholder="required"
                                                    name="validationProperties[1-${j}][validation_rule]" id="validation_rule" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Error Message</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                    name="validationProperties[1-${j}][validation_error_message]"
                                                    placeholder="This field is required" id="validation_error_message" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger remove-validation"><i class="ti ti-trash align-middle"></i></button>
                                    </div>
                                </div>`);
    });


    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });

    // REMOVE Validation
    $(document).on('click', '.remove-validation', function () {
        $(this).parents('.validation-input').remove();
    });
</script>
@endpush