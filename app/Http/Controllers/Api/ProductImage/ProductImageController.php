<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\ProductImage;

use App\Contracts\Product\ProductImageRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductImageController extends Controller
{
    protected ProductImageRepositoryContract $productImageRepository;

    public function __construct(
        ProductImageRepositoryContract $productImageRepository,
    ) {
        $this->productImageRepository = $productImageRepository;
    }

    /**
     * Удаление изображения продукта.
     *
     * @param Request $request
     * @param int $productImage
     * @return JsonResponse
     */
    public function destroy(Request $request, int $productImage): JsonResponse
    {
        try {
            $productImage = $this->productImageRepository->findById($productImage);
            $this->productImageRepository->destroyProductImage($productImage);

            return response()->json(['message' => 'Image deleted successfully']);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
