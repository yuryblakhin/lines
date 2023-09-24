<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Enums\SortDirectionEnum;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\FileUploadService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductRepository implements ProductRepositoryContract
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function getAllProducts(array $data): object
    {
        $perPage = (int) ($data['per_page'] ?? config('pagination.per_page'));
        $sortBy = (string) (isset($data['sort_by']) && in_array($data['sort_by'], Product::$sortable))
            ? $data['sort_by']
            : 'id';

        $sortDirection = (string) isset($data['sort_direction'])
            ? SortDirectionEnum::tryFrom($data['sort_direction'])->value ?? 'desc'
            : 'desc';

        return Product::with('categories')->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function storeProduct(array $data): object
    {
        DB::beginTransaction();

        try {
            if (isset($data['image'])) {
                $data['image_path'] = $this->fileUploadService->upload($data['image'], 'product');
            }

            $images = [];

            if (isset($data['images'])) {
                foreach ($data['images'] as $key => $image) {
                    $images[] = [
                        'image_path' => $this->fileUploadService->upload($image, 'product'),
                        'sort_order' => $key,
                    ];
                }
            }

            $product = new Product($data);
            $product->save();
            $product->categories()->attach($data['categories']);
            $product->images()->createMany($images);

            DB::commit();

            return $product;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function updateProduct(Product $product, array $data): object
    {
        DB::beginTransaction();

        try {
            if (isset($data['image'])) {
                $data['image_path'] = $this->fileUploadService->upload($data['image'], 'product');
            }

            $images = [];

            if (isset($data['images'])) {
                foreach ($data['images'] as $key => $image) {
                    $images[] = [
                        'image_path' => $this->fileUploadService->upload($image, 'product'),
                        'sort_order' => $key,
                    ];
                }
            }

            if (isset($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

            $product->images()->createMany($images);
            $product->update($data);

            DB::commit();

            return $product;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function destroyProduct(Product $product): void
    {
        DB::beginTransaction();

        try {
            $product->categories()->detach();
            $product->delete();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function findById(int $id): object
    {
        $product = Product::with(['categories', 'warehouses'])->where('id', $id)->first();

        if (!$product) {
            throw new ModelNotFoundException();
        }

        return $product;
    }

    public function updateWarehouseDetails(Product $product, Warehouse $warehouse, array $data): void
    {
        DB::beginTransaction();

        try {
            $quantity = $data['quantity'];
            $price = $data['price'];

            $product->warehouses()->syncWithoutDetaching([
                $warehouse->id => ['quantity' => $quantity, 'price' => $price],
            ]);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }
}
