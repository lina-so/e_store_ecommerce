<?php

namespace Database\Seeders;

use App\Models\ProdcutAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdcutAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttributeRecords = [
            'id' => 1, 
            'product_id' => 1,
            'value_id' => 1, 
            'price' => 100.1,
            'sku' => 'E12',
            'stock' => 10,
            'status' => 1,
        ];

        ProdcutAttribute::insert($productAttributeRecords);
    }
}
