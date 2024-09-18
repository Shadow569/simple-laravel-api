<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \App\Models\Post
     */
    public function get(int $id): Post;

    /**
     * @param string $slug
     * @return \App\Models\Post
     */
    public function getBySlug(string $slug): Post;

    /**
     * @param array $filters
     * @param array $order
     * @return \Illuminate\Support\Collection
     */
    public function getList(array $filters, array $order = []): Collection;

    /**
     * @param \App\Models\Post $post
     * @return \App\Models\Post|null
     */
    public function save(Post $post): ?Post;

    /**
     * @param \App\Models\Post $post
     * @param array $categories
     * @return \App\Models\Post
     */
    public function attachCategories(Post $post, array $categories): Post;

    /**
     * @param \App\Models\Post $post
     * @param array $tags
     * @return \App\Models\Post
     */
    public function attachTags(Post $post, array $tags): Post;

    /**
     * @param \App\Models\Post $post
     * @return bool
     */
    public function delete(Post $post): bool;
}
