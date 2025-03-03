<?php

namespace App\Http\Domains\Project\Filter;

use App\Filter\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class Name implements FilterInterface
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('name','like', '%'.$value.'%');
    }
}
