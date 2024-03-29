<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruiter extends Model
{
    use HasFactory;
    protected $table = 'recruiters';
    protected $guarded = [];

    //public $with = ['payments'];

    public function payments()
    {
        return $this->hasMany(Payment::class,  'recruiter_id', 'id');
    }

    public function countPayments()
    {
        return $this->hasMany(Payment::class,  'recruiter_id', 'id')->where('recruiter_id', $this->recruiter_id)->count();
    }

    public function addPayments()
    {
        return $this->hasMany(AddPayment::class,  'recruiter_id', 'id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'recruiter_id', 'id');
    }


    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function scopeRecruitersAcces($query, User $user)
    {
        switch ($user->role) {
            case 'user':
            case 'owner':
            case 'admin':
                $query->whereIn('id', $user->recruiters->pluck('id'));
                break;
            case 'assistant':
                $query->whereIn('id', $user->team->recruiters->pluck('id'));
                break;
            default:
                break;
        }
    }
}
