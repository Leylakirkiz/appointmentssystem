<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f0f2f5; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
        }
        
        .logo-bg {
            background-image: url("{{ asset('neuu.png')}}");
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
            background-blend-mode: multiply;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0; 
        }

        .logo-bg h3 {
            color: white; 
            padding: 20px;
        }

        #inputEmail:focus,
        .form-control:focus {
            border-color: #ff0000; 
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25); 
        }

        .card-footer a {
            color: red; 
        }

        .card-footer a:hover {
            color: #cc0000; 
            text-decoration: none;
        }
    </style>
</head>
<body>
    
<div class="login-card">
    <div class="card shadow-lg border-0 rounded-lg">
        
        {{-- HEADER AREA --}}
        <div class="card-header text-white text-center logo-bg"> 
            <h3 class="fw-bold my-1">Lecturer Portal</h3>
        </div>
        
        <div class="card-body p-4 p-md-5">
            {{-- Form Action updated for Teacher Login --}}
            <form method="POST" action="{{ route('loginth') }}">
                @csrf 
                
                {{-- Global Error Message --}}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Please check your email and password.
                    </div>
                @endif
                
                {{-- 1. Email Field --}}
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Lecturer E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           id="inputEmail" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="name@neu.edu.tr" />
                </div>

                {{-- 2. Password Field --}}
                <div class="mb-4">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           id="inputPassword" 
                           type="password" 
                           name="password" 
                           required 
                           placeholder="Password" />
                </div>
                
                {{-- Remember Me --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
                    <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>

                {{-- Login Button --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger btn-lg">Login</button>
                </div>
            </form>

        </div>
        
        <div class="card-footer text-center py-3">
            <div class="small">
                {{-- Link to Teacher Register --}}
                <a href="{{ route('registerviewth') }}">Don't have an account? Sign up.</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>