<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class PostService
{
    public static function create(array $data): ?Post
    {


        if (isset($data['post']['image'])) {
            unset($data['post']['image']);
        }


        try {
            DB::beginTransaction();
            $post = Post::create($data['post']);

            if (!empty($data['tags'])) {
                $tagIds = TagService::getTagIds($data['tags']);
                $post->tags()->attach($tagIds);
            }
            DB::commit();

            return $post;


        } catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception('Не удалось создать пост', $exception->getCode(), $exception);
        }


    }

    public static function update(Post $post, array $data): Post
    {
        try {
            DB::beginTransaction();


            if (isset($data['post']['image']) && $post->image_path) {
                Storage::disk('public')->delete($post->image_path);
                unset($data['post']['image']);
            }


            $post->update($data['post']);

            if (!empty($data['tags'])) {
                $tagIds = TagService::getTagIds($data['tags']);
                $post->tags()->sync($tagIds);
            }
            DB::commit();

            return $post;


        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception('Не удалось создать пост', $exception->getCode(), $exception);
        }

    }

    public static function delete(Post $post): void
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->tags()->detach();
        $post->likeable()->detach();
        $post->comments()->delete();

        $post->delete();

    }

    public static function processPost()
    {
        try {
            $post = Post::updateOrCreate(
                ['title' => 'Some title fsdfsdf'],
                ['content' => 'Some content',
                    'profile_id' => 1,
                    'category_id' => 1],
            );
            throw new CustomException($post, 'updateOrCreate', 'Post operation complete');
        } catch (CustomException $e) {
            $e->report();
        }

        try {
            $post = Post::firstOrCreate(
                ['title' => 'Another title'],
                ['content' => 'Another content',
                    'profile_id' => 1,
                    'category_id' => 1],

            );
            throw new CustomException($post, 'firstOrCreate', 'Post operation complete');
        } catch (CustomException $e) {
            $e->report();
        }
    }

}
