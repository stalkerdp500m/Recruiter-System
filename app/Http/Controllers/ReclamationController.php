<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Reclamation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ReclamationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $periodList = Payment::selectRaw('month, year , concat(month,"-", year) as period')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->distinct('period')->get();

        $recruiterList = User::select('name', 'id')->where('id', Auth::user()->id)->with('recruiters:id,name')->first()->only('recruiters');

        $reclamations = User::select('name', 'id')->where('id', Auth::user()->id)->with(['reclamations.status:id,title', 'reclamations.client:id,name,pasport', 'reclamations.recruiter:id,name'])->first()->only('reclamations');
        //   dd($reclamations);
        return Inertia::render('Reclamation/Index', [
            'searchPasport' => Request::only('pasport'),
            'periodList' => $periodList,
            'recruiterList' => $recruiterList,
            'reclamations' => $reclamations['reclamations']
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
    public function store()
    {

        $validatedData = Request::validate([
            'project' => ['required', 'max:255'],
            'client_name' => ['required', 'max:255'],
            'client_id' => ['nullable', 'integer'],
            'pasport' => ['required', 'max:100'],
            'recruiter_id' => ['required', 'integer'],
            'comment' => ['required'],
            'period' => ['required'],
        ]);

        $client = $validatedData['client_id'] ?
            Client::find($validatedData['client_id']) :
            Client::firstOrCreate(['pasport' => $validatedData['pasport']], ['name' => $validatedData['client_name']]);

        Reclamation::firstOrCreate(
            [
                'period' =>  $validatedData['period'],
                'client_id' => $client->id,
                'recruiter_id' => $validatedData['recruiter_id'],
                'user_id' => Auth::user()->id
            ],
            [
                'project' => $validatedData['project'],
                'comment' => $validatedData['comment'],
                'status_id' => 1,
            ]
        );

        // return Redirect::route('reclamations.index');
        return redirect()->action([ReclamationController::class, 'index']);
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
        //проверка, что рекламация принадлежить тому, кто ее удаляет
        Reclamation::destroy($id);
        return Redirect::route('reclamations.index');
    }
}
