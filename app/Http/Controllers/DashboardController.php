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
        $periodList = Payment::selectRaw('month, year , concat(month,"-", year) as period')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->distinct('period')->get();
        $endPeriod = $periodList->take(6)->first() ?? ["year" => 0, "month" => 0];;
        $startPeriod = $periodList->take(6)->last() ?? ["year" => 1, "month" => 1];
        $queryFilter = Request::only('start', 'end');


        $startYear = isset($queryFilter['start']) ? explode("-", $queryFilter['start'])[1] : $startPeriod['year'];
        $startMonth = isset($queryFilter['start']) ? explode("-", $queryFilter['start'])[0] : $startPeriod['month'];
        $endYear = isset($queryFilter['end']) ? explode("-", $queryFilter['end'])[1] : $endPeriod['year'];
        $endMonth = isset($queryFilter['end']) ? explode("-", $queryFilter['end'])[0] : $endPeriod['month'];



        // $paymentData = Recruiter::recruitersAcces(Auth::user())->withCount(['payments as countRecrutation' => function ($query) {
        //     $query->dashboardFilter('2021', '1', '2021',  '3');
        // }])->get();
        // dd($paymentData);

        // Payment::whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'))
        //     ->selectRaw('count(id) as countRecrutation, month, recruiter_id, year')
        //     ->where('bonus', '>', 0)
        //     ->groupBy('recruiter_id', 'month', 'year')
        //     ->dashboardFilter($startYear, $startMonth, $endYear,  $endMonth)
        //     ->with('recruiter:id,name')
        //     ->get();


        $paymentData = Payment::whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'))
            ->selectRaw('count(id) as countRecrutation, month, recruiter_id, year')
            ->where('bonus', '>', 0)
            ->groupBy('recruiter_id', 'month', 'year')
            ->dashboardFilter($startYear, $startMonth, $endYear,  $endMonth)
            ->with('recruiter:id,name')
            ->get();


        $paymentCouns = $paymentData->mapToGroups(function ($item) {
            //echo $item;
            return  [$item['recruiter_id'] =>  array(
                'rucruiterName' => $item['recruiter']['name'],
                'countPaym' => $item['countRecrutation'],
                'month' => $item['month'] . '-' . $item['year']
            )];
        });
        return Inertia::render('Dashboard/Index', [
            'filters' => Request::only('start', 'end'),
            'paymentCouns' => $paymentCouns,
            'periodList' => $periodList,
            'autoStartPeriod' => $startPeriod,
            'autoEndPeriod' => $endPeriod,
        ]);
    }
}
