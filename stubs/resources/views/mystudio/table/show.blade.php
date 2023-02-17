@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3><a href="{{ route('table.index') }}">{{ __('Table') }}</a> : {{ $table->name }} </h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Table</h5>
                        <div class="mb-3 row">
                            <x-label for="name" value="Table Name" />
                            <div class="col-sm-10">
                                <p for="name" class="h5 mt-2">{{ $table->name }}</p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <x-label for="description" value="Description" />
                            <div class="col-sm-10">
                                <p for="description" class="h5 mt-2">{{ $table->description }}</p>
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="column-tab" data-bs-toggle="tab"
                                    data-bs-target="#column" type="button" role="tab" aria-controls="column"
                                    aria-selected="true">Column</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="relation-tab" data-bs-toggle="tab" data-bs-target="#relation"
                                    type="button" role="tab" aria-controls="relation" aria-selected="false">Table
                                    Relation</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="operation-tab" data-bs-toggle="tab" data-bs-target="#operation"
                                    type="button" role="tab" aria-controls="operation"
                                    aria-selected="false">Operation</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="column" role="tabpanel"
                                aria-labelledby="column-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Field Type</th>
                                                <th scope="col">Field Label</th>
                                                <th scope="col">Column Name</th>
                                                <th scope="col">Column Type</th>
                                                <th scope="col">Index</th>
                                                <th scope="col">Comment</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($columns))
                                                @foreach ($columns as $column)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $column['html_input_type'] }}</td>
                                                        <td>{{ $column['html_label'] }}</td>
                                                        <td>{{ $column['column_name'] }}</td>
                                                        <td>{{ $column['column_type'] }}</td>
                                                        <td>{{ $column['column_index'] }}</td>
                                                        <td>{{ $column['column_comment'] }}</td>
                                                        <td>
                                                            <a href="{{ route('column.show', [$table->id, $column['column_id']]) }}"
                                                                class="btn btn-sm btn-primary"><i
                                                                    class="ti ti-eye align-middle"></i></a>
                                                            <a href="{{ route('column.edit', [$table->id, $column['column_id']]) }}"
                                                                class="btn btn-sm btn-warning"><i
                                                                    class="ti ti-pencil align-middle"></i></a>
                                                            <a href="http://" class="btn btn-sm btn-danger"><i
                                                                    class="ti ti-trash align-middle"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>


                                <div class="card-footer justify-content-center">
                                    <a href="{{ route('table.edit.table-column', $table->id) }}"
                                        class="btn btn-warning me-2" title="Edit Table">
                                        <i class="ti ti-pencil align-middle"></i><span class="align-middle">Edit
                                            Table</span>
                                    </a>
                                    <a href="{{ route('table.add.table-column', $table->id) }}" class="btn btn-primary">
                                        <i class="ti ti-square-plus align-middle"></i><span class="align-middle">Create
                                            Column</span>
                                    </a>
                                    <div class="ms-2">
                                        <a href="#" class="btn btn-primary dropdown-toggle" id="dropdownMenuLink"
                                            data-bs-toggle="dropdown" title="Generate">
                                            <i class="ti ti-file-plus align-middle"></i><span
                                                class="align-middle">Generate</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('table.file.migration.create', $table->id) }}">Generate
                                                    Migration File</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('table.file.model.create', $table->id) }}">Generate
                                                    Model File</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="relation" role="tabpanel" aria-labelledby="relation-tab">
                                <div class="mt-3 ms-3">
                                    @if (!empty($relations))
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Relation Type</th>
                                                    <th> Table/Model (1)</th>
                                                    <th> Table/Model (2)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($relations as $relation)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $relation['relation_name'] }}</td>
                                                        <td>{{ $relation['relation_table_first'] }}</td>
                                                        <td>{{ $relation['relation_table_second'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="card-footer justify-content-end">
                                            <a href="{{ route('relation.createRelation', $table->id) }}"
                                                class="btn btn-primary text-center me-2">Create Relation</a>
                                            <a href="{{ route('relation.editRelation', $table->id) }}"
                                                class="btn btn-warning text-center">Edit Relation</a>
                                        </div>
                                    @else
                                        <p class="mb-2">This Table Doesn't Have Relation Table</p>
                                        <a href="{{ route('relation.createRelation', $table->id) }}"
                                            class="btn btn-primary">
                                            <i class="ti ti-square-plus align-middle"></i><span
                                                class="align-middle">Create Relation</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="operation" role="tabpanel" aria-labelledby="operation-tab">
                                Content Operation
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
