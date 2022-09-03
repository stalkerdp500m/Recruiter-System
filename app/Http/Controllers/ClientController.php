<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // добавить ограничение (если нет доступа ни к одному рекрутеру - нет возможности поиска)


        $searchResults = Client::where('pasport', Request::input('pasport', ''))
            ->with(['payments' => function ($query) {
                $query->orderBy('year', 'DESC')->orderBy('month', 'DESC');
            }, 'payments.recruiter:id,name', 'salaries' => function ($query) {
                $query->orderBy('year', 'DESC')->orderBy('month', 'DESC');
            }])->first();



        if (!Request::expectsJson()) {
            return Inertia::render('Client/Index', [
                'searchPasport' => Request::only('pasport'),
                'searchResults' => $searchResults
            ]);
        } else {
            return  [
                'searchPasport' => Request::only('pasport'),
                'searchResults' => $searchResults
            ];
        }
        // if (!Request::input('json', false)) {
        //     return Inertia::render('Client/Index', [
        //         'searchPasport' => Request::only('pasport'),
        //         'searchResults' => $searchResults
        //     ]);
        // } else {
        //     return  [
        //         'searchPasport' => Request::only('pasport'),
        //         'searchResults' => $searchResults
        //     ];
        // }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
