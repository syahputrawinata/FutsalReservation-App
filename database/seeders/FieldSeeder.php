<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    public function run()
    {
        DB::table('fields')->insert([
            ['location' => 'Bogor', 'name' => 'Lapangan 1', 'price_per_hour' => 150000],
            ['location' => 'Depok', 'name' => 'Lapangan 2', 'price_per_hour' => 180000],
            ['location' => 'Jakarta', 'name' => 'Lapangan 3', 'price_per_hour' => 200000],
        ]);        
    }
}
