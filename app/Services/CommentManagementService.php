<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $isNew = false;
        if(array_key_exists('id', $commentData)){
            $comment = $this->commentRepository->get($commentData['id']);
            unset($commentData['id']);
            $comment->fill($commentData);
        } else {
            $comment = Comment::newModelInstance($commentData);
            $comment->user_id = Auth::id();
            $comment->post_id = $post->id;
            $isNew = true;
        }

        $comment = $this->commentRepository->save($comment);

        if($isNew && ($post->user->id !== $comment->user->id)){
            $post->load('user');
            $comment->load('user');

            $mailMessage = "You have a new comment on your post $post->title from poster {$post->user->name}";
            try{
                Mail::raw($mailMessage, function ($message) use ($post){
                    $message->to($post->user->email)->subject("New comment received!");
                });
            } catch (\Throwable $e){
                //just in case to prevent mailer exceptions from halting the execution
            }
        }

        return $comment;
    }
}
