@extends('layout')

@section('content')
<style>
    .teacher-list-container {
        padding: 20px 0;
    }
    
    .teacher-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        overflow: hidden;
    }
    
    .teacher-card:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(30, 58, 138, 0.1) !important; 
    }
    
    .avatar-circle {
        width: 65px; 
        height: 65px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        border-radius: 50%;
        display: flex; 
        align-items: center; 
        justify-content: center;
        font-size: 1.6rem; 
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
    }

    .btn-view-schedule {
        border: 2px solid #1e3a8a;
        color: #1e3a8a;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s;
    }

    .btn-view-schedule:hover {
        background-color: #1e3a8a;
        color: white;
    }
</style>

<div class="teacher-list-container">
    <div class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Faculties</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $faculty->name }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold text-dark"><i class="fas fa-users-rectangle me-2 text-primary"></i>{{ $faculty->name }}</h2>
        <p class="text-muted">Choose a lecturer to view their weekly availability and request an appointment.</p>
    </div>

    <div class="row g-4">
        @forelse($faculty->teachers as $teacher)
            <div class="col-md-6 col-lg-4">
                <div class="card teacher-card shadow-sm p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-circle me-3">
                            {{ strtoupper(substr($teacher->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h5 class="mb-0 fw-bold text-truncate" title="{{ $teacher->name }}">{{ $teacher->name }}</h5>
                            <small class="text-muted"><i class="fas fa-envelope me-1"></i>{{ $teacher->email }}</small>
                        </div>
                    </div>
                    
                    <div class="teacher-info mb-4">
                        <div class="d-flex align-items-center text-muted small mb-1">
                            <i class="fas fa-building me-2"></i> {{ $faculty->name }}
                        </div>
                        @if($teacher->office_location)
                        <div class="d-flex align-items-center text-primary small">
                            <i class="fas fa-map-marker-alt me-2"></i> Office: {{ $teacher->office_location }}
                        </div>
                        @endif
                    </div>

                    <a href="{{ route('faculty-reserve-detail', $teacher->id) }}" class="btn btn-view-schedule w-100 py-2">
                        View Schedule <i class="fas fa-calendar-alt ms-2"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-user-slash fa-4x text-light"></i>
                </div>
                <h4 class="text-muted">No lecturers found</h4>
                <p class="text-secondary">There are currently no lecturers registered for this faculty.</p>
                <a href="{{ route('home') }}" class="btn btn-primary rounded-pill">Back to Faculties</a>
            </div>
        @endforelse
    </div>
</div>
@endsection