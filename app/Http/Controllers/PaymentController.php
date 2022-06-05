<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Recruiter;
use App\Models\User;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

//use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $payments = User::where('id', Auth::user()->id)->with(['recruiters.payments' => function ($query) {
            $query->filter(Request::only('month', 'year', 'recruiter'));
        }])->first();

        $monthAnYears = Payment::selectRaw('DISTINCT  year , month, CONCAT(year,"-",month) "yearMonth"')->orderBy('year', 'DESC')->orderBy('month', 'DESC')->get()
            ->mapToGroups(function ($item) {
                return  [$item['year'] => $item['month']];
            });


        return Inertia::render('Payments', [
            'ranges' => $monthAnYears,
            'filters' => Request::only('month', 'year', 'recruiter'),
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
