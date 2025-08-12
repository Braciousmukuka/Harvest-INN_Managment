@props([
    'id' => 'product-form-modal',
    'title' => 'Product Form',
    'formAction' => '#',
    'method' => 'POST',
    'product' => null
])

<div 
    x-show="showAddModal" 
    class="fixed inset-0 overflow-y-auto z-50"
    x-cloak
>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div 
            x-show="showAddModal" 
            x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity" 
            @click="showAddModal = false"
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div 
            x-show="showAddModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
            x-data="{ 
                activeTab: 'basic',
                setActiveTab(tab) {
                    this.activeTab = tab;
                }
            }"
        >
    <form method="{{ $method === 'PUT' ? 'POST' : $method }}" action="{{ $formAction }}" enctype="multipart/form-data">
        @csrf
        @if($method === 'PUT' || $method === 'PATCH')
            @method($method)
        @endif
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900 flex justify-between items-center">
                <h3>{{ $title }}</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" @click="showAddModal = false">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Tabs navigation -->
            <div class="mt-4 border-b border-gray-200">
                <nav class="-mb-px flex space-x-5" aria-label="Tabs">
                    <button 
                        type="button"
                        @click="setActiveTab('basic')"
                        :class="activeTab === 'basic' ? 'border-harvest-green text-harvest-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-2 px-1 text-center border-b-2 font-medium text-sm"
                    >
                        Basic Information
                    </button>
                    <button 
                        type="button"
                        @click="setActiveTab('details')"
                        :class="activeTab === 'details' ? 'border-harvest-green text-harvest-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-2 px-1 text-center border-b-2 font-medium text-sm"
                    >
                        Additional Details
                    </button>
                    <button 
                        type="button"
                        @click="setActiveTab('images')"
                        :class="activeTab === 'images' ? 'border-harvest-green text-harvest-green' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-2 px-1 text-center border-b-2 font-medium text-sm"
                    >
                        Images
                    </button>
                </nav>
            </div>

            <!-- Tab content -->
            <div class="mt-4">
                <!-- Basic Information Tab -->
                <div x-show="activeTab === 'basic'" class="space-y-3">
                    <div class="grid grid-cols-1 gap-3">
                        <!-- Product Name -->
                        <div>
                            <x-input-label for="name" :value="__('Product Name')" class="text-sm" />
                            <x-text-input id="name" class="block mt-1 w-full text-sm" type="text" name="name" :value="old('name', $product?->name ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                            
                            <!-- SKU and Category -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="sku" :value="__('SKU')" class="text-sm" />
                                <x-text-input id="sku" class="block mt-1 w-full text-sm" type="text" name="sku" :value="old('sku', $product?->sku ?? '')" required />
                                <x-input-error :messages="$errors->get('sku')" class="mt-1" />
                            </div>
                            
                            <div>
                                <x-input-label for="category" :value="__('Category')" class="text-sm" />
                                <select id="category" name="category" class="block mt-1 w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50" required>
                                    <option value="">Select category</option>
                                    <option value="crop" {{ old('category', $product?->category ?? '') == 'crop' ? 'selected' : '' }}>Crop</option>
                                    <option value="livestock" {{ old('category', $product?->category ?? '') == 'livestock' ? 'selected' : '' }}>Livestock</option>
                                    <option value="dairy" {{ old('category', $product?->category ?? '') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                                    <option value="poultry" {{ old('category', $product?->category ?? '') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                                    <option value="other" {{ old('category', $product?->category ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-1" />
                            </div>
                        </div>
                        
                        <!-- Price and Quantity -->
                        <div class="grid grid-cols-2 gap-3">
                            <!-- Unit Price -->
                            <div>
                                <x-input-label for="price" :value="__('Unit Price')" class="text-sm" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-xs">$</span>
                                    </div>
                                    <x-text-input id="price" class="block w-full pl-7 pr-12 text-sm" type="number" name="price" :value="old('price', $product?->price ?? '')" step="0.01" min="0" required />
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <select id="price_unit" name="price_unit" class="h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-xs rounded-r-md focus:ring-0 focus:border-transparent">
                                            <option {{ old('price_unit', $product?->price_unit ?? '') == 'per unit' ? 'selected' : '' }}>per unit</option>
                                            <option {{ old('price_unit', $product?->price_unit ?? '') == 'per kg' ? 'selected' : '' }}>per kg</option>
                                            <option {{ old('price_unit', $product?->price_unit ?? '') == 'per lb' ? 'selected' : '' }}>per lb</option>
                                            <option {{ old('price_unit', $product?->price_unit ?? '') == 'per dozen' ? 'selected' : '' }}>per dozen</option>
                                        </select>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-1" />
                            </div>
                            
                            <!-- Quantity/Stock -->
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" class="text-sm" />
                                <div class="flex mt-1">
                                    <x-text-input id="quantity" class="block w-full text-sm" type="number" name="quantity" :value="old('quantity', $product?->quantity ?? '')" min="0" required />
                                    <select id="quantity_unit" name="quantity_unit" class="ml-2 text-sm rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50">
                                        <option value="units" {{ old('quantity_unit', $product?->quantity_unit ?? '') == 'units' ? 'selected' : '' }}>Units</option>
                                        <option value="kg" {{ old('quantity_unit', $product?->quantity_unit ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                                        <option value="lb" {{ old('quantity_unit', $product?->quantity_unit ?? '') == 'lb' ? 'selected' : '' }}>Lb</option>
                                        <option value="dozen" {{ old('quantity_unit', $product?->quantity_unit ?? '') == 'dozen' ? 'selected' : '' }}>Dozen</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <x-input-label :value="__('Status')" class="text-sm" />
                            <div class="mt-1 flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="status" value="in_stock" class="rounded-full text-harvest-green focus:ring-harvest-green" 
                                        {{ old('status', $product?->status ?? 'in_stock') == 'in_stock' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">In Stock</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="status" value="low_stock" class="rounded-full text-yellow-500 focus:ring-yellow-500"
                                        {{ old('status', $product?->status ?? '') == 'low_stock' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Low Stock</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="status" value="out_of_stock" class="rounded-full text-red-500 focus:ring-red-500"
                                        {{ old('status', $product?->status ?? '') == 'out_of_stock' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Out of Stock</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('status')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Additional Details Tab -->
                <div x-show="activeTab === 'details'" class="space-y-3">
                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" class="text-sm" />
                        <textarea id="description" name="description" rows="2" class="block mt-1 w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50">{{ old('description', $product?->description ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Low Stock Threshold -->
                        <div>
                            <x-input-label for="low_stock_threshold" :value="__('Low Stock Alert')" class="text-sm" />
                            <x-text-input id="low_stock_threshold" class="block mt-1 w-full text-sm" type="number" 
                                name="low_stock_threshold" :value="old('low_stock_threshold', $product?->low_stock_threshold ?? '')" min="0" />
                            <x-input-error :messages="$errors->get('low_stock_threshold')" class="mt-1" />
                        </div>
                        
                        <!-- Farm Location -->
                        <div>
                            <x-input-label for="location" :value="__('Farm Location')" class="text-sm" />
                            <x-text-input id="location" class="block mt-1 w-full text-sm" type="text" 
                                name="location" :value="old('location', $product?->location ?? '')" 
                                placeholder="e.g., North Field, Greenhouse 2" />
                            <x-input-error :messages="$errors->get('location')" class="mt-1" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Harvested Date -->
                        <div>
                            <x-input-label for="harvested_date" :value="__('Harvested Date')" class="text-sm" />
                            <x-text-input id="harvested_date" class="block mt-1 w-full text-sm" type="date" 
                                name="harvested_date" :value="old('harvested_date', $product?->harvested_date ?? '')" />
                            <x-input-error :messages="$errors->get('harvested_date')" class="mt-1" />
                        </div>
                        
                        <!-- Expiry Date -->
                        <div>
                            <x-input-label for="expiry_date" :value="__('Expiry Date')" class="text-sm" />
                            <x-text-input id="expiry_date" class="block mt-1 w-full text-sm" type="date" 
                                name="expiry_date" :value="old('expiry_date', $product?->expiry_date ?? '')" />
                            <x-input-error :messages="$errors->get('expiry_date')" class="mt-1" />
                        </div>
                    </div>
                    
                    <!-- Notes -->
                    <div>
                        <x-input-label for="notes" :value="__('Notes')" class="text-sm" />
                        <textarea id="notes" name="notes" rows="2" 
                            class="block mt-1 w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50">{{ old('notes', $product?->notes ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                    </div>
                </div>

                <!-- Images Tab -->
                <div x-show="activeTab === 'images'" class="space-y-4">
                    <div>
                        <x-input-label for="image" :value="__('Product Image')" class="text-sm" />
                        <div class="mt-1 flex justify-center px-4 pt-2 pb-4 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-harvest-green hover:text-harvest-green-dark focus-within:outline-none focus-within:ring-2 focus-within:ring-harvest-green">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-1" />
                    </div>
                    
                    @if($product && $product->image)
                    <div>
                        <x-input-label :value="__('Current Image')" class="text-sm" />
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-auto object-cover">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="px-6 py-3 bg-gray-50 text-right">
            <button type="button" class="text-sm font-medium text-gray-700 hover:text-gray-500 mr-3" @click="showAddModal = false">
                Cancel
            </button>
            <button type="submit" class="inline-flex items-center px-3 py-2 bg-harvest-green border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-harvest-green-dark focus:bg-harvest-green-dark active:bg-harvest-green focus:outline-none focus:ring-2 focus:ring-harvest-green focus:ring-offset-2 transition ease-in-out duration-150">
                {{ $product ? 'Update Product' : 'Create Product' }}
            </button>
        </div>
    </form>
</div>
