<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CommentCreationRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\ObjectAuthorizationService;
use App\Services\CommentManagementService;

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
        //TODO: implement creation of comment
    }

    public function update(Comment $comment, CommentUpdateRequest $request)
    {
        //TODO: implement update of comment
    }

    public function destroy(Comment $comment)
    {
        //TODO: implement deletion of comment
    }
}
