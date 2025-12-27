<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Teacher;
use App\Models\TeacherSchedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    // Randevuyu Onaylama Fonksiyonu
public function approve($id)
{
    // 1. Randevuyu bul (Öğrencinin seçtiği tarih ve saat zaten içinde kayıtlı)
    $appointment = Appointment::findOrFail($id);

    // 2. Sadece durumunu 'approved' yapıyoruz, tarihe dokunmuyoruz
    $appointment->update([
        'status' => 'approved'
    ]);

    // 3. Hocayı onaylı randevuların olduğu sayfaya yönlendir
    return redirect()->back()->with('success', 'Randevu başarıyla onaylandı.');
}
    /**
     * BİLDİRİMLER: Öğrencinin tüm başvuru süreçlerini gördüğü ekran.
     * 1 haftalık süresi dolan bekleyen randevuları otomatik iptal eder.
     */
    public function notifications() {
        $studentId = Auth::id();

        // 7 günü geçen ve hala 'pending' (beklemede) olanları 'expired' yap
        Appointment::where('student_id', $studentId)
            ->where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        $notifications = Appointment::with('teacher')
            ->where('student_id', $studentId)
            ->latest()
            ->get();

        return view('student_notifications', compact('notifications'));
    }

    /**
     * RANDEVULARIM: Sadece hocanın onayladığı (approved) randevular listelenir.
     */
    public function reservations() {
        $appointments = Appointment::with('teacher')
            ->where('student_id', Auth::id())
            ->where('status', 'approved') 
            ->latest()
            ->get();

        return view('reservations', compact('appointments'));
    }

    /**
     * Fakülte listesini gösteren ana sayfa.
     */
    public function index() {
        $faculties = Faculty::with('teachers')->get();
        return view('createreservations', compact('faculties'));
    }

    /**
     * Seçilen fakültedeki hocaları listeler.
     */
    public function showTeachers($faculty_id) {
        $faculty = Faculty::with('teachers')->findOrFail($faculty_id);
        return view('faculty_teachers', compact('faculty'));
    }

    /**
     * Hocanın haftalık programını ve randevu alma tablosunu gösterir.
     */
    public function reserve($id) {
        $teacher = Teacher::with('faculty')->findOrFail($id);
        $faculty = $teacher->faculty;

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $slots = [
            '08:30-09:30', '09:30-10:30', '10:30-11:30', '11:30-12:30', 
            '12:30-13:30', '13:30-14:30', '14:30-15:30', '15:30-16:30', '16:30-17:30'
        ];
                  
        $schedules = TeacherSchedule::where('teacher_id', $id)->get();
        
        return view('faculty_reserve_detail', compact('teacher', 'faculty', 'days', 'slots', 'schedules'));
    }

    /**
     * RANDEVU KAYIT: Tüm kısıtlamaların (Kontenjan, Haftalık Limit) kontrol edildiği yer.
     */
public function storeAppointment(Request $request)
{
    $request->validate([
        'teacher_id'       => 'required',
        'appointment_date' => 'required|date|after_or_equal:today',
        'time_slot'        => 'required',
        'student_note'     => 'required'
    ]);

    // Seçilen tarihin hangi gün olduğunu bul (Database'deki 'day' kolonu için)
    $dayName = \Carbon\Carbon::parse($request->appointment_date)->format('l');

    Appointment::create([
        'student_id'       => Auth::id(),
        'teacher_id'       => $request->teacher_id,
        'appointment_date' => $request->appointment_date, // Öğrencinin seçtiği net tarih
        'day'              => $dayName,                   // Monday, Tuesday vb.
        'time_slot'        => $request->time_slot,
        'student_note'     => $request->student_note,
        'status'           => 'pending'
    ]);

    return back()->with('success', 'Randevu talebiniz ' . $request->appointment_date . ' tarihi için iletildi.');
}

    /**
     * İPTAL İŞLEMİ: Öğrencinin kendi talebini geri çekmesi.
     */
    public function cancelAppointment($id) {
        $appointment = Appointment::where('id', $id)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        // Sadece bekleyen (pending) veya onaylanan (approved) randevular iptal edilebilir.
        if (in_array($appointment->status, ['pending', 'approved'])) {
            $appointment->update([
                'status' => 'cancelled',
                'is_read_teacher' => false, // Hocanın iptalden haberi olması için
            ]);
            return back()->with('success', 'Randevunuz başarıyla iptal edildi.');
        }

        return back()->with('error', 'Geçmiş veya reddedilmiş bir randevuyu iptal edemezsiniz.');
    }
}