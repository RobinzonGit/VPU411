<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::query()
        ->with('parent')          // жадная загрузка родителя, чтобы не было N+1
        ->orderBy('parent_id')    // сначала корневые (null), потом дочерние
        ->orderBy('title')
        ->get();

    return view('admin.categories.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $parents = Category::query()
        ->whereNull('parent_id')
        ->orderBy('title')
        ->get();

    return view('admin.categories.create', compact('parents'));
}

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'title'     => ['required', 'string', 'max:255'],
        'slug'      => ['required', 'string', 'max:255', 'unique:categories,slug'],
        'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
        'active'    => ['boolean'],
    ]);

    // Чекбокс приходит как "1" или отсутствует вовсе
    $validated['active'] = $request->boolean('active');

    Category::create($validated);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Категория создана');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Category $category)
{
    $parents = Category::query()
        ->whereNull('parent_id')
        ->where('id', '!=', $category->id)     // нельзя выбрать себя родителем
        ->orderBy('title')
        ->get();

    return view('admin.categories.edit', compact('category', 'parents'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
{
    $validated = $request->validate([
        'title'     => ['required', 'string', 'max:255'],
        'slug'      => ['required', 'string', 'max:255',
                        Rule::unique('categories', 'slug')->ignore($category->id)],
        'parent_id' => ['nullable', 'integer', 'exists:categories,id',
                        Rule::notIn([$category->id])],
        'active'    => ['boolean'],
    ]);

    $validated['active'] = $request->boolean('active');

    $category->update($validated);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Категория обновлена');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Category $category)
{
    // Проверка: есть ли дочерние категории?
    if ($category->children()->exists()) {
        return back()->with('error', 'Нельзя удалить категорию с подкатегориями');
    }

    // Проверка: есть ли товары?
    if ($category->products()->exists()) {
        return back()->with('error', 'Нельзя удалить категорию с товарами');
    }

    $category->delete();

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Категория удалена');
}
}
