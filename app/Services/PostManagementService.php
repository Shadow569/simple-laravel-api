<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostManagementService
{
    /**
     * @var \App\Repositories\Interfaces\PostRepositoryInterface
     */
    protected PostRepositoryInterface $postRepository;

    /**
     * @param \App\Repositories\Interfaces\PostRepositoryInterface $postRepository
     */
    public function __construct(
        PostRepositoryInterface $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param array $postData
     * @param array $tags
     * @param array $categories
     * @return \App\Models\Post
     */
    public function createOrUpdatePost(array $postData, array $tags = [], array $categories = []): Post
    {
        if(array_key_exists('id', $postData)){
            $post = $this->postRepository->get($postData['id']);
            unset($postData['id']);
            $post->fill($postData);
        } else {
            $post = Post::newModelInstance($postData);
        }

        $post = $this->postRepository->save($post);
        $post = $this->postRepository->attachCategories($post, $categories);
        return $this->postRepository->attachTags($post, $tags);
    }
}
