<?php

namespace App\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{
    use HasFilter;

    /**
     * Applying filters on query based on request parameters
     * @param Request $filters
     * @return Builder
     */
    public static abstract function apply(Request $filters): Builder;

    /**
     * Get filter Class
     * @param string $name
     * @return string
     */
    protected static abstract function createFilterDecorator(string $name): string;
}
