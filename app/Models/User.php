<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
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




    public function getnameRolAttribute()
    {
        if ($this->roles != null) {
            return $this->roles->pluck('name')->first();
        } else {
            return 'hola';
        }
    }

    public function getImagenAttribute()
    {

        if (Storage::disk('public')->exists('/users/admins/photos/' . $this->photo)) {
            $photo =  \Storage::disk('public')->url('/users/admins/photos/' . $this->photo);
        } else {
            $photo =  asset('/build/img/icons/user-img.jpg');
        }

        return url($photo);
    }
}
