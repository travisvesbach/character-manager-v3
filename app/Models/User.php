<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Character;
use App\Models\Monster;
use App\Models\Encounter;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'theme',
        'font',
        'admin',
        'party',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'party'             => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    protected static function booted()
    {
        static::creating(function ($user) {
            //if there aren't any users, this user is an admin
            if(User::count() == 0) {
                $user->admin = true;
            }
        });
    }

    public function characters() {
        return $this->hasMany(Character::class);
    }

    public function monsters() {
        return $this->hasMany(Monster::class);
    }

    public function encounters() {
        return $this->hasMany(Encounter::class);
    }

    public function encounterMonsters() {
        return $this->hasMany(EncounterMonsters::class);
    }
}
