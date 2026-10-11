<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuisine;

class CuisineSeeder extends Seeder
{
    public function run(): void
    {
        $cuisines = [
            ['name' => 'Italian', 'description' => 'Pasta, pizza, and rich tomato sauces.'],
            ['name' => 'Mexican', 'description' => 'Spicy, flavorful dishes with corn, beans, and chilies.'],
            ['name' => 'Indian', 'description' => 'Complex spice blends and rich curries.'],
            ['name' => 'American', 'description' => 'Classic comfort foods, burgers, and BBQ.'],
            ['name' => 'Japanese', 'description' => 'Sushi, ramen, and delicate flavors.'],
            ['name' => 'Mediterranean', 'description' => 'Healthy recipes featuring olive oil, vegetables, and lean proteins.'],
        ];

        foreach ($cuisines as $cuisine) {
            Cuisine::create($cuisine);
        }
    }
}
