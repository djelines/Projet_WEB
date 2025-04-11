<?php

namespace Database\Factories;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Ménage',
            'Rangement',
            'Courses groupées',
            'Courses urgentes',
            'Vaisselle',
            'Cuisine',
            'Achats communs',
            'Maintenance',
            'Événement',
            'Invités',
            'Réunions',
            'Visites des locaux',
            'Prise en main des stagiaires',
            'Autre'
        ];

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category' => $categories[array_rand($categories)],
            'user_id' => 1 
        ];
    }
}
