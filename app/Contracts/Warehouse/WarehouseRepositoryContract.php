<?php

declare(strict_types=1);

namespace App\Contracts\Warehouse;

use App\Models\Warehouse;

interface WarehouseRepositoryContract
{
    public function getAllWarehouses(array $data): object;

    public function storeWarehouse(array $data): object;

    public function updateWarehouse(Warehouse $warehouse, array $data): object;

    public function destroyWarehouse(Warehouse $warehouse): void;

    public function findByEmail(string $email): object;

    public function findById(int $id): object;
}
