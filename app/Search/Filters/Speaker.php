<?php

namespace App\Search\Filters;


class Speaker implements Filter
{
    public static function apply($builder, $value)
    {
        return $builder->where('speaker_id', $value);
    }
}