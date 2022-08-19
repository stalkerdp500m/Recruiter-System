<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Payment;
use App\Models\PaymentUser;
use App\Models\ReclamationStatus;
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
        ReclamationStatus::firstOrCreate(
            ['title' => 'Новая']
        );
        ReclamationStatus::firstOrCreate(
            ['title' => 'В работе']
        );
        ReclamationStatus::firstOrCreate(
            ['title' => 'Одобрена']
        );
        ReclamationStatus::firstOrCreate(
            ['title' => 'Отклонена']
        );
        User::factory(200)->create();
        Client::factory(300)->create();
        Recruiter::factory(15)->create();
        Salary::factory(500)->create();
        Payment::factory(500)->create();
        PaymentUser::factory(400)->create();
        RecruiterUser::factory(400)->create();
    }
}
