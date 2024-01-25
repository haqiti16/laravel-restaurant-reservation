<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableTest extends TestCase
{
    public function testAddSuccess()
    {
        $this->post('/api/tables', [
            "name"      => "Meja A1",
            "capacity"  => 4,
        ])->assertStatus(201)
        ->assertJson([
            "data" => [
                "name"      => "Meja A1",
                "capacity"  => 4,
            ]
        ]);
    }

    public function testAddFailed()
    {
        $this->post('/api/tables', [
            "name"      => '',
            "capacity"  =>  '',
        ])->assertStatus(400)
        ->assertJson([
            "errors" => [
                "name"      => [
                    "The name field is required."
                ],
                "capacity"  => [
                    "The capacity field is required."
                ],
            ]
        ]);
    }

    public function testAddAlreadyExists()
    {
        // $this->testAddSuccess();
        $this->post('/api/tables', [
            "name"      => "Meja A1",
            "capacity"  => 4,
        ])->assertStatus(400)
        ->assertJson([
            "errors" => [
                "name"      => [
                    "the table name already exists."
                ],
            ]
        ]);
    }

    public function testGetAll()
    {
        $this->get('/api/tables')
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'name' => 'Meja A1',
                    'capacity' => 4
                ]
            ]
        ]);
    }

    public function test_availability_tables()
    {
        $this->post('/api/tables/availability', [
            'start_time' => '2024-01-26T09:00:00',
            'end_time' => '2024-01-26T10:00:00',
            'guest_count' => 2,
        ])->assertStatus(200)
        ->assertJson([
            'available' => true,
            'tables' => [],
        ]);
    }
}
