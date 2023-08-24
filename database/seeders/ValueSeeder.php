<?php

namespace Database\Seeders;

use App\Models\Value;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $valueRecords = [
            [
                'id' => 1,
                'name' => 'Red',
                'option_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Black',
                'option_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'L',
                'option_id' => 1,
            ]
        ];

        Value::insert($valueRecords);
    }
}
