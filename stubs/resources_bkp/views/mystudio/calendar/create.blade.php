@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>Create Calendar</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Calendar</h5>
                    </div>
                    <div class="card-body">
                        <form id="create-calendar" action="{{ route('calendar.store') }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <x-label for="name" value="Calendar Name" />
                                <div class="col-sm-10">
                                    <x-input type="text" name="name" id="name" value="Calendar 1" required />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <x-label for="description" value="Description" />
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <x-label for="description" value="Enabled on Dashboard" />
                                <div class="col-sm-10">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="dashboard_enable" value="0">
                                        <input class="form-check-input" type="checkbox" name="dashboard_enable"
                                            value="1" @if ($dasboard_calendar) disabled @endif>
                                        <p><small class="text-danger">* Only 1 calendar can be enable on dashbord
                                                calendar</small></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <x-label for="description" value="Calendar Event" />
                                <div class="col-sm-10 mt-2">
                                    @foreach ($forms as $form)
                                        <div class="form-check">
                                            <input class="form-control" name="setting[{{ $form->name }}][table]"
                                                type="hidden"
                                                value="{{ $form->settings['formDetails'][0]['table_name'] }}">
                                            <input class="form-check-input" name="setting[{{ $form->name }}][form]"
                                                type="checkbox" value="{{ $form->name }}" id="form{{ $loop->iteration }}">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $form->name }}
                                            </label>
                                            <div id="settings{{ $loop->iteration }}" class="" style="display:none">
                                                <div class="mb-3 row">
                                                    <label for="date" class="col-sm-2 col-form-label">Date
                                                        column</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-select"
                                                            name="setting[{{ $form->name }}][date_column]">
                                                            @foreach ($form->settings['formDetails'] as $date)
                                                                @if ($date['type'] == 'date')
                                                                    <option value="{{ $date['column_name'] }}">
                                                                        {{ $date['column_name'] }}</option>
                                                                @endif
                                                            @endforeach
                                                            <option value="created_at">created_at</option>
                                                            <option value="updated_at">updated_at</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="title" class="col-sm-2 col-form-label">Title
                                                        column</label>
                                                    <div class="col-sm-5">
                                                        <select class="form-select"
                                                            name="setting[{{ $form->name }}][title_column]">
                                                            @foreach ($form->settings['formDetails'] as $title)
                                                                @if ($title['type'] !== 'date')
                                                                    <option value="{{ $title['column_name'] }}">
                                                                        {{ $title['column_name'] }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control"
                                                            name="setting[{{ $form->name }}][icon]" id="icon"
                                                            value="ti ti-dot">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="icon" class="col-sm-2 col-form-label">Color</label>
                                                    <div class="col-sm-5">
                                                        <input type="color" class="form-control"
                                                            name="setting[{{ $form->name }}][color]" id="color">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer justify-content-end h-8 bg-gradient-to-b from-white">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-2">Cancel</a>
                        <button type="submit" form="create-calendar" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            var forms = @json($forms);
            forms.forEach(hideShow);

            function hideShow(item, index) {
                index++;
                $(`#form${index}`).change(function() {
                    $(`#settings${index}`).toggle();
                });
            }

        });
    </script>
@endpush
