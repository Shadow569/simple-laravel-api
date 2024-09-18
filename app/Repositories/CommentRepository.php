<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Collection;

class CommentRepository implements Interfaces\CommentRepositoryInterface
{

    /**
     * @inheritDoc
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Comment
    {
        return Comment::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getList(array $filters, array $order = []): Collection
    {
        $commentsQuery = Comment::query();

        foreach ($filters as $filterGroup){
            $commentsQuery->orWhere($filterGroup);
        }

        $orderDir = $order['direction'] ?? 'asc';
        $orderField = $order['field'] ?? 'id';

        $commentsQuery->orderBy($orderField, $orderDir);

        return $commentsQuery->get();
    }

    /**
     * @inheritDoc
     */
    public function save(Comment $comment): ?Comment
    {
        return $comment->save() ? $comment : null;
    }

    /**
     * @inheritDoc
     */
    public function attachToPost(Post $post, Comment $comment): Comment
    {
        $comment->post()->associate($post);
        return $comment;
    }

    /**
     * @inheritDoc
     */
    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
