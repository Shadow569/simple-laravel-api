<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    /**
     * @param int $id
     * @return \App\Models\Comment
     */
    public function get(int $id): Comment;

    /**
     * @param array $filters
     * @param array $order
     * @return \Illuminate\Support\Collection
     */
    public function getList(array $filters, array $order = []): Collection;

    /**
     * @param \App\Models\Comment $comment
     * @return \App\Models\Comment|null
     */
    public function save(Comment $comment): ?Comment;

    /**
     * @param \App\Models\Post $post
     * @param \App\Models\Comment $comment
     * @return \App\Models\Comment
     */
    public function attachToPost(Post $post, Comment $comment): Comment;

    /**
     * @param \App\Models\Comment $comment
     * @return bool
     */
    public function delete(Comment $comment): bool;
}
