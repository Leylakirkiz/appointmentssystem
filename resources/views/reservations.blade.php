@extends('layout')

@section('title', 'Approved Appointments')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">My Approved Appointments</h3>

    <div class="row">
        @forelse($appointments as $app)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm border-start border-5 border-success p-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1 text-dark">{{ $app->teacher->name }}</h5>
                        <p class="mb-3 text-muted small">
                            <i class="fas fa-calendar-alt me-2 text-success"></i>{{ $app->day }} <br>
                            <i class="fas fa-clock me-2 text-success"></i>{{ $app->time_slot }}
                        </p>
                        
                        <form action="{{ route('appointment.cancel', $app->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill w-100">
                                <i class="fas fa-times me-1"></i> Cancel Appointment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">You do not have any approved appointments at the moment.</p>
                <a href="{{ route('createreservations') }}" class="btn btn-primary">Book an Appointment Now</a>
            </div>
        @endforelse
    </div>
</div>
@endsection