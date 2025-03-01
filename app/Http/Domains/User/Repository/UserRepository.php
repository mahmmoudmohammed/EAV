<?php

namespace App\Http\Domains\User\Repository;

use App\Http\Domains\User\Contract\UserInterface;
use App\Http\Domains\User\Model\User;
use App\Http\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserInterface
{
    protected function model(): string
    {
        return User::class;
    }

    public function create($data):model
    {
        return parent::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
    public function list(Builder $builder): LengthAwarePaginator
    {
        return $builder::paginate($this::paginationLimit(request('per_page', config('app.pagination'))));
    }

}
