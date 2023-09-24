<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\ProductWarehouse;

use App\Contracts\Product\ProductWarehouseRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductWarehouseController extends Controller
{
    protected ProductWarehouseRepositoryContract $productWarehouseRepository;

    public function __construct(
        ProductWarehouseRepositoryContract $productWarehouseRepository,
    ) {
        $this->productWarehouseRepository = $productWarehouseRepository;
    }

    /**
     * Удаление изображения продукта.
     *
     * @param Request $request
     * @param int $product
     * @return JsonResponse
     */
    public function update(Request $request, int $product): JsonResponse
    {
        try {
            var_dump($request->all());

            die;
            $productWarehouse = $this->productWarehouseRepository->findById($productWarehouse);
            $this->productWarehouseRepository->destroyProductWarehouse($productWarehouse);

            return response()->json(['message' => 'Warehouse deleted successfully']);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
