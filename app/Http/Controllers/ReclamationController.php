<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Reclamation;
use App\Models\ReclamationStatus;
use App\Models\Recruiter;
use App\Models\User;
use App\Notifications\ReclamationUpdate;
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
        // dd(Auth::user()->notifications);

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
        return redirect()->action([ReclamationController::class, 'index'])->with(['newFlash' => true, "type" => "success", "massage" => "Рекламация Создана"]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reclamation $reclamation)
    {
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
        if (Auth::user()->role !== 'accountant') {
            $validatedData = Request::validate([
                'comments' => ['required', 'array']
            ]);
        } else {
            $validatedData = Request::validate([
                'comments' => ['required', 'array'],
                'status_id' => ['required', 'integer'],
                'answer' => ['nullable', 'string'],
            ]);
            $validatedData['answerer_id'] = Auth::user()->id;
        }

        $reclamation->update($validatedData);
        if ($validatedData['status_id'] > 2 && $reclamation->wasChanged('status_id')) {
            $updateNotify = (object) [
                'newStatus' =>  ReclamationStatus::find($validatedData['status_id']),
                'reclamationId' => $reclamation->id,
                'reclamationClient' => $reclamation->client
            ];
            User::find($reclamation->user_id)->notify(new ReclamationUpdate($updateNotify));
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
        $reclamation->delete();
        return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "Рекламация перенесена в архив"]);
    }



    public function restore(Reclamation $reclamation)
    {
        $reclamation->restore();
        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Рекламация востановлена из архива"]);
    }
}
