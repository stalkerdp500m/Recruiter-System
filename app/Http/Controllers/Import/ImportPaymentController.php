<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\PaymentsImport;
use App\Models\AddPayment;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ImportPaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('Import/Payments');
    }

    public function create()
    {
        // dd(Request::all());

        $listaTableSettings = [
            'sheatName' => 'Lista',
            'RowStart' => 6
        ];

        $recruterTableSettings = [
            'sheatName' => 'Rekruter',
            'RowStart' => 6
        ];
        $dataLista = Excel::toCollection(new PaymentsImport($listaTableSettings), Request::file('file'));
        $dataRecruter = Excel::toCollection(new PaymentsImport($recruterTableSettings), Request::file('file'));

        return Inertia::render('Import/Payments', [
            'exemplData' =>  $dataLista['Lista']->take(15),
            'dopBonusData' => $dataRecruter['Rekruter']->take(15),
            'year' => intval(Request::get('year')),
            'month' => intval(Request::get('month'))
        ]);
    }

    public function store()
    {
        $listaTableSettings = [
            'sheatName' => 'Lista',
            'RowStart' => 6
        ];

        $recruterTableSettings = [
            'sheatName' => 'Rekruter',
            'RowStart' => 6
        ];
        $dataLista = Excel::toCollection(new PaymentsImport($listaTableSettings), Request::file('file'));
        $dataRecruter = Excel::toCollection(new PaymentsImport($recruterTableSettings), Request::file('file'));
        $month = Request::get('month');
        $year = Request::get('year');

        if ($month &&  $year) {
            foreach ($dataLista['Lista'] as $payment) {
                if (isset($payment['prac_identyfikator']) && isset($payment['prac_nazwiskoimie']) && $payment['prac_nazwiskoimie'] != '') {
                    $client = Client::firstOrCreate(
                        ['pasport' => trim($payment['prac_identyfikator'])],
                        ['name' => trim($payment['prac_nazwiskoimie'])]
                    );

                    $recruiter = Recruiter::firstOrCreate(
                        ['name' => trim($payment['prac_rekruternazwiskoimie'])]
                    );
                    $payment =  Payment::updateOrCreate(
                        [
                            'month' =>  $month,
                            'year' => $year,
                            'client_id' => $client->id,
                            'project' => trim($payment['proj_nazwa'] ?? null),
                        ],
                        [
                            'recruiter_id' => $recruiter->id,
                            'hours' => $payment['godziny_uop_enova'] ?? null,
                            'category' => trim($payment['projrek_kategoriaprojektudopremii'] ?? null),
                            'bonus' => $payment['premrek_kwotapremii_brutto'] ?? null,
                            'status' => trim($payment['status_wyplaty'] ?? null),
                            'syncroner_id' => trim($payment['prac_synchronerid'] ?? null),
                        ]
                    );
                }
            }

            foreach ($dataRecruter['Rekruter'] as $recrut) {

                if (trim($recrut['prac_rekruternazwiskoimie']) != '') {

                    $recruiter = Recruiter::firstOrCreate(
                        ['name' => trim($recrut['prac_rekruternazwiskoimie'])]
                    );

                    foreach ($recrut as $key => $addPaym) {
                        if ($key == "premrek_doplatazabiuro" && intval($addPaym) != 0) {
                            AddPayment::updateOrCreate(
                                [
                                    'month' =>  $month,
                                    'year' => $year,
                                    'recruiter_id' => $recruiter->id,
                                    'type' => "doplata za biuro",
                                    'summ' => intval($addPaym)
                                ]
                            );
                        }
                        if ($key == "rekruter_korektapremii" && intval($addPaym) != 0) {
                            AddPayment::updateOrCreate(
                                [
                                    'month' =>  $month,
                                    'year' => $year,
                                    'recruiter_id' => $recruiter->id,
                                    'type' => "korekta premii",
                                    'summ' => intval($addPaym)
                                ]
                            );
                        }
                        if ($key == "premrek_rekruterdlugpoprzednimiesiac" && intval($addPaym) != 0) {
                            AddPayment::updateOrCreate(
                                [
                                    'month' =>  $month,
                                    'year' => $year,
                                    'recruiter_id' => $recruiter->id,
                                    'type' => "dlug poprzedni miesiac",
                                    'summ' => intval($addPaym)
                                ]
                            );
                        }
                    }
                }
            }
        }

        return redirect()->route('payments.index');
    }
}
