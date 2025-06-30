<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GradeLevel;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gradeLevels = [
            ['name' => 'Kelas 1'],
            ['name' => 'Kelas 2'],
            ['name' => 'Kelas 3'],
            ['name' => 'Kelas 4'],
            ['name' => 'Kelas 5'],
            ['name' => 'Kelas 6'],
        ];

        foreach ($gradeLevels as $level) {
            GradeLevel::create($level);
        }
    }
}
