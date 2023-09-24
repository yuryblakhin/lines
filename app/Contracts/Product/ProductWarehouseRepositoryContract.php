<?php

declare(strict_types=1);

namespace App\Contracts\Product;

use App\Models\Product;

interface ProductWarehouseRepositoryContract
{
    public function updateQuantity(Product $product): void;
}
