@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-harvest-gold text-start text-base font-medium text-harvest-green bg-harvest-gold/10 focus:outline-none focus:text-harvest-green-dark focus:bg-harvest-gold/20 focus:border-harvest-gold-dark transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-harvest-green hover:bg-harvest-gold/5 hover:border-harvest-gold focus:outline-none focus:text-harvest-green focus:bg-harvest-gold/10 focus:border-harvest-gold transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
