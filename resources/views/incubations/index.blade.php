@extends('layouts.app')

@section('title', 'Incubation Management')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Incubation Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Incubation</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('incubations.create') }}" class="btn btn-success btn-sm" style="background-color: #1e5631; border-color: #1e5631; color: white; font-size: 12px; padding: 4px 8px;">
                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                    New Batch
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ $incubationStats['active_batches'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Active Batches</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="egg" class="f-28 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-blue">{{ $incubationStats['total_eggs_incubating'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Eggs Incubating</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="layers" class="f-28 text-c-blue"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-yellow">{{ $incubationStats['hatching_this_week'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Hatching This Week</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="calendar" class="f-28 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-red">{{ $incubationStats['average_hatch_rate'] ?? 0 }}%</h4>
                            <h6 class="text-muted m-b-0">Avg Hatch Rate</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="trending-up" class="f-28 text-c-red"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <input type="text" class="form-control form-control-sm" placeholder="Search batches..." id="searchInput">
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select class="form-select form-select-sm" id="eggTypeFilter">
                        <option value="">All Types</option>
                        <option value="chicken">Chicken</option>
                        <option value="duck">Duck</option>
                        <option value="goose">Goose</option>
                        <option value="turkey">Turkey</option>
                        <option value="guinea_fowl">Guinea Fowl</option>
                        <option value="quail">Quail</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="hatching">Hatching</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <input type="date" class="form-control form-control-sm" id="dateFilter" placeholder="Expected hatch date">
                </div>
                <div class="col-md-2 col-sm-6">
                    <ul class="list-inline me-auto mb-0">
                        <li class="list-inline-item align-bottom">
                            <button type="button" 
                                class="btn btn-sm btn-icon btn-light-success" 
                                onclick="applyFilters()" 
                                title="Apply Filters">
                                <i class="ti ti-search"></i>
                            </button>
                        </li>
                        <li class="list-inline-item align-bottom">
                            <button type="button" 
                                class="btn btn-sm btn-icon btn-light-secondary" 
                                onclick="clearFilters()" 
                                title="Clear Filters">
                                <i class="ti ti-x"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Incubation Batches -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Incubation Batches</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Batch #</th>
                            <th>Name</th>
                            <th>Type & Breed</th>
                            <th>Eggs Placed</th>
                            <th>Progress</th>
                            <th>Hatch Rate</th>
                            <th>Status</th>
                            <th>Expected Hatch</th>
                            <th>Days Left</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incubations as $incubation)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $incubation->batch_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $incubation->batch_name }}</strong>
                                    @if($incubation->notes)
                                        <br><small class="text-muted">{{ Str::limit($incubation->notes, 30) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="badge bg-info">{{ ucfirst($incubation->egg_type) }}</span>
                                    @if($incubation->breed)
                                        <br><small class="text-muted">{{ $incubation->breed }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <strong>{{ $incubation->eggs_placed }}</strong>
                                    @if($incubation->eggs_candled > 0)
                                        <br><small class="text-muted">{{ $incubation->eggs_fertile }}/{{ $incubation->eggs_candled }} fertile</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($incubation->progress_percentage >= 90) bg-warning
                                        @elseif($incubation->progress_percentage >= 70) bg-info  
                                        @else bg-success
                                        @endif" 
                                        style="width: {{ $incubation->progress_percentage }}%"></div>
                                </div>
                                <small class="text-muted">{{ $incubation->progress_percentage }}% complete</small>
                            </td>
                            <td>
                                @if($incubation->eggs_hatched > 0)
                                    <div class="text-center">
                                        <strong class="text-success">{{ $incubation->hatch_rate }}%</strong>
                                        <br><small class="text-muted">{{ $incubation->eggs_hatched }}/{{ $incubation->eggs_placed }} hatched</small>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @switch($incubation->status)
                                    @case('active')
                                        <span class="badge bg-primary">Active</span>
                                        @break
                                    @case('hatching')
                                        <span class="badge bg-warning">Hatching</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Failed</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-secondary">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($incubation->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $incubation->expected_hatch_date->format('M d, Y') }}</strong>
                                    @if($incubation->actual_hatch_date)
                                        <br><small class="text-success">Actual: {{ $incubation->actual_hatch_date->format('M d') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($incubation->days_remaining > 0)
                                    <span class="badge 
                                        @if($incubation->days_remaining <= 3) bg-warning
                                        @elseif($incubation->days_remaining <= 7) bg-info
                                        @else bg-secondary
                                        @endif">
                                        {{ $incubation->days_remaining }} days
                                    </span>
                                @elseif($incubation->days_remaining == 0)
                                    <span class="badge bg-danger">Due Today!</span>
                                @else
                                    <span class="badge bg-dark">Overdue</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('incubations.show', $incubation) }}" 
                                            class="btn btn-sm btn-icon btn-light-primary" 
                                            title="View Details">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <button type="button" 
                                            class="btn btn-sm btn-icon btn-light-info"
                                            onclick="updateProgress({{ $incubation->id }})"
                                            title="Update Progress">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('incubations.edit', $incubation) }}" 
                                            class="btn btn-sm btn-icon btn-light-secondary"
                                            title="Edit Batch">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <form action="{{ route('incubations.destroy', $incubation) }}" method="POST" 
                                              style="display: inline-block; margin: 0;"
                                              onsubmit="return confirm('Are you sure you want to delete this incubation batch?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-sm btn-icon btn-light-danger"
                                                title="Delete Batch">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="empty-state">
                                    <i data-feather="egg" class="text-muted" style="font-size: 48px;"></i>
                                    <h6 class="mt-3 text-muted">No incubation batches found</h6>
                                    <p class="text-muted">Start by creating your first incubation batch to track egg hatching.</p>
                                    <a href="{{ route('incubations.create') }}" class="btn btn-primary btn-sm">
                                        <i data-feather="plus" class="me-1"></i>New Batch
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($incubations->hasPages())
            <div class="row mt-3">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info">
                        Showing {{ $incubations->firstItem() }} to {{ $incubations->lastItem() }} of {{ $incubations->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers">
                        {{ $incubations->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Update Progress Modal -->
<div class="modal fade" id="updateProgressModal" tabindex="-1" aria-labelledby="updateProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProgressModalLabel">Update Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="progressForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_eggs_candled" class="form-label">Eggs Candled</label>
                                <input type="number" class="form-control" id="progress_eggs_candled" name="eggs_candled" min="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_eggs_fertile" class="form-label">Eggs Fertile</label>
                                <input type="number" class="form-control" id="progress_eggs_fertile" name="eggs_fertile" min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_eggs_hatched" class="form-label">Eggs Hatched</label>
                                <input type="number" class="form-control" id="progress_eggs_hatched" name="eggs_hatched" min="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_chicks_healthy" class="form-label">Healthy Chicks</label>
                                <input type="number" class="form-control" id="progress_chicks_healthy" name="chicks_healthy" min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_status" class="form-label">Status</label>
                                <select class="form-select" id="progress_status" name="status">
                                    <option value="active">Active</option>
                                    <option value="hatching">Hatching</option>
                                    <option value="completed">Completed</option>
                                    <option value="failed">Failed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="progress_actual_hatch_date" class="form-label">Actual Hatch Date</label>
                                <input type="date" class="form-control" id="progress_actual_hatch_date" name="actual_hatch_date">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="progress_notes" class="form-label">Progress Notes</label>
                        <textarea class="form-control" id="progress_notes" name="notes" rows="2"></textarea>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

function updateProgress(incubationId) {
    // Show the progress modal and set the form action
    const modal = new bootstrap.Modal(document.getElementById('updateProgressModal'));
    const form = document.getElementById('progressForm');
    form.action = `/incubations/${incubationId}/progress`;
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
            // Close modal and reload page
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

function applyFilters() {
    // Get filter values
    const search = document.getElementById('searchInput').value;
    const eggType = document.getElementById('eggTypeFilter').value;
    const status = document.getElementById('statusFilter').value;
    const date = document.getElementById('dateFilter').value;
    
    // Build query string
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (eggType) params.append('egg_type', eggType);
    if (status) params.append('status', status);
    if (date) params.append('expected_date', date);
    
    // Redirect with filters
    window.location.href = '{{ route("incubations.index") }}?' + params.toString();
}

function clearFilters() {
    // Clear all filter inputs
    document.getElementById('searchInput').value = '';
    document.getElementById('eggTypeFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFilter').value = '';
}
</script>
@endpush
