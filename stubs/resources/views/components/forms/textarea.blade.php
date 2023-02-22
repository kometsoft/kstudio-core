@props(['width' => 9, 'label' => null, 'name'=> null, 'value'=>null, 'readonly' => null])

<div class="input-field row mb-3">
    <div class="col-md-3">
        <label for="" class="col-form-label">{{ $label ? $label : '' }}</label>
    </div>
    <div {{ $attributes->merge(['class' => 'col-md-'.$width]) }}>
        @if($readonly)
            <textarea class="form-control" id="" rows="10" name="{{ $name ? $name : '' }}" readonly>{{ $value ? $value : '' }}</textarea>
        @else
            <textarea class="form-control" id="" rows="5" name="{{ $name ? $name : '' }}">{{ $value ? $value : '' }}</textarea>
        @endif
    </div>
    {{$slot }}
</div>