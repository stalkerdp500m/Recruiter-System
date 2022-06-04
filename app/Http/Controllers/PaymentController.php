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
    public function index(Request $request)
    {

        //dd($request::user()->id);

        //РАБОЧИЙ
        // $payments = User::with(['recruiters.payments' => function ($query) {
        //     $query->where('payments.month', '9');
        // }])->where('id', Auth::user()->id)->get();


        $payments = User::where('id', Auth::user()->id)->with(['recruiters.payments' => function ($query) {
            $query->filter(Request::only('month', 'year', 'recruiter'));
        }])->first();
        // $payments = User::where('id', Auth::user()->id)->with(['recruiters.payments' => function ($query) {
        //     $query->filter(Request::only('month', 'year', 'recruiter'));
        // }])->first();

        // $payments = User::where('id', Auth::user()->id)->with(['recruiters.payments' => function ($query) {
        //     $query->where('payments.month', '2');
        //     $query->where('payments.year', '2021');
        // }])->get();

        return Inertia::render('Payments', [
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
