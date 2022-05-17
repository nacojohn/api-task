<?php

namespace Database\Seeders;

use App\Models\LaboratoryTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaboratoryTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LaboratoryTest::truncate();

        $tests = [
            ['Chest', 'cervical vertebrae', 'thoracic vertebrae', 'Lumvar Vartebrae', 'Lumbo sacral vertebrae', 'wrist joint', 'ankle', 'fingers', 'toes'],
            ['breast', 'pelvis', 'prostrate', 'thyroid']
        ];

        foreach ($tests as $index => $test) {
            $id = $index + 1;
            $data = array_map(fn ($a) => ['laboratory_category_id' => $id, 'title' => $a], $test);

            LaboratoryTest::insert($data);
        }
    }
}
