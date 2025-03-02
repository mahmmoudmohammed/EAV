<?php

namespace App\Http\Domains\EAV\Repository;

use App\Http\Domains\EAV\Contract\AttributeInterface;
use App\Http\Domains\EAV\Model\Attribute;
use App\Http\Repository\BaseRepository;

class AttributeRepository extends BaseRepository implements AttributeInterface
{
    protected function model(): string
    {
        return Attribute::class;
    }

    /**
     * @throws \Exception
     */
    public function load(Attribute $model, array|string $relations): Attribute
    {
        return $model->load($relations);
    }
}
