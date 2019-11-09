<?php

namespace App\Search\Filters;

class Series implements Filter
{
    public static function apply($builder, $value)
    {
        return $builder->where('series_id', $value);
    }
}