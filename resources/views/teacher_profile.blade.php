@extends('layoutth')

@section('content')
<div class="teacher-wrapper py-4">
    <div class="col-md-8 mx-auto">
        <h2 class="fw-bold mb-4 text-dark">Profile Settings</h2>
        
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header py-3 text-center border-0" style="background-color: #1e3a8a;">
                <h5 class="mb-0 text-white fw-bold">Personal & Academic Information</h5>
            </div>
            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('teacher.profile.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-user text-primary"></i></span>
                            <input type="text" name="name" class="form-control border-start-0 shadow-sm" value="{{ $teacher->name }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 shadow-sm" value="{{ $teacher->email }}" readonly>
                        </div>
                        <div class="form-text text-muted">The email address is used for system identification and cannot be changed.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Office Location / Room Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-door-open text-primary"></i></span>
                            <input type="text" name="office_location" class="form-control border-start-0 shadow-sm" 
                                   placeholder="e.g. Faculty of Engineering, Block B, Room 302" 
                                   value="{{ $teacher->office_location }}">
                        </div>
                        <div class="form-text text-muted">Students will see this location when booking an appointment.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Assigned Faculty</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-university text-primary"></i></span>
                            <select name="faculty_id" class="form-select border-start-0 shadow-sm">
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ $teacher->faculty_id == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm py-3 fw-bold" style="background-color: #1e3a8a; border: none;">
                            <i class="fas fa-save me-2"></i> Update Profile Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection