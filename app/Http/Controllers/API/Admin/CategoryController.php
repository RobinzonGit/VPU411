<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Category::query()->paginate(10));
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
       return response()->json([
           'message' => 'Category created successfully.',
           'data' => Category::create($request->validated())
       ]);
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): JsonResponse
    {
        return response()->json([
            'message' => 'Category updated successfully.',
            'data' => $category->update($request->validated())
        ]);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json([
            'data' => [],
            'status' => 'success',
        ]);
    }
}
