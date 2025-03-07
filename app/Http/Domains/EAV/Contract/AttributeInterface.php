<?php

namespace App\Http\Domains\EAV\Contract;

use App\Http\Domains\EAV\Model\Attribute;
use App\Http\Repository\BaseCrudInterface;

interface AttributeInterface extends BaseCrudInterface
{
    public function load(Attribute $model, array|string $relations): Attribute;
}
