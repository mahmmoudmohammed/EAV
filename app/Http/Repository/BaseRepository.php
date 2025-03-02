<?php

namespace App\Http\Repository;

use App\Http\Helpers\ApiDesignTrait;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    use ApiDesignTrait;

    protected abstract function model(): string|Model;

    public function create(array $data): model
    {
        return $this->model()::create($data);
    }


    public function getById(int $id): model|bool
    {
        return $this->model()::where('id', $id)->first() ?: false;
    }

    public function update(model $model, array $data): Model
    {
        $model->update($data);
        return $model->refresh();
    }

    public function delete(model $model): bool|null
    {
        return $model->delete();
    }

    public static function paginationLimit($perPage, $minPerPage = 5, $maxPerPage = 100)
    {
        $perPage ??= 15;
        return max($minPerPage, min($maxPerPage, $perPage));
    }

}
