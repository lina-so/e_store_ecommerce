<?php

namespace Database\Seeders;

use App\Models\VendorBankDetail;
use Illuminate\Database\Seeder;

class VendorBankDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VendorBankDetail::factory()->count(10)->create();
    }
}
