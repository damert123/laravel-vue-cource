<?php


if (!function_exists('getArrayFromString')){
    function getArrayFromString(string $tags): array

    {
        return array_filter(array_map(function ($tag) {
            $tag = str_replace(' ', '', trim($tag));
            return $tag ? (strpos($tag, '#') === 0 ? $tag : "#{$tag}") : null;
        }, explode(',', $tags)));
    }

}

