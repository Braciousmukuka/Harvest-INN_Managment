@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Edit Product: {{ $product->name }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                    <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                    Back to Products
                </a>
            </div>
        </div>
    </div>
                    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Product Information</h3>
                                
                                <!-- Product Name -->
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Product Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$product->name ?? old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                
                                <!-- SKU -->
                                <div class="mb-4">
                                    <x-input-label for="sku" :value="__('SKU (Stock Keeping Unit)')" />
                                    <x-text-input id="sku" class="block mt-1 w-full" type="text" name="sku" :value="$product->sku ?? old('sku')" required />
                                    <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                                    <p class="text-xs text-gray-500 mt-1">A unique identifier for your product</p>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <x-input-label for="description" :value="__('Product Description')" />
                                    <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50" required>{{ $product->description ?? old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                                
                                <!-- Category -->
                                <div class="mb-4">
                                    <x-input-label for="category" :value="__('Category')" />
                                    <select id="category" name="category" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50" required>
                                        <option value="">Select a category</option>
                                        <option value="crop" {{ (isset($product) && $product->category == 'crop') || old('category') == 'crop' ? 'selected' : '' }}>Crop</option>
                                        <option value="livestock" {{ (isset($product) && $product->category == 'livestock') || old('category') == 'livestock' ? 'selected' : '' }}>Livestock</option>
                                        <option value="dairy" {{ (isset($product) && $product->category == 'dairy') || old('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                                        <option value="poultry" {{ (isset($product) && $product->category == 'poultry') || old('category') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                                        <option value="other" {{ (isset($product) && $product->category == 'other') || old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Inventory & Pricing</h3>
                                
                                <!-- Unit Price -->
                                <div class="mb-4">
                                    <x-input-label for="price" :value="__('Unit Price')" />
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <x-text-input id="price" class="block w-full pl-7 pr-12" type="number" name="price" :value="$product->price ?? old('price')" step="0.01" min="0" required />
                                        <div class="absolute inset-y-0 right-0 flex items-center">
                                            <select id="price_unit" name="price_unit" class="h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-r-md focus:ring-0 focus:border-transparent">
                                                <option {{ (isset($product) && $product->price_unit == 'per unit') ? 'selected' : '' }}>per unit</option>
                                                <option {{ (isset($product) && $product->price_unit == 'per kg') ? 'selected' : '' }}>per kg</option>
                                                <option {{ (isset($product) && $product->price_unit == 'per lb') ? 'selected' : '' }}>per lb</option>
                                                <option {{ (isset($product) && $product->price_unit == 'per dozen') ? 'selected' : '' }}>per dozen</option>
                                            </select>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <!-- Quantity/Stock -->
                                <div class="mb-4">
                                    <x-input-label for="quantity" :value="__('Quantity in Stock')" />
                                    <div class="flex mt-1">
                                        <x-text-input id="quantity" class="block w-full" type="number" name="quantity" :value="$product->quantity ?? old('quantity')" min="0" required />
                                        <select id="quantity_unit" name="quantity_unit" class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50">
                                            <option value="units" {{ (isset($product) && $product->quantity_unit == 'units') ? 'selected' : '' }}>Units</option>
                                            <option value="kg" {{ (isset($product) && $product->quantity_unit == 'kg') ? 'selected' : '' }}>Kilograms</option>
                                            <option value="lb" {{ (isset($product) && $product->quantity_unit == 'lb') ? 'selected' : '' }}>Pounds</option>
                                            <option value="dozen" {{ (isset($product) && $product->quantity_unit == 'dozen') ? 'selected' : '' }}>Dozen</option>
                                        </select>
                                    </div>
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>

                                <!-- Low Stock Alert -->
                                <div class="mb-4">
                                    <x-input-label for="low_stock_threshold" :value="__('Low Stock Alert Threshold')" />
                                    <x-text-input id="low_stock_threshold" class="block mt-1 w-full" type="number" name="low_stock_threshold" :value="$product->low_stock_threshold ?? old('low_stock_threshold')" min="0" />
                                    <p class="text-xs text-gray-500 mt-1">Get notified when stock falls below this number</p>
                                    <x-input-error :messages="$errors->get('low_stock_threshold')" class="mt-2" />
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <x-input-label :value="__('Product Status')" />
                                    <div class="mt-2 space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="in_stock" class="rounded-full border-gray-300 text-harvest-green shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50"
                                            {{ (isset($product) && $product->status == 'in_stock') || old('status') == 'in_stock' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">In Stock</span>
                                        </label>
                                        <br>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="low_stock" class="rounded-full border-gray-300 text-yellow-500 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50"
                                            {{ (isset($product) && $product->status == 'low_stock') || old('status') == 'low_stock' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">Low Stock</span>
                                        </label>
                                        <br>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="out_of_stock" class="rounded-full border-gray-300 text-red-500 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50"
                                            {{ (isset($product) && $product->status == 'out_of_stock') || old('status') == 'out_of_stock' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">Out of Stock</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Product Image</h3>
                            
                            <div class="mb-4">
                                <x-input-label for="image" :value="__('Product Image')" />
                                
                                @if(isset($product) && $product->image)
                                <div class="mt-2 mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                    <div class="w-32 h-32 bg-gray-100 rounded-md overflow-hidden">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                @endif
                                
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-harvest-green hover:text-harvest-green-dark focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-harvest-green">
                                                <span>Upload a new image</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Additional Information</h3>
                            
                            <!-- Harvested/Produced Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <x-input-label for="harvested_date" :value="__('Harvested/Produced Date')" />
                                    <x-text-input id="harvested_date" class="block mt-1 w-full" type="date" name="harvested_date" :value="isset($product->harvested_date) ? date('Y-m-d', strtotime($product->harvested_date)) : old('harvested_date')" />
                                    <x-input-error :messages="$errors->get('harvested_date')" class="mt-2" />
                                </div>
                                
                                <!-- Expiry Date -->
                                <div class="mb-4">
                                    <x-input-label for="expiry_date" :value="__('Expiry Date (if applicable)')" />
                                    <x-text-input id="expiry_date" class="block mt-1 w-full" type="date" name="expiry_date" :value="isset($product->expiry_date) ? date('Y-m-d', strtotime($product->expiry_date)) : old('expiry_date')" />
                                    <x-input-error :messages="$errors->get('expiry_date')" class="mt-2" />
                                </div>
                            </div>
                            
                            <!-- Farm Location -->
                            <div class="mb-4">
                                <x-input-label for="location" :value="__('Farm Location')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="$product->location ?? old('location')" placeholder="e.g., North Field, Greenhouse 2, Barn 3" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <x-input-label for="notes" :value="__('Additional Notes')" />
                                <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-harvest-green focus:ring focus:ring-harvest-green focus:ring-opacity-50">{{ $product->notes ?? old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-8">
                            <x-secondary-button type="reset" class="mr-3">
                                {{ __('Reset Changes') }}
                            </x-secondary-button>

                            <x-primary-button>
                                {{ __('Update Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
