<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Faculty;
use App\Models\TeacherSchedule;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusMail;

class TeacherAuthController extends Controller
{
    
    /**
     * Hoca Paneli Ana Sayfası (İstatistikler)
     */
    public function dashboard()
    {
        $id = Auth::guard('teacher')->id();

        $stats = [
            'total'     => Appointment::where('teacher_id', $id)->count(),
            'pending'   => Appointment::where('teacher_id', $id)->where('status', 'pending')->count(),
            'approved'  => Appointment::where('teacher_id', $id)->where('status', 'approved')->count(),
            'completed' => Appointment::where('teacher_id', $id)->where('status', 'completed')->count(),
        ];

        $recentAppointments = Appointment::where('teacher_id', $id)
            ->where('status', 'pending')
            ->with('student')
            ->latest()
            ->take(5)
            ->get();

        return view('hometh', compact('stats', 'recentAppointments'));
    }

    /**
     * Randevuyu Tamamlandı Olarak İşaretle (QR Kodsuz Yeni Sistem)
     */
    public function completeAppointment($id) {
        $appointment = Appointment::where('teacher_id', Auth::guard('teacher')->id())->findOrFail($id);
        $appointment->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Randevu başarıyla tamamlandı olarak işaretlendi.');
    }

    /**
     * Randevu Bildirimleri ve Listesi
     */
public function notifications() {
    $teacherId = Auth::guard('teacher')->id();

    $notifications = Appointment::with(['student.faculty']) // Öğrenciyle birlikte fakülteyi de yükle
        ->where('teacher_id', $teacherId)
        ->latest()
        ->get();

    return view('teacher_notifications', compact('notifications'));
}

    /**
     * Randevu Onaylama veya Reddetme (Kapasite Kontrollü)
     */
    public function handleAppointment(Request $request, $id) 
    {
        $appointment = Appointment::with(['student', 'teacher'])->findOrFail($id);
        
        if ($request->status == 'approved') {
            // Kontenjan Kontrolü: Aynı saatte onaylı kaç kişi var?
            $approvedCount = Appointment::where('teacher_id', Auth::guard('teacher')->id())
                ->where('day', $appointment->day)
                ->where('time_slot', $appointment->time_slot)
                ->where('status', 'approved')
                ->count();

            if ($approvedCount >= 4) {
                return back()->with('error', 'Bu saat dilimi için zaten 4 onaylı randevunuz var. Kapasite dolmuştur.');
            }
        }

        $appointment->update([
            'status' => $request->status,
            'is_read_student' => false 
        ]);

        // Bilgilendirme Maili
        try {
            Mail::to($appointment->student->email)->send(new AppointmentStatusMail($appointment));
            $mailStatus = " ve öğrenciye mail gönderildi.";
        } catch (\Exception $e) {
            $mailStatus = " (Mail gönderilemedi).";
        }

        $msg = $request->status == 'approved' ? 'Randevuyu onayladınız' : 'Randevuyu reddettiniz';
        return back()->with('success', $msg . $mailStatus);
    }

    // --- PROGRAM YÖNETİMİ ---
    public function showScheduleOnly() {
        $teacher = Auth::guard('teacher')->user(); 
        if (!$teacher) return redirect()->route('loginviewth');

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $slots = ['08:30-09:30', '09:30-10:30', '10:30-11:30', '11:30-12:30', '12:30-13:30', '13:30-14:30', '14:30-15:30', '15:30-16:30', '16:30-17:30'];
        $schedules = TeacherSchedule::where('teacher_id', $teacher->id)->get();

        return view('teacher_schedule', compact('teacher', 'days', 'slots', 'schedules'));
    }

    public function updateScheduleBulk(Request $request) {
        $teacherId = Auth::guard('teacher')->id();
        $schedules = $request->input('schedules');

        if ($schedules) {
            foreach ($schedules as $data) {
                TeacherSchedule::updateOrCreate(
                    ['teacher_id' => $teacherId, 'day' => $data['day'], 'time_slot' => $data['time_slot']],
                    ['status' => $data['status']]
                );
            }
        }
        return response()->json(['success' => true]);
    }

    // --- PROFİL VE AUTH ---
    public function showProfileSettings() {
        $teacher = Auth::guard('teacher')->user();
        $faculties = Faculty::all();
        return view('teacher_profile', compact('teacher', 'faculties'));
    }

public function updateProfile(Request $request)
{
    // Hocanın ID'sini oturumdan alıyoruz
    $teacherId = auth()->guard('teacher')->id(); // Eğer hoca guard'ı kullanıyorsan
    $teacher = Teacher::findOrFail($teacherId);

    $request->validate([
        'name' => 'required|string|max:255',
        'office_location' => 'nullable|string|max:255',
        'faculty_id' => 'required'
    ]);

    // Veritabanına yazma işlemi
    $teacher->update([
        'name' => $request->name,
        'office_location' => $request->office_location,
        'faculty_id' => $request->faculty_id
    ]);

    return back()->with('success', 'Ofis bilginiz ve profiliniz güncellendi.');
}

    public function loginviewth() { return view('loginth'); }

    public function loginth(Request $request) {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::guard('teacher')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('hometh'));
        }
        return back()->withErrors(['email' => 'Hatalı giriş bilgileri.']);
    }

    public function logoutTeacher(Request $request) {
        Auth::guard('teacher')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/loginth');
    }

    public function registerviewth() {
        $faculties = Faculty::all();
        return view('registerth', compact('faculties'));
    }

    public function registerth(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:teachers', 'regex:/^[a-zA-Z0-9._%+-]+@neu\.edu\.tr$/i'],
            'faculty_id' => 'required|exists:faculties,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $teacher = Teacher::create([
            'name' => $request->name, 'email' => $request->email, 'faculty_id' => $request->faculty_id, 'password' => Hash::make($request->password),
        ]);

        Auth::guard('teacher')->login($teacher);
        return redirect()->route('hometh');
    }
  public function showReservations()
{
    $teacherId = auth()->id();

    // Sadece 'approved' (onaylı) olanları ve tarihe göre sıralı çekiyoruz
    $reservations = Appointment::where('teacher_id', $teacherId)
        ->where('status', 'approved')
        ->with('student')
        ->orderBy('appointment_date', 'asc') // En yakın tarih en üstte
        ->get()
        ->groupBy('appointment_date'); // ÖNEMLİ: Tarihe göre gruplar

    return view('reservationsth', compact('reservations'));
}
}