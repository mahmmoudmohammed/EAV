<?php

namespace App\Http\Repository;

use App\Http\Helpers\ApiDesignTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseCrudInterface
{
    use ApiDesignTrait;

    protected abstract function model(): string|Model;

    public function create(array $data): Model
    {
        return $this->model()::create($data);
    }


    public function getById(int $id): Model|bool
    {
        return $this->model()::where('id', $id)->first() ?: false;
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);
        return $model->refresh();
    }

    public function delete(Model $model): bool|null
    {
        return $model->delete();
    }

    public static function paginationLimit($perPage, $minPerPage = 5, $maxPerPage = 100)
    {
        $perPage ??= 15;
        return max($minPerPage, min($maxPerPage, $perPage));
    }

    public function list(Builder $builder): LengthAwarePaginator
    {
        return $builder->paginate($this::paginationLimit(request('per_page', config('app.pagination'))));
    }

}
