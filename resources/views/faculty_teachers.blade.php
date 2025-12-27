@extends('layout')

@section('content')
<style>
    .teacher-list-wrapper {
        margin-left: 280px; /* Sidebar genişliği */
        padding: 50px 40px;
        width: calc(100% - 280px);
    }
    .teacher-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        background: white;
    }
    .teacher-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .avatar-circle {
        width: 60px; height: 60px;
        background-color: #e63946;
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: bold;
    }
</style>

<div class="teacher-list-wrapper">
    <div class="mb-5">
        <h2 class="fw-bold text-dark">{{ $faculty->name }}</h2>
        <p class="text-muted">Select a lecturer to view their schedule and make an appointment.</p>
    </div>

    <div class="row g-4">
        @forelse($faculty->teachers as $teacher)
            <div class="col-md-6 col-lg-4">
                <div class="card teacher-card shadow-sm p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle me-3">
                            {{ strtoupper(substr($teacher->name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $teacher->name }}</h5>
                            <small class="text-muted">{{ $teacher->email }}</small>
                        </div>
                    </div>
                    {{-- Web.php'deki isimlendirme ile uyumlu rota --}}
                    <a href="{{ route('faculty-reserve-detail', $teacher->id) }}" class="btn btn-outline-danger w-100 rounded-pill">
                        View Schedule
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="alert alert-info">No lecturers found in this faculty.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection