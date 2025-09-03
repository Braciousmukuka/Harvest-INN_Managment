<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::latest()->paginate(10);
        
        // Get purchase statistics
        $purchaseStats = [
            'total_purchases' => Purchase::count(),
            'pending_purchases' => Purchase::where('status', 'pending')->count(),
            'total_amount' => Purchase::sum('total_amount'),
            'pending_payments' => Purchase::where('payment_status', 'pending')->count(),
        ];
        
        return view('purchases.index', compact('purchases', 'purchaseStats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'supplier_email' => 'nullable|email|max:255',
            'supplier_address' => 'nullable|string',
            'item_name' => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'quantity_unit' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'status' => 'required|in:pending,ordered,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,partial,overdue',
            'notes' => 'nullable|string',
            'storage_location' => 'nullable|string|max:255',
        ]);

        Purchase::create($validated);

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase created successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        return view('purchases.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'supplier_email' => 'nullable|email|max:255',
            'supplier_address' => 'nullable|string',
            'item_name' => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'quantity_unit' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'status' => 'required|in:pending,ordered,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,partial,overdue',
            'notes' => 'nullable|string',
            'storage_location' => 'nullable|string|max:255',
        ]);

        $purchase->update($validated);

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase updated successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase deleted successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
