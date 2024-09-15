<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentManagementService
{
    /**
     * @var \App\Repositories\Interfaces\CommentRepositoryInterface
     */
    protected CommentRepositoryInterface $commentRepository;

    /**
     * @param \App\Repositories\Interfaces\CommentRepositoryInterface $commentRepository
     */
    public function __construct(
        CommentRepositoryInterface $commentRepository
    )
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param array $commentData
     * @param \App\Models\Post $post
     * @return \App\Models\Comment
     */
    public function createOrUpdateComment(array $commentData, Post $post): Comment
    {
        if(array_key_exists('id', $commentData)){
            $comment = $this->commentRepository->get($commentData['id']);
            unset($commentData['id']);
            $comment->fill($commentData);
        } else {
            $comment = Comment::newModelInstance($commentData);
            $comment->user_id = Auth::id();
        }

        $comment = $this->commentRepository->save($comment);
        return $this->commentRepository->attachToPost($post, $comment);
    }
}
