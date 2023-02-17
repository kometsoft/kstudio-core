@extends('layouts.dashboard') @section('content')
    <div class="container-fluid p-0">
        <x-page-header>
            <h3>{{ $form->name }} Form View</h3>
        </x-page-header>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (!empty($formDetails))
                            @foreach ($formDetails as $index => $detail)
                                @if ($detail['type'] == 'text' ||
                                    $detail['type'] == 'email' ||
                                    $detail['type'] == 'file' ||
                                    $detail['type'] == 'date' ||
                                    $detail['type'] == 'number')
                                    <x-forms.input label="{{ $detail['label'] }}" type="{{ $detail['type'] }}"
                                        placeholder="{{ $detail['placeholder'] }}" name="{{ $detail['column_name'] }}">
                                    </x-forms.input>
                                @elseif($detail['type'] == 'textarea')
                                    <x-forms.textarea label="{{ $detail['label'] }}" name="{{ $detail['column_name'] }}">
                                    </x-forms.textarea>
                                @elseif($detail['type'] == 'dropdown')
                                    <x-forms.dropdown label="{{ $detail['label'] }}" name="{{ $detail['column_name'] }}" :options="dropdown_option($form->id, $index)">
                                    </x-forms.dropdown>
                                @elseif($detail['type'] == 'checkbox')
                                    <x-forms.checkbox label="{{ $detail['label'] }}" name="{{ $detail['column_name'] }}" :options="dropdown_option($form->id, $index)">
                                        <x-slot name="option">
                                            @foreach ($detail['value'] as $value)
                                                <x-forms.checkbox-value label="{{ $value['description'] }}"
                                                    name="{{ $detail['column_name'] }}" value="{{ $value['value'] }}">
                                                </x-forms.checkbox-value>
                                            @endforeach
                                        </x-slot>
                                    </x-forms.checkbox>
                                @elseif($detail['type'] == 'radio')
                                    <x-forms.radiobutton label="{{ $detail['label'] }}" name="{{ $detail['column_name'] }}" :options="dropdown_option($form->id, $index)">
                                        <x-slot name="option">
                                            @foreach ($detail['value'] as $value)
                                                <x-forms.radio-value label="{{ $value['description'] }}"
                                                    name="{{ $detail['column_name'] }}" value="{{ $value['value'] }}">
                                                </x-forms.radio-value>
                                            @endforeach
                                        </x-slot>
                                    </x-forms.radiobutton>
                                @elseif($detail['type'] == 'hidden')
                                    @foreach ($detail['value'] as $value)
                                        <x-forms.input label="{{ $detail['label'] }}({{ $detail['type'] }})"
                                            type="text" placeholder="{{ $detail['placeholder'] }}"
                                            name="{{ $detail['column_name'] }}" value="{{ $value['value'] }}">
                                        </x-forms.input>
                                    @endforeach
                                @else
                                <p>{{ __('Undefined Input') }}</p>
                                @endif
                            @endforeach
                        @else
                            <p>NO FORM</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
@endpush
