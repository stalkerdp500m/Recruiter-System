<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // Возвращает список периодов
    public function scopePaymentPeriodList($query)
    {
        $query->select('year', 'month')->distinct('year', 'month')->orderBy('year', 'DESC')->orderBy('month', 'DESC');
    }




    public function scopeDashboardFilter($query, $startYear, $startMonth, $endYear,  $endMonth)
    {


        if ($endYear - $startYear >= 1) {
            $query->whereRaw(
                '(((month between ? and 12) and (year = ?))
                     or ( (month between 1 and ?) and (year =?))
                     or ((month between 1 and 12) and year > ? and year < ? ) )',
                [$startMonth, $startYear,  $endMonth,  $endYear, $startYear, $endYear]
            );
        } else {
            $query->whereRaw(
                '(  ((month between ? and ?) and year = ?) )',
                [$startMonth, $endMonth, $endYear]
            );
        }
        $query->orderBy('year', 'asc');
        $query->orderBy('month', 'asc');
    }

    //возвращает выплаты за переданый год и месяц или за последний месяц и год в таблице
    public function scopePaymentOneMonthFilter($query, array $filters)
    {
        if (isset($filters['year']) && isset($filters['month'])) {
            $query->where('payments.year', $filters['year']);
            $query->where('payments.month', $filters['month']);
        } else {
            $query
                ->where('payments.month', '=', function ($query) {
                    $query->selectRaw('max(month)')->where('p.year', '=', function ($query) {
                        $query->selectRaw('max(p.year)')->from('payments as p');
                    })->from('payments as p');
                })
                ->where('payments.year', '=', function ($query) {
                    $query->selectRaw('max(p.year)')->from('payments as p');
                });;
        }
    }



    // public function scopePeriodPaymentFilter($query, array $filters)
    // {
    //     if (isset($filters['year']) && isset($filters['month'])) {
    //         $query->where('payments.year', $filters['year']);
    //         $query->where('payments.month', $filters['month']);
    //     } else {
    //         $query->whereRaw(
    //             "month = (select max(`month`) from payments where year = (select max(`year`) from payments))
    //              AND year = (select max(`year`) from payments)"
    //         );
    //     }
    // }
}
