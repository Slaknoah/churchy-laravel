<?php

namespace App\Search;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Searchable
{
    protected static $allowedFilters = [];
    protected static $defaultFilters = [];

    public static function returnModelInstance()
    {
        return (new \App\User)->newQuery();
    }

    public static function apply(Request $filters)
    {

        $query = static::returnModelInstance();
        $query = static::applyDecoratorsFromRequest($filters, $query);

        return static::getResults($query);

    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    private static function isAllowedFilter($name)
    {
        return in_array($name, static::$allowedFilters);
    }

    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        if (count(static::$defaultFilters) > 0) {
            foreach (static::$defaultFilters as $filterName => $value) {
                $decorator = static::createFilterDecorator($filterName);
                if (static::isValidDecorator($decorator)) {
                    $query = $decorator::apply($query, $value);
                }
            }
        }
        foreach ($request->all() as $filtername => $value) {
            $decorator = static::createFilterDecorator($filtername);
            $filterClassName = static::createFilterClassName($filtername);

            if (static::isAllowedFilter($filterClassName) && static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }

        return $query;
    }

    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' .
        str_replace(' ', '',
            \ucwords(str_replace('_', ' ', $name)));
    }

    private static function createFilterClassName($name)
    {
        return str_replace(' ', '',
            \ucwords(str_replace('_', ' ', $name)));
    }

    private static function getResults(Builder $query)
    {
        return $query->offsetPaginate();
    }
}