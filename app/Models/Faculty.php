<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['name'];

    // Teachers
    public function teachers() {
        return $this->hasMany(Teacher::class);
    }

    // Students
    public function users() {
        return $this->hasMany(User::class, 'faculty_id');
    }
}