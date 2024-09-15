<?php

namespace App\Services;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ObjectAuthorizationService
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function canEdit(Model $model): bool
    {
        $currentUserId = Auth::id();

        if(empty($currentUserId) || ($currentUserId !== $model->user_id)){
            throw new AuthorizationException("Unauthorized", 400);
        }

        return true;
    }

    /**
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function canCreate(): bool
    {
        $currentUserId = Auth::id();

        if(empty($currentUserId)){
            throw new AuthorizationException("Unauthorized", 400);
        }

        return true;
    }
}
