@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Tabs List</h3>
            <a href="{{ route('tabs.create') }}" class="btn btn-primary"><i class="ti ti-square-plus align-middle"></i><span
                    class="align-middle">Create</span></a>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tab Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tabs as $tab)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tab->name }}</td>
                                            <td>{{ $tab->description }}</td>
                                            <td>
                                                <a href="{{ route('tabs.show', $tab->id) }}" class="btn btn-primary btn-sm"
                                                    title="Show">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('tabs.edit', $tab->id) }}" class="btn btn-primary btn-sm"
                                                    title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-primary btn-sm dropdown-toggle"
                                                    id="dropdownMenuLink" data-bs-toggle="dropdown" title="Generate">
                                                    <i class="ti ti-file-plus"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#">
                                                            Generate Tab File
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No records found.
                                                <br><br>
                                                <a href="{{ route('tabs.create') }}" class="btn btn-primary"><i
                                                        class="ti ti-square-plus align-middle"></i><span
                                                        class="align-middle">Create Tab</span></a>
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
