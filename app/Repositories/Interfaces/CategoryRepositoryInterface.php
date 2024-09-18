<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     * @return \App\Models\Category
     */
    public function get(int $id): Category;

    /**
     * @param string $slug
     * @return \App\Models\Category
     */
    public function getBySlug(string $slug): Category;

    /**
     * @param array $filters
     * @param array $order
     * @return \Illuminate\Support\Collection
     */
    public function getList(array $filters, array $order = []): Collection;

    /**
     * @param \App\Models\Category $category
     * @return \App\Models\Category|null
     */
    public function save(Category $category): ?Category;

    /**
     * @param \App\Models\Category $category
     * @return bool
     */
    public function delete(Category $category): bool;
}
