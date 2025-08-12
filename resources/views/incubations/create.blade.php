@extends('layouts.app')

@section('title', 'Start New Incubation Batch')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Start New Incubation Batch</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incubations.index') }}">Incubations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Batch</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('incubations.index') }}" class="btn btn-secondary btn-sm">
                    <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                    Back to Incubations
                </a>
            </div>
        </div>
    </div>

    <!-- Create Incubation Form -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Batch Information</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('incubations.store') }}">
                @csrf

                <!-- Basic Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Basic Information</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="batch_name" class="form-label">Batch Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="batch_name" name="batch_name" value="{{ old('batch_name') }}" required>
                            <small class="form-text text-muted">Give this batch a descriptive name (e.g., "Spring 2025 Rhode Island Red")</small>
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
                                <option value="chicken" {{ old('egg_type') == 'chicken' ? 'selected' : '' }}>Chicken (21 days)</option>
                                <option value="duck" {{ old('egg_type') == 'duck' ? 'selected' : '' }}>Duck (28 days)</option>
                                <option value="goose" {{ old('egg_type') == 'goose' ? 'selected' : '' }}>Goose (30 days)</option>
                                <option value="turkey" {{ old('egg_type') == 'turkey' ? 'selected' : '' }}>Turkey (28 days)</option>
                                <option value="guinea_fowl" {{ old('egg_type') == 'guinea_fowl' ? 'selected' : '' }}>Guinea Fowl (28 days)</option>
                                <option value="quail" {{ old('egg_type') == 'quail' ? 'selected' : '' }}>Quail (18 days)</option>
                            </select>
                            <small class="form-text text-muted">Incubation period shown in parentheses</small>
                            @error('egg_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="breed" class="form-label">Breed (Optional)</label>
                            <input type="text" class="form-control" id="breed" name="breed" value="{{ old('breed') }}" placeholder="e.g., Rhode Island Red, Leghorn">
                            <small class="form-text text-muted">Specify the breed if known</small>
                            @error('breed')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="eggs_placed" class="form-label">Number of Eggs <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="eggs_placed" name="eggs_placed" value="{{ old('eggs_placed') }}" min="1" required>
                            <small class="form-text text-muted">Total number of eggs placed in the incubator</small>
                            @error('eggs_placed')
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
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" required>
                            <small class="form-text text-muted">Date when eggs were placed in the incubator</small>
                            @error('start_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expected_hatch_date" class="form-label">Expected Hatch Date</label>
                            <input type="date" class="form-control" id="expected_hatch_date" name="expected_hatch_date" readonly>
                            <small class="form-text text-muted">Automatically calculated based on egg type and start date</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Environmental Conditions -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Environmental Conditions</h5>
                        <p class="text-muted mb-3">Set the initial incubator conditions. You can update these later as needed.</p>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="temperature_celsius" class="form-label">Temperature (°C)</label>
                            <input type="number" class="form-control" id="temperature_celsius" name="temperature_celsius" 
                                   value="{{ old('temperature_celsius', '37.5') }}" step="0.1" min="30" max="45">
                            <small class="form-text text-muted">Recommended: 37.5°C for most poultry eggs</small>
                            @error('temperature_celsius')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="humidity_percent" class="form-label">Humidity (%)</label>
                            <input type="number" class="form-control" id="humidity_percent" name="humidity_percent" 
                                   value="{{ old('humidity_percent', '55') }}" step="0.1" min="30" max="80">
                            <small class="form-text text-muted">Recommended: 55% for first 18 days, 65% for hatching</small>
                            @error('humidity_percent')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Additional Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Additional Information</h5>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" 
                                      placeholder="Any special notes about this batch, egg source, breeding program, etc.">{{ old('notes') }}</textarea>
                            <small class="form-text text-muted">Include any relevant information about egg source, breeding notes, or special considerations</small>
                            @error('notes')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Expected Outcomes Preview -->
                <div class="row" id="incubation-preview" style="display: none;">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i data-feather="info" style="width: 16px; height: 16px;"></i>
                                Incubation Preview
                            </h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Incubation Period:</strong><br>
                                    <span id="preview-days">-</span> days
                                </div>
                                <div class="col-md-3">
                                    <strong>Expected Hatch:</strong><br>
                                    <span id="preview-hatch-date">-</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Candling Date:</strong><br>
                                    <span id="preview-candling-date">-</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Lockdown Date:</strong><br>
                                    <span id="preview-lockdown-date">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('incubations.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="reset" class="btn btn-outline-secondary">Reset Form</button>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="play" style="width: 16px; height: 16px;"></i>
                                Start Incubation
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
    
    // Calculate expected hatch date and show preview
    function updateIncubationPreview() {
        const eggType = document.getElementById('egg_type').value;
        const startDate = document.getElementById('start_date').value;
        
        if (eggType && startDate) {
            const days = incubationPeriods[eggType];
            const start = new Date(startDate);
            
            // Calculate dates
            const hatchDate = new Date(start);
            hatchDate.setDate(hatchDate.getDate() + days);
            
            const candlingDate = new Date(start);
            candlingDate.setDate(candlingDate.getDate() + (eggType === 'quail' ? 7 : 10));
            
            const lockdownDate = new Date(hatchDate);
            lockdownDate.setDate(lockdownDate.getDate() - 3);
            
            // Update expected hatch date field
            document.getElementById('expected_hatch_date').value = hatchDate.toISOString().split('T')[0];
            
            // Update preview
            document.getElementById('preview-days').textContent = days;
            document.getElementById('preview-hatch-date').textContent = hatchDate.toLocaleDateString();
            document.getElementById('preview-candling-date').textContent = candlingDate.toLocaleDateString();
            document.getElementById('preview-lockdown-date').textContent = lockdownDate.toLocaleDateString();
            
            // Show preview
            document.getElementById('incubation-preview').style.display = 'block';
        } else {
            // Hide preview
            document.getElementById('incubation-preview').style.display = 'none';
            document.getElementById('expected_hatch_date').value = '';
        }
    }
    
    // Event listeners for date calculation
    document.getElementById('egg_type').addEventListener('change', updateIncubationPreview);
    document.getElementById('start_date').addEventListener('change', updateIncubationPreview);
    
    // Initial calculation if values are pre-filled
    updateIncubationPreview();
    
    // Set recommended conditions based on egg type
    document.getElementById('egg_type').addEventListener('change', function() {
        const eggType = this.value;
        const temperatureInput = document.getElementById('temperature_celsius');
        const humidityInput = document.getElementById('humidity_percent');
        
        // Set recommended conditions based on egg type
        switch(eggType) {
            case 'chicken':
                temperatureInput.value = '37.5';
                humidityInput.value = '55';
                break;
            case 'duck':
                temperatureInput.value = '37.5';
                humidityInput.value = '55';
                break;
            case 'goose':
                temperatureInput.value = '37.4';
                humidityInput.value = '55';
                break;
            case 'turkey':
                temperatureInput.value = '37.5';
                humidityInput.value = '55';
                break;
            case 'guinea_fowl':
                temperatureInput.value = '37.5';
                humidityInput.value = '55';
                break;
            case 'quail':
                temperatureInput.value = '37.7';
                humidityInput.value = '60';
                break;
            default:
                temperatureInput.value = '37.5';
                humidityInput.value = '55';
        }
    });
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const eggType = document.getElementById('egg_type').value;
        const startDate = document.getElementById('start_date').value;
        const eggsPlaced = document.getElementById('eggs_placed').value;
        
        if (!eggType || !startDate || !eggsPlaced) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
        
        if (parseInt(eggsPlaced) < 1) {
            e.preventDefault();
            alert('Number of eggs must be at least 1.');
            return false;
        }
        
        // Confirm start of incubation
        const confirmMessage = `Are you ready to start incubation for ${eggsPlaced} ${eggType} eggs?\n\nThis will create a new batch and begin tracking the incubation process.`;
        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endpush
