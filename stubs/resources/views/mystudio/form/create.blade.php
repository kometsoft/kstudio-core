@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Create Form</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Form</h5>
                    </div>
                    <div class="card-body">
                        <form id="create-form" action="{{ route('form.store') }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <x-label for="name" value="Form Name" />
                                <div class="col-sm-10">
                                    <x-input type="text" name="name" id="name" value="Form {{ $formCount + 1 }}"
                                        required />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <x-label for="description" value="Description" />
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row" hidden>
                                <x-label for="name" value="Table Type" />
                                <div class="col-sm-10 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input id="table-type-single" class="form-check-input" type="radio"
                                            name="tabletype" value="single" checked>
                                        <label for="table-type-single" class="form-check-label">Single Table</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="table-type-multiple" class="form-check-input" type="radio"
                                            name="tabletype" value="multiple">
                                        <label for="table-type-multiple" class="form-check-label">Multiple Table</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row" id="single">
                                <x-label for="name" value="Table Form" />
                                <div class="col-sm-10">
                                    <select class="form-select table-used" name="table[0][table_id]" id="single-input"
                                        required>
                                        <option value="">Choose Table ..</option>
                                        @foreach ($tables as $table)
                                            <option value="{{ $table->id }}">{{ $table->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row" id="multiple" style="display:none;">
                                <x-label for="name" value="Table Form" />
                                <div class="col-sm-10 mt-2" id="CheckBoxList">
                                    @foreach ($tables as $table)
                                        <div class="form-check">
                                            <input class="form-check-input multiple" id="table-form-multiple"
                                                name="table[{{ $loop->iteration }}][table_id]" type="checkbox"
                                                value="{{ $table->id }}" id="">
                                            <label class="form-check-label" for="table-form-multiple">
                                                {{ $table->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <x-label for="name" value="Initiate field in Form Designer" />
                                <div class="mb-3 mt-2 col-md-9" id="table-column">

                                </div>
                            </div>

                            <div class="mb-3 row">
                                <x-label for="indexList" value="Index List" />
                                <div class="col-sm-10">
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-3 col-form-label">Number of Item / Page</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" type="number" name="item_per_page" value="10">
                                        </div>
                                    </div>
                                    <table class="table" id="table-list">
                                        <thead>
                                            <tr>
                                                <th scope="col">Table Name</th>
                                                <th scope="col">Field Name</th>
                                                <th scope="col">Field to Display</th>
                                                <th scope="col">Field for Filter</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer justify-content-end h-8 bg-gradient-to-b from-white">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                        <button type="submit" form="create-form" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                if (inputValue == 'single') {
                    $('#single').show();
                    $("#single-input").prop("disabled", false);
                    $(".multiple").prop("checked", false);
                    $('#multiple').hide();
                } else {
                    $('#single').hide();
                    $("#single-input").prop("disabled", true);
                    $('#multiple').show();
                }
            });
        });

        // single Table
        $(document).ready(function() {
            $(".table-used").change(function(e) {
                e.preventDefault();

                // clear div element
                $("#table-column").html("");
                $("#table-body").html("");

                var table = $("#single-input").val();

                $.ajax({
                    url: "/form/getData/" + table + "",
                    type: 'GET',
                    data: {
                        table: table
                    },
                    success: function(data) {
                        $.each(data.column, function(index, value) {
                            if (value.column_name == 'id' || value.column_name ==
                                'created_at' || value.column_name == 'updated_at') {
                                //empty
                            } else {
                                $("#table-column").append(
                                    '<div class="form-check"><input name="initiate[' +
                                    value.column_id +
                                    '][column_name]" class="form-check-input" type="checkbox" value="' +
                                    value.column_name +
                                    '" checked ><label class="form-check-label" for="">' +
                                    value.column_name + '</label></div>');
                            }
                        });
                        $.each(data.column, function(index, value) {
                            $("#table-list").append('<tr><th scope="row">' + data
                                .table + '</th><td>' + value.column_name +
                                '<input type="hidden" name="list[' + index +
                                '][field_name]" value="' + value.column_name +
                                '"></td><td><div class="form-check"><input class="" type="hidden" name="list[' +
                                index +
                                '][field_display]" value="No"><input class="form-check-input" name="list[' +
                                index +
                                '][field_display]" type="checkbox" value="Yes"></div></td><td><div class="form-check"><input class="" type="hidden" name="list[' +
                                index +
                                '][field_filter]" value="No"><input class="form-check-input" name="list[' +
                                index +
                                '][field_filter]" type="checkbox" value="Yes"></div></td></tr>'
                                );
                        });
                    }
                });
            });

        });

        // Mutiple Table
        $(document).ready(function() {
            $('#CheckBoxList').on('change', 'input[type=checkbox]', function() {

                var table = $(this).val(); // this gives me null

                if (table != null) {


                    $.ajax({
                        url: "/form/getData/" + table + "",
                        type: 'GET',
                        data: {
                            table: table
                        },
                        success: function(data) {
                            // console.log(data);
                            $.each(data.column, function(index, value) {
                                $("#table-column").append(
                                    '<div class="form-check"><input name="initiate[' +
                                    data.table + '' + value.column_id +
                                    '][column_name]" class="form-check-input" type="checkbox" value="' +
                                    value.column_name +
                                    '" ><label class="form-check-label" for="">' +
                                    value.column_name + '</label></div>');
                            });
                            $.each(data.column, function(index, value) {
                                $("#table-list").append('<tr><th scope="row">' + data
                                    .table + '<input type="hidden" name="list[' +
                                    data.table + '' + index +
                                    '][table_id]" value="' + data.id +
                                    '"></th><td>' + value.column_name +
                                    '<input type="hidden" name="list[' + data
                                    .table + '' + index + '][field_name]" value="' +
                                    value.column_name +
                                    '"></td><td><div class="form-check"><input class="" type="hidden" name="list[' +
                                    data.table + '' + index +
                                    '][field_display]" value="No"><input class="form-check-input" name="list[' +
                                    data.table + '' + index +
                                    '][field_display]" type="checkbox" value="Yes"></div></td><td><div class="form-check"><input class="" type="hidden" name="list[' +
                                    data.table + '' + index +
                                    '][field_filter]" value="No"><input class="form-check-input" name="list[' +
                                    data.table + '' + index +
                                    '][field_filter]" type="checkbox" value="Yes"></div></td></tr>'
                                    );
                            });
                        }
                    });
                }

            });
        });
    </script>
@endpush
