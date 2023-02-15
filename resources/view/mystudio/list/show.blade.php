@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>View List</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h5>List</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <x-label for="name" value="List Name" />
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" value="{{ $list->name }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <x-label for="description" value="Description" />
                            <div class="col-sm-10">
                                <textarea readonly class="form-control-plaintext" name="description" id="description" cols="30" rows="5">{{ $list->description }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <x-label for="name" value="Model" />
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext"
                                    value="{{ $list->settings['model'] }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <x-label for="condition" value="Conditions" />
                            @foreach ($list->settings['conditions'] as $val)
                                <div class="row condition-div">
                                    <x-label for="" value="" />

                                    <div class="col-sm-10 row ">
                                        <div class="col-sm-3">
                                            <small><label class="form-label">{{ $loop->iteration }}. Column</label></small>
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $val['column'] }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <small><label class="form-label">Condition</label></small>
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $val['condition'] }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <small><label class="form-label">Value</label></small>
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $val['value'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3 row">
                            <x-label for="indexList" value="Index List" />
                            <div class="col-sm-10">
                                <div class="mb-3 row">
                                    <label for="" class="col-sm-3 col-form-label">Number of Item / Page</label>
                                    <div class="col-sm-2">
                                        <input readonly class="form-control-plaintext" type="number" name="item_per_page"
                                            value="{{ $list->settings['indexList']['item_per_page'] }}">
                                    </div>
                                </div>
                                <table class="table" id="model-list">
                                    <thead>
                                        <tr>
                                            <th scope="col">Model Name</th>
                                            <th scope="col">Field Name</th>
                                            <th scope="col">Field to Display</th>
                                            <th scope="col">Field for Filter</th>
                                        </tr>
                                    </thead>
                                    <tbody id="model-body">
                                        @foreach ($list->settings['indexList']['list_properties'] as $listdetail)
                                            <tr>
                                                <th scope="row">{{ $model }}</th>
                                                <td>
                                                    {{ $listdetail['field_name'] }}
                                                </td>
                                                <td>
                                                    {{ $listdetail['field_display'] }}
                                                </td>
                                                <td>
                                                    {{ $listdetail['field_filter'] }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer justify-content-end">
                        {{-- <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
						<button type="submit" form="update-list" class="btn btn-primary">Edit</button> --}}
                        <a href="{{ route('list.edit', $list->id) }}" class="btn btn-warning mb-2"><i
                                class="ti ti-pencil align-middle"></i> <span class="align-middle">Edit</span></a>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
