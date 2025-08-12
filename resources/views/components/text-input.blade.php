@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 focus:border-harvest-green focus:ring-harvest-green rounded-md shadow-sm placeholder-gray-400/80']) }}>
