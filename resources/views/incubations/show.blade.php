@extends('layouts.app')

@section('title', 'Incubation Batch - ' . $incubation->batch_number)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Incubation Batch: {{ $incubation->batch_number }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('incubations.index') }}">Incubations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $incubation->batch_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('incubations.edit', $incubation) }}" class="btn btn-primary btn-sm">
                        <i data-feather="edit-3" style="width: 14px; height: 14px;"></i>
                        Edit Batch
                    </a>
                    <a href="{{ route('incubations.index') }}" class="btn btn-secondary btn-sm">
                        <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Batch Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Batch Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Batch Name</label>
                                <p class="info-value">{{ $incubation->batch_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Batch Number</label>
                                <p class="info-value">{{ $incubation->batch_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Egg Type</label>
                                <p class="info-value">
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $incubation->egg_type)) }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Breed</label>
                                <p class="info-value">{{ $incubation->breed ?: 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($incubation->notes)
                    <div class="info-group">
                        <label class="info-label">Notes</label>
                        <p class="info-value">{{ $incubation->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Progress Tracking -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Progress Tracking</h5>
                    <button type="button" class="btn btn-success btn-sm" onclick="updateProgress({{ $incubation->id }})">
                        <i data-feather="refresh-cw" style="width: 14px; height: 14px;"></i>
                        Update Progress
                    </button>
                </div>
                <div class="card-body">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Incubation Progress</span>
                            <span class="fw-bold">{{ $incubation->progress_percentage }}%</span>
                        </div>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar 
                                @if($incubation->progress_percentage >= 90) bg-warning
                                @elseif($incubation->progress_percentage >= 70) bg-info  
                                @else bg-success
                                @endif" 
                                style="width: {{ $incubation->progress_percentage }}%">
                                {{ $incubation->progress_percentage }}%
                            </div>
                        </div>
                        <small class="text-muted">
                            Day {{ now()->diffInDays($incubation->start_date) + 1 }} of {{ $incubation->incubation_days ?? 21 }} days
                        </small>
                    </div>

                    <!-- Egg Statistics -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-card text-center p-3 bg-light rounded">
                                <div class="stat-icon mb-2">
                                    <i data-feather="layers" class="text-primary"></i>
                                </div>
                                <div class="stat-number h4 mb-1">{{ $incubation->eggs_placed }}</div>
                                <div class="stat-label text-muted small">Eggs Placed</div>
                            </div>
                        </div>
                        
                        @if($incubation->eggs_candled > 0)
                        <div class="col-md-3">
                            <div class="stat-card text-center p-3 bg-light rounded">
                                <div class="stat-icon mb-2">
                                    <i data-feather="search" class="text-info"></i>
                                </div>
                                <div class="stat-number h4 mb-1">{{ $incubation->eggs_candled }}</div>
                                <div class="stat-label text-muted small">Eggs Candled</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($incubation->eggs_fertile > 0)
                        <div class="col-md-3">
                            <div class="stat-card text-center p-3 bg-light rounded">
                                <div class="stat-icon mb-2">
                                    <i data-feather="check-circle" class="text-success"></i>
                                </div>
                                <div class="stat-number h4 mb-1">{{ $incubation->eggs_fertile }}</div>
                                <div class="stat-label text-muted small">Fertile Eggs</div>
                                @if($incubation->eggs_candled > 0)
                                    <div class="text-success small">({{ $incubation->fertility_rate }}%)</div>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        @if($incubation->eggs_hatched > 0)
                        <div class="col-md-3">
                            <div class="stat-card text-center p-3 bg-light rounded">
                                <div class="stat-icon mb-2">
                                    <i data-feather="smile" class="text-warning"></i>
                                </div>
                                <div class="stat-number h4 mb-1">{{ $incubation->eggs_hatched }}</div>
                                <div class="stat-label text-muted small">Eggs Hatched</div>
                                <div class="text-warning small">({{ $incubation->hatch_rate }}%)</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($incubation->chicks_healthy > 0)
                        <div class="col-md-3">
                            <div class="stat-card text-center p-3 bg-light rounded">
                                <div class="stat-icon mb-2">
                                    <i data-feather="heart" class="text-danger"></i>
                                </div>
                                <div class="stat-number h4 mb-1">{{ $incubation->chicks_healthy }}</div>
                                <div class="stat-label text-muted small">Healthy Chicks</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Status and Timeline -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Current Status</h5>
                </div>
                <div class="card-body text-center">
                    <div class="status-badge mb-3">
                        @switch($incubation->status)
                            @case('active')
                                <span class="badge bg-primary fs-6 px-3 py-2">
                                    <i data-feather="play-circle" style="width: 16px; height: 16px;"></i>
                                    Active
                                </span>
                                @break
                            @case('hatching')
                                <span class="badge bg-warning fs-6 px-3 py-2">
                                    <i data-feather="zap" style="width: 16px; height: 16px;"></i>
                                    Hatching
                                </span>
                                @break
                            @case('completed')
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i data-feather="check-circle" style="width: 16px; height: 16px;"></i>
                                    Completed
                                </span>
                                @break
                            @case('failed')
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i data-feather="x-circle" style="width: 16px; height: 16px;"></i>
                                    Failed
                                </span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-secondary fs-6 px-3 py-2">
                                    <i data-feather="pause-circle" style="width: 16px; height: 16px;"></i>
                                    Cancelled
                                </span>
                                @break
                        @endswitch
                    </div>
                    
                    @if($incubation->days_remaining > 0)
                        <div class="days-remaining">
                            <h3 class="text-primary">{{ $incubation->days_remaining }}</h3>
                            <p class="text-muted mb-0">Days Remaining</p>
                        </div>
                    @elseif($incubation->days_remaining == 0)
                        <div class="days-remaining">
                            <h3 class="text-warning">Today!</h3>
                            <p class="text-muted mb-0">Hatching Due</p>
                        </div>
                    @else
                        <div class="days-remaining">
                            <h3 class="text-danger">Overdue</h3>
                            <p class="text-muted mb-0">{{ abs($incubation->days_remaining) }} days past due</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon bg-primary">
                                <i data-feather="play" style="width: 12px; height: 12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Incubation Started</h6>
                                <p class="text-muted mb-0">{{ $incubation->start_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon bg-info">
                                <i data-feather="calendar" style="width: 12px; height: 12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Expected Hatch Date</h6>
                                <p class="text-muted mb-0">{{ $incubation->expected_hatch_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        @if($incubation->actual_hatch_date)
                        <div class="timeline-item">
                            <div class="timeline-icon bg-success">
                                <i data-feather="check" style="width: 12px; height: 12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Actual Hatch Date</h6>
                                <p class="text-muted mb-0">{{ $incubation->actual_hatch_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Environmental Conditions -->
            @if($incubation->temperature_celsius || $incubation->humidity_percent)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Environmental Conditions</h5>
                </div>
                <div class="card-body">
                    @if($incubation->temperature_celsius)
                    <div class="condition-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <i data-feather="thermometer" class="text-danger me-2"></i>
                            <span>Temperature</span>
                        </div>
                        <span class="fw-bold">{{ $incubation->temperature_celsius }}°C</span>
                    </div>
                    @endif
                    
                    @if($incubation->humidity_percent)
                    <div class="condition-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i data-feather="droplets" class="text-info me-2"></i>
                            <span>Humidity</span>
                        </div>
                        <span class="fw-bold">{{ $incubation->humidity_percent }}%</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Batch Actions</h6>
                        <div class="btn-group">
                            <a href="{{ route('incubations.edit', $incubation) }}" class="btn btn-outline-primary btn-sm">
                                <i data-feather="edit-3" style="width: 14px; height: 14px;"></i>
                                Edit Details
                            </a>
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="updateProgress({{ $incubation->id }})">
                                <i data-feather="refresh-cw" style="width: 14px; height: 14px;"></i>
                                Update Progress
                            </button>
                            <form action="{{ route('incubations.destroy', $incubation) }}" method="POST" style="display: inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this incubation batch? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    Delete Batch
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Progress Modal -->
<div class="modal fade" id="updateProgressModal" tabindex="-1" aria-labelledby="updateProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProgressModalLabel">Update Progress - {{ $incubation->batch_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="progressForm" action="{{ route('incubations.progress', $incubation) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_eggs_candled" class="form-label">Eggs Candled</label>
                                <input type="number" class="form-control" id="progress_eggs_candled" name="eggs_candled" 
                                       min="0" max="{{ $incubation->eggs_placed }}" value="{{ $incubation->eggs_candled }}">
                                <small class="form-text text-muted">Max: {{ $incubation->eggs_placed }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_eggs_fertile" class="form-label">Eggs Fertile</label>
                                <input type="number" class="form-control" id="progress_eggs_fertile" name="eggs_fertile" 
                                       min="0" value="{{ $incubation->eggs_fertile }}">
                                <small class="form-text text-muted">Based on candling</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_eggs_hatched" class="form-label">Eggs Hatched</label>
                                <input type="number" class="form-control" id="progress_eggs_hatched" name="eggs_hatched" 
                                       min="0" max="{{ $incubation->eggs_placed }}" value="{{ $incubation->eggs_hatched }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_chicks_healthy" class="form-label">Healthy Chicks</label>
                                <input type="number" class="form-control" id="progress_chicks_healthy" name="chicks_healthy" 
                                       min="0" value="{{ $incubation->chicks_healthy }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_status" class="form-label">Status</label>
                                <select class="form-select" id="progress_status" name="status">
                                    <option value="active" {{ $incubation->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="hatching" {{ $incubation->status == 'hatching' ? 'selected' : '' }}>Hatching</option>
                                    <option value="completed" {{ $incubation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="failed" {{ $incubation->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="cancelled" {{ $incubation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_actual_hatch_date" class="form-label">Actual Hatch Date</label>
                                <input type="date" class="form-control" id="progress_actual_hatch_date" name="actual_hatch_date" 
                                       value="{{ $incubation->actual_hatch_date ? $incubation->actual_hatch_date->format('Y-m-d') : '' }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="progress_notes" class="form-label">Progress Notes</label>
                        <textarea class="form-control" id="progress_notes" name="notes" rows="2" 
                                  placeholder="Any observations or notes about the current progress...">{{ $incubation->notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Progress</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.info-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    font-size: 1rem;
    color: #495057;
    margin-bottom: 0;
}

.stat-card {
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    position: absolute;
    left: -23px;
    top: 2px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content h6 {
    font-size: 0.875rem;
    font-weight: 600;
}

.condition-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.condition-item:last-child {
    border-bottom: none;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

function updateProgress(incubationId) {
    // Show the progress modal
    const modal = new bootstrap.Modal(document.getElementById('updateProgressModal'));
    modal.show();
}

// Handle progress form submission
document.getElementById('progressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = this.action;
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal and reload page to show updated data
            bootstrap.Modal.getInstance(document.getElementById('updateProgressModal')).hide();
            location.reload();
        } else {
            alert('Error updating progress: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating progress. Please try again.');
    });
});

// Add validation for fertile eggs not exceeding candled eggs
document.getElementById('progress_eggs_candled').addEventListener('input', function() {
    const candled = parseInt(this.value) || 0;
    const fertile = document.getElementById('progress_eggs_fertile');
    fertile.max = candled;
    if (parseInt(fertile.value) > candled) {
        fertile.value = candled;
    }
});

// Add validation for healthy chicks not exceeding hatched eggs
document.getElementById('progress_eggs_hatched').addEventListener('input', function() {
    const hatched = parseInt(this.value) || 0;
    const healthy = document.getElementById('progress_chicks_healthy');
    healthy.max = hatched;
    if (parseInt(healthy.value) > hatched) {
        healthy.value = hatched;
    }
});
</script>
@endpush
