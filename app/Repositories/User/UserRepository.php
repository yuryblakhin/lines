<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Contracts\User\UserRepositoryContract;
use App\Enums\SortDirectionEnum;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
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
            : 'asc';

        return User::orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function storeUser(array $data): object
    {
        DB::beginTransaction();

        try {
            $user = new User($data);
            $user->save();

            DB::commit();

            return $user;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function updateUser(User $user, array $data): object
    {
        DB::beginTransaction();

        try {
            $user->update($data);

            DB::commit();

            return $user;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function destroyUser(User $user): void
    {
        DB::beginTransaction();

        try {
            $user->delete();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function findByEmail(string $email): object
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new ModelNotFoundException();
        }

        return $user;
    }

    public function findById(int $id): object
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            throw new ModelNotFoundException();
        }

        return $user;
    }
}
