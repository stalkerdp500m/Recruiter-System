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


    public function paym($id)
    {
        return $this->belongsToMany(Payment::class)->wherePivotIn('id', $id);
    }
}
