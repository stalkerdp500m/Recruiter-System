<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Recruiter;
use App\Models\User;
//use Illuminate\Http\Request;
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
        $endPeriod = $periodList->take(6)->first();
        $startPeriod = $periodList->take(6)->last();


        $paymentData = Payment::whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'))
            ->selectRaw('count(id) as countRecrutation, month, recruiter_id, year')
            ->where('bonus', '>', 0)
            ->groupBy('recruiter_id', 'month', 'year')
            ->dashboardFilter(Request::only('start', 'end'), $startPeriod, $endPeriod)
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

        //dd($payments);

        return Inertia::render('Dashboard/Index', [
            'filters' => Request::only('start', 'end'),
            'paymentCouns' => $paymentCouns,
            'periodList' => $periodList,
            'autoStartPeriod' => $startPeriod,
            'autoEndPeriod' => $endPeriod,
        ]);
    }
}
