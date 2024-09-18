<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository implements Interfaces\CategoryRepositoryInterface
{

    /**
     * @inheritDoc
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * @inheritDoc
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getBySlug(string $slug): Category
    {
        return Category::getBySlug($slug);
    }

    /**
     * @inheritDoc
     */
    public function getList(array $filters, array $order = []): Collection
    {
        $categoriesQuery = Category::query();

        foreach ($filters as $filterGroup){
            $categoriesQuery->orWhere($filterGroup);
        }

        $orderDir = $order['direction'] ?? 'asc';
        $orderField = $order['field'] ?? 'id';

        $categoriesQuery->orderBy($orderField, $orderDir);

        return $categoriesQuery->get();
    }

    /**
     * @inheritDoc
     */
    public function save(Category $category): ?Category
    {
        return $category->save() ? $category : null;
    }

    /**
     * @inheritDoc
     */
    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
