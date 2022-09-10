<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Reclamation;
use App\Models\ReclamationStatus;
use App\Models\Recruiter;
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

        $periodList = Payment::paymentPeriodList()->get()->map(function ($item) {
            return  ['month' => $item['month'], 'year' => $item['year'], 'period' => $item['month'] . "-" . $item['year']];
        });

        $recruiterList = Recruiter::recruitersAcces(Auth::user())->get();

        $statuseList = ReclamationStatus::select('title', 'id')->get()->mapWithKeys(function ($item) {
            return  [$item['title'] => $item['id']];
        });

        $reclamations = Recruiter::recruitersAcces(Auth::user())->with('reclamations', function ($query) {
            $query->trashedFilter(Request::only('trashed'))
                ->with('status:id,title', 'client:id,name,pasport', 'recruiter:id,name', 'user:id,name');
        })->get()
            ->pluck('reclamations')
            ->flatten()
            ->sortBy([['updated_at', 'desc']]);

        // $newReclamations = $reclamations->pluck('reclamations')
        //     ->flatten()
        //     ->sortBy([['updated_at', 'desc']]);

        //  dd($reclamations);

        // Reclamation::when(Auth::user()->role !== 'admin', function ($query) {
        //     $query->whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'));
        // })->trashedFilter(Request::only('trashed'))->orderBy('updated_at', 'desc')
        //     ->with('status:id,title', 'client:id,name,pasport', 'recruiter:id,name', 'user:id,name')->get();

        // $reclamations = Reclamation::when(Auth::user()->role !== 'admin', function ($query) {
        //     $query->whereIn('recruiter_id', Auth::user()->recruiters->pluck('id'));
        // })->trashedFilter(Request::only('trashed'))->orderBy('updated_at', 'desc')
        //     ->with('status:id,title', 'client:id,name,pasport', 'recruiter:id,name', 'user:id,name')->get();



        // dd($statuseList);
        // $statuseList = $newReclamations->mapWithKeys(function ($item) {
        //     return  [$item['status']['title'] => $item['status']['id']];
        // });



        return Inertia::render('Reclamation/Index', [
            'searchPasport' => Request::only('pasport'),
            'periodList' => $periodList,
            'recruiterList' => ["recruiters" => $recruiterList],
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
        return redirect()->action([ReclamationController::class, 'index'])->with(['newFlash' => true, "type" => "success", "massage" => "Рекламация Создана"]);
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
        $statuseList = ReclamationStatus::select('id', 'title')->get();
        return Inertia::render('Reclamation/Edit', [
            'reclamation' => $reclamation,
            'statuseList' => $statuseList,
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

        if (Auth::user()->role !== 'admin') {
            $validatedData = Request::validate([
                'comments' => ['required', 'array'],
                'status_id' => ['required', 'integer'],
                'answer' => ['nullable', 'string'],
            ]);
            $reclamation->update($validatedData);
        } else {
            $validatedData = Request::validate([
                'comments' => ['required', 'array'],
                'status_id' => ['required', 'integer'],
                'answer' => ['nullable', 'string'],
            ]);
            $reclamation->update($validatedData);
        }
        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Рекламация обновлена"]);
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
        return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "Рекламация перенесена в архив"]);
    }



    public function restore(Reclamation $reclamation)
    {
        abort_if(Auth::user()->id != $reclamation->user_id, 403);
        $reclamation->restore();
        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Рекламация востановлена из архива"]);
    }
}
