@props(['label' => null,'value' => null, 'name'=> null, 'disabled'=> false, 'checked' => false])

<div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" value="{{ $value ? $value : '' }}" name="{{ $name ? $name : '' }}" {{ $disabled ? 'disabled' : '' }} {{ $checked ? 'checked' : '' }}>
    <label class="form-check-label" for="">
        {{ $label ? $label : '' }}
    </label>
</div>