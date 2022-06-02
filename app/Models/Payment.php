<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $guarded = [];

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
        $date = \Carbon\Carbon::now();
        $filteredMonth = isset($filters['month']) ? $filters['month'] : $date->subMonth()->format('m');
        $filteredYear = isset($filters['year']) ? $filters['year'] : $date->format('Y');
        $query->where('payments.month', $filteredMonth);
        $query->where('payments.year', $filteredYear);
        if (isset($filters['recruiter'])) {
            $query->where('payments.recruiter_id', $filters['recruiter']);
        }
    }
}
