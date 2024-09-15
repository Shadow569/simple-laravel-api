<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;
use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    /**
     * @param int $id
     * @return \App\Models\Tag
     */
    public function get(int $id): Tag;

    /**
     * @param string $identifier
     * @return \App\Models\Tag
     */
    public function getByIdentifier(string $identifier): Tag;

    /**
     * @param array $filters
     * @param array $order
     * @return \Illuminate\Support\Collection
     */
    public function getList(array $filters, array $order = []): Collection;

    /**
     * @param \App\Models\Tag $tag
     * @return \App\Models\Tag
     */
    public function save(Tag $tag): Tag;

    /**
     * @param \App\Models\Tag $tag
     * @return bool
     */
    public function delete(Tag $tag): bool;
}
