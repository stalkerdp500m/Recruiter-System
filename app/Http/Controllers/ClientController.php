<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchClientRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchClientRequest $request)
    {
        $searchResults = Client::where('pasport', $request->safe()->only('pasport'))
            ->with(['payments' => function ($query) {
                $query->orderBy('year', 'DESC')->orderBy('month', 'DESC');
            }, 'payments.recruiter:id,name', 'salaries' => function ($query) {
                $query->orderBy('year', 'DESC')->orderBy('month', 'DESC');
            }])->first();



        if (!Request::expectsJson()) {
            return Inertia::render('Client/Index', [
                'searchPasport' => $request->safe()->only('pasport'),
                'searchResults' => $searchResults
            ]);
        } else {
            return  [
                'searchPasport' => $request->safe()->only('pasport'),
                'searchResults' => $searchResults
            ];
        }
    }
}
