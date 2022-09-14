<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Models\Client;
use App\Models\Salary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SalaryController extends Controller
{

    use ApiHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Import/Salary', [
            // 'recruiterList' => Recruiter::select('id', 'name', 'team_id', 'owner_id')->with(['team:id,name', 'owner:id,name'])->orderBy('created_at', 'desc')->get(),
            // 'teamsList' => Team::select('id', 'name')->get(),
            // 'userList' => User::select('id', 'name')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->isCan(Request::user(), 'salaries:update')) {

            $validator = Validator::make(Request::all(), $this->salaryValidationRules());

            if ($validator->passes()) {
                $salaryesData = Request::input('data');
                $countAded = 0;
                try {
                    DB::beginTransaction();

                    foreach ($salaryesData as $salary) {

                        $client = Client::firstOrCreate(
                            ['pasport' => trim($salary['client_pasport'])],
                            ['name' => trim($salary['client_name'])]
                        );
                        $salaryAdd =  Salary::updateOrCreate(
                            [
                                'month' =>  $salary['month'],
                                'year' => $salary['year'],
                                'client_id' => $client->id,
                                'project' => trim($salary['project']),
                            ],
                            [
                                'hours' => $salary['hours'],
                                'rate' => $salary['rate'],
                                'salary' => $salary['salary'],
                            ]

                        );

                        if ($salaryAdd->wasRecentlyCreated) {
                            $countAded++;
                        }
                    }
                    DB::commit();
                    return $this->onSuccess("Add $countAded salaries ", 'Finish job');
                } catch (\Exception $expection) {
                    DB::rollBack();
                    echo $expection->getMessage();
                }
            } else  return $this->onError(400, $validator->errors());
        } else {
            return $this->onError(401, 'Unauthorized Access');
        }
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
    public function update(Request $request, $id)
    {
        //
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
