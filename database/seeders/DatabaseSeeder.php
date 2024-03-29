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


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleList = ['user', 'assistant', 'owner', 'accountant', 'admin'];
        $reclamationStatusesList = ['Новая', 'В работе', 'Одобрена', 'Отклонена'];

        foreach ($roleList as $role) {
            Role::firstOrCreate(['title' => $role]);
        }

        foreach ($reclamationStatusesList as $status) {
            ReclamationStatus::firstOrCreate(['title' => $status]);
        }


        if (config('app.is_demo')) {

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
            Team::factory(30)->create();
            User::factory(1000)->create();
            Client::factory(200)->create();
            Recruiter::factory(20)->create();
            Salary::factory(700)->create();
            Payment::factory(650)->create();
            PaymentUser::factory(600)->create();
            RecruiterUser::factory(150)->create();
            Reclamation::factory(100)->create();
        }
    }
}
