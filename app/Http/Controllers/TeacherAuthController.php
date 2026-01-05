<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Faculty;
use App\Models\TeacherSchedule;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class TeacherAuthController extends Controller
{
    
    // Teacher Dashboard (Statistics)
     
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



    // Appointment Notifications and List
     
    public function notifications () {
        $teacherId = Auth::guard('teacher')->id();

        $notifications = Appointment::with(['student.faculty']) // Load student with faculty details
            ->where('teacher_id', $teacherId)
            ->latest()
            ->get();
        
        Appointment::where('teacher_id', $teacherId)
            ->where('is_read_teacher', false)
            ->update(['is_read_teacher' => true]);    

        return view('teacher_notifications', compact('notifications'));
    }

    /**
     * Approve or Reject Appointment (with Capacity Control)
     */
    public function handleAppointment(Request $request, $id) 
{
    // Fetch the appointment with related data
    $appointment = Appointment::with(['student', 'teacher'])->findOrFail($id);
    
    if ($request->status == 'approved') {
        // Capacity Check: How many approved appointments exist for this specific slot?
        $approvedCount = Appointment::where('teacher_id', Auth::guard('teacher')->id())
            ->where('day', $appointment->day)
            ->where('time_slot', $appointment->time_slot)
            ->where('status', 'approved')
            ->count();

        // If capacity (4) is reached, prevent further approvals
        if ($approvedCount >= 4) {
            return back()->with('error', 'Capacity full: You already have 4 approved appointments for this time slot.');
        }
    }

    // Update database record and set the notification flag for the student dashboard
    $appointment->update([
        'status' => $request->status,
        'is_read_student' => false 
    ]);

    // Prepare success message based on the action taken
    $msg = $request->status == 'approved' ? 'Appointment has been approved.' : 'Appointment has been rejected.';
    
    return back()->with('success', $msg);
}

    // --- SCHEDULE MANAGEMENT ---

    // Show Weekly Schedule
     
    public function showScheduleOnly() {
        $teacher = Auth::guard('teacher')->user(); 
        if (!$teacher) return redirect()->route('loginviewth');

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $slots = ['08:30-09:30', '09:30-10:30', '10:30-11:30', '11:30-12:30', '12:30-13:30', '13:30-14:30', '14:30-15:30', '15:30-16:30', '16:30-17:30'];
        $schedules = TeacherSchedule::where('teacher_id', $teacher->id)->get();

        return view('teacher_schedule', compact('teacher', 'days', 'slots', 'schedules'));
    }

    // Update Schedule in Bulk
     
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

    // --- PROFILE AND AUTHENTICATION ---

    // Show Profile Edit Page
     
    public function showProfileSettings() {
        $teacher = Auth::guard('teacher')->user();
        $faculties = Faculty::all();
        return view('teacher_profile', compact('teacher', 'faculties'));
    }

    // Update Teacher Profile
     
    public function updateProfile(Request $request)
    {
        $teacherId = auth()->guard('teacher')->id();
        $teacher = Teacher::findOrFail($teacherId);

        $request->validate([
            'name' => 'required|string|max:255',
            'office_location' => 'nullable|string|max:255',
            'faculty_id' => 'required'
        ]);

        $teacher->update([
            'name' => $request->name,
            'office_location' => $request->office_location,
            'faculty_id' => $request->faculty_id
        ]);

        return back()->with('success', 'Your office location and profile have been updated.');
    }

    public function loginviewth() { return view('loginth'); }

    // Teacher Login Logic
     
    public function loginth(Request $request) {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::guard('teacher')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('hometh'));
        }
        return back()->withErrors(['email' => 'Invalid login credentials.']);
    }

    //Teacher Logout
     
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

    // Teacher Registration Logic
     
    public function registerth(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:teachers', 'regex:/^[a-zA-Z0-9._%+-]+@neu\.edu\.tr$/i'],
            'faculty_id' => 'required|exists:faculties,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $teacher = Teacher::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'faculty_id' => $request->faculty_id, 
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('teacher')->login($teacher);
        return redirect()->route('hometh');
    }

    
      //List Approved Reservations
     
    public function showReservations()
    {
        $teacherId = auth()->id();

        // Fetch only 'approved' appointments grouped by date
        $reservations = Appointment::where('teacher_id', $teacherId)
            ->where('status', 'approved')
            ->with('student')
            ->orderBy('appointment_date', 'asc') // Nearest date first
            ->get()
            ->groupBy('appointment_date');

        return view('reservationsth', compact('reservations'));
    }
}