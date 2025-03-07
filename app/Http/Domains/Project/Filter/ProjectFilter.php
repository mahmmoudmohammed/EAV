<?php

namespace App\Http\Domains\Project\Filter;

use App\Filter\Filter;
use App\Http\Domains\Project\Model\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectFilter extends Filter
{
    /**
     * Applying filters on query based on request parameters
     * @param Request $filters
     * @return Builder
     */
    public static function apply(Request $filters): Builder
    {
        $query = static::applyDecoratorsFromRequest($filters, (new Project())->newQuery());

        return static::getResults($query);
    }

    protected static function createFilterDecorator($name): string
    {
        return __NAMESPACE__ . '\\' . Str::studly($name);
    }
}
