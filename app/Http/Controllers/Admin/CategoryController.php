<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(): View
    {
        $categories = Category::query()
            ->with('parent')
            ->orderBy('title')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('title')
            ->get();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно создана.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category): View
    {
        $category->load([
            'parent',
            'children',
//            'products',
        ]);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $categories = Category::query()
            ->where('id', '!=', $category->id)
            ->orderBy('title')
            ->get();

        return view('admin.categories.edit', compact(
            'category',
            'categories'
        ));
    }

    /**
     * Update the specified category.
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): RedirectResponse {
        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно обновлена.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно удалена.');
    }
}
