<?php

declare(strict_types=1);

namespace App\Repositories\Warehouse;

use App\Contracts\Warehouse\WarehouseRepositoryContract;
use App\Enums\SortDirectionEnum;
use App\Models\Warehouse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class WarehouseRepository implements WarehouseRepositoryContract
{
    public function getAllWarehouses(array $data): object
    {
        $perPage = (int) ($data['per_page'] ?? config('pagination.per_page'));
        $sortBy = (string) (isset($data['sort_by']) && in_array($data['sort_by'], Warehouse::$sortable))
            ? $data['sort_by']
            : 'id';

        $sortDirection = (string) isset($data['sort_direction'])
            ? SortDirectionEnum::tryFrom($data['sort_direction'])->value ?? 'desc'
            : 'desc';

        return Warehouse::orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function storeWarehouse(array $data): object
    {
        DB::beginTransaction();

        try {
            $warehouse = new Warehouse($data);
            $warehouse->save();

            DB::commit();

            return $warehouse;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function updateWarehouse(Warehouse $warehouse, array $data): object
    {
        DB::beginTransaction();

        try {
            $warehouse->update($data);

            DB::commit();

            return $warehouse;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function destroyWarehouse(Warehouse $warehouse): void
    {
        DB::beginTransaction();

        try {
            $warehouse->delete();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function findByEmail(string $email): object
    {
        $warehouse = Warehouse::where('email', $email)->first();

        if (!$warehouse) {
            throw new ModelNotFoundException();
        }

        return $warehouse;
    }

    public function findById(int $id): object
    {
        $warehouse = Warehouse::where('id', $id)->first();

        if (!$warehouse) {
            throw new ModelNotFoundException();
        }

        return $warehouse;
    }
}
