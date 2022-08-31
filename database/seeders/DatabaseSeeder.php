<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Payment;
use App\Models\PaymentUser;
use App\Models\Reclamation;
use App\Models\ReclamationStatus;
use App\Models\Recruiter;
use App\Models\Salary;
use App\Models\User;
use App\Models\RecruiterUser;
use App\Models\Role;
use App\Models\Team;
use Database\Factories\ReclamationFactory;
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
                'email_verified_at' => now(),
                'password' => bcrypt('123'),
            ]
        );
        User::firstOrCreate(
            ['email' => 'another@gmail.com'],
            [
                'name' => 'Another User',
                'email_verified_at' => now(),
                'password' => bcrypt('123'),
            ]
        );
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Test Admin',
                'email_verified_at' => now(),
                'password' => bcrypt('123'),
                'role' => 'admin'
            ]
        );

        $roleList = ['user', 'assistant', 'owner', 'accountant', 'admin'];
        $reclamationStatusesList = ['Новая', 'В работе', 'Одобрена', 'Отклонена'];

        foreach ($roleList as $role) {
            Role::firstOrCreate(['title' => $role]);
        }

        foreach ($reclamationStatusesList as $status) {
            ReclamationStatus::firstOrCreate(['title' => $status]);
        }


        // ReclamationStatus::firstOrCreate(
        //     ['title' => 'Новая']
        // );
        // ReclamationStatus::firstOrCreate(
        //     ['title' => 'В работе']
        // );
        // ReclamationStatus::firstOrCreate(
        //     ['title' => 'Одобрена']
        // );
        // ReclamationStatus::firstOrCreate(
        //     ['title' => 'Отклонена']
        // );
        Team::factory(10)->create();
        User::factory(200)->create();
        Client::factory(350)->create();
        Recruiter::factory(40)->create();
        Salary::factory(600)->create();
        Payment::factory(700)->create();
        PaymentUser::factory(300)->create();
        RecruiterUser::factory(400)->create();
        Reclamation::factory(200)->create();
    }
}
