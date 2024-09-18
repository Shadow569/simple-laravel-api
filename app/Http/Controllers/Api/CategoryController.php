<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends \App\Http\Controllers\Controller
{
    /**
     * @var \App\Repositories\Interfaces\CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * @param \App\Repositories\Interfaces\CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $order = $request->input('order', []);

        return CategoryResource::collection($this->categoryRepository->getList($filters, $order));
    }
}
