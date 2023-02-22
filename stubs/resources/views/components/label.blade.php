@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'col-sm-2 col-form-label']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-danger"> *</span>
    @endif
</label>
