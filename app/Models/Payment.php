<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $guarded = [];
    public $with = ['client'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id', 'id');
    }

    public function recommender()
    {
        return $this->belongsTo(User::class, 'recommender_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'payment_users', 'payment_id', 'user_id');
    }




    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['year']) && isset($filters['month'])) {
            $query->where('payments.year', $filters['year']);
            $query->where('payments.month', $filters['month']);
        } else {
            $query->whereRaw("month = (select max(`month`) from payments) AND year = (select max(`year`)  from payments) ");
        }
        // if (isset($filters['recruiter'])) {
        //     $query->where('payments.recruiter_id', $filters['recruiter']);
        // }
    }
}
