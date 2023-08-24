<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords = [
            [
                'id' => 1,
                'name' => 'Super Admin', 
                'Type' => 'superadmin',
                'vendor_id' => 0,
                'mobile' => '0911111111',
                'email' => 'admin@admin.com',
                'password' => '$2a$12$hW1jwVmJ0vAkzaayycWQPeKpjKfJtxCYlz8TtzgVdoogyjxdnsL6.',
                'image' => '',
                'status' => '1',
            ],
            [
                'id' => 2,
                'name' => 'Massa', 
                'Type' => 'vendor',
                'vendor_id' => 1,
                'mobile' => '0911111111',
                'email' => 'massa@admin.com',
                'password' => '$2a$12$hW1jwVmJ0vAkzaayycWQPeKpjKfJtxCYlz8TtzgVdoogyjxdnsL6.',
                'image' => '',
                'status' => '1',
            ],
            [
                'id' => 3,
                'name' => 'Lena', 
                'Type' => 'admin',
                'vendor_id' => 0,
                'mobile' => '0911111111',
                'email' => 'lena@admin.com',
                'password' => '$2a$12$hW1jwVmJ0vAkzaayycWQPeKpjKfJtxCYlz8TtzgVdoogyjxdnsL6.',
                'image' => '',
                'status' => '1',
            ],
        ];
        Admin::insert($adminRecords);
    }
}
