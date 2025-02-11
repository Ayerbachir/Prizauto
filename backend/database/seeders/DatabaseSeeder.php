<?php

namespace Database\Seeders;

use App\Models\Car;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Car::factory(10)->create();


        
        Car::factory()->create([
            'name' => 'Test User',
            'model' => 'test',
            'price' =>'99',
            'state' =>'no',
            'nci' =>"96385274",
        ]);
        
    }
}
