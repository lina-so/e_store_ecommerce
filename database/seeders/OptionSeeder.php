<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $optionRecords = [
            [
                'id' => 1,
                'name' => 'Colors',
            ],
            [
                'id' => 2,
                'name' => 'Sizes',
            ],
            [
                'id' => 3,
                'name' => 'Capacities',
            ],
        ];

        Option::insert($optionRecords);
    }
}
