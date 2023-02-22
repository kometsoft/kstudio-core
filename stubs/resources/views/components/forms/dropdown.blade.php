@props(['width' => 9, 'label' => null, 'name'=> null, 'class'=> null, 'value'=>null, 'disabled'=> false, 'options'=> [], 'divClass' => 'input-field row mb-3', 'placeholder' => 'Choose One...'])

<div class="{{ $divClass }}">
    @if (!empty($label))
    <div class="col-md-3">
        <label for="" class="col-form-label">{{ $label ? $label : '' }}</label>
    </div>
    @endif
    <div {{ $attributes->merge(['class' => 'col-md-'.$width]) }}>
        <select {{ $attributes->merge(['class' => 'form-select ' . $class]) }}  name="{{ $name ? $name : '' }}" {{ $disabled ? 'disabled' : '' }}>
            <option selected value="">{{ $placeholder }}</option>
            {{$option ?? ''}}
            @if (!empty($options))
                @foreach ($options as $_value => $_label)
                    <option value="{{ $_value }}" @if($value == $_value) selected @endif>{{ $_label ?? '' }}</option>
                @endforeach
            @endif
        </select>
    </div>
    {{$slot }}
</div>