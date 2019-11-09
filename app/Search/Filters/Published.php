<?php

namespace App\Search\Filters;

class Published implements Filter
{
    public static function apply($builder, $value)
    {
        return $builder->where('published', $value);
    }
}