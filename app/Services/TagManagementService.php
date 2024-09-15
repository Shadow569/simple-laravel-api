<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagManagementService
{
    /**
     * @var \App\Repositories\Interfaces\TagRepositoryInterface
     */
    protected TagRepositoryInterface $tagRepository;

    /**
     * @param \App\Repositories\Interfaces\TagRepositoryInterface $tagRepository
     */
    public function __construct(
        TagRepositoryInterface $tagRepository
    )
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param array $tagData
     * @return \App\Models\Tag
     */
    public function createOrUpdateTag(array $tagData): Tag
    {
        if(array_key_exists('id', $tagData)){
            $tag = $this->tagRepository->get($tagData['id']);
            unset($tagData['id']);
            $tag->fill($tagData);
        } else {
            $tag = Tag::newModelInstance($tagData);
        }

        return $this->tagRepository->save($tag);
    }
}
