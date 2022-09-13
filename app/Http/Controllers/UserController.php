<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Notifications\createUser;
use App\Notifications\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
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
        return Inertia::render('Setting/User/Index', [
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
    public function create(Request $request)
    {

        return Inertia::render('Setting/User/Create', [
            'recruiterList' => Recruiter::select('id', 'name')->get(),
            'roleList' => Role::select('title')->get()->pluck('title'),
            'teamsList' => Team::select('id', 'name')->get()
        ]);
    }

    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->only('email'), ['email' => 'required|string|email|max:255|unique:users']);
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
        // добавить синхронизацию рекрутеров!!!

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required'],
            'team' => ['nullable', 'exists:teams,id'],
            'role' => ['required', 'exists:roles,title'],
            'recruiters_id' => ['array']
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'team_id' => $request->team,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'email_verified_at' =>  now()
        ]);
        $user->recruiters()->sync($request->recruiters_id);
        $user->notify(new createUser($request->only(['name', 'email', 'password'])));
        $user->notify(new Welcome($user));
        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Пользователь $request->name добавлен"]);
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
                $user->update($request->only('role'));
                return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "новая роль у $user->name $request->role"]);
            case 'recruitersList':
                $user->recruiters()->sync($request->recruiter_id);
                return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Список рекрутеров у $user->name обновлен"]);
            case 'team':
                $user->update($request->only('team_id'));
                return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Команда пользователя $user->name обновлена"]);
            default:
                return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "Действие не определено"]);
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
