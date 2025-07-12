<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user as author
        $adminUser = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$adminUser) {
            $this->command->error('Admin user not found. Please run user seeder first.');
            return;
        }

        // Get categories
        $mentalHealthCategory = Category::where('name', 'Mental Health')->first();
        $anxietyCategory = Category::where('name', 'Anxiety')->first();
        $sleepCategory = Category::where('name', 'Sleep')->first();
        $resilienceCategory = Category::where('name', 'Resilience')->first();
        $mindfulnessCategory = Category::where('name', 'Mindfulness')->first();
        $announcementsCategory = Category::where('name', 'Announcements')->first();

        $articles = [
            [
                'title' => 'Understanding Mental Health: A Comprehensive Guide',
                'content' => 'Mental health is a crucial aspect of overall well-being that encompasses our emotional, psychological, and social well-being. It affects how we think, feel, and act, influencing how we handle stress, relate to others, and make choices in our daily lives.

Good mental health is more than just the absence of mental illness. It involves having a positive sense of well-being, the ability to function effectively in daily activities, and resilience in the face of life\'s challenges.

Some key components of mental health include:

1. Emotional well-being: Understanding and managing your emotions effectively
2. Social connections: Maintaining healthy relationships with family, friends, and community
3. Self-care practices: Engaging in activities that promote physical and mental wellness
4. Stress management: Developing healthy coping mechanisms for life\'s challenges
5. Purpose and meaning: Having goals and finding fulfillment in daily activities

Signs of good mental health include feeling good about yourself, having healthy relationships, being able to cope with stress, and maintaining a sense of purpose. If you\'re struggling with mental health challenges, remember that help is available and seeking support is a sign of strength, not weakness.',
                'category_id' => $mentalHealthCategory?->id,
                'excerpt' => 'Explore the fundamentals of mental health and learn about the key components that contribute to overall psychological well-being.',
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Managing Anxiety: Practical Tips for Daily Life',
                'content' => 'Anxiety is a normal human emotion that everyone experiences from time to time. However, when anxiety becomes persistent, excessive, or interferes with daily activities, it may indicate an anxiety disorder that requires attention and care.

Common symptoms of anxiety include:
- Excessive worry or fear
- Restlessness or feeling on edge
- Difficulty concentrating
- Physical symptoms like rapid heartbeat, sweating, or trembling
- Sleep disturbances
- Avoidance of certain situations or activities

Here are some practical strategies for managing anxiety:

1. Deep breathing exercises: Practice slow, controlled breathing to activate your body\'s relaxation response
2. Progressive muscle relaxation: Systematically tense and relax different muscle groups
3. Mindfulness meditation: Focus on the present moment without judgment
4. Regular exercise: Physical activity can help reduce anxiety and improve mood
5. Limit caffeine and alcohol: These substances can exacerbate anxiety symptoms
6. Maintain a regular sleep schedule: Quality sleep is essential for mental health
7. Connect with others: Share your feelings with trusted friends or family members

Remember, if anxiety significantly impacts your daily life, it\'s important to seek professional help. Mental health professionals can provide additional strategies and treatments tailored to your specific needs.',
                'category_id' => $anxietyCategory?->id,
                'excerpt' => 'Learn practical, evidence-based strategies for managing anxiety in your daily life and when to seek professional help.',
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'The Importance of Sleep for Mental Health',
                'content' => 'Sleep and mental health are closely interconnected. Poor sleep can contribute to mental health problems, while mental health issues can also disrupt sleep patterns, creating a challenging cycle.

Quality sleep is essential for:
- Emotional regulation
- Cognitive function and memory consolidation
- Stress management
- Immune system function
- Overall physical and mental well-being

Tips for better sleep hygiene:

1. Maintain a consistent sleep schedule: Go to bed and wake up at the same time every day
2. Create a relaxing bedtime routine: Develop calming activities before sleep
3. Optimize your sleep environment: Keep your bedroom dark, quiet, and cool
4. Limit screen time before bed: Blue light can interfere with natural sleep cycles
5. Avoid caffeine and large meals close to bedtime
6. Get regular exercise: Physical activity can improve sleep quality
7. Manage stress and worries: Practice relaxation techniques or write in a journal

If you continue to experience sleep problems despite good sleep hygiene, consider consulting with a healthcare provider. Sleep disorders and mental health conditions often require professional treatment for optimal management.',
                'category_id' => $sleepCategory?->id,
                'excerpt' => 'Discover the vital connection between quality sleep and mental health, plus practical tips for improving your sleep hygiene.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Building Resilience: Bouncing Back from Life\'s Challenges',
                'content' => 'Resilience is the ability to adapt and bounce back from difficult experiences, trauma, or significant stress. It\'s not about avoiding challenges but rather developing the skills and mindset to navigate them effectively.

Resilient people often share certain characteristics:
- Adaptability and flexibility
- Strong problem-solving skills
- Healthy relationships and social support
- Self-awareness and emotional regulation
- Optimism and hope for the future
- Self-care practices and healthy boundaries

Ways to build resilience:

1. Develop strong relationships: Cultivate connections with supportive family and friends
2. Practice self-compassion: Treat yourself with kindness during difficult times
3. Learn from experience: Reflect on past challenges and how you overcame them
4. Set realistic goals: Break large tasks into manageable steps
5. Take care of your physical health: Exercise, eat well, and get adequate sleep
6. Practice mindfulness: Stay present and avoid catastrophic thinking
7. Seek meaning and purpose: Find activities that give your life meaning
8. Accept change as part of life: Develop flexibility in facing new situations

Building resilience is a gradual process that requires patience and practice. Remember that everyone\'s path to resilience is different, and it\'s okay to seek professional support when needed.',
                'category_id' => $resilienceCategory?->id,
                'excerpt' => 'Learn how to build resilience and develop the skills needed to bounce back from life\'s inevitable challenges and setbacks.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Mindfulness and Meditation: A Beginner\'s Guide',
                'content' => 'Mindfulness is the practice of purposefully paying attention to the present moment without judgment. It\'s a powerful tool for improving mental health, reducing stress, and enhancing overall well-being.

Benefits of mindfulness practice:
- Reduced stress and anxiety
- Improved emotional regulation
- Better focus and concentration
- Increased self-awareness
- Enhanced relationships
- Greater sense of calm and peace

Getting started with mindfulness:

1. Start small: Begin with just 5-10 minutes of practice daily
2. Find a quiet space: Choose a comfortable, distraction-free environment
3. Focus on your breath: Use breathing as an anchor for your attention
4. Notice when your mind wanders: Gently redirect your attention back to the present
5. Be patient with yourself: Mindfulness is a skill that develops over time
6. Try different techniques: Explore various forms of meditation to find what works for you

Simple mindfulness exercises:
- Body scan meditation: Systematically focus on different parts of your body
- Mindful breathing: Pay attention to the sensation of breathing
- Walking meditation: Practice mindfulness while walking slowly
- Mindful eating: Focus fully on the experience of eating
- Loving-kindness meditation: Send good wishes to yourself and others

Remember, there\'s no "perfect" way to practice mindfulness. The goal is simply to notice when your mind wanders and gently bring your attention back to the present moment.',
                'category_id' => $mindfulnessCategory?->id,
                'excerpt' => 'Discover the benefits of mindfulness and learn simple techniques to start your own meditation practice for better mental health.',
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Upcoming Mental Health Awareness Campaign',
                'content' => 'We are excited to announce our upcoming mental health awareness campaign launching next month. This comprehensive initiative will focus on reducing stigma and promoting mental health education in our community.

Campaign highlights will include:
- Free mental health screenings
- Educational workshops and seminars
- Community support group formations
- Resource distribution and awareness materials
- Collaboration with local mental health professionals

Stay tuned for more details and ways to get involved in supporting mental health awareness in our community.',
                'category_id' => $announcementsCategory?->id,
                'excerpt' => 'Learn about our upcoming mental health awareness campaign and how you can get involved in supporting mental health education.',
                'status' => 'draft',
                'published_at' => null,
            ],
        ];

        foreach ($articles as $articleData) {
            Article::create([
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'content' => $articleData['content'],
                'category_id' => $articleData['category_id'],
                'excerpt' => $articleData['excerpt'],
                'author_id' => $adminUser->id,
                'status' => $articleData['status'],
                'published_at' => $articleData['published_at'],
                'created_at' => $articleData['published_at'] ?? now(),
                'updated_at' => $articleData['published_at'] ?? now(),
            ]);
        }

        $this->command->info('Articles seeded successfully!');
    }
}
