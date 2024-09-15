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
     * @return \App\Models\Post
     */
    public function createPost(Post $post, array $tags = [], array $categories = []): Post
    {
        $post->save();
        $post->tags()->sync($tags);
        $post->categories()->sync($categories);

        return $post;
    }

    /**
     * @param \App\Models\Post $post
     * @param array $tags
     * @param array $categories
     * @return \App\Models\Post
     */
    public function editPost(Post $post, array $tags = [], array $categories = []): Post
    {
        $post->save();
        $post->tags()->sync($tags);
        $post->categories()->sync($categories);

        return $post;
    }
}
