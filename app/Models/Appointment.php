<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Mass assignment (toplu atama) izni verilen sütunlar
    protected $fillable = [
        'student_id',
        'teacher_id',
        'day',
        'time_slot',
        'appointment_date',
        'status',
        'message',
        'student_note',
        'is_read_student',
        'is_read_teacher',
        'expires_at'
    ];

    // İlişkileri de buraya ekleyelim (Blade dosyalarında hata almamak için)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}