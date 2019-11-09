<?php

namespace App\Search\Filters;


class HasCoverImage implements Filter
{
    public static function apply($builder, $value)
    {
        return $builder->where('cover_image', '!=', false);
    }
}