<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-harvest-gold border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest shadow-md hover:bg-harvest-gold-dark focus:outline-none focus:ring-2 focus:ring-harvest-gold focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
