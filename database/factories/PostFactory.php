<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'title' => fake()->text(30),
            'content' => fake()->text(200),
            'published_at' => fake()->dateTime(),
            'profile_id' => Profile::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'image_path' => fake()->imageUrl(),
            'status' => fake()->numberBetween(1, 3),
            'views' => fake()->numberBetween(0, 100),

        ];
    }

//    public function configure()
//    {
//        return $this->afterCreating(function (Post $post) {
//            $tags = Tag::inRandomOrder()->take(rand(1, 2))->pluck('id');
//            $post->tags()->attach($tags);
//
//            Comment::factory()->count(rand(1, 2))->create([
//                'post_id' => $post->id,
//            ]);
//
//           $profiles = Profile::inRandomOrder()->take(rand(1, 5))->pluck('id');
//           $post->likedByProfiles()->attach($profiles);
//        });
//    }
}
