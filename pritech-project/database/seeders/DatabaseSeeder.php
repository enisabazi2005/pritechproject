<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tag;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $tags = Tag::factory(10)->create();

        Project::factory(5)
            ->create()
            ->each(function ($project) use ($tags) {

                Issue::factory(5)
                    ->create([
                        'project_id' => $project->id,
                    ])
                    ->each(function ($issue) use ($tags) {

                        $issue->tags()->attach(
                            $tags->random(rand(1, 3))->pluck('id')
                        );

                        Comment::factory(3)->create([
                            'issue_id' => $issue->id,
                        ]);
                    });
            });
    }
}