<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use App\Contracts\Category\CategoryRepositoryContract;
use App\Enums\SortDirectionEnum;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            : 'desc';

        return Category::orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function storeCategory(array $data): object
    {
        try {
            return Category::query()->create($data);
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function updateCategory(Category $category, array $data): object
    {
        try {
            if (isset($data['parent_id']) && $data['parent_id'] !== $category->parent_id) {
                $category->appendToNode(Category::find($data['parent_id']))->save();
            }

            $category->update($data);

            return $category;
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function destroyCategory(Category $category): void
    {
        try {
            $category->delete();
        } catch (Throwable $exception) {
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
