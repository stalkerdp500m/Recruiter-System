<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userData = User::select('id', 'name', 'email', 'team_id', 'role')->with('recruiters:id,name', 'team:id,name')->find($user->id);
        return Inertia::render('Profile/Index', ['userData' => $userData]);
    }
    public function createToken(Request $request)
    {
        $request->user()->tokens()->delete();
        $token = $request->user()->createToken($request->token_name, ['salaries:update'])->plainTextToken;
        return response()->json(['token' => $token]);;
    }
}
