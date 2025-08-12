<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get product details for AJAX requests
     */
    public function getProduct(Product $product)
    {
        return response()->json([
            'product' => $product,
            'image_url' => $product->image ? asset('storage/' . $product->image) : null,
        ]);
    }
}
