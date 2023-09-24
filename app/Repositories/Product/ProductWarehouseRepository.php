<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Contracts\Product\ProductWarehouseRepositoryContract;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductWarehouseRepository implements ProductWarehouseRepositoryContract
{
    public function updateQuantity(Product $product): void
    {
        DB::beginTransaction();

        try {
            var_dump($product);

            die;
            $productImage->delete();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }
}
