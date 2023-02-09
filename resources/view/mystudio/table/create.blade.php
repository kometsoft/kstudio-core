@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Create Table</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Table</h5>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" id="create-table" action="{{ route('table.store') }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <x-label for="name" value="Table Name" required="true" />
                                <div class="col-sm-10">
                                    <x-input type="text" name="name" id="name" placeholder="Table Name" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <x-label for="description" value="Description" />
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                        <button type="submit" form="create-table" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
