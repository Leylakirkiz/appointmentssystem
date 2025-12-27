<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HasFactory, Notifiable;
use App\Models\Faculty;

class Teacher extends Authenticatable
{
    

    protected $fillable = [
        'name',
        'email',
        'password',
        'faculty_id',
        'office_location',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // İlişki: Bir Hoca bir fakülteye bağlıdır
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
