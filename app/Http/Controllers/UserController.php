<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('User/Index', [
            'userList' => User::with(['recruiters:id,name', 'team'])->orderBy('created_at', 'desc')->get(),
            'recruiterList' => Recruiter::select('id', 'name')->get(),
            'roleList' => Role::select('title')->get()->pluck('title'),
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
    public function update(Request $request, User $user)
    {


        switch ($request->action) {
            case 'role':
                //  dd($request->only('role'));
                $user->update($request->only('role'));
                return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "новая роль у $user->name $request->role"]);
            case 'recruitersList':
                $user->recruiters()->sync($request->recruiter_id);
                return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Список рекрутеров у $user->name обновлен"]);
            case 'team':
                $user->update($request->only('team_id'));
                return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Команда пользователя $user->name обновлена"]);
            default:
                # code...
                break;
        }
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
