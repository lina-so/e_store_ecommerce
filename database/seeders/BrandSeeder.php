<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandRecord = [
            [
                'id' => 1,
                'name' => 'Nike',
                'status' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Addidas',
                'status' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Apple',
                'status' => 1,
            ],
        ];

        Brand::insert($brandRecord);
    }
}
