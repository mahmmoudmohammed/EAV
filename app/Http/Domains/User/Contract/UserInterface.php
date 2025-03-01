<?php

namespace App\Http\Domains\User\Contract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function create($data): Model;
    public function list(Builder $builder): LengthAwarePaginator;
}
