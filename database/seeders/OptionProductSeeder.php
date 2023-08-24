<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionProduct;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $optionProductRecords = [
            [
                'id' => 1,
                'option_id' => 1,
                'product_id' => 1,
            ],
            [
                'id' => 2,
                'option_id' => 2,
                'product_id' => 1,
            ],
            [
                'id' => 3,
                'option_id' => 3,
                'product_id' => 2,
            ],
        ];

        OptionProduct::insert($optionProductRecords);
    }
}
