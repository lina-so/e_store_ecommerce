<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionoRecord = [
            [
                'id' => 1,
                'name' => 'T-shirts',
                'status' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Dresses',
                'status' => 1,
            ]
        ];

        Section::insert($sectionoRecord);
    }
}
