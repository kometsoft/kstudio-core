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
        <h3>Table : {{$table->name}} / Create Relation </h3>
    </x-page-header>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Table</h5>
                    <div class="mb-3 row">
                        <x-label for="name" value="Table Name" />
                        <div class="col-sm-10">
                            <p for="name" class="h5 mt-2">{{$table->name}}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <x-label for="description" value="Description" />
                        <div class="col-sm-10">
                            <p for="description" class="h5 mt-2">{{$table->description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <x-page-header>
                        <!-- <h3>Table : {{$table->name}} / Create Relation </h3> -->
                        <h5></h5>
                        <!-- <button type="button" class="btn btn-outline-primary" id="add-relation"> Add </button> -->
                    </x-page-header>
                    <form id="create-relation" action="{{route('relation.storeRelation', $table->id)}}" method="post">
                        @csrf
                        <div id="relation">
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Relation Type</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="relation[0][relation_name]" id="relationtype">
                                        <option value="hasOne">One To One</option>
                                        <option value="hasMany">One To Many</option>
                                        <option value="belongsTo">Belongs To</option>
                                        <option value="belongsToMany">Many To Many</option>
                                        <option value="hasOneThrough">Has One Through</option>
                                        <option value="hasManyThrough">Has Many Through</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row" id="table1">
                                <label for="" class="col-sm-2 col-form-label">Table/Model (1)</label>
                                <div class="col-sm-10">
                                    <!-- <input class="form-control" type="text" name="relation[0][relation_table_first]" /> -->
                                    <select class="form-select" name="relation[0][relation_table_first]" id="">
                                        <option value="">Choose Table/Model ..</option>
                                        @foreach($tableList as $list)
                                        <option value="{{$list->name}}">{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row" style="display:none;" id="table2">
                                <label for="" class="col-sm-2 col-form-label">Table/Model (2)</label>
                                <div class="col-sm-10">
                                    <!-- <input class="form-control" type="text" name="relation[0][relation_table_second]" /> -->
                                    <select class="form-select" name="relation[0][relation_table_second]" id="">
                                        <option value="">Choose Table/Model ..</option>
                                        @foreach($tableList as $list)
                                        <option value="{{$list->name}}">{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row" id="argument1">
                                <label for="" class="col-sm-2 col-form-label">Argument (1)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[0][relation_first_argument]" />
                                </div>
                            </div>
                            <div class="mb-3 row" id="argument2">
                                <label for="" class="col-sm-2 col-form-label">Argument (2)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[0][relation_second_argument]" />
                                </div>
                            </div>
                            <div class="mb-3 row" style="display:none;" id="argument3">
                                <label for="" class="col-sm-2 col-form-label">Argument (3)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[0][relation_third_argument]" />
                                </div>
                            </div>
                            <div class="mb-3 row" style="display:none;" id="argument4">
                                <label for="" class="col-sm-2 col-form-label">Argument (4)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[0][relation_fourth_argument]" />
                                </div>
                            </div>
                            <hr>
                        </div>
                    </form>
                </div>
                <div class="card-footer justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                    <button type="submit" form="create-relation" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('belowscripts')
<script type="text/javascript">
    //     var i = 0;
    // $("#add-relation").click(function () {
    //     ++i;
    //     //AddROW
    //     $("#relation").append('<div id="div'+i+'"><div class="mb-3 row"><label for="" class="col-sm-2 col-form-label">Relation Type</label><div class="col-sm-10"><select class="form-select" name="relation['+i+'][relation_name]" id="relationtype"><option value="hasOne">One To One</option><option value="hasMany">One To Many</option><option value="belongsTo">Belongs To</option><option value="belongsToMany">Many To Many</option><option value="hasOneThrough">Has One Through</option><option value="hasManyThrough">Has Many Through</option></select></div></div><div><div class="mb-3 row" id="table1"><label for="" class="col-sm-2 col-form-label">Table/Model (1)</label><div class="col-sm-10"><input class="form-control" type="text" name="relation['+i+'][relation_table_first]" /></div></div><div class="mb-3 row" style="display:none;" id="table2"><label for="" class="col-sm-2 col-form-label">Table/Model (2)</label><div class="col-sm-10"><input class="form-control" type="text" name="relation['+i+'][relation_table_second]" /></div></div><div class="mb-3 row" id="argument1"><label for="" class="col-sm-2 col-form-label">Argument (1)</label><div class="col-sm-10"><input class="form-control" type="text" name="relation['+i+'][relation_first_argument]" /></div></div><div class="mb-3 row" id="argument2"><label for="" class="col-sm-2 col-form-label">Argument (2)</label><div class="col-sm-10"><input class="form-control" type="text" name="relation['+i+'][relation_second_argument]" /></div></div><div class="mb-3 row" style="display:none;" id="argument3"><label for="" class="col-sm-2 col-form-label">Argument (3)</label><div class="col-sm-10"><input class="form-control" type="text" name="relation['+i+'][relation_third_second]" /></div></div><div class="mb-3 row" style="display:none;" id="argument4"><label for="" class="col-sm-2 col-form-label">Argument (4)</label><div class="col-sm-10"><input class="form-control" type="text" name="relation['+i+'][relation_fourth_second]" /></div></div></div> <div class="text-center"><button type="button" class="btn btn-outline-danger" id="remove'+i+'"><i class="ti ti-trash align-middle"></i><span class="align-middle"> Delete</span></button></div> <hr></div>');
  
    // });

 
    $(document).on('change', '#relationtype', function () {
        if($(this).val() == 'hasOne' || $(this).val() == 'hasMany' || $(this).val() == 'belongsTo'){
                $('#table1').show();
                $('#table2').hide();
                $('#argument1').show();
                $('#argument2').show();
                $('#argument3').hide();
                $('#argument4').hide();
            }else if($(this).val() == 'hasOneThrough' || $(this).val() == 'hasManyThrough'){
                $('#table1').show();
                $('#table2').show();
                $('#argument1').show();
                $('#argument2').show();
                $('#argument3').show();
                $('#argument4').show();
            }else{
                $('#table1').show();
                $('#table2').hide();
                $('#argument1').show();
                $('#argument2').show();
                $('#argument3').show();
                $('#argument4').hide();
            }
    });

    // $(document).on('click', '.remove-input-field', function () {
    //     $(this).parents('#div1').remove();
    // });

 
</script>

@endpush