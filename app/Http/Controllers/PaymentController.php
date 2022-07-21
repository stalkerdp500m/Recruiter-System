<?php

namespace App\Http\Controllers;

use App\Imports\GetHeadRow;
use App\Imports\PaymentsImport;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
            $query->filter(Request::only('month', 'year', 'recruiter'))->with('client');
        }, 'recruiters.addPayments' => function ($query) { // тут подтягивать допвыплаты по той же фактуре, что и основные
            $query->filter(Request::only('month', 'year', 'recruiter'));
        }])->first();

        $monthAnYears = Payment::selectRaw('DISTINCT  year , month, CONCAT(year,"-",month) "yearMonth"')->orderBy('year', 'DESC')->orderBy('month', 'DESC')->get()
            ->mapToGroups(function ($item) {
                return  [$item['year'] => $item['month']];
            });

        if (count($monthAnYears) > 0) {
            return Inertia::render('Payment/Index', [
                'ranges' => $monthAnYears,
                'filters' => Request::only('month', 'year', 'recruiter'),
                'payments' => $payments
            ]);
        } else {
            return Inertia::render('EmptyDataPage');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
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
