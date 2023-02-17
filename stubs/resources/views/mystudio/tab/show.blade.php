@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Show Tab</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Tab </h5>
                    </div>
                    <div class="card-body">
                        {{-- Parent tab --}}
                        <div class="mb-3 row">
                            <x-label for="name" value="Tab Title" />
                            <div class="col-sm-8">
                                <input type="text" readonly class="form-control-plaintext"
                                    value="{{ $tab->settings['title'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Parent Form</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="form" id="form" disabled>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}"
                                            @if ($tab->settings['form_id'] === $form->id) selected @endif>{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Parent Table</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="table" id="table" disabled>
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
                                        <input type="text" readonly class="form-control-plaintext"
                                            value="{{ $sub['title'] }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Form</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" disabled>
                                            @foreach ($forms as $form)
                                                <option value="{{ $form->id }}"
                                                    @if ($sub['form_id'] === $form->id) selected @endif>{{ $form->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Table</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" disabled>
                                            <option value="{{ $sub['table_id'] }}">{{ $sub['table'] }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-2 col-form-label">Relation Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" disabled>
                                            {{-- <option value="hasOne">One To One</option> --}}
                                            <option value="hasMany" @if ($sub['relation_type'] === 'hasMany') selected @endif>One To
                                                Many</option>
                                            {{-- <option value="belongsTo">Belongs To</option> --}}
                                            <option value="belongsToMany" @if ($sub['relation_type'] === 'belongsToMany') selected @endif>
                                                Many To Many</option>
                                            {{-- <option value="hasOneThrough">Has One Through</option>
                                        <option value="hasManyThrough">Has Many Through</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="my-relation">
                                    <div class="hasMany @if ($sub['relation_type'] === 'belongsToMany') hide @endif ">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Parent Reference
                                                Column</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control"
                                                    value="{{ $sub['foreign_key'] }}">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Reference Column</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control"
                                                    value="{{ $sub['local_key'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="belongsToMany @if ($sub['relation_type'] === 'hasMany') hide @endif ">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Relation Table</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" disabled>
                                                    @foreach ($tables as $table)
                                                        <option value="{{ $table->id }}"
                                                            @if ($sub['ref_table_id'] === $table->id) selected @endif>
                                                            {{ $table->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Parent Reference
                                                Column</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" disabled>
                                                    @if (!empty($sub['list_column']))
                                                        @foreach ($sub['list_column'] as $list)
                                                            <option value="{{ $list['column_name'] }}"
                                                                @if ($sub['foreign_key'] === $list['column_name']) selected @endif>
                                                                {{ $list['column_name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">Reference Column</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" disabled>
                                                    @if (!empty($sub['list_column']))
                                                        @foreach ($sub['list_column'] as $list)
                                                            <option value="{{ $list['column_name'] }}"
                                                                @if ($sub['local_key'] === $list['column_name']) selected @endif>
                                                                {{ $list['column_name'] }}</option>
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
                    </div>
                    <div class="card-footer justify-content-end h-8 bg-gradient-to-b from-white">
                        {{-- <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a> --}}
                        <a href="{{ route('tabs.edit', $tab->id) }}" class="btn btn-primary me-2">Edit</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush

@push('styles')
    <style>
        .hide {
            display: none;
        }
    </style>
@endpush
