<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\Team;
use App\Models\User;
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
        //  dd(Recruiter::with('owner')->find(1));
        return Inertia::render('Setting/Recruiter/Index', [
            'recruiterList' => Recruiter::select('id', 'name', 'team_id', 'owner_id')->with(['team:id,name', 'owner:id,name'])->orderBy('created_at', 'desc')->get(),
            'teamsList' => Team::select('id', 'name')->get(),
            'userList' => User::select('id', 'name')->orderBy('created_at', 'desc')->get(),
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recruiter  $recruiter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recruiter $recruiter)
    {

        switch ($request->action) {
            case 'team':
                $massageAction = " новая команда ";
                $recruiter->update($request->only('team_id'));
                break;
            case 'owner':
                $massageAction = " новый владелец ";
                $owner = User::find($request->owner_id);
                $owner->update(['role' => 'owner']);
                $owner->recruiters()->attach($recruiter->id);
                $recruiter->update($request->only('owner_id'));
                break;
            default:
                return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "Действие не определено"]);
        }


        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => $request['recruiterName'] . $massageAction . $request['teamName']]);
    }
}
