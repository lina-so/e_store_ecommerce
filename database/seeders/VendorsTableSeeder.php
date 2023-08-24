<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecord = [
            [
                'id' => 1,
                'name' => 'Massa',
                'address' => 'Al-Hamra Street',
                'City' => 'Damascus',
                'Country' => 'Syria',
                'mobile' => '0912222222',
                'email' => 'massa@vendor.com',
                'password' => '$2a$12$hW1jwVmJ0vAkzaayycWQPeKpjKfJtxCYlz8TtzgVdoogyjxdnsL6.',
                'status' => 0
            ]
        ];

        Vendor::insert($vendorRecord);
    }
}
