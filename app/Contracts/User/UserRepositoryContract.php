<?php

declare(strict_types=1);

namespace App\Contracts\User;

use App\Models\User;

interface UserRepositoryContract
{
    public function getAllUsers(array $data): object;

    public function storeUser(array $data): object;

    public function updateUser(User $user, array $data): object;

    public function destroyUser(User $user): void;

    public function findByEmail(string $email): object;

    public function findById(int $id): object;
}
