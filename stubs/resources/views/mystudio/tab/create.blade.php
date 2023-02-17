@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
    <x-page-header>
        <h3>Create Tab</h3>
    </x-page-header>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tab</h5>
                    <div class="float-end">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-tab">+
                            Tab
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="create-tab" action="{{route('tabs.store')}}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <x-label for="name" value="Tab Title" />
                            <div class="col-sm-8">
                                <x-input type="text" name="title" placeholder="Tab title" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="date" class="col-sm-2 col-form-label">Parent Form</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="form" id="form">
                                    <option value="">Please choose</option>
                                    @foreach ($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="date" class="col-sm-2 col-form-label">Parent Table</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="table" id="table">

                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <x-label for="" value="Tab Title" />
                            <div class="col-sm-8">
                                <x-input type="text" name="child[0][title]" placeholder="Tab title" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="date" class="col-sm-2 col-form-label">Form</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="child[0][form]" id="subform">
                                    <option value="">Please choose</option>
                                    @foreach ($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="date" class="col-sm-2 col-form-label">Table</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="child[0][table]" id="subtable">

                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="date" class="col-sm-2 col-form-label">Relation Type</label>
                            <div class="col-sm-8">
                                <select class="form-select div-toggle" data-target=".my-relation" name="child[0][relation_type]" id="relation_type">
                                    {{-- <option value="hasOne">One To One</option> --}}
                                    <option value="hasMany" data-show=".hasMany">One To Many</option>
                                    {{-- <option value="belongsTo">Belongs To</option> --}}
                                    <option value="belongsToMany" data-show=".belongsToMany" selected>Many To Many</option>
                                    {{-- <option value="hasOneThrough">Has One Through</option>
                                    <option value="hasManyThrough">Has Many Through</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="my-relation">
                            <div class="hasMany hide">
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Parent Reference Column</label>
                                    <div class="col-sm-8">
                                        <x-input type="text" name="child[0][hasMany_foreignKey]" placeholder="table_id" />
                                        {{-- <select class="form-select relation-hasmany" name="child[0][parent_ref_column]">
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Reference Column</label>
                                    <div class="col-sm-8">
                                        <x-input type="text" name="child[0][hasMany_localKey]" placeholder="id" />
                                        {{-- <select class="form-select relation-hasMany" name="child[0][ref_column]">
                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="belongsToMany">
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Relation Table</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="child[0][relation_table]" id="relation_table">
                                            <option value="">Please choose</option>
                                            @foreach ($tables as $table)
                                            <option value="{{ $table->id }}">{{ $table->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Parent Reference Column</label>
                                    <div class="col-sm-8">
                                        <select class="form-select relation" name="child[0][belongsToMany_foreignKey]">
                                            {{-- option based on table relation choose - ajax return table column data --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Reference Column</label>
                                    <div class="col-sm-8">
                                        <select class="form-select relation" name="child[0][belongsToMany_localKey]">
                                            {{-- option based on table relation choose - ajax return table column data --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="tab">

                        </div>
                    </form>
                </div>
                <div class="card-footer justify-content-end h-8 bg-gradient-to-b from-white">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                    <button type="submit" form="create-tab" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('belowscripts')
<script type="text/javascript">
    var i = 0;
    $("#add-tab").click(function () {
        i++;

        $("#tab").append(`<div class="child-tab">
                                <div class="mb-3 row">
                                    <x-label for="" value="Tab Title" />
                                    <div class="col-sm-8">
                                        <x-input type="text" name="child[${i}][title]" placeholder="Tab title" required />
                                    </div>
                                    <div class="col-sm-1">
                                        <button class="btn btn-md btn-danger remove-tab">Delete</button>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Form</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="child[${i}][form]" id="subform${i}">
                                            <option value="">Please choose</option>
                                            @foreach ($forms as $form)
                                                <option value="{{ $form->id }}">{{ $form->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Table</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="child[${i}][table]" id="subtable${i}">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="date" class="col-sm-2 col-form-label">Relation Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-select div-toggle${i}" data-target=".my-relation${i}" name="child[${i}][relation_type]" id="relation_type">
                                            {{-- <option value="hasOne">One To One</option> --}}
                                            <option value="hasMany" data-show=".hasMany${i}">One To Many</option>
                                            {{-- <option value="belongsTo">Belongs To</option> --}}
                                            <option value="belongsToMany" data-show=".belongsToMany${i}" selected>Many To Many</option>
                                            {{-- <option value="hasOneThrough">Has One Through</option>
                                            <option value="hasManyThrough">Has Many Through</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="my-relation${i}">
                                    <div class="hasMany${i} hide">
                                        <div class="mb-3 row">
                                            <label for="date" class="col-sm-2 col-form-label">Foreign Key (column name)</label>
                                            <div class="col-sm-8">
                                                <x-input type="text" name="child[${i}][hasMany_foreignKey]" placeholder="table_id"  />
                                                {{-- <select class="form-select relation-hasmany" name="child[${i}][parent_ref_column]">
                                                </select> --}}
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="date" class="col-sm-2 col-form-label">Local Key (column name)</label>
                                            <div class="col-sm-8">
                                                <x-input type="text" name="child[${i}][hasMany_localKey]" placeholder="id"  />
                                                {{-- <select class="form-select relation-hasMany" name="child[${i}][ref_column]">
                                                </select> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="belongsToMany${i}">
                                        <div class="mb-3 row">
                                            <label for="date" class="col-sm-2 col-form-label">Relation Table</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="child[${i}][relation_table]" id="relation_table${i}">
                                                    <option value="">Please choose</option>
                                                    @foreach ($tables as $table)
                                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="date" class="col-sm-2 col-form-label">Foreign Key</label>
                                            <div class="col-sm-8">
                                                <select class="form-select relation${i}" name="child[${i}][belongsToMany_foreignKey]">
                                                    {{-- option based on table relation choose - ajax return table column data --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="date" class="col-sm-2 col-form-label">Local Key</label>
                                            <div class="col-sm-8">
                                                <select class="form-select relation${i}" name="child[${i}][belongsToMany_localKey]">
                                                    {{-- option based on table relation choose - ajax return table column data --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>`);

        var formid = `#relation_table${i}`;
        var ref = `.relation${i}`;
        $(formid).change(function (e) {
            e.preventDefault();
            var form = $(formid).val();

            $.ajax({
                url: "/tabs/getData/" + form + "",
                type: 'GET',
                data: {
                    form: form
                },
                success: function (data) {
                    $(ref).empty();
                    $.each(data, function (index, value) {
                        $(ref).append('<option value="' + value.column_name + '">' + value.column_name + '</option>');
                    })
                }
            });

        });

        var subform = `#subform${i}`;
        var subtable = `#subtable${i}`;
        // get table from subtab form choosen
        $(subform).change(function (e) {
            e.preventDefault();

            var form = $(subform).val();

            $.ajax({
                url: "/tabs/getTable/" + form + "",
                type: 'GET',
                data: {
                    form: form
                },
                success: function (data) {
                    console.log(data);
                    $(subtable).empty();
                    $.each(data, function (index, value) {
                        $(subtable).append('<option value="' + value.table_id + '">' + value.table_name + '</option>');
                    })
                }
            });
        });

        var toogle = `.div-toggle${i}`;
        // hide and show div based on relation type choosen
        $(document).on('change', toogle, function () {
            var target = $(this).data('target');
            var show = $("option:selected", this).data('show');
            $(target).children().addClass('hide');
            $(show).removeClass('hide');

            $(toogle).trigger('change');
        });

    });

    // remove Child TAB
    $(document).on('click', '.remove-tab', function () {
        $(this).parents('.child-tab').remove();
    });

    $(document).ready(function () {

        // get table from parent form choosen
        $("#form").change(function (e) {
            e.preventDefault();

            var form = $("#form").val();

            $.ajax({
                url: "/tabs/getTable/" + form + "",
                type: 'GET',
                data: {
                    form: form
                },
                success: function (data) {
                    console.log(data);
                    $('#table').empty();
                    $.each(data, function (index, value) {
                        $('#table').append('<option value="' + value.table_id + '">' + value.table_name + '</option>');
                    })
                }
            });
        });

        // get table from subtab form choosen
        $("#subform").change(function (e) {
            e.preventDefault();

            var form = $("#subform").val();

            $.ajax({
                url: "/tabs/getTable/" + form + "",
                type: 'GET',
                data: {
                    form: form
                },
                success: function (data) {
                    console.log(data);
                    $('#subtable').empty();
                    $.each(data, function (index, value) {
                        $('#subtable').append('<option value="' + value.table_id + '">' + value.table_name + '</option>');
                    })
                }
            });
        });

        // get relation table column , based on relation table choosen
        $("#relation_table").change(function (e) {
            e.preventDefault();

            var table = $("#relation_table").val();

            $.ajax({
                url: "/tabs/getData/" + table + "",
                type: 'GET',
                data: {
                    table: table
                },
                success: function (data) {
                    $('.relation').empty();
                    $.each(data, function (index, value) {
                        $('.relation').append('<option value="' + value.column_name + '">' + value.column_name + '</option>');
                    })
                }
            });
        });
    });

    // hide and show div based on relation type choosen
    $(document).on('change', '.div-toggle', function () {
        var target = $(this).data('target');
        var show = $("option:selected", this).data('show');
        $(target).children().addClass('hide');
        $(show).removeClass('hide');
    });
    $(document).ready(function () {
        $('.div-toggle').trigger('change');
    });
</script>
@endpush

@push('styles')
<style>
    .hide {
        display: none;
    }
</style>
@endpush