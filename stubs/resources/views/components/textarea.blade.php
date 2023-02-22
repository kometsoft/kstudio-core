@props(['name' => null, 'value' => null, 'disabled' => false])

@php
$classes = ($errors->has($name) ?? false)
            ? 'form-control is-invalid'
            : 'form-control';
@endphp

<textarea type="text" name="{{ $name ? $name : '' }}" 
    {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>{{ old($name, $value) }}</textarea>

@error($name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror