@extends('layout')

@section('title', 'My Profile')

@section('content')
<style>
    
    .form-control:focus, .form-select:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.1);
    }
    .custom-check .form-check-input:checked {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }
    .profile-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .input-group-text {
        background-color: #f1f5f9;
        border: none;
    }
</style>

<div class="container-fluid py-4">
    <div class="col-xl-10 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:55px; height:55px; background: linear-gradient(135deg, #1e3a8a, #3b82f6) !important;">
                <i class="fas fa-user-graduate fa-lg"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 text-dark">My Profile Information</h2>
                <p class="text-muted mb-0">Update your academic details to help lecturers know you better.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <div class="card profile-card overflow-hidden">
            <div class="card-header bg-dark py-3 border-0">
                <h5 class="card-title mb-0 text-white fw-bold small text-uppercase" style="letter-spacing: 1px;">
                    System Registration Details
                </h5>
            </div>
            
            <div class="card-body p-4 bg-white">
                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-0 py-2" value="{{ $student->name }}" readonly>
                            </div>
                            <small class="text-muted mt-1 d-block">Contact Student Affairs to change your legal name.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-light border-0 py-2" value="{{ $student->email }}" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="my-2 opacity-25">
                            <h6 class="fw-bold text-primary mb-3">Updateable Academic Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Faculty</label>
                            <select name="faculty_id" class="form-select py-2 border-light-subtle shadow-sm" required>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ $student->faculty_id == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Department / Program</label>
                            <input type="text" name="department" class="form-control py-2 border-light-subtle shadow-sm" 
                                   placeholder="e.g., Software Engineering" value="{{ $student->department }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Grade Level</label>
                            <select name="class_level" class="form-select py-2 border-light-subtle shadow-sm">
                                <option value="" disabled {{ !$student->class_level ? 'selected' : '' }}>Select your grade</option>
                                <option value="1" {{ $student->class_level == 1 ? 'selected' : '' }}>1st Year (Freshman)</option>
                                <option value="2" {{ $student->class_level == 2 ? 'selected' : '' }}>2nd Year (Sophomore)</option>
                                <option value="3" {{ $student->class_level == 3 ? 'selected' : '' }}>3rd Year (Junior)</option>
                                <option value="4" {{ $student->class_level == 4 ? 'selected' : '' }}>4th Year (Senior)</option>
                                <option value="5" {{ $student->class_level > 4 ? 'selected' : '' }}>Post-Graduate</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Instruction Language</label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check custom-check">
                                    <input class="form-check-input" type="radio" name="language" id="langTr" value="Turkish" {{ $student->language == 'Turkish' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="langTr">Turkish</label>
                                </div>
                                <div class="form-check custom-check">
                                    <input class="form-check-input" type="radio" name="language" id="langEn" value="English" {{ $student->language == 'English' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="langEn">English</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-lg border-0" style="background: #1e3a8a;">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection