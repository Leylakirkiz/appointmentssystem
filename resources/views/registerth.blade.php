<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Registration | NEU Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --hover-blue: #1e40af;
        }

        body {
            background-color: #f1f5f9; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            padding: 40px 0;
        }

        .register-card {
            max-width: 500px;
            width: 100%;
        }

        .card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
        }
        
        .logo-bg {
            background-color: var(--primary-blue);
            background-image: linear-gradient(rgba(30, 58, 138, 0.85), rgba(30, 58, 138, 0.85)), url("{{ asset('neuu.png') }}");
            background-size: cover;
            background-position: center;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-control, .form-select {
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.15);
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--hover-blue);
            transform: translateY(-1px);
        }

        .card-footer a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .portal-icon {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    
<div class="register-card px-3">
    <div class="card shadow-lg">
        
        <div class="card-header text-white text-center logo-bg border-0"> 
            
        </div>
        
        <div class="card-body p-4">
            <form method="POST" action="{{ route('registerth') }}">
                @csrf 
                
                {{-- 1. FULL NAME --}}
                <div class="mb-3">
                    <label for="inputName" class="form-label fw-semibold">Full Name</label>
                    <input class="form-control @error('name') is-invalid @enderror" 
                           id="inputName" type="text" name="name" value="{{ old('name') }}" 
                           required autofocus placeholder="e.g. Prof. Dr. John Doe" />
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                {{-- 2. E-MAIL --}}
                <div class="mb-3">
                    <label for="inputEmail" class="form-label fw-semibold">Academic E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           id="inputEmail" type="email" name="email" value="{{ old('email') }}" 
                           required placeholder="name@neu.edu.tr" />
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- 3. FACULTY SELECTION (Dynamic) --}}
                <div class="mb-3">
                    <label for="faculty_id" class="form-label fw-semibold">Faculty Assignment</label>
                    <select class="form-select @error('faculty_id') is-invalid @enderror" id="faculty_id" name="faculty_id" required>
                        <option value="">Select your faculty...</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                {{ $faculty->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('faculty_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- 4. PASSWORD --}}
                <div class="mb-3">
                    <label for="inputPassword" class="form-label fw-semibold">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" 
                           id="inputPassword" type="password" name="password" 
                           required placeholder="At least 8 characters" />
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                {{-- 5. PASSWORD CONFIRMATION --}}
                <div class="mb-4">
                    <label for="inputPasswordConfirm" class="form-label fw-semibold">Confirm Password</label>
                    <input class="form-control" id="inputPasswordConfirm" type="password" 
                           name="password_confirmation" required placeholder="Repeat password" />
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                        Create Lecturer Account
                    </button>
                </div>
            </form>
        </div>
        
        <div class="card-footer text-center py-4">
            <div class="small text-muted">
                Already registered? <a href="{{ route('loginviewth') }}">Log In here</a>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ url('/neu') }}" class="text-decoration-none text-muted small">
            <i class="fas fa-chevron-left me-1"></i> Back to Main Page
        </a>
    </div>
</div>

</body>
</html>