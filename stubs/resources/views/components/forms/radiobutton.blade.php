@props(['width' => 9, 'label' => null, 'name' => null, 'value' => null, 'options' => []])

<div class="input-field row mb-3">
    <div class="col-md-3">
        <label for="" class="col-form-label">{{ $label ? $label : '' }}</label>
    </div>
    <div {{ $attributes->merge(['class' => 'mt-2 col-md-' . $width]) }}>
        {{ $option }}
    </div>
    {{ $slot }}
</div>
