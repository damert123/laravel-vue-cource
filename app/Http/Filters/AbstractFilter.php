<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class AbstractFilter
{
    protected array $keys = [];

    public function apply(array $data, Builder $query): Builder
    {
        foreach ($this->keys as $key) {
            if (isset($data[$key])) {
                $method = Str::camel($key);


                if (method_exists($this, $method)) {
                    $this->$method($query, $data[$key]);
                } else {
                    // Обрабатываем ситуацию, когда метод не найден
                    throw new \Exception("Метод $method для фильтрации не найден.");
                }
            }
        }

        return $query;
    }
}
