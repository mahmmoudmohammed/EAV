<?php

namespace App\Http\Domains\User\Contract;

use Illuminate\Database\Eloquent\Model;

interface AuthInterface
{
    public function register($data): Model;
    public function login(array $data): Model|null;
}
