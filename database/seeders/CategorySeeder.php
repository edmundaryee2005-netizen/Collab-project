<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // 1. Import the Category model

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Clear the table first to avoid duplicates
        Category::truncate();

        // 3. Create an array of categories
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Fashion & Apparel'],
            ['name' => 'Home & Garden'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Sports & Outdoors'],
            ['name' => 'Toys & Hobbies'],
            ['name' => 'Vehicles & Parts'],
            ['name' => 'Other'],
        ];

        // 4. Insert the categories into the database
        Category::insert($categories);
    }
}

