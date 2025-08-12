@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-harvest-gold text-sm font-medium leading-5 text-harvest-green focus:outline-none focus:border-harvest-gold-dark transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-harvest-green hover:border-harvest-gold focus:outline-none focus:text-harvest-green focus:border-harvest-gold transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
