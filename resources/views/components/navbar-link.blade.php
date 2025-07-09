@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link text-nowrap me-3 active'
            : 'nav-link text-nowrap me-3';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>