<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Mental Health',
                'description' => 'Articles about mental health awareness, tips, and general mental wellbeing',
                'color' => '#8B5CF6',
                'is_active' => true,
            ],
            [
                'name' => 'Anxiety',
                'description' => 'Content focused on anxiety management, coping strategies, and understanding anxiety disorders',
                'color' => '#F59E0B',
                'is_active' => true,
            ],
            [
                'name' => 'Sleep',
                'description' => 'Information about sleep hygiene, sleep disorders, and the importance of quality sleep',
                'color' => '#3B82F6',
                'is_active' => true,
            ],
            [
                'name' => 'Resilience',
                'description' => 'Building resilience, overcoming challenges, and developing mental strength',
                'color' => '#10B981',
                'is_active' => true,
            ],
            [
                'name' => 'Mindfulness',
                'description' => 'Mindfulness practices, meditation techniques, and present-moment awareness',
                'color' => '#6366F1',
                'is_active' => true,
            ],
            [
                'name' => 'Announcements',
                'description' => 'Important announcements, news, and updates from the platform',
                'color' => '#EF4444',
                'is_active' => true,
            ],
            [
                'name' => 'General Health',
                'description' => 'General health topics, wellness tips, and healthy lifestyle advice',
                'color' => '#14B8A6',
                'is_active' => true,
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Lifestyle tips, work-life balance, and daily wellness practices',
                'color' => '#F97316',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
