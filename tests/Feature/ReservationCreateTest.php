<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Reservation;
use Illuminate\Support\Facades\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\ReservationCreateRequest;
use Database\Seeders\TableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationCreateTest extends TestCase
{

    public function test_it_stores_a_reservation()
    {
        $this->post('/api/reservation', [
            'table_id' => 1,
            'name' => 'haqi',
            'email' => 'haqiti16@gmail.com',
            'phone_number' => '6281xxxxx',
            'start_time' => '2024-01-26T09:00:00',
            'end_time' => '2024-01-26T10:00:00',
            'guest_count' => 2,
        ])->assertStatus(201)
        ->assertJson([
            "data" => [
                'start_time'    => '2024-01-26T09:00:00',
                'end_time'      => '2024-01-26T10:00:00',
                'guest_count'   => 2,
                'status'        => 'active',
            ]
        ]);
    }

    public function test_it_fails_if_table_is_not_available()
    {
        $this->post('/api/reservation', [
            'table_id' => 1,
            'name' => 'haqi',
            'email' => 'haqiti16@gmail.com',
            'phone_number' => '6281xxxxx',
            'start_time' => '2024-01-26T09:00:00',
            'end_time' => '2024-01-26T10:00:00',
            'guest_count' => 2,
        ])->assertStatus(400)
        ->assertJson([
            "errors" => [
                "message" => [
                    "Sorry, table is not available!"
                ]
            ]
        ]);
    }
}
