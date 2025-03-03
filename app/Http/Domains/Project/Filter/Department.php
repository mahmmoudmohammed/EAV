<?php

namespace App\Http\Domains\Project\Filter;

use App\Filter\FilterInterface;
use App\Http\Domains\EAV\Model\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Department implements FilterInterface
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
        // TODO::Need to be more dynamic by passing name from http query
        $attribute = Attribute::where('name', 'department')->first();
        return $builder->whereHas('attributeValues', function ($q) use ($attribute, $value) {
            $q->where('attribute_id', $attribute->id);
            $q->where('value','like', '%'.$value.'%');
            return $q;
        });
    }
}
