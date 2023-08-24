<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $categoryRecord = [
            [
                'id' => 1,
                'parent_id' => 0,
                'section_id' => 1, 
                'category_name' => 'Clothing',
                'category_image' => '',
                'category_discount' => 0,
                'description' => '',
                'status' => 1,
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'section_id' => 2, 
                'category_name' => 'Women',
                'category_image' => '',
                'category_discount' => 0,
                'description' => 'Women Clothing',
                'status' => 1,
            ],
        ];

        Category::insert($categoryRecord);
    }
}
