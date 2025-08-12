<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow any authenticated user to create/update products
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'in:crop,livestock,dairy,poultry,other'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_unit' => ['required', 'string'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'quantity_unit' => ['required', 'string'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:in_stock,low_stock,out_of_stock'],
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'harvested_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:harvested_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];

        // Unique SKU validation, taking into account updates
        if ($this->isMethod('post')) {
            // For create, SKU must be unique
            $rules['sku'] = ['required', 'string', 'max:50', 'unique:products,sku'];
        } else {
            // For update, SKU must be unique except for this product
            $rules['sku'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($this->product),
            ];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'sku' => 'SKU',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sku.unique' => 'This SKU is already in use. Please use a unique identifier.',
            'expiry_date.after_or_equal' => 'The expiry date must be after or equal to the harvested date.',
        ];
    }
}
