@extends('layouts.dashboard')
@section('content')
<div class="container-fluid p-0">
    <x-page-header>
        <h3>Table : {{$table->name}} / Edit Relation </h3>
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
                    <form id="create-relation" action="{{route('relation.updateRelation', $table->id)}}" method="post">
                        @csrf
                        <div id="relation">
                            @foreach($relations as $relation)
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Relation Type</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="relation[{{$loop->iteration}}][relation_name]"
                                        id="relationtype">
                                        <option @if($relation['relation_name']=='hasOne' ) selected @endif
                                            value="hasOne">One To One</option>
                                        <option @if($relation['relation_name']=='hasMany' ) selected @endif
                                            value="hasMany">One To Many</option>
                                        <option @if($relation['relation_name']=='belongsTo' ) selected @endif
                                            value="belongsTo">Belongs To</option>
                                        <option @if($relation['relation_name']=='belongsToMany' ) selected @endif
                                            value="belongsToMany">Many To Many</option>
                                        <option @if($relation['relation_name']=='hasOneThrough' ) selected @endif
                                            value="hasOneThrough">Has One Through</option>
                                        <option @if($relation['relation_name']=='hasManyThrough' ) selected @endif
                                            value="hasManyThrough">Has Many Through</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Table/Model (1)</label>
                                <div class="col-sm-10">
                                    <!-- <input class="form-control" type="text" name="relation[{{$loop->iteration}}][relation_table_first]" /> -->
                                    <select class="form-select"
                                        name="relation[{{$loop->iteration}}][relation_table_first]" id="">
                                        <option value="">Choose Table/Model ..</option>
                                        @foreach($tableList as $list)
                                        <option value="{{$list->name}}" @if($relation['relation_table_first']==$list->
                                            name) selected @endif>{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Table/Model (2)</label>
                                <div class="col-sm-10">
                                    <!-- <input class="form-control" type="text" name="relation[{{$loop->iteration}}][relation_table_second]" /> -->
                                    <select class="form-select"
                                        name="relation[{{$loop->iteration}}][relation_table_second]" id="">
                                        <option value="">Choose Table/Model ..</option>
                                        @foreach($tableList as $list)
                                        <option value="{{$list->name}}" @if($relation['relation_table_second']==$list->
                                            name) selected @endif>{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Argument (1)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[{{$loop->iteration}}][relation_first_argument]"
                                        value="{{$relation['relation_first_argument']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Argument (2)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[{{$loop->iteration}}][relation_second_argument]"
                                        value="{{$relation['relation_second_argument']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Argument (3)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[{{$loop->iteration}}][relation_third_argument]"
                                        value="{{$relation['relation_third_argument']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Argument (4)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"
                                        name="relation[{{$loop->iteration}}][relation_fourth_argument]"
                                        value="{{$relation['relation_fourth_argument']}}" />
                                </div>
                            </div>

                            <div class="card-footer justify-content-center">
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="card-footer justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                    <button type="submit" form="create-relation" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('belowscripts')


@endpush