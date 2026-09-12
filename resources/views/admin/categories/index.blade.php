@extends('admin.layout')

@section('title', 'Категории')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Категории</h1>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Создать категорию
        </a>
    </div>

    <table class="w-full bg-white rounded shadow">
        <thead class="bg-gray-50 text-left text-sm text-gray-600">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Название</th>
                <th class="px-4 py-2">Slug</th>
                <th class="px-4 py-2">Родитель</th>
                <th class="px-4 py-2">Активна</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $category->id }}</td>
                    <td class="px-4 py-2">{{ $category->title }}</td>
                    <td class="px-4 py-2 text-gray-500">{{ $category->slug }}</td>
                    <td class="px-4 py-2">{{ $category->parent?->title ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $category->active ? 'Да' : 'Нет' }}</td>
                    <td class="px-4 py-2 text-right space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="text-blue-600 hover:underline">Изменить</a>

                        <form action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('Удалить категорию?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        Категорий пока нет
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection