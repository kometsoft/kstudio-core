@props(['width' => 9, 'label' => null, 'type' => null, 'placeholder' => null, 'name'=> null, 'value'=>null, 'readonly' => null])

<div class="input-field row mb-3">
    <div class="col-md-3">
        <label for="" class="col-form-label">{{ $label ? $label : '' }}</label>
    </div>
    <div {{ $attributes->merge(['class' => 'col-md-'.$width]) }}>  
        @if($readonly)
        <input type="text" class="form-control-plaintext" name="{{ $name ? $name : '' }}" placeholder="{{ $placeholder ? $placeholder : '' }}" value="{{ old($name, $value) }}">
        @else
        <input type="{{ $type ? $type : '' }}" class="form-control" name="{{ $name ? $name : '' }}" placeholder="{{ $placeholder ? $placeholder : '' }}" value="{{ old($name, $value) }}">
        @endif
    </div>
    {{$slot }}
</div>