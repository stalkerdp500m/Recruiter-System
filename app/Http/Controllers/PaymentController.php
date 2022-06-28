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
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Symfony\Component\HttpKernel\HttpCache\Ssi;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $payments = User::where('id', Auth::user()->id)->with(['recruiters.payments' => function ($query) {
        //     $query->filter(Request::only('month', 'year', 'recruiter'));
        // }])->first();
        $payments = User::where('id', Auth::user()->id)->with(['recruiters.payments' => function ($query) {
            $query->filter(Request::only('month', 'year', 'recruiter'))->with('client');
        }])->first();
        //dd($payments);

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
    // public function create()
    // {
    //     return Inertia::render('Payment/Create');
    // }
    // public function import()
    // {
    //     $tableSettings = [
    //         'sheatName' => 'Lista',
    //         'RowStart' => 6
    //     ];


    //     $data = Excel::toCollection(new PaymentsImport($tableSettings), Request::file('file'));
    //     $month = Request::get('month');
    //     $year = Request::get('year');

    //     if ($month &&  $year) {
    //         foreach ($data['Lista'] as $payment) {
    //             if (isset($payment['prac_identyfikator']) && isset($payment['prac_nazwiskoimie']) && $payment['prac_nazwiskoimie'] != '') {
    //                 // dd($payment);
    //                 $client = Client::firstOrCreate(
    //                     ['pasport' => trim($payment['prac_identyfikator'])],
    //                     ['name' => trim($payment['prac_nazwiskoimie'])]
    //                 );

    //                 $recruiter = Recruiter::firstOrCreate(
    //                     ['name' => trim($payment['prac_rekruternazwiskoimie'])]
    //                 );
    //                 $payment =  Payment::updateOrCreate(
    //                     [
    //                         'month' =>  $month,
    //                         'year' => $year,
    //                         'client_id' => $client->id,
    //                         'project' => trim($payment['proj_nazwa']),
    //                     ],
    //                     [
    //                         'recruiter_id' => $recruiter->id,
    //                         'hours' => $payment['godziny_uop_enova'],
    //                         'category' => trim($payment['projrek_kategoriaprojektudopremii']),
    //                         'bonus' => $payment['premrek_kwotapremii_brutto'],
    //                         'status' => trim($payment['status_wyplaty']),
    //                         'syncroner_id' => trim($payment['prac_synchronerid']),
    //                     ]
    //                 );
    //             }
    //         }
    //     }

    //     return redirect()->route('payments.index');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $tableSettings = [
            'sheatName' => 'Lista',
            'RowStart' => 6
        ];
        $data = Excel::toCollection(new PaymentsImport($tableSettings), Request::file('file'));
        return Inertia::render('Payment/Create', [
            'exemplData' =>  $data['Lista']->take(10),
            'year' => Request::get('year'),
            'month' => Request::get('month')
        ]);
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
