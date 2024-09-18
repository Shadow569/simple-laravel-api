<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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
     * @param array|null $tags
     * @param array|null $categories
     * @return \App\Models\Post
     */
    public function createOrUpdatePost(array $postData, ?array $tags = null, ?array $categories = null): Post
    {
        if(array_key_exists('id', $postData)){
            $post = $this->postRepository->get($postData['id']);
            unset($postData['id']);
            $post->fill($postData);
        } else {
            $post = Post::newModelInstance($postData);
            $post->user_id = Auth::id();
        }

        $post = $this->postRepository->save($post);

        if(is_array($categories)){
            $post = $this->postRepository->attachCategories($post, $categories);
        }

        if(is_array($tags)){
            $post = $this->postRepository->attachTags($post, $tags);
        }

        return $post;
    }
}
