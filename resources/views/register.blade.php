<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | NEU Portal</title>
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
            <form method="POST" action="{{ route('register') }}">
                @csrf 
                
                {{-- Full Name --}}
                <div class="mb-3">
                    <label for="inputName" class="form-label fw-semibold">Full Name</label>
                    <input class="form-control @error('name') is-invalid @enderror" id="inputName" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe" />
                    @error('name')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Email --}}
                <div class="mb-3">
                    <label for="inputEmail" class="form-label fw-semibold">Institutional E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="inputEmail" type="email" name="email" value="{{ old('email') }}" required placeholder="student@std.neu.edu.tr" />
                    @error('email')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Faculty Selection --}}
                <div class="mb-3">
                    <label for="inputFaculty" class="form-label fw-semibold">Faculty</label>
                    <select class="form-select @error('faculty') is-invalid @enderror" id="inputFaculty" name="faculty" required>
                        <option value="">Please select your faculty...</option>
                        <option value="Atatürk Faculty of Education" {{ old('faculty') == 'Atatürk Faculty of Education' ? 'selected' : '' }}>Atatürk Faculty of Education</option>
                        <option value="Faculty of Dentistry" {{ old('faculty') == 'Faculty of Dentistry' ? 'selected' : '' }}>Faculty of Dentistry</option>
                        <option value="Faculty of Pharmacy" {{ old('faculty') == 'Faculty of Pharmacy' ? 'selected' : '' }}>Faculty of Pharmacy</option>
                        <option value="Faculty of Arts and Sciences" {{ old('faculty') == 'Faculty of Arts and Sciences' ? 'selected' : '' }}>Faculty of Arts and Sciences</option>
                        <option value="Faculty of Fine Arts and Design" {{ old('faculty') == 'Faculty of Fine Arts and Design' ? 'selected' : '' }}>Faculty of Fine Arts and Design</option>
                        <option value="Faculty of Nursing" {{ old('faculty') == 'Faculty of Nursing' ? 'selected' : '' }}>Faculty of Nursing</option>
                        <option value="Faculty of Law" {{ old('faculty') == 'Faculty of Law' ? 'selected' : '' }}>Faculty of Law</option>
                        <option value="Faculty of Economics and Administrative Sciences" {{ old('faculty') == 'Faculty of Economics and Administrative Sciences' ? 'selected' : '' }}>Faculty of Economics and Administrative Sciences</option>
                        <option value="Faculty of Civil and Environmental Engineering" {{ old('faculty') == 'Faculty of Civil and Environmental Engineering' ? 'selected' : '' }}>Faculty of Civil and Environmental Engineering</option>
                        <option value="Faculty of Theology" {{ old('faculty') == 'Faculty of Theology' ? 'selected' : '' }}>Faculty of Theology</option>
                        <option value="Faculty of Communication" {{ old('faculty') == 'Faculty of Communication' ? 'selected' : '' }}>Faculty of Communication</option>
                        <option value="Faculty of Architecture" {{ old('faculty') == 'Faculty of Architecture' ? 'selected' : '' }}>Faculty of Architecture</option>
                        <option value="Faculty of Engineering" {{ old('faculty') == 'Faculty of Engineering' ? 'selected' : '' }}>Faculty of Engineering</option>
                        <option value="Faculty of Health Sciences" {{ old('faculty') == 'Faculty of Health Sciences' ? 'selected' : '' }}>Faculty of Health Sciences</option>
                        <option value="Faculty of Sports Sciences" {{ old('faculty') == 'Faculty of Sports Sciences' ? 'selected' : '' }}>Faculty of Sports Sciences</option>
                        <option value="Faculty of Medicine" {{ old('faculty') == 'Faculty of Medicine' ? 'selected' : '' }}>Faculty of Medicine</option>
                        <option value="Faculty of Tourism" {{ old('faculty') == 'Faculty of Tourism' ? 'selected' : '' }}>Faculty of Tourism</option>
                        <option value="Faculty of Veterinary Medicine" {{ old('faculty') == 'Faculty of Veterinary Medicine' ? 'selected' : '' }}>Faculty of Veterinary Medicine</option>
                        <option value="Faculty of Artificial Intelligence and Informatics" {{ old('faculty') == 'Faculty of Artificial Intelligence and Informatics' ? 'selected' : '' }}>Faculty of Artificial Intelligence and Informatics</option>
                        <option value="Faculty of Agriculture" {{ old('faculty') == 'Faculty of Agriculture' ? 'selected' : '' }}>Faculty of Agriculture</option>
                    </select>
                    @error('faculty')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="inputPassword" class="form-label fw-semibold">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="inputPassword" type="password" name="password" required placeholder="At least 8 characters" />
                    @error('password')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Password Confirmation --}}
                <div class="mb-4">
                    <label for="inputPasswordConfirm" class="form-label fw-semibold">Confirm Password</label>
                    <input class="form-control" id="inputPasswordConfirm" type="password" name="password_confirmation" required placeholder="Repeat password" />
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Register Now</button>
                </div>
            </form>
        </div>
        
        <div class="card-footer text-center py-4">
            <div class="small text-muted">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
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