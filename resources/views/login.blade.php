<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f0f2f5; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-card { /* Class adını register yerine login olarak değiştirdik */
            max-width: 450px;
            width: 100%;
        }
        
        /* LOGO ARKA PLAN STİLLERİ - Kayıt sayfasıyla aynı */
        .logo-bg {
            background-image: url("{{ asset('neuu.png')}}");
            background-size: contain;
            background-position: center center;
            background-repeat: no-repeat;
             /* Varsayılan Kırmızı Renk */
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
    
<div class="login-card">
    <div class="card shadow-lg border-0 rounded-lg">
        
        {{-- BAŞLIK ALANI --}}
        <div class="card-header text-white text-center logo-bg"> 
            <h3 class="fw-bold my-1"></h3>
        </div>
        
        <div class="card-body p-4 p-md-5">
            {{-- Form Başlangıcı: 'login' POST rotasına göndeririz --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf 
                
                {{-- Global Hata Mesajı (Giriş Başarısızlığı için) --}}
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        Please chack your email and password.
                    </div>
                @enderror
                
                {{-- 1. E-posta Alanı --}}
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           id="inputEmail" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="E-mail" />
                    {{-- Burada sadece yukarıdaki genel hatayı kullanacağız, validation hataları için error kısmı kaldırıldı --}}
                </div>

                {{-- 2. Şifre Alanı --}}
                <div class="mb-4">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           id="inputPassword" 
                           type="password" 
                           name="password" 
                           required 
                           placeholder="Password" />
                </div>
                
                {{-- Beni Hatırla (Opsiyonel) --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
                    <label class="form-check-label" for="remember_me">Remember</label>
                </div>

                {{-- Giriş Yap Butonu --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger btn-lg">Login</button>
                </div>
            </form>
            {{-- Form Sonu --}}

        </div>
        
        <div class="card-footer text-center py-3">
            <div class="small">
                {{-- Kayıt olma rotasına yönlendirme --}}
                <a href="{{ route('registerview')  }}">Sign up.</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>