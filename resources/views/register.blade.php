<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
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
        
        /* LOGO ARKA PLAN STİLLERİ */
        .logo-bg {
            /* Resmin yolu asset() ile dinamik olarak verilmeli */
            background-image: url("{{ asset('neuu.png') }}");
            
            background-size: contain;          /* Tüm alanı kapla */
            background-position: center center; /* Resmi ortala */
            background-repeat: no-repeat;    
            
            /* Kırmızı Overlay ve Karıştırma */
             /* Bootstrap Kırmızı Rengi */
            background-blend-mode: multiply; /* Resim ve rengi karıştırarak koyulaştırır */
            
            min-height: 150px; /* Resmin görünür olması için yükseklik */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            
            /* Başlık rengini üstten ve alttan boşluk vermek için kaldırıyoruz */
            padding: 0; 
        }
        /* inputEmail ID'sini veya form-control sınıfını hedefliyoruz */
#inputEmail:focus,
.form-control:focus {
    /* 1. Varsayılan mavi çerçeve rengini kırmızıya çevir */
    border-color: #ff0000; /* Kırmızı renk kodu */

    /* 2. Tarayıcının varsayılan dış halkasını (outline) kaldır (Genellikle Bootstrap bunu yapıyor) */
    outline: 0;

    /* 3. Bootstrap'in varsayılan mavi box-shadow gölgesini kırmızıya çevir */
    /* Bu, o belirgin mavi parlamayı oluşturan kısımdır. */
    box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25); /* Kırmızı, %25 şeffaflıkta gölge */
    
    /* Veya daha koyu bir kırmızı (tercihe göre) */
    /* box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);  */
}
/* Ana metin rengi ve odak rengi */
.card-footer a {
    color: red; 
    /* color: #dc3545;  Bootstrap'in "danger" kırmızısını tercih edebilirsiniz. */
}

/* Fare üzerine gelme (Hover) rengi */
.card-footer a:hover {
    color: #cc0000; /* Koyu kırmızı */
    text-decoration: none; /* Üzerine gelince alt çizgiyi kaldırmak isterseniz */
}

        
    </style>
</head>
<body>
    
<div class="register-card">
    <div class="card shadow-lg border-0 rounded-lg">
        
        {{-- BAŞLIK ALANI (Resim artık CSS ile arka planda) --}}
        <div class="card-header text-white text-center logo-bg"> 
            <h3 class="fw-bold my-1"></h3>
        </div>
        
        <div class="card-body p-4 p-md-5">
            {{-- Form kodu buraya gelecek... --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf 
                
                {{-- ... (Giriş alanları) ... --}}
                <div class="mb-3">
                    <label for="inputName" class="form-label">Name Surname</label>
                    <input class="form-control @error('name') is-invalid @enderror" id="inputName" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Name Surname" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="inputEmail" type="email" name="email" value="{{ old('email') }}" required placeholder="email@std.neu.edu.tr" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="inputPassword" type="password" name="password" required autocomplete="new-password" placeholder="At least 8 characters" />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="inputPasswordConfirm" class="form-label">Confirm Password</label>
                    <input class="form-control" id="inputPasswordConfirm" type="password" name="password_confirmation" required placeholder="Repeat Password" />
                </div>

                <div class="d-grid gap-2">
    <button type="submit" class="btn btn-danger btn-lg">Create Account</button>
</div>
            </form>
            {{-- Form Sonu --}}

        </div>
        
        <div class="card-footer text-center py-3">
            <div class="small">
                <a href="{{ route('loginview') ?? '#' }}">Login.</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>