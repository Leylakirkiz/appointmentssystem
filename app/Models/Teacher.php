<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // Teacher-Faculty relationship
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
