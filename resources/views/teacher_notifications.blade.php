@extends('layoutth')

@section('content')
<style>
    .teacher-wrapper { padding: 20px 0; }
    
    .request-card { 
        border-left: 6px solid #1e3a8a; 
        transition: 0.3s; 
        border-radius: 15px; 
        overflow: hidden; 
        background: #fff; 
        border-top: none; border-right: none; border-bottom: none;
    }
    
    .border-cancelled { border-left-color: #64748b !important; background-color: #f8fafc; } 
    .border-approved { border-left-color: #10b981 !important; } 
    .border-rejected { border-left-color: #ef4444 !important; } 
    
    .request-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 10px 25px rgba(30, 58, 138, 0.1) !important; 
    }
    
    .student-link { color: #1e293b; text-decoration: none; transition: 0.2s; font-weight: 700; }
    .student-link:hover { color: #3b82f6; }

    .date-badge-wrapper {
        background-color: #eff6ff; color: #1e3a8a; border: 1px solid #bfdbfe;
        padding: 8px 15px; border-radius: 10px; display: inline-flex;
        align-items: center; font-weight: 700;
    }

    .time-display { font-size: 1.1rem; font-weight: 700; color: #1e293b; display: inline-flex; align-items: center; margin-left: 15px; }
    .note-box { background-color: #f8fafc; border-left: 4px solid #0ea5e9; padding: 15px; border-radius: 10px; margin: 15px 0; }
    
    .student-avatar {
        width: 50px; height: 50px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; 
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        font-weight: bold; font-size: 1.2rem; cursor: pointer;
    }

    .modal-profile-icon { 
        width: 80px; height: 80px; background: #f0f7ff; color: #1e3a8a; 
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        margin: 0 auto 15px; border: 2px solid #dbeafe; 
    }
</style>

<div class="teacher-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Appointment Requests</h2>
            <p class="text-muted small mb-0"><i class="fas fa-info-circle me-1"></i> Click on a student's name to view their full profile.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($notifications as $req)
            @php
                $statusClass = match($req->status) {
                    'cancelled' => 'border-cancelled',
                    'approved' => 'border-approved',
                    'rejected' => 'border-rejected',
                    default => '',
                };
            @endphp

            <div class="col-12 mb-4">
                <div class="card request-card shadow-sm {{ $statusClass }}">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="student-avatar me-3" data-bs-toggle="modal" data-bs-target="#studentModal{{ $req->id }}">
                                        {{ strtoupper(substr($req->student->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="mb-0">
                                            <a href="#" class="student-link" data-bs-toggle="modal" data-bs-target="#studentModal{{ $req->id }}">
                                                {{ $req->student->name ?? 'Unknown Student' }}
                                            </a>
                                        </h4>
                                        <small class="text-muted">{{ $req->student->email ?? '' }}</small>
                                    </div>
                                    @if($req->status == 'cancelled')
                                        <span class="badge bg-secondary ms-3 rounded-pill px-3">CANCELLED</span>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center flex-wrap mb-3">
                                    <div class="date-badge-wrapper">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        {{ $req->appointment_date ? \Carbon\Carbon::parse($req->appointment_date)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($req->appointment_date)->format('l') : 'No Date' }}
                                    </div>
                                    <div class="time-display">
                                        <i class="fas fa-clock me-2 text-primary"></i> {{ $req->time_slot }}
                                    </div>
                                </div>

                                @if($req->student_note)
                                    <div class="note-box shadow-sm">
                                        <small class="text-info fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem;"><i class="fas fa-comment-dots"></i> Student Note</small>
                                        <span class="text-dark italic">"{{ $req->student_note }}"</span>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-4 text-end">
                                @if($req->status == 'pending')
                                    <div class="d-flex gap-2 justify-content-end">
                                        <form action="{{ route('teacher.appointment.handle', $req->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-bold shadow-sm">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('teacher.appointment.handle', $req->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-outline-danger px-4 py-2 rounded-pill fw-bold">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge {{ $req->status == 'approved' ? 'bg-success' : ($req->status == 'rejected' ? 'bg-danger' : 'bg-secondary') }} fs-6 px-4 py-2 rounded-pill">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="studentModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4 pt-0 text-center">
                            <div class="modal-profile-icon"><i class="fas fa-user-graduate fa-2x"></i></div>
                            <h4 class="fw-bold mb-1">{{ $req->student->name }}</h4>
                            <p class="text-muted mb-4">{{ $req->student->email }}</p>
                            
                            <div class="row g-3 text-start">
                                <div class="col-6">
                                    <label class="small text-muted fw-bold text-uppercase d-block">Faculty</label>
                                    <span class="text-dark fw-semibold">
                                        {{ $req->student->faculty->name ?? ($req->student->faculty ?? 'Not Specified') }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <label class="small text-muted fw-bold text-uppercase d-block">Department</label>
                                    <span class="text-dark fw-semibold">{{ $req->student->department ?? 'Not Specified' }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="small text-muted fw-bold text-uppercase d-block">Class Level</label>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill">Year {{ $req->student->class_level ?? '-' }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="small text-muted fw-bold text-uppercase d-block">Language</label>
                                    <span class="text-dark fw-semibold">{{ $req->student->language ?? 'Not Specified' }}</span>
                                </div>
                            </div>
                        </div>
                       
                         
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white shadow-sm rounded-4 py-5 border">
                    <i class="fas fa-inbox fa-4x text-light mb-3"></i>
                    <p class="text-muted fs-5">You have no pending appointment requests at the moment.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection