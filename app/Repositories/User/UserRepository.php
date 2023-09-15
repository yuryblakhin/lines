<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Contracts\User\UserRepositoryContract;
use App\Models\User;

class UserRepository implements UserRepositoryContract
{
    public function createUser(array $data): object
    {
        return User::query()->create($data);
    }

    public function findByEmail(string $email): object|null
    {
        return User::query()->where('email', $email)->first();
    }

    public function findById(int $id): object|null
    {
        return User::query()->where('id', $id)->first();
    }
}
