<?php

declare(strict_types=1);

namespace App\Contracts\Category;

use App\Models\Category;

interface CategoryRepositoryContract
{
    public function getAllCategories(array $data): object;

    public function storeCategory(array $data): object;

    public function updateCategory(Category $category, array $data): object;

    public function destroyCategory(Category $category): void;

    public function findById(int $id): object;
}
