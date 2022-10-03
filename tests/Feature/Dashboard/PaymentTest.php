<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->recruiters = Recruiter::factory(10)->create();
        Client::factory(10)->create();
        Payment::factory(20)->create([
            'recruiter_id' => 1,
            'month' => 12,
            'bonus' => 250,
            'year' => 2021,
        ]);
        Payment::factory(10)->create([
            'recruiter_id' => 5,
            'month' => 1,
            'bonus' => 250,
            'year' => 2022,
        ]);
        $this->user->recruiters()->attach($this->recruiters->pluck('id'));
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_count_recrutation()
    {
        $response =  $this->actingAs($this->user)->getJson('/dashboard');
        $response->assertJson(
            function (AssertableJson $json) {
                //должно быть 10 рекрутеров
                $json->has('recruiterPaymentsCount', 10)
                    ->has(
                        'recruiterPaymentsCount.0',
                        function ($json) {
                            $json
                                ->where('name', $this->recruiters[0]['name'])
                                ->where('payments.0', [
                                    'month' => '12',
                                    'recruiter_id' => '1',
                                    'year' => '2021',
                                    'countpaym' => '20',
                                ]);
                        }
                    )->has(
                        'recruiterPaymentsCount.4',
                        function ($json) {
                            Log::debug($json);
                            $json
                                ->where('name', $this->recruiters[4]['name'])
                                ->where('payments.0', [
                                    'month' => '1',
                                    'recruiter_id' => '5',
                                    'year' => '2022',
                                    'countpaym' => '10',
                                ]);
                        }
                    )
                    ->has('periodList', 2)
                    ->where('periodList.0',   [
                        'month' => '1',
                        'year' => '2022',
                        'period' => '1-2022'
                    ])
                    ->where('periodList.1',   [
                        'month' => '12',
                        'year' => '2021',
                        'period' => '12-2021'
                    ])
                    ->has('queryFilter', 2)
                    ->where('queryFilter',   [
                        'start' => '12-2021',
                        'end' => '1-2022'
                    ]);
            }
        );
    }
}
