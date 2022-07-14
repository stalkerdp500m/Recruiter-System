<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'email',
        'password',
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
    ];

    // public function payments()
    // {
    //     return $this->belongsToMany(Payment::class, 'payment_users', 'user_id', 'payment_id');
    // }
    // public function payments()
    // {
    //     return $this->belongsToMany(Payment::class, 'user_recruiter', 'user_id',  'recruiter_id', 'id', 'recruiter_id')->using(UserRecruiter::class);
    // }
    public function recruiters()
    {
        return $this->belongsToMany(Recruiter::class)->orderBy('name');
    }
    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'user_id', 'id')->orderByDesc('updated_at');
    }



    //     public function payments()
    //     {
    //         // return $this->belongsToMany(Recruiter::class, 'user_recruiters', 'user_id', 'recruiter_id');
    //         return $this->belongsToMany(Payment::class, 'user_recruiter', 'user_id',  'recruiter_id', 'id', 'recruiter_id')->using(UserRecruiter::class);
    //         // return $this->hasManyThrough(Recruiter::class, Payment::class);
    //     }
}
