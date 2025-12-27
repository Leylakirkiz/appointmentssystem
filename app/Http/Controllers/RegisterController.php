<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Faculty;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class RegisterController extends Controller

{
   public function profile()
{
    // Giriş yapmış kullanıcının verilerini alıyoruz
    $student = Auth::user(); 
    
    // Tüm fakülteleri dropdown (seçim kutusu) için çekiyoruz
    $faculties = \App\Models\Faculty::all();
    
    // Değişkeni 'student' adıyla view'a gönderiyoruz
    return view('informations', [
        'student' => $student, 
        'faculties' => $faculties
    ]);
}

    // Bilgileri günceller
    public function updateProfile(Request $request)
    {
        $student = auth()->user();

        $request->validate([
            'department' => 'nullable|string|max:255',
            'class_level' => 'nullable|string',
            'language' => 'nullable|string',
            'faculty_id' => 'required|exists:faculties,id'
        ]);

        $student->update([
            'department' => $request->department,
            'class_level' => $request->class_level,
            'language' => $request->language,
            'faculty_id' => $request->faculty_id
        ]);

        return back()->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }
    public function show()
    {
        // Oturum açmış kullanıcının tüm veritabanı kaydını alır
        $user = Auth::user(); 
        
        // Bu veriyi view'a gönderir
        return view('informations', compact('user'));
    }
public function register(Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^\d{8}@std\.neu\.edu\.tr$/i'],
        'faculty' => ['required', 'string'], // Blade'deki select'in name'i "faculty"
        'password' => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)->letters()->mixedCase()->symbols()->numbers()],
    ]);

    // Formdan gelen metne göre veritabanındaki Faculty kaydını bul (ID'yi almak için)
    $facultyRecord = \App\Models\Faculty::where('name', $request->faculty)->first();

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        
        // BURASI KRİTİK: İki sütunu da dolduruyoruz
        'faculty' => $request->faculty, // Hata veren sütun (String: "Faculty of Engineering" vb.)
        'faculty_id' => $facultyRecord ? $facultyRecord->id : null, // İlişki sütunu (ID: 3 vb.)
    ]);

    \Illuminate\Support\Facades\Auth::login($user);
    return redirect('/home');
}

    public function registerview(){
        return view('register');
    }
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login'); // loginview yerine rota ismini kullandık
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

    // credentials verisini kontrol et
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        // Rota ismi 'home' olan yere yönlendir
        return redirect()->route('home'); 
    }

    // Eğer buraya düşüyorsa giriş başarısızdır, hata mesajını gösterir
    return back()->withErrors([
        'email' => 'Girdiğiniz bilgiler hatalı veya böyle bir kullanıcı yok.',
    ])->onlyInput('email');
}
    public function notifications() {
        \App\Models\Appointment::where('status', 'pending')
        ->where('created_at', '<', now()->subDays(7))
        ->update(['status' => 'expired']);
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $studentId = Auth::id();

    // KURAL: 1 hafta dolunca (onaylanmamışsa) isteği "Zaman Aşımı" yap
    Appointment::where('student_id', $studentId)
        ->where('status', 'pending')
        ->where('expires_at', '<', now())
        ->update(['status' => 'expired']);

    // Bildirimleri çek
    $notifications = Appointment::with('teacher')
        ->where('student_id', $studentId)
        ->latest()
        ->get();

    // Sayfaya girince, okunmamış bildirimleri okundu say (isteğe bağlı)
    Appointment::where('student_id', $studentId)
        ->where('is_read_student', false)
        ->update(['is_read_student' => true]);

    return view('student_notifications', compact('notifications'));
}
   
}
