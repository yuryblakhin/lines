<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Contracts\Product\ProductImageRepositoryContract;
use App\Models\ProductImage;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductImageRepository implements ProductImageRepositoryContract
{
    public function destroyProductImage(ProductImage $productImage): void
    {
        DB::beginTransaction();

        try {
            $productImage->delete();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function findById(int $id): ProductImage
    {
        $productImage = ProductImage::where('id', $id)->first();

        if (!$productImage) {
            throw new ModelNotFoundException();
        }

        return $productImage;
    }
}
