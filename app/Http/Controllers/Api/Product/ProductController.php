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
     * Удаляет дополнительную картинку продукта.
     *
     * @param Request $request
     * @param int $productId
     * @param int $imageId
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function destroyImage(Request $request, int $productId, int $imageId): JsonResponse
    {
        try {
            $product = $this->productRepository->findById($productId);
            $productImage = $this->productRepository->findProductImageById($product, $imageId);
            $this->productRepository->destroyProductImage($productImage);

            return response()->json(['message' => 'Image deleted successfully']);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * Обновляет детали склада для продукта.
     *
     * @param ProductUpdateQuantityRequest $request
     * @param int $productId
     * @param int $warehouseId
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function updateWarehouse(ProductUpdateQuantityRequest $request, int $productId, int $warehouseId): JsonResponse
    {
        try {
            $data = $request->validated();

            $product = $this->productRepository->findById($productId);
            $warehouse = $this->warehouseRepository->findById($warehouseId);

            $this->productRepository->updateProductWarehouseDetails($product, $warehouse, $data);

            return response()->json(['message' => 'Updated successfully']);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
