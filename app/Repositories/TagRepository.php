<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagRepository implements Interfaces\TagRepositoryInterface
{

    /**
     * @inheritDoc
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Tag
    {
        return Tag::findOrFail($id);
    }

    /**
     * @inheritDoc
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getByIdentifier(string $identifier): Tag
    {
        return Tag::findByIdentifier($identifier);
    }

    /**
     * @inheritDoc
     */
    public function getList(array $filters, array $order = []): Collection
    {
        $tagQuery = Tag::query();

        foreach ($filters as $filterGroup){
            $tagQuery->orWhere($filterGroup);
        }

        $orderDir = $order['direction'] ?? 'asc';
        $orderField = $order['field'] ?? 'id';

        $tagQuery->orderBy($orderField, $orderDir);

        return $tagQuery->get();
    }

    /**
     * @inheritDoc
     */
    public function save(Tag $tag): ?Tag
    {
        return $tag->save() ? $tag : null;
    }

    /**
     * @inheritDoc
     */
    public function delete(Tag $tag): bool
    {
        return $tag->delete();
    }
}
