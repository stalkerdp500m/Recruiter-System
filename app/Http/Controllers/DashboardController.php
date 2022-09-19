<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $periodList = Payment::paymentPeriodList()->get()->map(function ($item) {
            return  ['month' => $item['month'], 'year' => $item['year'], 'period' => $item['month'] . "-" . $item['year']];
        });

        $queryFilter = Request::only('start', 'end');
        if (!isset($queryFilter['start']) || !isset($queryFilter['end'])) {
            $queryFilter['start'] = $periodList->take(6)->last()['period'] ?? "0-0";
            $queryFilter['end'] = $periodList->take(6)->first()['period'] ?? "1-1";
        }

        $dashbourdPeriod  = (object) [
            'startYear' =>  explode("-", $queryFilter['start'])[1],
            'startMonth' =>  explode("-", $queryFilter['start'])[0],
            'endYear' => explode("-", $queryFilter['end'])[1],
            'endMonth' => explode("-", $queryFilter['end'])[0]
        ];

        $recruiterPaymentsCount = Recruiter::recruitersAcces(Auth::user())
            ->with('payments', function ($query) use ($dashbourdPeriod) {
                $query
                    ->select('month', 'recruiter_id', 'year')
                    ->selectRaw('count(id) as countpaym')
                    ->where('bonus', '>', 0)
                    ->PaymentPeriodFilter($dashbourdPeriod)
                    ->groupBy('recruiter_id', 'month', 'year');
            })
            ->get();

        return Inertia::render('Dashboard/Index', [
            'recruiterPaymentsCount' => $recruiterPaymentsCount,
            'periodList' => $periodList,
            'queryFilter' => $queryFilter
        ]);
    }
}
