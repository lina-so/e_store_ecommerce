<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productRecords = [
            [
                'id' => 1,
                'category_id' => 1,
                'brand_id' => 1,
                'vendor_id' => 2,
                'admin_type' => 'vendor',
                'product_name' => 'shirts',
                'product_price' => 100.0,
                'product_discount' => 10,
                'product_image' => '',
                'description' => 'asldjaksdfjls',
                'is_featured' => 'Yes',
                'status' => 1,
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'brand_id' => 2,
                'vendor_id' => 2,
                'admin_type' => 'vendor',
                'product_name' => 'Asus Laptop 23E',
                'product_price' => 100.0,
                'product_discount' => 10,
                'product_image' => '',
                'description' => 'asldjaksdfjls',
                'is_featured' => 'Yes',
                'status' => 1,
            ],
        ];

        Product::insert($productRecords);
    }
}
