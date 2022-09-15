<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function recruiter()
    {

        return $this->belongsTo(Recruiter::class, 'recruiter_id', 'id');
    }

    public function scopePeriodAdPaymentFilter($query, array $filters)
    {
        if (isset($filters['year']) && isset($filters['month'])) {
            $query->where('add_payments.year', $filters['year']);
            $query->where('add_payments.month', $filters['month']);
        } else {
            $query
                ->where('add_payments.month', '=', function ($query) {
                    $query->selectRaw('max(month)')->where('p.year', '=', function ($query) {
                        $query->selectRaw('max(p.year)')->from('payments as p');
                    })->from('payments as p');
                })
                ->where('add_payments.year', '=', function ($query) {
                    $query->selectRaw('max(p.year)')->from('payments as p');
                });
            // $query->whereRaw(
            //     "month = (select max(`month`) from payments where year = (select max(`year`) from payments))
            //      AND year = (select max(`year`) from payments)"
            // );
        }
    }
}
