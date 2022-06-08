<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\Recruiter;
use App\Models\Salary;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categoriesProject = ["VIP", "Premium", "VIP+", "Standart"];
        $statusesPayments = ["Wypłata 100% Suma30Dni", "Wypłata 100%", "Wypłata 100% SumaRBH"];

        return [
            'client_id' => Client::get()->random(),
            'recruiter_id' => Recruiter::get()->random(),
            'recommender_id' => User::get()->random(),
            'month' => random_int(1, 4),
            'year' => 2022,
            //  'year' => random_int(2021, 2022),
            'project' => $this->faker->company(),
            'hours' => random_int(30, 300),
            'category' => $categoriesProject[random_int(0, 3)],
            'bonus' => random_int(100, 300),
            'status' => $statusesPayments[random_int(0, 2)],
            'syncroner_id' => $this->faker->uuid(),
            'bitrix_id' => random_int(1, 5000),
        ];
    }
}
