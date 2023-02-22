@props(['name' => null, 'value' => null, 'disabled' => false, 'options' => []])

@php
$classes = ($errors->has($name) ?? false)
            ? 'form-control is-invalid'
            : 'form-control';
@endphp

@if (collect($options)->count() > 0)
    <div>
        @foreach ($options as $key => $label)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="{{ $key ?: '' }}" name="{{ $name ?: '' }}" 
                    {{ $disabled ? 'disabled' : '' }} 
                    {{ ($value == $key) ? 'checked' : '' }}>
                <label class="form-check-label" for="">
                    {{ $label ? $label : '' }}
                </label>
            </div>
        @endforeach
    </div>
@endif

@error($name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror