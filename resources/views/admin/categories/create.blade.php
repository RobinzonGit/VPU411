@extends('admin.layout')

@section('title', 'Новая категория')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Новая категория</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        @include('admin.categories._form', ['category' => null, 'parents' => $parents])

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