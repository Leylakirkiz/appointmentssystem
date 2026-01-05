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

    /**
     * NOTIFICATIONS: Displays the status of the student's applications.
     * Automatically expires pending appointments older than 7 days.
     */
    public function notifications() {
        $studentId = Auth::id();

        // Auto-expire pending appointments that are older than 7 days
        Appointment::where('student_id', $studentId)
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subDays(7))
            ->update(['status' => 'expired']);

        // Fetch notifications
        $notifications = Appointment::with('teacher')
            ->where('student_id', $studentId)
            ->latest()
            ->get();

        // Mark unread notifications as read when the page is visited
        Appointment::where('student_id', $studentId)
            ->where('is_read_student', false)
            ->update(['is_read_student' => true]);

        return view('student_notifications', compact('notifications'));
    }

    // MY RESERVATIONS: Lists only the appointments approved by the teacher.
     
    public function reservations() {
        $appointments = Appointment::with('teacher')
            ->where('student_id', Auth::id())
            ->where('status', 'approved') 
            ->latest()
            ->get();

        return view('reservations', compact('appointments'));
    }

    //Main page showing the list of faculties.
     
    public function index() {
        $faculties = Faculty::with('teachers')->get();
        return view('createreservations', compact('faculties'));
    }

    // Lists teachers within a selected faculty.
     
    public function showTeachers($faculty_id) {
        $faculty = Faculty::with('teachers')->findOrFail($faculty_id);
        return view('faculty_teachers', compact('faculty'));
    }

    // Shows the teacher's weekly schedule and appointment booking table.
     
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

    // STORE APPOINTMENT: Handles appointment creation with validation.
     
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'teacher_id'       => 'required',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot'        => 'required',
            'student_note'     => 'required'
        ]);

        // Find the day name of the selected date (for the 'day' column)
        $dayName = \Carbon\Carbon::parse($request->appointment_date)->format('l');

        Appointment::create([
            'student_id'       => Auth::id(),
            'teacher_id'       => $request->teacher_id,
            'appointment_date' => $request->appointment_date, // Specific date selected by student
            'day'              => $dayName,                   // Monday, Tuesday, etc.
            'time_slot'        => $request->time_slot,
            'student_note'     => $request->student_note,
            'status'           => 'pending'
        ]);

        return back()->with('success', 'Your appointment request for ' . $request->appointment_date . ' has been submitted.');
    }

    //CANCEL OPERATION: Allows the student to withdraw their own request.
     
    public function cancelAppointment($id) {
        $appointment = Appointment::where('id', $id)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        // Only pending or approved appointments can be cancelled.
        if (in_array($appointment->status, ['pending', 'approved'])) {
            $appointment->update([
                'status' => 'cancelled',
                'is_read_teacher' => false, // Notify teacher of the cancellation
            ]);
            return back()->with('success', 'Your appointment has been successfully cancelled.');
        }

        return back()->with('error', 'You cannot cancel a past or already rejected appointment.');
    }
}