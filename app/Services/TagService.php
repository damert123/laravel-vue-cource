<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;

class TagService
{

    public static function create(array $data): Tag
    {
        return Tag::create($data);
    }

    public static function getTagIds(string $tags): array
    {
        $tagIds = [];

        foreach (getArrayFromString($tags) as $tagTitle) {

            $tagIds[] = Tag::firstOrCreate(['name' => $tagTitle])->id;
        }


        return $tagIds;
    }

    public static function update(Tag $tag, array $data): Tag
    {
        $tag->update($data);
        return $tag;

    }

    public static function delete(Tag $tag): void
    {

        $tag->delete();

    }

}
