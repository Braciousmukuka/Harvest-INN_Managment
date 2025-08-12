@extends('layouts.app')

@section('title', 'Edit Incubation Batch - ' . $incubation->batch_number)

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Edit Incubation Batch: {{ $incubation->batch_number }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incubations.index') }}">Incubations</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incubations.show', $incubation) }}">{{ $incubation->batch_number }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('incubations.show', $incubation) }}" class="btn btn-secondary btn-sm">
                        <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                        View Details
                    </a>
                    <a href="{{ route('incubations.index') }}" class="btn btn-secondary btn-sm">
                        <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Incubation Form -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Batch Information</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('incubations.update', $incubation) }}">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Basic Information</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="batch_name" class="form-label">Batch Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="batch_name" name="batch_name" value="{{ old('batch_name', $incubation->batch_name) }}" required>
                            @error('batch_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="egg_type" class="form-label">Egg Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="egg_type" name="egg_type" required>
                                <option value="">Select Egg Type</option>
                                <option value="chicken" {{ old('egg_type', $incubation->egg_type) == 'chicken' ? 'selected' : '' }}>Chicken (21 days)</option>
                                <option value="duck" {{ old('egg_type', $incubation->egg_type) == 'duck' ? 'selected' : '' }}>Duck (28 days)</option>
                                <option value="goose" {{ old('egg_type', $incubation->egg_type) == 'goose' ? 'selected' : '' }}>Goose (30 days)</option>
                                <option value="turkey" {{ old('egg_type', $incubation->egg_type) == 'turkey' ? 'selected' : '' }}>Turkey (28 days)</option>
                                <option value="guinea_fowl" {{ old('egg_type', $incubation->egg_type) == 'guinea_fowl' ? 'selected' : '' }}>Guinea Fowl (28 days)</option>
                                <option value="quail" {{ old('egg_type', $incubation->egg_type) == 'quail' ? 'selected' : '' }}>Quail (18 days)</option>
                            </select>
                            @error('egg_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="breed" class="form-label">Breed (Optional)</label>
                            <input type="text" class="form-control" id="breed" name="breed" value="{{ old('breed', $incubation->breed) }}" placeholder="e.g., Rhode Island Red, Leghorn">
                            @error('breed')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="eggs_placed" class="form-label">Number of Eggs <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="eggs_placed" name="eggs_placed" value="{{ old('eggs_placed', $incubation->eggs_placed) }}" min="1" required>
                            @error('eggs_placed')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Progress Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Progress Information</h5>
                        <p class="text-muted mb-3">Update the progress of this incubation batch.</p>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="eggs_candled" class="form-label">Eggs Candled</label>
                            <input type="number" class="form-control" id="eggs_candled" name="eggs_candled" value="{{ old('eggs_candled', $incubation->eggs_candled) }}" min="0">
                            <small class="form-text text-muted">Max: {{ $incubation->eggs_placed }}</small>
                            @error('eggs_candled')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="eggs_fertile" class="form-label">Eggs Fertile</label>
                            <input type="number" class="form-control" id="eggs_fertile" name="eggs_fertile" value="{{ old('eggs_fertile', $incubation->eggs_fertile) }}" min="0">
                            <small class="form-text text-muted">Based on candling</small>
                            @error('eggs_fertile')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="eggs_hatched" class="form-label">Eggs Hatched</label>
                            <input type="number" class="form-control" id="eggs_hatched" name="eggs_hatched" value="{{ old('eggs_hatched', $incubation->eggs_hatched) }}" min="0">
                            <small class="form-text text-muted">Successfully hatched</small>
                            @error('eggs_hatched')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="chicks_healthy" class="form-label">Healthy Chicks</label>
                            <input type="number" class="form-control" id="chicks_healthy" name="chicks_healthy" value="{{ old('chicks_healthy', $incubation->chicks_healthy) }}" min="0">
                            <small class="form-text text-muted">Surviving chicks</small>
                            @error('chicks_healthy')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Timing Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Timing Information</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $incubation->start_date->format('Y-m-d')) }}" required>
                            @error('start_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="expected_hatch_date" class="form-label">Expected Hatch Date</label>
                            <input type="date" class="form-control" id="expected_hatch_date" name="expected_hatch_date" value="{{ $incubation->expected_hatch_date ? $incubation->expected_hatch_date->format('Y-m-d') : '' }}" readonly>
                            <small class="form-text text-muted">Automatically calculated</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="actual_hatch_date" class="form-label">Actual Hatch Date</label>
                            <input type="date" class="form-control" id="actual_hatch_date" name="actual_hatch_date" value="{{ old('actual_hatch_date', $incubation->actual_hatch_date ? $incubation->actual_hatch_date->format('Y-m-d') : '') }}">
                            <small class="form-text text-muted">When hatching actually occurred</small>
                            @error('actual_hatch_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Environmental Conditions -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Environmental Conditions</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="temperature_celsius" class="form-label">Temperature (°C)</label>
                            <input type="number" class="form-control" id="temperature_celsius" name="temperature_celsius" 
                                   value="{{ old('temperature_celsius', $incubation->temperature_celsius) }}" step="0.1" min="30" max="45">
                            <small class="form-text text-muted">Current incubator temperature</small>
                            @error('temperature_celsius')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="humidity_percent" class="form-label">Humidity (%)</label>
                            <input type="number" class="form-control" id="humidity_percent" name="humidity_percent" 
                                   value="{{ old('humidity_percent', $incubation->humidity_percent) }}" step="0.1" min="30" max="80">
                            <small class="form-text text-muted">Current incubator humidity</small>
                            @error('humidity_percent')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Status and Notes -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Status & Notes</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" {{ old('status', $incubation->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="hatching" {{ old('status', $incubation->status) == 'hatching' ? 'selected' : '' }}>Hatching</option>
                                <option value="completed" {{ old('status', $incubation->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ old('status', $incubation->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="cancelled" {{ old('status', $incubation->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" 
                                      placeholder="Any observations, changes, or special notes about this batch...">{{ old('notes', $incubation->notes) }}</textarea>
                            @error('notes')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Current Stats Display -->
                @if($incubation->eggs_candled > 0 || $incubation->eggs_hatched > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i data-feather="bar-chart-2" style="width: 16px; height: 16px;"></i>
                                Current Statistics
                            </h6>
                            <div class="row">
                                @if($incubation->eggs_candled > 0)
                                <div class="col-md-3">
                                    <strong>Fertility Rate:</strong><br>
                                    {{ $incubation->fertility_rate }}% ({{ $incubation->eggs_fertile }}/{{ $incubation->eggs_candled }})
                                </div>
                                @endif
                                @if($incubation->eggs_hatched > 0)
                                <div class="col-md-3">
                                    <strong>Hatch Rate:</strong><br>
                                    {{ $incubation->hatch_rate }}% ({{ $incubation->eggs_hatched }}/{{ $incubation->eggs_placed }})
                                </div>
                                @endif
                                <div class="col-md-3">
                                    <strong>Progress:</strong><br>
                                    {{ $incubation->progress_percentage }}% complete
                                </div>
                                <div class="col-md-3">
                                    <strong>Days Remaining:</strong><br>
                                    {{ $incubation->days_remaining > 0 ? $incubation->days_remaining . ' days' : 'Due/Overdue' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('incubations.show', $incubation) }}" class="btn btn-secondary">Cancel</a>
                            <button type="reset" class="btn btn-outline-secondary">Reset Changes</button>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" style="width: 16px; height: 16px;"></i>
                                Update Batch
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Incubation periods for different egg types
    const incubationPeriods = {
        'chicken': 21,
        'duck': 28,
        'goose': 30,
        'turkey': 28,
        'guinea_fowl': 28,
        'quail': 18
    };
    
    // Calculate expected hatch date when egg type or start date changes
    function updateExpectedHatchDate() {
        const eggType = document.getElementById('egg_type').value;
        const startDate = document.getElementById('start_date').value;
        
        if (eggType && startDate) {
            const days = incubationPeriods[eggType];
            const start = new Date(startDate);
            const hatchDate = new Date(start);
            hatchDate.setDate(hatchDate.getDate() + days);
            
            document.getElementById('expected_hatch_date').value = hatchDate.toISOString().split('T')[0];
        }
    }
    
    // Event listeners for date calculation
    document.getElementById('egg_type').addEventListener('change', updateExpectedHatchDate);
    document.getElementById('start_date').addEventListener('change', updateExpectedHatchDate);
    
    // Validation for candling and fertility
    document.getElementById('eggs_candled').addEventListener('input', function() {
        const eggsPlaced = parseInt(document.getElementById('eggs_placed').value) || 0;
        const candled = parseInt(this.value) || 0;
        
        // Limit candled eggs to placed eggs
        if (candled > eggsPlaced) {
            this.value = eggsPlaced;
        }
        
        // Update max for fertile eggs
        const fertile = document.getElementById('eggs_fertile');
        fertile.max = this.value;
        if (parseInt(fertile.value) > parseInt(this.value)) {
            fertile.value = this.value;
        }
    });
    
    // Validation for fertile eggs
    document.getElementById('eggs_fertile').addEventListener('input', function() {
        const candled = parseInt(document.getElementById('eggs_candled').value) || 0;
        const fertile = parseInt(this.value) || 0;
        
        if (fertile > candled) {
            this.value = candled;
        }
    });
    
    // Validation for hatched eggs
    document.getElementById('eggs_hatched').addEventListener('input', function() {
        const eggsPlaced = parseInt(document.getElementById('eggs_placed').value) || 0;
        const hatched = parseInt(this.value) || 0;
        
        // Limit hatched eggs to placed eggs
        if (hatched > eggsPlaced) {
            this.value = eggsPlaced;
        }
        
        // Update max for healthy chicks
        const healthy = document.getElementById('chicks_healthy');
        healthy.max = this.value;
        if (parseInt(healthy.value) > parseInt(this.value)) {
            healthy.value = this.value;
        }
    });
    
    // Validation for healthy chicks
    document.getElementById('chicks_healthy').addEventListener('input', function() {
        const hatched = parseInt(document.getElementById('eggs_hatched').value) || 0;
        const healthy = parseInt(this.value) || 0;
        
        if (healthy > hatched) {
            this.value = hatched;
        }
    });
    
    // Validation for eggs placed
    document.getElementById('eggs_placed').addEventListener('input', function() {
        const placed = parseInt(this.value) || 0;
        
        // Update max values for other fields
        const candled = document.getElementById('eggs_candled');
        const hatched = document.getElementById('eggs_hatched');
        
        candled.max = placed;
        hatched.max = placed;
        
        // Adjust values if they exceed the new limit
        if (parseInt(candled.value) > placed) {
            candled.value = placed;
            candled.dispatchEvent(new Event('input'));
        }
        
        if (parseInt(hatched.value) > placed) {
            hatched.value = placed;
            hatched.dispatchEvent(new Event('input'));
        }
    });
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        // Basic validation
        const eggsPlaced = parseInt(document.getElementById('eggs_placed').value) || 0;
        const eggsCandled = parseInt(document.getElementById('eggs_candled').value) || 0;
        const eggsFertile = parseInt(document.getElementById('eggs_fertile').value) || 0;
        const eggsHatched = parseInt(document.getElementById('eggs_hatched').value) || 0;
        const chicksHealthy = parseInt(document.getElementById('chicks_healthy').value) || 0;
        
        // Validate logical constraints
        if (eggsCandled > eggsPlaced) {
            e.preventDefault();
            alert('Candled eggs cannot exceed placed eggs.');
            return false;
        }
        
        if (eggsFertile > eggsCandled && eggsCandled > 0) {
            e.preventDefault();
            alert('Fertile eggs cannot exceed candled eggs.');
            return false;
        }
        
        if (eggsHatched > eggsPlaced) {
            e.preventDefault();
            alert('Hatched eggs cannot exceed placed eggs.');
            return false;
        }
        
        if (chicksHealthy > eggsHatched && eggsHatched > 0) {
            e.preventDefault();
            alert('Healthy chicks cannot exceed hatched eggs.');
            return false;
        }
    });
    
    // Set initial max values
    const eggsPlaced = parseInt(document.getElementById('eggs_placed').value) || 0;
    document.getElementById('eggs_candled').max = eggsPlaced;
    document.getElementById('eggs_hatched').max = eggsPlaced;
});
</script>
@endpush
