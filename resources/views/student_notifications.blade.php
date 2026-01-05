@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white rounded-3 p-2 me-3">
            <i class="fas fa-bell fa-lg"></i>
        </div>
        <h3 class="fw-bold mb-0 text-dark">Notification Center</h3>
    </div>

    @forelse($notifications as $notif)
        <div class="card mb-3 border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div class="d-flex align-items-start">
                    <div class="me-4 text-center">
                        <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center mb-1" style="width: 50px; height: 50px;">
                            <span class="fw-bold text-primary">{{ strtoupper(substr($notif->teacher->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">{{ $notif->teacher->name }}</h6>
                        <div class="text-muted small mb-2">
                            <i class="far fa-calendar-alt me-1"></i> {{ $notif->day }} 
                            <span class="mx-2 text-light">|</span>
                            <i class="far fa-clock me-1"></i> {{ $notif->time_slot }}
                        </div>
                        
                        @if($notif->status == 'pending')
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                <i class="fas fa-hourglass-half me-1"></i> Pending Approval
                            </span>
                        @elseif($notif->status == 'approved')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                <i class="fas fa-check-circle me-1"></i> Request Approved
                            </span>
                        @elseif($notif->status == 'rejected')
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                <i class="fas fa-times-circle me-1"></i> Request Declined
                            </span>
                        @elseif($notif->status == 'cancelled')
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">
                                <i class="fas fa-ban me-1"></i> Cancelled by You
                            </span>
                        @endif
                    </div>
                </div>

                @if($notif->status == 'pending' || $notif->status == 'approved')
                    <form action="{{ route('appointment.cancel', $notif->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold" 
                                onclick="return confirm('Are you sure you want to cancel this appointment request?')">
                            Cancel Request
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <div class="mb-3 text-light">
                <i class="fas fa-inbox fa-4x"></i>
            </div>
            <h5 class="text-muted">No notifications found</h5>
            <p class="text-secondary small">You haven't made any appointment requests yet.</p>
        </div>
    @endforelse
</div>
@endsection