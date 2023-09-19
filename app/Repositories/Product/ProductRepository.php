<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Enums\SortDirectionEnum;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProductRepository implements ProductRepositoryContract
{
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
                $image = $data['image'];
                $uuid = Str::uuid()->toString();
                $uniqueFileName = $uuid . '.' . $image->getClientOriginalExtension();
                $hash = md5($uuid);
                $firstLevel = substr($hash, 0, 2);
                $secondLevel = substr($hash, 2, 2);
                $destinationDisk = Storage::disk(config('filesystems.default'));

                $data['image'] = $destinationDisk->putFileAs("up/{$firstLevel}/{$secondLevel}", $image, $uniqueFileName);
            }

            $product = new Product($data);
            $product->save();
            $product->categories()->attach($data['categories']);

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
                $image = $data['image'];
                $uuid = Str::uuid()->toString();
                $uniqueFileName = $uuid . '.' . $image->getClientOriginalExtension();
                $hash = md5($uuid);
                $firstLevel = substr($hash, 0, 2);
                $secondLevel = substr($hash, 2, 2);
                $destinationDisk = Storage::disk(config('filesystems.default'));

                $data['image'] = $destinationDisk->putFileAs("up/{$firstLevel}/{$secondLevel}", $image, $uniqueFileName);
            }

            if (isset($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

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
        $product = Product::with('categories')->where('id', $id)->first();

        if (!$product) {
            throw new ModelNotFoundException();
        }

        return $product;
    }
}
