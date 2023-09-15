<?php

declare(strict_types=1);

namespace App\Contracts\User;

interface UserRepositoryContract
{
    public function createUser(array $data): object;

    public function findByEmail(string $email): object|null;

    public function findById(int $id): object|null;
}
