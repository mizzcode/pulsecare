<?php

namespace Database\Seeders;

use App\Models\AssesmentAnswer;
use Illuminate\Database\Seeder;

class AssesmentAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answers = [
            ['name' => 'Tidak Pernah', 'value' => 0],
            ['name' => 'Kadang-kadang', 'value' => 1],
            ['name' => 'Sering', 'value' => 2],
            ['name' => 'Sangat Sering', 'value' => 3],
        ];

        foreach ($answers as $answer) {
            AssesmentAnswer::create($answer);
        }
    }
}
