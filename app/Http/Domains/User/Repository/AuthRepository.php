<?php

namespace App\Http\Domains\User\Repository;

use App\Http\Domains\User\Contract\AuthInterface;
use App\Http\Domains\User\Model\User;
use App\Http\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends BaseRepository implements AuthInterface
{
    public function __construct(private User $user)
    {
    }

    protected function model(): string
    {
        return $this->user::class;
    }

    public function register($data):model
    {
        return parent::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function login(array $data): Model|null
    {
        $user = $this->getOneByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password))
            return null;
        return $user;
    }

    public function getOneByEmail(string $email): ?model
    {
        return $this->user->where('email','like', $email)->get()?->first();
    }

}
