<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['name'];

    // Fakültenin hocaları
    public function teachers() {
        return $this->hasMany(Teacher::class);
    }

    // Fakültenin öğrencileri (Yeni eklenen kısım)
    public function users() {
        return $this->hasMany(User::class, 'faculty_id');
    }
}