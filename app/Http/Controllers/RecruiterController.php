<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RecruiterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Setting/Recruiter/Index', [
            'recruiterList' => Recruiter::select('id', 'name', 'team_id')->with('team')->orderBy('created_at', 'desc')->get(),
            'teamsList' => Team::select('id', 'name')->get()
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

    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->only('email'), ['email' => 'required|string|email|max:255|unique:recruiters']);
        return $validator->errors();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:recruiters',
            'team' => ['nullable', 'exists:teams,id'],
        ]);

        $recruiter = Recruiter::create([
            'name' => $request->name,
            'email' => $request->email,
            'team_id' => $request->team,
        ]);
        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Рекрутер $request->name добавлен"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recruiter  $recruiter
     * @return \Illuminate\Http\Response
     */
    public function show(Recruiter $recruiter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recruiter  $recruiter
     * @return \Illuminate\Http\Response
     */
    public function edit(Recruiter $recruiter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recruiter  $recruiter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recruiter $recruiter)
    {
        $recruiter->update($request->only('team_id'));
        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => $request['userName'] . " добавлен в команду " . $request['teamName']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recruiter  $recruiter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recruiter $recruiter)
    {
        //
    }
}
