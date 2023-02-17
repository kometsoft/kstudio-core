@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Lists</h3>
            <a href="{{ route('list.create') }}" class="btn btn-primary"><i class="ti ti-square-plus align-middle"></i><span
                    class="align-middle">Create</span></a>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">List Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Generate File</th>
                                        <th scope="col" width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lists as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $list->name }}</td>
                                            <td>{{ Str::limit($list->description, 100) }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info mb-2">
                                                    <i class="ti ti-file align-middle"></i>
                                                    <span class="align-middle"></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('list.show', $list->id) }}"
                                                    class="btn btn-primary mb-2"><i class="ti ti-eye align-middle"></i>
                                                    <span class="align-middle"></span></a>
                                                <a href="{{ route('list.edit', $list->id) }}"
                                                    class="btn btn-warning mb-2"><i class="ti ti-pencil align-middle"></i>
                                                    <span class="align-middle"></span></a>
                                                <button class="btn btn-danger mb-2"><i class="ti ti-trash align-middle"></i>
                                                    <span class="align-middle"></span></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No records found.
                                                <br><br>
                                                <a href="{{ route('list.create') }}" class="btn btn-primary"><i
                                                        class="ti ti-square-plus align-middle"></i><span
                                                        class="align-middle">Create List</span></a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
