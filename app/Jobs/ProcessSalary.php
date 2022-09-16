<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Salary;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProcessSalary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 240;
    protected $salaryesData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($salaryesData)
    {
        $this->salaryesData = $salaryesData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $countAded = 0;
        foreach ($this->salaryesData as $salary) {
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
        Notification::send(User::where('role', 'admin')->get(), new AdminNotification("Добавлено $countAded новых отработок"));
    }
}
