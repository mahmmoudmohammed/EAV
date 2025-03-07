<?php

namespace App\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasFilter
{
    protected static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    private static function isValidDecorator($decorator): bool
    {
        return class_exists($decorator);
    }

    protected static function getResults(Builder $query): Builder
    {
        return $query;
    }

}
