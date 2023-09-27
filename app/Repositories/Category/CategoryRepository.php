<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use App\Contracts\Category\CategoryRepositoryContract;
use App\Enums\SortDirectionEnum;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryRepository implements CategoryRepositoryContract
{
    public function getAllCategories(array $data): object
    {
        $perPage = (int) ($data['per_page'] ?? config('pagination.per_page'));
        $sortBy = (string) (isset($data['sort_by']) && in_array($data['sort_by'], Category::$sortable))
            ? $data['sort_by']
            : 'id';

        $sortDirection = (string) isset($data['sort_direction'])
            ? SortDirectionEnum::tryFrom($data['sort_direction'])->value ?? 'desc'
            : 'asc';

        return Category::orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function storeCategory(array $data): object
    {
        DB::beginTransaction();

        try {
            $category = new Category($data);

            if (isset($data['parent_id'])) {
                $parentCategory = Category::find($data['parent_id']);

                if (!$parentCategory) {
                    throw new ModelNotFoundException();
                }

                $category->appendToNode($parentCategory);
            }

            $category->save();

            DB::commit();

            return $category;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function updateCategory(Category $category, array $data): object
    {
        DB::beginTransaction();

        try {
            if (isset($data['parent_id']) && $data['parent_id'] !== $category->parent_id) {
                $parentCategory = Category::find($data['parent_id']);

                if (!$parentCategory) {
                    throw new ModelNotFoundException();
                }

                $category->appendToNode($parentCategory)->save();
            }

            $category->update($data);

            DB::commit();

            return $category;
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function destroyCategory(Category $category): void
    {
        DB::beginTransaction();

        try {
            $category->delete();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new Exception($exception->getMessage());
        }
    }

    public function findById(int $id): object
    {
        $category = Category::query()->where('id', $id)->first();

        if (!$category) {
            throw new ModelNotFoundException();
        }

        return $category;
    }
}
