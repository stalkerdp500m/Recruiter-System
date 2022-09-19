<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Jobs\ProcessSalary;
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
        return Inertia::render('Import/Salary');
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
                $countAll = count($salaryesData);
                ProcessSalary::dispatch($salaryesData);
                return $this->onSuccess("Валидация пройдена, задание добавлено в очередь ", "recive $countAll salaries start job");
            } else  return $this->onError(400, $validator->errors());
        } else {
            return $this->onError(401, 'Unauthorized Access');
        }
    }
}
