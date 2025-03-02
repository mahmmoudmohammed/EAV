<?php

namespace App\Http\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseCrudInterface
{
    public function create(array $data): Model;

    public function getById(int $id): Model|bool;

    public function update(Model $model, array $data): Model;

    public function delete(Model $model): bool|null;
    public function list(Builder $builder): LengthAwarePaginator;
}
