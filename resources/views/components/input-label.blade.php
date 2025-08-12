@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-harvest-green']) }}>
    {{ $value ?? $slot }}
</label>
