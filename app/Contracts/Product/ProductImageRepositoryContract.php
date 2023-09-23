<?php

declare(strict_types=1);

namespace App\Contracts\Product;

use App\Models\ProductImage;

interface ProductImageRepositoryContract
{
    public function destroyProductImage(ProductImage $productImage): void;

    public function findById(int $id): object;
}
