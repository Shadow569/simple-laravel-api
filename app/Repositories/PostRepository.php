<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;

class PostRepository implements Interfaces\PostRepositoryInterface
{

    /**
     * @inheritDoc
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Post
    {
        return Post::findOrFail($id);
    }

    /**
     * @inheritDoc
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getBySlug(string $slug): Post
    {
        return Post::getBySlug($slug);
    }

    /**
     * @inheritDoc
     */
    public function getList(array $filters, array $order = []): Collection
    {
        $postsQuery = Post::query();

        foreach ($filters as $filterGroup){
            $postsQuery->orWhere($filterGroup);
        }

        $orderDir = $order['direction'] ?? 'asc';
        $orderField = $order['field'] ?? 'id';

        $postsQuery->orderBy($orderField, $orderDir);

        $postsQuery->with('categories')->with('tags');

        return $postsQuery->get();
    }

    /**
     * @inheritDoc
     */
    public function save(Post $post): Post
    {
        $post->save();
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function attachCategories(Post $post, array $categories): Post
    {
        $post->categories()->sync($categories);
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function attachTags(Post $post, array $tags): Post
    {
        $post->tags()->sync($tags);
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
