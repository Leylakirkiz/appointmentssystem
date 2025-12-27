<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --neu-red: #dc3545;
            --neu-red-focus: #ff0000;
        }

        body {
            background-color: #f0f2f5; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .register-card {
            max-width: 450px;
            width: 100%;
        }
        
        .logo-bg {
            background-image: url("{{ asset('neuu.png') }}");
            background-size: contain; 
            background-position: center center;
            background-repeat: no-repeat; 
            background-blend-mode: multiply; 
            min-height: 150px;
            padding: 0; 
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--neu-red-focus);
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
        }
        
        .card-footer a {
            color: var(--neu-red); 
            text-decoration: none;
        }
        .card-footer a:hover {
            color: #cc0000;
        }
    </style>
</head>
<body>
    
<div class="register-card">
    <div class="card shadow-lg border-0 rounded-lg">
        
        <div class="card-header text-white text-center logo-bg"> 
            <h3 class="fw-bold my-1"></h3>
        </div>
        
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('register') }}">
                @csrf 
                
                {{-- 1. AD SOYAD --}}
                <div class="mb-3">
                    <label for="inputName" class="form-label">Ad Soyad</label>
                    <input class="form-control @error('name') is-invalid @enderror" id="inputName" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Ad Soyad" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- 2. E-POSTA --}}
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">E-posta</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="inputEmail" type="email" name="email" value="{{ old('email') }}" required placeholder="email@std.neu.edu.tr" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 3. FAKÜLTE SEÇİMİ --}}
                <div class="mb-3">
                    <label for="inputFaculty" class="form-label">Faculty Selection</label>
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
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 4. ŞİFRE --}}
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Şifre</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="inputPassword" type="password" name="password" required autocomplete="new-password" placeholder="En az 8 karakter" />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- 5. ŞİFRE ONAYI --}}
                <div class="mb-4">
                    <label for="inputPasswordConfirm" class="form-label">Şifreyi Onayla</label>
                    <input class="form-control" id="inputPasswordConfirm" type="password" name="password_confirmation" required placeholder="Şifreyi Tekrarla" />
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger btn-lg">Hesap Oluştur</button>
                </div>
            </form>
        </div>
        
        <div class="card-footer text-center py-3">
            <div class="small">
                <a href="{{ route('login') }}">Zaten hesabınız var mı? Giriş Yap.</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>