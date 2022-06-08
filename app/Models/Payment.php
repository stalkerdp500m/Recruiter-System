<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $guarded = [];
    // public $with = ['client'];

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




    public function scopeDashboardFilter($query, array $filters,  $periodList)
    {
        if (isset($filters['start']) && isset($filters['end'])) {
            $query->where('payments.year', $filters['year']);
            $query->where('payments.month', $filters['month']);
        } else {
            $endPeriod = $periodList->splice(0, 2)->first();
            $startPeriod = $periodList->splice(0, 2)->last();
            // echo $startPeriod;
            // echo $endPeriod;

            $query->whereRaw(
                '((month >= ? and year = ?) or ( month <= ? and year = ? ))',
                [$startPeriod['month'], $startPeriod['year'], $endPeriod['month'], $endPeriod['year']]
            );
            $query->orderBy('year', 'asc');
            $query->orderBy('month', 'asc');

            //  ->dd();

            // $query->orWhere(function ($query, $startPeriod) {
            //     $query->where('month', '>=', $startPeriod['month']);
            //     $query->where('year', '>=', $startPeriod['year']);
            // });
            // $query->orWhere(function ($query, $endPeriod) {
            //     $query->where('month', '<=', $endPeriod['month']);
            //     $query->where('year', '<=', $endPeriod['year']);
            // });
            // $query->whereBetween('year', [$startPeriod['year'], $endPeriod['year']])->dd();
        }
    }



    public function scopeFilter($query, array $filters)
    {

        // $query->when(isset($filters['year']), function ($q, $filters) {
        //     return $q->where('payments.year', $filters['year'])->where('payments.month', $filters['month']);
        // }, function ($q) {
        //     $q->whereRaw("month = (select max(`month`) from payments) AND year = (select max(`year`)  from payments) ");
        // });


        if (isset($filters['year']) && isset($filters['month'])) {
            $query->where('payments.year', $filters['year']);
            $query->where('payments.month', $filters['month']);
        } else {
            // $query->whereRaw("month = (select max(`month`) from payments) AND year = (select max(`year`)  from payments ) ");
            $query->whereRaw(
                "month = (select max(`month`) from payments where year = (select max(`year`) from payments))
                 AND year = (select max(`year`) from payments)"
            );
        }


        // if (isset($filters['recruiter'])) {
        //     $query->where('payments.recruiter_id', $filters['recruiter']);
        // }
    }
}
