<?php

namespace App\Http\Domains\EAV\Filter;

use App\Filter\Filter;
use App\Http\Domains\EAV\Model\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeFilter extends Filter
{
    /**
     * Applying filters on query based on request parameters
     * @param Request $filters
     * @return Builder
     */
    public static function apply(Request $filters): Builder
    {
        $query = static::applyDecoratorsFromRequest($filters, (new Attribute())->newQuery());

        return static::getResults($query);
    }

    protected static function createFilterDecorator($name): string
    {
        return __NAMESPACE__ . '\\' . Str::studly($name);
    }
}
