@extends('admin.layout')

@section('title', 'Редактирование категории')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Редактирование: {{ $category->title }}</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        @include('admin.categories._form', ['category' => $category, 'parents' => $parents])

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Сохранить
            </button>
            <a href="{{ route('admin.categories.index') }}"
               class="px-4 py-2 rounded border">Отмена</a>
        </div>
    </form>
@endsection