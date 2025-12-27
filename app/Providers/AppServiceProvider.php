<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    \Illuminate\Support\Facades\Schema::defaultStringLength(191);

    // Her iki navbar dosyasını da dinliyoruz
    \Illuminate\Support\Facades\View::composer(['navbar', 'navbarth'], function ($view) {
        $user = \Illuminate\Support\Facades\Auth::user(); 
        $teacher = \Illuminate\Support\Facades\Auth::guard('teacher')->user(); 
        
        $unreadCount = 0;
        $studentId = null;

        // Öğrenci Navbar'ı (navbar) için veri
        if ($user) {
            if (str_contains($user->email, '@')) {
                $studentId = explode('@', $user->email)[0];
            }
            $unreadCount = \App\Models\Appointment::where('student_id', $user->id)
                ->where('status', '!=', 'pending')
                ->where('is_read_student', false)
                ->count();
        } 
        
        // Hoca Navbar'ı (navbarth) için veri
        if ($teacher) {
            $unreadCount = \App\Models\Appointment::where('teacher_id', $teacher->id)
                ->where('is_read_teacher', false)
                ->count();
        }

        $view->with([
            'user' => $user, 
            'teacher' => $teacher,
            'studentId' => $studentId, 
            'unreadCount' => $unreadCount
        ]);
    });
}
}
