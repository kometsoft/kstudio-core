@extends('layouts.dashboard') @section('content')
<div class="container-fluid p-0">
    <x-page-header>
        <h3>Edit Tab {{ $tab->name }}</h3>
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
                    {{-- Parent tab --}}
                    <form id="update-tab" action="{{route('tabs.update', $tab->id)}}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <x-label for="name" value="Tab Title" />
                            <div class="col-sm-8">
                                <x-input type="text" name="title" value="{{ $tab->settings['title'] }}" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Parent Form</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="form" id="form">
                                    <option value="">Please choose</option>
                                    @foreach ($forms as $form)
                                    <option value="{{ $form->id }}" @if ($tab->settings['form_id'] === $form->id)
                                        selected
                                        @endif
                                        >{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Parent Table</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="table" id="table">
                                    <option value="{{ $tab->settings['table_id'] }}">{{ $tab->settings['table'] }}</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        {{-- Sub Tab --}}
                        @foreach ($subtabs as $sub)
                        <div class="child-tab">
                            <div class="mb-3 row">
                                <x-label for="" value="Tab Title" />
                                <div class="col-sm-8">
                                    <x-input type="text" name="child[{{ $loop->iteration }}][title]" value="{{ $sub['title'] }}" required />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Form</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="child[{{ $loop->iteration }}][form]" id="subform{{ $loop->iteration }}">
                                        @foreach ($forms as $form)
                                        <option value="{{ $form->id }}" @if ($sub['form_id']===$form->id)
                                            selected
                                            @endif
                                            >{{ $form->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-md btn-danger remove-tab">Delete</button>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Table</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="child[{{ $loop->iteration }}][table]" id="subtable{{ $loop->iteration }}">
                                        <option value="{{ $sub['table_id'] }}">{{ $sub['table'] }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Relation Type</label>
                                <div class="col-sm-8">
                                    <select class="form-select div-toggle{{ $loop->iteration }}" data-target=".my-relation{{ $loop->iteration }}" name="child[{{ $loop->iteration }}][relation_type]" id="relation_type">
                                        {{-- <option value="hasOne">One To One</option> --}}
                                        <option value="hasMany" @if($sub['relation_type']==='hasMany' ) selected @endif data-show=".hasMany{{ $loop->iteration }}">One To Many</option>
                                        {{-- <option value="belongsTo">Belongs To</option> --}}
                                        <option value="belongsToMany" @if($sub['relation_type']==='belongsToMany' ) selected @endif data-show=".belongsToMany{{ $loop->iteration }}">Many To Many</option>
                                        {{-- <option value="hasOneThrough">Has One Through</option>
                                        <option value="hasManyThrough">Has Many Through</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="my-relation{{ $loop->iteration }}">
                                <div class="hasMany{{ $loop->iteration }} @if ($sub['relation_type'] === 'belongsToMany')
                                hide 
                                @endif ">
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Parent Reference Column</label>
                                        <div class="col-sm-8">
                                            <x-input type="text" name="child[{{ $loop->iteration }}][hasMany_foreignKey]" value="{{ $sub['foreign_key'] }}" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Reference Column</label>
                                        <div class="col-sm-8">
                                            <x-input type="text" name="child[{{ $loop->iteration }}][hasMany_localKey]" value="{{ $sub['local_key'] }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="belongsToMany{{ $loop->iteration }} @if ($sub['relation_type'] === 'hasMany')
                                hide 
                                @endif ">
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Relation Table</label>
                                        <div class="col-sm-8">
                                            <select class="form-select" name="child[{{ $loop->iteration }}][relation_table]" id="relation_table{{ $loop->iteration }}">
                                                @foreach ($tables as $table)
                                                <option value="{{ $table->id }}" @if ($sub['ref_table_id']===$table->id)
                                                    selected
                                                    @endif
                                                    >{{ $table->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Parent Reference Column</label>
                                        <div class="col-sm-8">
                                            <select class="form-select relation{{ $loop->iteration }}" name="child[{{ $loop->iteration }}][belongsToMany_foreignKey]">
                                                @if (!empty($sub['list_column']))
                                                @foreach ($sub['list_column'] as $list)
                                                <option value="{{ $list['column_name'] }}" @if ($sub['foreign_key']===$list['column_name']) selected @endif>{{ $list['column_name'] }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="" class="col-sm-2 col-form-label">Reference Column</label>
                                        <div class="col-sm-8">
                                            <select class="form-select relation{{ $loop->iteration }}" name="child[{{ $loop->iteration }}][belongsToMany_localKey]">
                                                @if (!empty($sub['list_column']))
                                                @foreach ($sub['list_column'] as $list)
                                                <option value="{{ $list['column_name'] }}" @if ($sub['local_key']===$list['column_name']) selected @endif>{{ $list['column_name'] }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        @endforeach
                        <div id="tab">

                        </div>
                    </form>
                </div>
                <div class="card-footer justify-content-end h-8 bg-gradient-to-b from-white">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                    <button type="submit" form="update-tab" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('belowscripts')
<script type="text/javascript">
    // Existing data from settings
    $(document).ready(function () {
        var subtabs = @json($subtabs);
        var id = 0;

        subtabs.forEach(function (subtab, ) {
            id++;
            var setting_formid = `#relation_table${id}`;
            var setting_ref = `.relation${id}`;
            var toogle = `.div-toggle${id}`;

            // hide and show div based on relation type choosen
            $(document).on('change', toogle, function () {
                var target = $(this).data('target');
                var show = $("option:selected", this).data('show');
                $(target).children().addClass('hide');
                $(show).removeClass('hide');

                $(toogle).trigger('change');

            });

            $(setting_formid).change(function (e) {
                e.preventDefault();
                var table = $(setting_formid).val();

                $.ajax({
                    url: "/tabs/getData/" + table + "",
                    type: 'GET',
                    data: {
                        table: table
                    },
                    success: function (data) {
                        $(setting_ref).empty();
                        console.log(data);
                        $.each(data, function (index, value) {
                            $(setting_ref).append('<option value="' + value.column_name + '">' + value.column_name + '</option>');
                        })
                    }
                });
            });


            var subform = `#subform${id}`;
            var subtable = `#subtable${id}`;
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

        });

    });

    // New tabs data
    var i = {
        {
            $countTab
        }
    };
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
                                    <label for="" class="col-sm-2 col-form-label">Form</label>
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
                                    <label for="" class="col-sm-2 col-form-label">Table</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="child[${i}][table]" id="subtable${i}">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Relation Type</label>
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
                                            <label for="" class="col-sm-2 col-form-label">Foreign Key (column name)</label>
                                            <div class="col-sm-8">
                                                <x-input type="text" name="child[${i}][hasMany_foreignKey]" placeholder="table_id"  />
                                                {{-- <select class="form-select relation-hasmany" name="child[${i}][parent_ref_column]">
                                                </select> --}}
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Local Key (column name)</label>
                                            <div class="col-sm-8">
                                                <x-input type="text" name="child[${i}][hasMany_localKey]" placeholder="id"  />
                                                {{-- <select class="form-select relation-hasMany" name="child[${i}][ref_column]">
                                                </select> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="belongsToMany${i}">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Relation Table</label>
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
                                            <label for="" class="col-sm-2 col-form-label">Foreign Key</label>
                                            <div class="col-sm-8">
                                                <select class="form-select relation${i}" name="child[${i}][belongsToMany_foreignKey]">
                                                    {{-- option based on table relation choose - ajax return table column data --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Local Key</label>
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

        // get table from subtab form choosen
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
</script>
@endpush

@push('styles')
<style>
    .hide {
        display: none;
    }
</style>
@endpush