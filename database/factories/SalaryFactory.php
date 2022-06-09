<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salary>
 */
class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_id' => Client::get()->random(),
            'month' => random_int(1, 12),
            'year' => 2020,
            // 'year' => random_int(2021, 2022),
            'project' => $this->faker->company(),
            'hours' => random_int(30, 300),
            'salary' => $this->faker->randomFloat(2, -200, 7000),
            'rate' => $this->faker->randomFloat(2, 10, 30),
        ];
    }
}
