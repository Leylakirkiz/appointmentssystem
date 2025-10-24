<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
   public function register(Request $request){
       $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
        ],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users',
            
            // Regex Kuralı: E-postanın formatını kontrol eder
            'regex:/^\d{8}@std\.neu\.edu\.tr$/i',],
            'password' => [
            'required',
            'string',
            'confirmed',
            
            
            // Laravel'in güçlü şifre kural yapısını kullanıyoruz
            Password::min(8) // En az 8 karakter
                ->letters()  // En az bir harf
                ->mixedCase() // En az bir büyük ve bir küçük harf (istediğiniz "bir büyük harf"i kapsar)
                ->symbols()  // En az bir noktalama/sembol (istediğiniz "bir noktalama işareti"ni kapsar)
                ->numbers(), // En az bir rakam
        ],
        [
        'email.ends_with' => 'Lütfen sadece okulunuzun resmi e-posta adresini kullanın.',
        'password.confirmed' => 'Şifrenizi onaylarken hata yaptınız, şifreler eşleşmiyor.',
        'name.required' => 'Ad ve soyad alanı boş bırakılamaz.',
    ]
    ]);

    // 2. Kullanıcı Oluşturma
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        
        // Şifreyi Hash'leyerek veritabanına kaydetme kısmı BURASI!
        'password' => Hash::make($request->password), 
    ]);
    
    // 3. Yönlendirme
     
    return redirect('/home');}


    public function registerview(){
        return view('register');
    }
    public function loginview(){
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Doğrulama başarılıysa
            $request->session()->regenerate();

            // Kullanıcıyı istediğiniz panoya yönlendirin (örn: /dashboard)
            return redirect()->intended('/home'); 
        }
        return back()->withErrors([
            'email' => 'Girdiğiniz kimlik bilgileri kayıtlarımızla eşleşmiyor.',
        ])->onlyInput('email');
    }
}
