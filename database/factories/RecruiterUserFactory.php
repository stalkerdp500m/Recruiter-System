<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentUsers>
 */
class RecruiterUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'recruiter_id' => Recruiter::get()->random(),
            'user_id' => User::get()->random()
        ];
    }
}
