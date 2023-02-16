@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Show {{ $calendar->name }}</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Calendar</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Calendar Name</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id=""
                                    value="{{ $calendar['name'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id=""
                                    value="{{ $calendar['description'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <x-label for="description" value="Enabled on Dashboard" />
                            <div class="col-sm-10">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="dashboard_enable" value="1"
                                        @if ($calendar->dashboard_enable) checked @endif disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <x-label for="description" value="Calendar Event" />
                            <div class="col-sm-10 mt-2">
                                @foreach ($calendar->settings as $event)
                                    <div class="mb-3">
                                        <label for="" class="form-label">{{ $event['form'] }}</label>
                                        <div class="ms-3">
                                            <div class="row">
                                                <label for="" class="col-sm-2 col-form-label">Date</label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                        id="" value="{{ $event['date_column'] }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="" class="col-sm-2 col-form-label">Title</label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                        id="" value="{{ $event['title_column'] }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="" class="col-sm-2 col-form-label">Icon</label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                        id="" value="{{ $event['icon'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-end h-8 bg-gradient-to-b from-white">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                        <a href="{{ route('calendar.edit', $calendar->id) }}" class="btn btn-primary me-2">Edit</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@endpush
