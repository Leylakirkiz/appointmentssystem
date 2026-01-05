@extends('layoutth')

@section('content')
<style>
    .reservation-page-wrapper {
        padding: 20px 0;
        min-height: 100vh;
    }
    
    .date-card {
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
    }
    
    .date-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(30, 58, 138, 0.1) !important;
    }

    .date-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 15px 20px;
        border: none;
    }

    .time-badge {
        background-color: #f0f7ff;
        color: #1e3a8a;
        border: 1px solid #dbeafe;
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 10px;
        min-width: 110px;
        text-align: center;
    }

    .student-info-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.05rem;
    }

    .empty-state {
        background: white;
        border-radius: 30px;
        padding: 60px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
</style>

<div class="reservation-page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Approved Appointment Calendar</h2>
            <p class="text-muted">Track all your scheduled meetings with students here.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm" style="background-color: #1e3a8a !important;">
                <i class="fas fa-calendar-day me-2"></i>Today: {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>
    
    @if($reservations->isEmpty())
        <div class="empty-state text-center">
            <div class="mb-4">
                <i class="fas fa-calendar-times fa-4x text-light"></i>
            </div>
            <h4 class="fw-bold text-secondary">No Approved Appointments</h4>
            <p class="text-muted">Your approved appointments will be listed here chronologically.</p>
        </div>
    @else
        <div class="row">
            @foreach($reservations as $dayGroup => $dayReservations)
                @php
                    $firstRes = $dayReservations->first();
                    $dateObj = \Carbon\Carbon::parse($firstRes->appointment_date);
                @endphp
                
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card date-card shadow-sm h-100">
                        <div class="card-header date-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar-check me-2"></i>
                                <span class="fs-5 fw-bold">{{ $dateObj->format('M d, Y') }}</span>
                            </div>
                            <span class="text-uppercase small fw-bold" style="letter-spacing: 1px; opacity: 0.9;">
                                {{ $dateObj->format('l') }}
                            </span>
                        </div>

                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($dayReservations as $res)
                                    <div class="list-group-item p-3 border-0 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="time-badge me-3 shadow-sm">
                                                <i class="far fa-clock me-1"></i> {{ $res->time_slot }}
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="student-info-name">{{ $res->student->name }}</div>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 0.7rem;">
                                                        <i class="fas fa-check-circle me-1"></i>Approved
                                                    </span>
                                                    @if($res->student_note)
                                                        <span class="ms-2 text-muted small" title="{{ $res->student_note }}">
                                                            <i class="fas fa-comment-alt text-info me-1"></i>Note Attached
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection