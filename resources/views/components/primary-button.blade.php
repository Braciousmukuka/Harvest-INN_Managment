<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-harvest-green border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-harvest-green-dark focus:bg-harvest-green-dark active:bg-harvest-green focus:outline-none focus:ring-2 focus:ring-harvest-green focus:ring-offset-2 transition ease-in-out duration-150 shadow-md']) }}>
    {{ $slot }}
</button>
