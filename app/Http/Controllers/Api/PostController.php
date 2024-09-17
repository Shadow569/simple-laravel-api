<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BlogPostCreationRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\ObjectAuthorizationService;
use App\Services\PostManagementService;
use Illuminate\Http\Request;

class PostController extends \App\Http\Controllers\Controller
{
    /**
     * @var \App\Services\ObjectAuthorizationService
     */
    protected ObjectAuthorizationService $objectAuthorizationService;
    /**
     * @var \App\Services\PostManagementService
     */
    protected PostManagementService $postManagementService;
    /**
     * @var \App\Repositories\Interfaces\PostRepositoryInterface
     */
    protected PostRepositoryInterface $postRepository;

    /**
     * @param \App\Services\ObjectAuthorizationService $objectAuthorizationService
     * @param \App\Services\PostManagementService $postManagementService
     * @param \App\Repositories\Interfaces\PostRepositoryInterface $postRepository
     */
    public function __construct(
        ObjectAuthorizationService $objectAuthorizationService,
        PostManagementService $postManagementService,
        PostRepositoryInterface $postRepository
    )
    {
        $this->objectAuthorizationService = $objectAuthorizationService;
        $this->postManagementService = $postManagementService;
        $this->postRepository = $postRepository;
    }

    public function index(Request $request)
    {
        //TODO: implement retrieval of posts
    }

    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    public function store(BlogPostCreationRequest $request)
    {
        //TODO: implement creation of post
    }

    public function update(Post $post, BlogPostUpdateRequest $request)
    {
        //TODO: implement update of post
    }

    public function destroy(Post $post)
    {
        //TODO: implement deletion of post
    }
}
