<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create basic plan
        Plan::create([
            'name' => 'Basic',
            'month_price' => 9.99,
            'year_price' => 99.99,
            'trail_days' => 7,
        ]);
        //create pro plan
        Plan::create([
            'name' => 'Pro',
            'month_price' => 19.99,
            'year_price' => 199.99,
            'trail_days' => 7,
        ]);
    }
}
