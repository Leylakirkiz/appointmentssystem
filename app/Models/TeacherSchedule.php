<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSchedule extends Model
{
    protected $table = 'teacher_schedules';

    protected $fillable = [
        'teacher_id',
        'day',
        'time_slot',
        'status',
    ];
}
