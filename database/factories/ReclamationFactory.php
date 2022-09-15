<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ReclamationStatus;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reclamation>
 */
class ReclamationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::get()->random(),
            'recruiter_id' => Recruiter::get()->random(),
            'client_id' => Client::get()->random(),
            'status_id' => ReclamationStatus::get()->random(),
            'project' => $this->faker->company(),
            'period' => random_int(1, 12) . "-" . random_int(2021, 2022),
            'answer' => $this->faker->text(random_int(5, 1000)),
            'comments' => [[
                "role" => User::get('role')->random()->role,
                "user" => User::get('name')->random()->name,
                "message" => $this->faker->text(random_int(5, 1000)),
                "sendedAt" => $this->faker->date()
            ]]
        ];
    }
}
