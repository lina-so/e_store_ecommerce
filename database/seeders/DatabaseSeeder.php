<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Option;
use App\Models\OptionProduct;
use App\Models\Value;
use Database\Seeders\AdminsTableSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\OptionSeeder;
use Database\Seeders\ProdcutAttributeSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SectionSeeder;
use Database\Seeders\ValueSeeder;
use Database\Seeders\VendorBankDetailTableSeeder;
use Database\Seeders\VendorBusinessDetailTableSeeder;
use Database\Seeders\VendorsTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(VendorBusinessDetailTableSeeder::class);
        $this->call(VendorBankDetailTableSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(ValueSeeder::class);
        $this->call(ProdcutAttributeSeeder::class);
    }
}
