<?php

namespace App\Search\Filters;

class Author implements Filter
{
    public static function apply($builder, $value)
    {
        return $builder->where('author_id', $value);
    }
}