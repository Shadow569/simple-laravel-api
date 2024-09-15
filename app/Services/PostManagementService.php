<?php

namespace App\Services;

use App\Models\Post;

class PostManagementService
{

    /**
     * @var \App\Services\ObjectAuthorizationService
     */
    protected $objectAuthorizationService;

    /**
     * @param \App\Services\ObjectAuthorizationService $objectAuthorizationService
     */
    public function __construct(
        ObjectAuthorizationService $objectAuthorizationService
    )
    {
        $this->objectAuthorizationService = $objectAuthorizationService;
    }

    /**
     * @param \App\Models\Post $post
     * @param array $tags
     * @param array $categories
     * @return \App\Models\Post|null
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createPost(Post $post, array $tags = [], array $categories = []): ?Post
    {
        if($this->objectAuthorizationService->canCreate()){
            $post->save();
            $post->tags()->saveMany($tags);
            $post->categories()->saveMany($categories);

            return $post;
        }

        return null;
    }

    /**
     * @param \App\Models\Post $post
     * @param array $tags
     * @param array $categories
     * @return \App\Models\Post|null
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editPost(Post $post, array $tags = [], array $categories = []): ?Post
    {
        if($this->objectAuthorizationService->canEdit($post)){
            $post->save();
            $post->tags()->saveMany($tags);
            $post->categories()->saveMany($categories);

            return $post;
        }

        return null;
    }
}
