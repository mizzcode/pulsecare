<?php

namespace Database\Seeders;

use App\Models\AssesmentQuestion;
use Illuminate\Database\Seeder;

class AssesmentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['name' => 'Saya merasa sulit untuk santai.', 'category' => 'STRESS'],
            ['name' => 'Saya merasa tangan saya gemetar.', 'category' => 'ANXIETY'],
            ['name' => 'Saya merasa tidak ada harapan.', 'category' => 'DEPRESSION'],
            ['name' => 'Saya mudah merasa kesal.', 'category' => 'ANXIETY'],
            ['name' => 'Saya merasa sulit untuk beristirahat.', 'category' => 'DEPRESSION'],
            ['name' => 'Saya merasa murung atau sedih.', 'category' => 'STRESS'],
            ['name' => 'Saya merasa takut tanpa alasan yang jelas.', 'category' => 'ANXIETY'],
            ['name' => 'Saya merasa kehilangan minat pada hal-hal yang dulu saya sukai.', 'category' => 'STRESS'],
            ['name' => 'Saya merasa gugup atau cemas.', 'category' => 'ANXIETY'],
            ['name' => 'Saya tidak memiliki energi untuk melakukan hal-hal.', 'category' => 'DEPRESSION'],
            ['name' => 'Saya mengalami kesulitan untuk tidur.', 'category' => 'STRESS'],
            ['name' => 'Saya merasa tidak berharga.', 'category' => 'STRESS'],
            ['name' => 'Saya merasa tegang atau sulit untuk duduk diam.', 'category' => 'DEPRESSION'],
            ['name' => 'Saya merasa putus asa dengan masa depan.', 'category' => 'STRESS'],
            ['name' => 'Saya merasa mudah panik.', 'category' => 'ANXIETY'],
            ['name' => 'Saya merasa tidak berguna.', 'category' => 'DEPRESSION'],
            ['name' => 'Saya merasa ketakutan akan sesuatu yang buruk akan terjadi.', 'category' => 'DEPRESSION'],
            ['name' => 'Saya merasa hidup ini tidak berarti.', 'category' => 'STRESS'],
            ['name' => 'Saya merasa sulit berkonsentrasi.', 'category' => 'ANXIETY'],
            ['name' => 'Saya kehilangan minat terhadap aktivitas sosial.', 'category' => 'ANXIETY'],
            ['name' => 'Saya merasa tidak bisa mengendalikan rasa cemas saya.', 'category' => 'DEPRESSION'],
        ];

        foreach ($questions as $question) {
            AssesmentQuestion::create($question);
        }
    }
}