<?php

namespace App\Search\Filters;

class HasMedia implements Filter
{
    public static function apply($builder, $value)
    {
        return $builder->where('media', '!=', null);
    }
}