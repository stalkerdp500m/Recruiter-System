<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Payment;
use App\Models\PaymentUser;
use App\Models\Recruiter;
use App\Models\Salary;
use App\Models\User;
use App\Models\RecruiterUser;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('123'),
            ]
        );
        User::firstOrCreate(
            ['email' => 'another@gmail.com'],
            [
                'name' => 'Another User',
                'password' => bcrypt('123'),
            ]
        );
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('123'),
                'role' => 'admin'
            ]
        );
        Client::factory(1000)->create();
        Recruiter::factory(15)->create();
        Salary::factory(1300)->create();
        Payment::factory(1100)->create();
        PaymentUser::factory(20)->create();
        RecruiterUser::factory(10)->create();
    }
}
