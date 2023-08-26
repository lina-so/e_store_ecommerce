<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttriputeRecords = [
            [
                'id' => 1,
                'product_id' => 1,
                'value_id' => 1,
                'price' => 213.1,
                'stock' => 12,
                'sku' => 'E22',
                'status' => 1
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'value_id' => 2,
                'price' => 213.2,
                'stock' => 12,
                'sku' => 'E12',
                'status' => 1
            ],
        ];

        ProductAttribute::insert($productAttriputeRecords);
    }
}
