@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Категории</h1>

            <a href="{{ route('admin.categories.create') }}"
               class="btn btn-primary">
                Создать категорию
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($categories->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Slug</th>
                        <th>Родитель</th>
                        <th>Статус</th>
                        <th width="220">Действия</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                {{ $category->id }}
                            </td>

                            <td>
                                {{ $category->title }}
                            </td>

                            <td>
                                {{ $category->slug }}
                            </td>

                            <td>
                                {{ $category->parent?->title ?? '—' }}
                            </td>

                            <td>
                                @if($category->active)
                                    <span class="badge bg-success">
                                        Активна
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Неактивна
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}"
                                   class="btn btn-sm btn-info">
                                    Просмотр
                                </a>

                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-warning">
                                    Изменить
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Удалить категорию?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        @else
            <div class="alert alert-info">
                Категорий пока нет.
            </div>
        @endif

    </div>
@endsection
