<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Faculty;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    //Show the student profile information.
     
    public function profile()
    {
        // Get the authenticated user's data
        $student = Auth::user(); 
        
        // Fetch all faculties for the dropdown selection
        $faculties = Faculty::all();
        
        // Return view with student and faculty data
        return view('informations', [
            'student' => $student, 
            'faculties' => $faculties
        ]);
    }

    // Update student profile information.
     
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

        return back()->with('success', 'Profile information updated successfully.');
    }
    
    //Handle student registration.
     
    public function register(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^\d{8}@std\.neu\.edu\.tr$/i'],
            'faculty' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->symbols()->numbers()],
        ]);

        // Find the Faculty record to get the ID based on the selected name
        $facultyRecord = Faculty::where('name', $request->faculty)->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
            // Fill both the string column and the relationship ID
            'faculty' => $request->faculty, 
            'faculty_id' => $facultyRecord ? $facultyRecord->id : null,
        ]);

        Auth::login($user);
        return redirect('/home');
    }

    // Show the registration view.
     
    public function registerview(){
        return view('register');
    }

    // Handle user logout.
     
    public function logout(Request $request)
    {
         Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');

        
    }

    //Show the login view.
     
    public function loginview(){
        return view('login');
    }

    // Handle student login.
     
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('home'); 
        }

        // Return error if authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}