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
        //->take(6)->get();
        //  dd($periodList->splice(0, 5)->last());

        $paymentData = Payment::whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'))
            ->selectRaw('count(id) as countRecrutation, month, recruiter_id, year')
            ->groupBy('recruiter_id', 'month', 'year')
            // ->whereBetween('month', [1, 6])
            //   ->where('year', 2022)
            ->dashboardFilter(Request::only('start', 'end'), $periodList)
            ->with('recruiter:id,name')
            ->get();

        //  dd($paymentData);

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
            'filters' => Request::only('month', 'year', 'recruiter'),
            'paymentCouns' => $paymentCouns
        ]);
    }
}
