<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_address' => ['nullable', 'string', 'max:500'],
            'quantity_sold' => ['required', 'numeric', 'min:0.01'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,mobile_money,bank_transfer,credit'],
            'payment_status' => ['required', 'in:pending,completed,failed,refunded'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
            'sale_date' => ['required', 'date', 'before_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:completed,pending,cancelled'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'product_id' => 'product',
            'customer_name' => 'customer name',
            'customer_phone' => 'customer phone',
            'customer_email' => 'customer email',
            'customer_address' => 'customer address',
            'quantity_sold' => 'quantity sold',
            'unit_price' => 'unit price',
            'discount_amount' => 'discount amount',
            'payment_method' => 'payment method',
            'payment_status' => 'payment status',
            'payment_reference' => 'payment reference',
            'sale_date' => 'sale date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product_id.exists' => 'The selected product does not exist.',
            'quantity_sold.min' => 'The quantity sold must be greater than 0.',
            'unit_price.min' => 'The unit price must be 0 or greater.',
            'discount_amount.min' => 'The discount amount must be 0 or greater.',
            'sale_date.before_or_equal' => 'The sale date cannot be in the future.',
        ];
    }
}
