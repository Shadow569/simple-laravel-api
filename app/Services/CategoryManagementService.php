<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryManagementService
{
    /**
     * @var \App\Repositories\Interfaces\CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * @param \App\Repositories\Interfaces\CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array $categoryData
     * @return \App\Models\Category
     */
    public function createOrUpdateCategory(array $categoryData): Category
    {
        if(array_key_exists('id', $categoryData)){
            $category = $this->categoryRepository->get($categoryData['id']);
            unset($categoryData['id']);
            $category->fill($categoryData);
        } else {
            $category = Category::newModelInstance($categoryData);
        }

        return $this->categoryRepository->save($category);
    }
}
