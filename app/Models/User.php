<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'gender',
        'birthdate',
        'email_verified_at',
        'role_id',
        'password',
    ];

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

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    // Chat relationships
    public function patientChats()
    {
        return $this->hasMany(Chat::class, 'patient_id');
    }

    public function doctorChats()
    {
        return $this->hasMany(Chat::class, 'doctor_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    // Scope for doctors
    public function scopeDoctors($query)
    {
        return $query->where('role_id', 2);
    }

    // Check if user is doctor
    public function isDoctor()
    {
        return $this->role && $this->role->name === 'dokter';
    }

    // Check if user is patient
    public function isPatient()
    {
        return $this->role && $this->role->name === 'pasien';
    }

    /**
     * Get role name
     */
    public function getRoleNameAttribute()
    {
        if ($this->role) {
            return $this->role->name;
        }
        return 'Unknown';
    }
}