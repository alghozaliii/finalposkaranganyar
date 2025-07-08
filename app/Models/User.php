<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'employees_role',
        'is_approved',
        'owner_id',
        'store_name',
        'store_address', // Tambahkan ini
        'address',
        'nik',
        'phone', 
        'ktp_photo', 
        'selfie_photo',
        'qris_photo',
        'username' // Add username field
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_approved' => 'boolean',
    ];

    /**
     * Relasi ke tabel roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }       

    /**
     * Set default role_id = 2 (Owner) jika belum diisi saat registrasi
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->role_id)) {
                $user->role_id = 2; // Owner
            }
        });
    }

    /**
     * Get employees belonging to this owner
     */
    public function employees()
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    /**
     * Get the owner of this user
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Add custom authentication using username
     */
    public function username()
    {
        return 'username';
    }
}
