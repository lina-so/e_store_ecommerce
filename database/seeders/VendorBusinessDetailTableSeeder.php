<?php

namespace Database\Seeders;

use App\Models\VendorBusinessDetail;
use Illuminate\Database\Seeder;

class VendorBusinessDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VendorBusinessDetail::factory()->count(10)->create();
    }
}
