<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name' => fake()->unique()->randomElement([
            'Bug',
            'Feature',
            'Frontend',
            'Backend',
            'Urgent',
            'Documentation',
            'Testing',
            'Enhancement',
            'API',
            'Database',
            'UI',
            'Refactor',
            'Performance',
            'Security',
            'DevOps',
        ]),
            'color' => fake()->hexColor(),
        ];
    }
}
