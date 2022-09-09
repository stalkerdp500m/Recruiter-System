<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Recruiter;
use App\Models\User;
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

        $endPeriod = $periodList->take(6)->first() ?? ["year" => 0, "month" => 0];;
        $startPeriod = $periodList->take(6)->last() ?? ["year" => 1, "month" => 1];
        $queryFilter = Request::only('start', 'end');


        $startYear = isset($queryFilter['start']) ? explode("-", $queryFilter['start'])[1] : $startPeriod['year'];
        $startMonth = isset($queryFilter['start']) ? explode("-", $queryFilter['start'])[0] : $startPeriod['month'];
        $endYear = isset($queryFilter['end']) ? explode("-", $queryFilter['end'])[1] : $endPeriod['year'];
        $endMonth = isset($queryFilter['end']) ? explode("-", $queryFilter['end'])[0] : $endPeriod['month'];

        // Recruiter::recruitersAcces(Auth::user())->with('payments', function ($query) {
        //     $query->PaymentPeriodFilter([]);
        // })->get();

        $recruiterPaymentsCount = Recruiter::recruitersAcces(Auth::user())
            ->with('payments', function ($query) use ($startYear, $startMonth, $endYear,  $endMonth) {
                $query
                    ->select('month', 'recruiter_id', 'year')
                    ->selectRaw('count(id) as countPaym')
                    ->where('bonus', '>', 0)
                    // ->dashboardFilter($startYear, $startMonth, $endYear,  $endMonth)
                    ->PaymentPeriodFilter(Request::only('start', 'end'))
                    ->groupBy('recruiter_id', 'month', 'year');
            })
            ->get();

        return Inertia::render('Dashboard/Index', [
            'filters' => Request::only('start', 'end'),
            'recruiterPaymentsCount' => $recruiterPaymentsCount,
            'periodList' => $periodList,
            'autoStartPeriod' => $startPeriod,
            'autoEndPeriod' => $endPeriod,
        ]);
    }
}
