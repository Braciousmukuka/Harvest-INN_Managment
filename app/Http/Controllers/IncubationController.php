<?php

namespace App\Http\Controllers;

use App\Models\Incubation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncubationController extends Controller
{
    public function index(Request $request)
    {
        $query = Incubation::orderBy('created_at', 'desc');
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('egg_type')) {
            $query->where('egg_type', $request->egg_type);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('batch_number', 'like', "%{$search}%")
                  ->orWhere('batch_name', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%");
            });
        }
        
        $incubations = $query->paginate(10);
        
        // Calculate statistics
        $incubationStats = [
            'active_batches' => Incubation::active()->count(),
            'total_eggs_incubating' => Incubation::active()->sum('eggs_placed'),
            'hatching_this_week' => Incubation::whereBetween('expected_hatch_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'average_hatch_rate' => round(Incubation::completed()->avg('eggs_hatched') / (Incubation::completed()->avg('eggs_placed') ?: 1) * 100, 1)
        ];
        
        return view('incubations.index', compact('incubations', 'incubationStats'));
    }

    public function create()
    {
        return view('incubations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:255',
            'egg_type' => 'required|in:chicken,duck,goose,turkey,guinea_fowl,quail',
            'breed' => 'nullable|string|max:255',
            'eggs_placed' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'temperature_celsius' => 'nullable|numeric|min:30|max:45',
            'humidity_percent' => 'nullable|numeric|min:30|max:80',
            'notes' => 'nullable|string'
        ]);

        $incubation = Incubation::create($validated);

        return redirect()->route('incubations.index')
            ->with('success', "Incubation batch {$incubation->batch_number} created successfully!")
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
            ->header('X-Refresh-Required', 'true')
            ->header('X-CRUD-Operation', 'create');
    }

    public function show(Incubation $incubation)
    {
        return view('incubations.show', compact('incubation'));
    }

    public function edit(Incubation $incubation)
    {
        return view('incubations.edit', compact('incubation'));
    }

    public function update(Request $request, Incubation $incubation)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:255',
            'egg_type' => 'required|in:chicken,duck,goose,turkey,guinea_fowl,quail',
            'breed' => 'nullable|string|max:255',
            'eggs_placed' => 'required|integer|min:1',
            'eggs_candled' => 'nullable|integer|min:0',
            'eggs_fertile' => 'nullable|integer|min:0',
            'eggs_hatched' => 'nullable|integer|min:0',
            'chicks_healthy' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'actual_hatch_date' => 'nullable|date',
            'temperature_celsius' => 'nullable|numeric|min:30|max:45',
            'humidity_percent' => 'nullable|numeric|min:30|max:80',
            'status' => 'required|in:active,hatching,completed,failed,cancelled',
            'notes' => 'nullable|string'
        ]);

        // Ensure eggs_hatched doesn't exceed eggs_placed
        if (isset($validated['eggs_hatched']) && $validated['eggs_hatched'] > $validated['eggs_placed']) {
            return back()->withErrors(['eggs_hatched' => 'Hatched eggs cannot exceed placed eggs.']);
        }

        // Ensure eggs_fertile doesn't exceed eggs_candled
        if (isset($validated['eggs_fertile']) && isset($validated['eggs_candled']) && 
            $validated['eggs_fertile'] > $validated['eggs_candled']) {
            return back()->withErrors(['eggs_fertile' => 'Fertile eggs cannot exceed candled eggs.']);
        }

        $incubation->update($validated);

        return redirect()->route('incubations.show', $incubation)
            ->with('success', 'Incubation batch updated successfully!')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
            ->header('X-Refresh-Required', 'true')
            ->header('X-CRUD-Operation', 'update');
    }

    public function destroy(Incubation $incubation)
    {
        $batchNumber = $incubation->batch_number;
        $incubation->delete();

        return redirect()->route('incubations.index')
            ->with('success', "Incubation batch {$batchNumber} deleted successfully!")
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
            ->header('X-Refresh-Required', 'true')
            ->header('X-CRUD-Operation', 'delete');
    }

    public function updateProgress(Request $request, Incubation $incubation)
    {
        $validated = $request->validate([
            'eggs_candled' => 'nullable|integer|min:0|max:' . $incubation->eggs_placed,
            'eggs_fertile' => 'nullable|integer|min:0',
            'eggs_hatched' => 'nullable|integer|min:0|max:' . $incubation->eggs_placed,
            'chicks_healthy' => 'nullable|integer|min:0',
            'status' => 'nullable|in:active,hatching,completed,failed,cancelled',
            'actual_hatch_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        // Additional validation
        if (isset($validated['eggs_fertile']) && isset($validated['eggs_candled']) && 
            $validated['eggs_fertile'] > $validated['eggs_candled']) {
            return response()->json(['error' => 'Fertile eggs cannot exceed candled eggs.'], 422);
        }

        if (isset($validated['chicks_healthy']) && isset($validated['eggs_hatched']) && 
            $validated['chicks_healthy'] > $validated['eggs_hatched']) {
            return response()->json(['error' => 'Healthy chicks cannot exceed hatched eggs.'], 422);
        }

        $incubation->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully!',
            'data' => [
                'hatch_rate' => $incubation->hatch_rate,
                'fertility_rate' => $incubation->fertility_rate,
                'progress_percentage' => $incubation->progress_percentage
            ]
        ]);
    }
}
