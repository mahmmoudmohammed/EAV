<?php

namespace App\Http\Domains\Order\Filter;

use App\Filter\Filter;
use App\Http\Domains\Order\Model\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderFilter extends Filter
{
    /**
     * Applying filters on query based on request parameters
     * @param Request $filters
     * @return Builder
     */
    public static function apply(Request $filters): Builder
    {
        $query = static::applyDecoratorsFromRequest($filters, (new Order())->newQuery());

        return static::getResults($query);
    }

    protected static function createFilterDecorator($name): string
    {
        return __NAMESPACE__ . '\\' . Str::studly($name);
    }
}
