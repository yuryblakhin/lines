<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Contracts\User\UserRepositoryContract;
use App\Enums\SortDirectionEnum;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class UserRepository implements UserRepositoryContract
{
    public function getAllUsers(array $data): object
    {
        $perPage = (int) ($data['per_page'] ?? config('pagination.per_page'));
        $sortBy = (string) (isset($data['sort_by']) && in_array($data['sort_by'], User::$sortable))
            ? $data['sort_by']
            : 'id';

        $sortDirection = (string) isset($data['sort_direction'])
            ? SortDirectionEnum::tryFrom($data['sort_direction'])->value ?? 'desc'
            : 'desc';

        return User::orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function storeUser(array $data): object
    {
        try {
            return User::query()->create($data);
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function updateUser(User $user, array $data): object
    {
        try {
            $user->update($data);

            return $user;
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function destroyUser(User $user): void
    {
        try {
            $user->delete();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function findByEmail(string $email): object
    {
        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            throw new ModelNotFoundException();
        }

        return $user;
    }

    public function findById(int $id): object
    {
        $user = User::query()->where('id', $id)->first();

        if (!$user) {
            throw new ModelNotFoundException();
        }

        return $user;
    }
}
