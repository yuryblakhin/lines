<?php

declare(strict_types=1);

namespace App\Contracts\Product;

use App\Models\Product;
use App\Models\Warehouse;

interface ProductRepositoryContract
{
    public function getAllProducts(array $data): object;

    public function storeProduct(array $data): object;

    public function updateProduct(Product $product, array $data): object;

    public function destroyProduct(Product $product): void;

    public function findById(int $id): object;

    public function destroyImage(Product $product, int $imageId): void;

    public function updateWarehouseDetails(Product $product, Warehouse $warehouse, array $data): void;
}
