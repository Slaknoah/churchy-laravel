<?php

namespace App\Search\Filters;


class SortByDate implements Filter
{
    public static function apply($builder, $value)
    {
        return $builder->orderBy('created_at', $value);
    }
}