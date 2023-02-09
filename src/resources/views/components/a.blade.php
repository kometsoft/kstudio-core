@props(['label' => null, 'href' => null, 'icon' => null])

<a href="{{ $href }}" {!! $attributes->merge(['class' => '']) !!}>
    @if ($icon)
    <i class="ti ti-{{ $icon }} icon"></i>
    @endif
    <span>{{ $label }}</span>
</a>

{{--

<x-tabler::a type="submit" form="form" class="btn btn-primary" icon="check" :label="__('Save')"></x-tabler::a>

--}}