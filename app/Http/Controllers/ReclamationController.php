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
use Illuminate\Validation\Rule;
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

        // $reclamations = User::where('id', Auth::user()->id)->with(['recruiters.reclamations' => function ($query) {
        //     $query->trashedFilter(Request::only('trashed'))->with('status:id,title');
        // }, 'recruiters.reclamations.client:id,name,pasport'])->first();



        $reclamations = Reclamation::when(Auth::user()->role !== 'admin', function ($query) {
            $query->whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'));
        })->trashedFilter(Request::only('trashed'))->orderBy('updated_at', 'desc')
            ->with('status:id,title', 'client:id,name,pasport', 'recruiter:id,name', 'user:id,name')->get();

        $statuseList = $reclamations->mapWithKeys(function ($item) {
            return  [$item['status']['title'] => $item['status']['id']];
        });



        return Inertia::render('Reclamation/Index', [
            'searchPasport' => Request::only('pasport'),
            'periodList' => $periodList,
            'recruiterList' => $recruiterList,
            'reclamations' => $reclamations,
            'statuseList' => $statuseList,
            'trashed' => Request::input('trashed', 'no')
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
                'comments' => $validatedData['comment'],
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
    public function edit(Reclamation $reclamation)
    {
        abort_if(Auth::user()->role !== 'admin'  && !Auth::user()->recruiters->pluck('id')->contains($reclamation->recruiter_id), 403);
        return Inertia::render('Reclamation/Edit', [
            'reclamation' => $reclamation
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Reclamation $reclamation)
    {
        abort_if(Auth::user()->role !== 'admin'  && !Auth::user()->recruiters->pluck('id')->contains($reclamation->recruiter_id), 403);
        $reclamation->update(Request::only('comments'));
        return Redirect::back()->with('success', 'Комментарий добавлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reclamation $reclamation)
    {
        // dump(Auth::user()->id);
        //dd($reclamation->user_id);
        abort_if(Auth::user()->id != $reclamation->user_id, 403);
        $reclamation->delete();
        return Redirect::back()->with('success', 'Рекламация перенесена в архив');
    }



    public function restore(Reclamation $reclamation)
    {
        abort_if(Auth::user()->id != $reclamation->user_id, 403);
        $reclamation->restore();
        return Redirect::back()->with('success', 'Рекламация востановлена из архива');
    }
}
