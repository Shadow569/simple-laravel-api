<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BlogPostCreationRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\ObjectAuthorizationService;
use App\Services\PostManagementService;
use Illuminate\Auth\Access\AuthorizationException;
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
        $filters = $request->input('filters', []);
        $order = $request->input('order', []);

        return PostResource::collection($this->postRepository->getList($filters, $order));
    }

    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    public function store(BlogPostCreationRequest $request)
    {
        try{
            $this->objectAuthorizationService->canCreate();
            $post = $this->postManagementService->createOrUpdatePost(
                $request->validated(['title', 'slug', 'content']),
                $request->validated('tags', []),
                $request->validated('categories', [])
            );

            if(empty($post)){
                return response()->json(['message' => 'unable to create post'], 500);
            }

            return PostResource::make($post);
        } catch (AuthorizationException $e){
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function update(Post $post, BlogPostUpdateRequest $request)
    {
        try{
            $this->objectAuthorizationService->canEdit($post);
            $blogPostData = $request->validated(['title', 'slug', 'content']);
            $blogPostData['id'] = $post->id;
            $post = $this->postManagementService->createOrUpdatePost(
                $request->validated(['title', 'slug', 'content']),
                $request->validated('tags', []),
                $request->validated('categories', [])
            );

            if(empty($post)){
                return response()->json(['message' => 'unable to update post'], 500);
            }

            return PostResource::make($post);
        } catch (AuthorizationException $e){
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function destroy(Post $post)
    {
        try{
            $this->objectAuthorizationService->canEdit($post);
            if($this->postRepository->delete($post)){
                return response()->json(["message" => "successful deletion"]);
            }

            return response()->json(["message" => "unable to delete post"], 500);
        } catch (AuthorizationException $e){
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
