<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Login | NEU Portal</title>
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
        }

        .login-card {
            max-width: 450px;
            width: 100%;
        }

        .card {
            border-radius: 20px;
            overflow: hidden;
        }
        
        .logo-bg {
            background-color: var(--primary-blue);
            background-image: linear-gradient(rgba(30, 58, 138, 0.9), rgba(30, 58, 138, 0.9)), url("{{ asset('neuu.png')}}");
            background-size: cover;
            background-position: center;
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .form-control {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
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

        .card-footer {
            background-color: #f8fafc;
            border-top: 1px solid #f1f5f9;
        }

        .card-footer a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        .portal-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: rgba(255,255,255,0.9);
        }
    </style>
</head>
<body>
    
<div class="login-card">
    <div class="card shadow-lg border-0">
        
        <div class="card-header text-white text-center logo-bg"> 
            
        </div>
        
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('loginth') }}">
                @csrf 
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 small" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> Invalid email or password.
                    </div>
                @endif
                
                <div class="mb-3">
                    <label for="inputEmail" class="form-label fw-semibold">E-mail Address</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           id="inputEmail" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="name@neu.edu.tr" />
                </div>

                <div class="mb-4">
                    <label for="inputPassword" class="form-label fw-semibold">Password</label>
                    <input class="form-control" 
                           id="inputPassword" 
                           type="password" 
                           name="password" 
                           required 
                           placeholder="••••••••" />
                </div>
                
                

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Sign In <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="card-footer text-center py-4">
            <div class="small text-muted">
                New to the system? <a href="{{ route('registerviewth') }}">Create an account</a>
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