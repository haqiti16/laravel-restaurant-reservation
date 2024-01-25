<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Table::create([
            "name"      => "Meja A1",
            "capacity"  => 2,
        ]);
        Table::create([
            "name"      => "Meja A2",
            "capacity"  => 4,
        ]);
        Table::create([
            "name"      => "Meja A3",
            "capacity"  => 4,
        ]);
        Table::create([
            "name"      => "Meja B1",
            "capacity"  => 2,
        ]);
        Table::create([
            "name"      => "Meja B2",
            "capacity"  => 4,
        ]);
        Table::create([
            "name"      => "Meja B3",
            "capacity"  => 4,
        ]);
    }
}
