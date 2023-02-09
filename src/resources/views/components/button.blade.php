@props(['label' => null, 'icon' => null])

<button {!! $attributes->merge(['class' => 'btn']) !!}>
    @if ($icon)
    <i class="ti ti-{{ $icon }} icon"></i>
    @endif
    <span>{{ $label }}</span>
</button>

{{--

<x-tab::button type="submit" form="form" class="btn btn-primary" icon="check" :label="__('Save')"></x-tab::button>

--}}