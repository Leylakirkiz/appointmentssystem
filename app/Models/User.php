<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
class User extends Authenticatable
{
  
    protected function studentId(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // E-posta adresini @ işaretinden böl
                $parts = explode('@', $attributes['email']);
                
                // İlk parçayı (yani öğrenci numarasını) geri döndür
                return $parts[0] ?? 'Bilinmiyor'; 
            },
        );
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // app/Models/User.php
protected $fillable = [
    'name',
    'email',
    'password',
    'faculty_id', // Buranın doğruluğundan eminiz
    'language',
    'department',
    'class_level',
];

public function faculty()
{
    // users tablosundaki faculty_id ile faculties tablosundaki id eşleşmeli
    return $this->belongsTo(Faculty::class, 'faculty_id');
}
    protected $table='users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
