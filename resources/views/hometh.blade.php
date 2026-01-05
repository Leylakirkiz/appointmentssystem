@extends('layoutth')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Welcome, {{ Auth::user()->name }}</h2>
            <p class="text-muted">Here is an overview of your current appointment status.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0">Total</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 me-3">
                        <i class="fas fa-hourglass-half fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-0">Pending</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['pending'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Recent Pending Requests</h5>
            <a href="{{ route('teacher.notifications') }}" class="btn btn-link text-primary text-decoration-none fw-bold p-0">View All</a>
        </div>
        
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 px-3 py-3">Student</th>
                        <th class="border-0 py-3">Date</th>
                        <th class="border-0 py-3">Time</th>
                        <th class="border-0 text-end px-3 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAppointments as $app)
                        <tr>
                            <td class="px-3">
                                <span class="fw-semibold text-dark">{{ $app->student->name }}</span>
                            </td>
                            <td>{{ $app->day }}</td>
                            <td>
                                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                                    {{ $app->time_slot }}
                                </span>
                            </td>
                            <td class="text-end px-3">
                                <a href="{{ route('teacher.notifications') }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted mb-2">
                                    <i class="fas fa-check-circle fa-2x opacity-25"></i>
                                </div>
                                <span class="text-muted">No pending requests found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection