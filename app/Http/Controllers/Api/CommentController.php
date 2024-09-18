<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CommentCreationRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\ObjectAuthorizationService;
use App\Services\CommentManagementService;
use Illuminate\Auth\Access\AuthorizationException;

class CommentController extends \App\Http\Controllers\Controller
{
    /**
     * @var \App\Services\ObjectAuthorizationService
     */
    protected ObjectAuthorizationService $objectAuthorizationService;
    /**
     * @var \App\Services\CommentManagementService
     */
    protected CommentManagementService $commentManagementService;
    /**
     * @var \App\Repositories\Interfaces\CommentRepositoryInterface
     */
    protected CommentRepositoryInterface $commentRepository;

    /**
     * @param \App\Services\ObjectAuthorizationService $objectAuthorizationService
     * @param \App\Services\CommentManagementService $commentManagementService
     * @param \App\Repositories\Interfaces\CommentRepositoryInterface $commentRepository
     */
    public function __construct(
        ObjectAuthorizationService $objectAuthorizationService,
        CommentManagementService $commentManagementService,
        CommentRepositoryInterface $commentRepository
    )
    {
        $this->objectAuthorizationService = $objectAuthorizationService;
        $this->commentManagementService = $commentManagementService;
        $this->commentRepository = $commentRepository;
    }
    public function store(Post $post, CommentCreationRequest $request)
    {
        try{
            $this->objectAuthorizationService->canCreate();
            $comment = $this->commentManagementService->createOrUpdateComment(
                $request->validated(['comment']),
                $post,
            );

            if(empty($comment)){
                return response()->json(['message' => 'unable to create comment'], 500);
            }

            return CommentResource::make($comment);
        } catch (AuthorizationException $e){
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function update(Comment $comment, CommentUpdateRequest $request)
    {
        try{
            $this->objectAuthorizationService->canEdit($comment);

            $commentData = $request->validated(['comment']);
            $commentData['id'] = $comment->id;

            $comment = $this->commentManagementService->createOrUpdateComment(
                $commentData,
                $comment->post,
            );

            if(empty($comment)){
                return response()->json(['message' => 'unable to update comment'], 500);
            }

            return CommentResource::make($comment);
        } catch (AuthorizationException $e){
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function destroy(Comment $comment)
    {
        try{
            $this->objectAuthorizationService->canEdit($comment);
            if($this->commentRepository->delete($comment)){
                return response()->json(["message" => "successful deletion"]);
            }

            return response()->json(["message" => "unable to delete comment"], 500);
        } catch (AuthorizationException $e){
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}
