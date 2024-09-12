<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commentableModels = [
            Post::class,
            Video::class,
        ];

        $commentableType = fake()->randomElement($commentableModels);

        $commentable = $commentableType::inRandomOrder()->first();


        return [

            'title' => fake()->sentence(),
            'profile_id' => Profile::inRandomOrder()->first()->id,
            'commentable_id' => $commentable->id,
            'commentable_type' => $commentableType,
            'parent_id' => null,

        ];
    }
}
