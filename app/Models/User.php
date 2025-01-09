<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'role',
        'farm_id',
        'profile_picture',
    ];
    /**
     * Mutator untuk memastikan path gambar tidak memiliki karakter tambahan.
     *
     * @param string|null $value
     */
    public function saveImage($file)
    {
        return $file->store('profile_pictures', 'public'); // Menyimpan gambar di disk 'public' dalam folder 'penyakit-images'
    }

    public function getProfilePictureUrlAttribute()
    {
        return asset('storage/' . $this->profile_picture);
    }

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
    ];
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
    public function siklus()
    {
        return $this->hasMany(Siklus::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->profile_picture = null; // Pastikan defaultnya null
        });
    }
}