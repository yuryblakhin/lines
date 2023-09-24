<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Contracts\Warehouse\WarehouseRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductUpdateQuantityRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    protected ProductRepositoryContract $productRepository;

    protected WarehouseRepositoryContract $warehouseRepository;

    public function __construct(
        ProductRepositoryContract $productRepository,
        WarehouseRepositoryContract $warehouseRepository
    ) {
        $this->productRepository = $productRepository;
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * Удаление изображения продукта.
     *
     * @param Request $request
     * @param int $product
     * @return JsonResponse
     */
    public function updateWarehouse(ProductUpdateQuantityRequest $request, int $product, int $warehouse): JsonResponse
    {
        try {
            $data = $request->validated();

            $product = $this->productRepository->findById($product);
            $warehouse = $this->warehouseRepository->findById($warehouse);

            $this->productRepository->updateWarehouseDetails($product, $warehouse, $data);

            return response()->json(['message' => 'Updated successfully']);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
