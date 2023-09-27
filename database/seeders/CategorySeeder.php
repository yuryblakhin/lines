<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $rootCategoryData = [
            'name' => 'Root Category',
            'code' => 'root',
            'description' => 'Root category description',
            'parent_id' => null,
            'active' => true,
        ];

        $rootCategory = Category::where('code', $rootCategoryData['code'])->first();

        if (!$rootCategory) {
            $rootCategory = new Category($rootCategoryData);
            $rootCategory->save();
        }

        $childCategoriesData = [
            [
                'name' => 'Child Category 1',
                'code' => 'child1',
                'description' => 'Child category 1 description',
                'parent_id' => $rootCategory->id,
                'active' => true,
            ],
            [
                'name' => 'Child Category 2',
                'code' => 'child2',
                'description' => 'Child category 2 description',
                'parent_id' => $rootCategory->id,
                'active' => true,
            ],
        ];

        foreach ($childCategoriesData as $data) {
            if (!Category::where('code', $data['code'])->exists()) {
                $childCategory = new Category($data);
                $childCategory->save();
            }
        }
    }
}
