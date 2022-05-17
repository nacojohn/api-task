<?php

namespace Database\Seeders;

use App\Models\LaboratoryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaboratoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LaboratoryCategory::truncate();

        LaboratoryCategory::insert([
            ['title' => 'X-Ray'],
            ['title' => 'Ultrasound Scan']
        ]);
    }
}
