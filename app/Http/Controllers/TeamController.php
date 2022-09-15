<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  dd(Team::select('id', 'name')->with('asistants')->get());

        return Inertia::render('Setting/Team/Index', [
            'teamsList' => Team::select('id', 'name')->with(['recruiters', 'assistants'])->orderBy('created_at', 'desc')->get(),
            'recruiterList' => Recruiter::select('id', 'name')->get(),
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
        ]);

        Team::create([
            'name' => $request->name,
        ]);
        return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => "Команда $request->name добавлена"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $massageAction = "";
        try {
            DB::beginTransaction();
            switch ($request->action) {
                case 'recruiters':
                    $massageAction = "рекрутеры";
                    $team->recruiters()->update(['team_id' => null]);
                    Recruiter::whereIn('id', $request->recruiters)->update(['team_id' => $team->id]);
                    break;
                case 'assistants':
                    $massageAction = "асистенты";
                    $team->assistants()->update(['team_id' => null, 'role' => 'user']);
                    User::whereIn('id', $request->assistants)->update(['role' => 'assistant', 'team_id' => $team->id]);
                    break;
                case 'name':
                    $massageAction = "навзвание ";
                    $team->update(['name' => $request['teamName']]);
                    break;
                default:
                    return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "Действие не определено"]);
            }
            DB::commit();
            return Redirect::back()->with(['newFlash' => true, "type" => "success", "massage" => $massageAction . " команды  " . $request['teamName'] . " обновлены"]);
        } catch (\Exception $expection) {
            DB::rollBack();
            return Redirect::back()->with(['newFlash' => true, "type" => "danger", "massage" => "Ошибка, операция не выполнена"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
