<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BlogPostCreationRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Services\ObjectAuthorizationService;
use App\Services\PostManagementService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @var \App\Repositories\Interfaces\TagRepositoryInterface
     */
    protected TagRepositoryInterface $tagRepository;

    /**
     * @param \App\Services\ObjectAuthorizationService $objectAuthorizationService
     * @param \App\Services\PostManagementService $postManagementService
     * @param \App\Repositories\Interfaces\PostRepositoryInterface $postRepository
     * @param \App\Repositories\Interfaces\TagRepositoryInterface $tagRepository
     */
    public function __construct(
        ObjectAuthorizationService $objectAuthorizationService,
        PostManagementService $postManagementService,
        PostRepositoryInterface $postRepository,
        TagRepositoryInterface $tagRepository
    )
    {
        $this->objectAuthorizationService = $objectAuthorizationService;
        $this->postManagementService = $postManagementService;
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $order = $request->input('order', []);

        return PostResource::collection($this->postRepository->getList($filters, $order));
    }

    public function userPosts(Request $request)
    {
        $filters = [
            ['user_id' => Auth::id()]
        ];

        return PostResource::collection($this->postRepository->getList($filters));
    }

    public function show(Post $post)
    {
        return PostResource::make($post->load(['user', 'categories', 'tags', 'comments', 'comments.user']));
    }

    public function getBySlug(string $slug)
    {
        try{
            $post = $this->postRepository->getBySlug($slug);
        } catch (ModelNotFoundException $e){
            return response()->json(['message' => "unable to find post $slug"], 400);
        }


        if(empty($post)){
            return response()->json(['message' => "unable to find post $slug"], 400);
        }

        return PostResource::make($post->load(['user', 'categories', 'tags', 'comments', 'comments.user']));
    }

    public function store(BlogPostCreationRequest $request)
    {
        try{
            $this->objectAuthorizationService->canCreate();

            $postData = [
                'title' => $request->validated('title'),
                'slug' => $request->validated('slug'),
                'content' => $request->validated('content')
            ];

            $tags = $request->validated('tags') ?? [];

            $tags[] = $this->tagRepository->getByIdentifier('new')->id;

            $tags = array_unique($tags);

            $post = $this->postManagementService->createOrUpdatePost(
                $postData,
                $tags,
                $request->validated('categories')
            );

            if(empty($post)){
                return response()->json(['message' => 'unable to create post'], 500);
            }

            return PostResource::make($post->load(['user', 'categories', 'tags']));
        } catch (AuthorizationException $e){
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function update(Post $post, BlogPostUpdateRequest $request)
    {
        try{
            $this->objectAuthorizationService->canEdit($post);
            $postData = [
                'title' => $request->validated('title', $post->title),
                'slug' => $request->validated('slug', $post->slug),
                'content' => $request->validated('content', $post->content),
                'id' => $post->id
            ];

            $tags = $request->validated('tags') ?? $post->tags->pluck('id')->toArray();

            $tags[] = $this->tagRepository->getByIdentifier('edited')->id;

            $tags = array_unique($tags);

            $post = $this->postManagementService->createOrUpdatePost(
                $postData,
                $tags,
                $request->validated('categories')
            );

            if(empty($post)){
                return response()->json(['message' => 'unable to update post'], 500);
            }

            return PostResource::make($post->load(['user', 'categories', 'tags', 'comments', 'comments.user']));
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
