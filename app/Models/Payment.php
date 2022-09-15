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

    // Возвращает список периодов
    public function scopePaymentPeriodList($query)
    {
        $query->select('year', 'month')->distinct('year', 'month')->orderBy('year', 'DESC')->orderBy('month', 'DESC');
    }


    public function scopePaymentPeriodFilter($query, object $dashbourdPeriod)
    {
        if ($dashbourdPeriod->endYear - $dashbourdPeriod->startYear > 0) {
            $query
                ->where('year', '>', $dashbourdPeriod->startYear)
                ->where('year', '<', $dashbourdPeriod->endYear)
                ->orWhere(function ($query) use ($dashbourdPeriod) {
                    $query->whereBetween('month', [$dashbourdPeriod->startMonth, 12])
                        ->where('year',  $dashbourdPeriod->startYear);
                })
                ->orWhere(function ($query) use ($dashbourdPeriod) {
                    $query->whereBetween('month', [1, $dashbourdPeriod->endMonth])
                        ->where('year',  $dashbourdPeriod->endYear);
                });
        } else {
            $query
                ->whereBetween('month', [$dashbourdPeriod->startMonth, $dashbourdPeriod->endMonth])
                ->where('year',  $dashbourdPeriod->startYear);
        }
        $query->orderBy('year', 'asc')->orderBy('month', 'asc');
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
                });
        }
    }
}
