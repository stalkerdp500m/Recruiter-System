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
        $paymentData = Payment::whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'))
            ->selectRaw('count(id) as countRecrutation, month, recruiter_id, year')
            ->groupBy('recruiter_id', 'month', 'year')
            ->whereBetween('month', [1, 6])
            ->where('year', 2022)
            // ->filter(FacadesRequest::only('month', 'year', 'recruiter'))
            ->with('recruiter:id,name')
            ->get();
        // return  [$item['recruiter_id'] => array_merge($item->toArray(), ['month' => $item['month'] . '-' . $item['year']])];

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
