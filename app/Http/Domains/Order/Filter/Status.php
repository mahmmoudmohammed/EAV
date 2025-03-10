<?php

namespace App\Http\Domains\Order\Filter;

use App\Filter\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class Status implements FilterInterface
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
        return $builder->where('status', $value);
    }
}
